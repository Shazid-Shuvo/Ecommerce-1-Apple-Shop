<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;

use App\Helper\SSLCommerz;
use App\Models\CustomerProfile;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\ProductCart;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
   public function CreateInvoice(Request $request):JsonResponse{

       try {

           DB::beginTransaction();
           $user_id = $request->header('id');
           $email = $request->header('email');
           $delivery_status = 'pending';
           $payment_status = 'pending';
           $tran_id = uniqid();
           $total = 0;

           $customer = CustomerProfile::where('user_id', '=', $user_id)->first();
           $cus_details = "Name:$customer->cus_name,Address:$customer->cus_add,City:$customer->cus_city,Phone:$customer->cus_phone";
           $ship_details = "Name:$customer->ship_name,Address:$customer->ship_add,City:$customer->shipp_city,Phone:$customer->ship_phone";
           $cartList = ProductCart::where('user_id', '=', $user_id)->get();

           foreach ($cartList as $cartItem) {
               $total = $total + $cartItem->price;
           }
           $vat = ($total * 3) / 100;
           $payable = $total + $vat;

           $invoice = Invoice::create([
               'total' => $total,
               'vat' => $vat,
               'cus_details' => $cus_details,
               'ship_details' => $ship_details,
               'tran_id' => $tran_id,
               'delivery_status' => $delivery_status,
               'payment_status' => $payment_status,
               'user_id' => $user_id
           ]);

           $invoice_id = $invoice->id;

           foreach ($cartList as $eachProduct) {
               InvoiceProduct::create([
                   'invoice_id' => $invoice_id,
                   'product_id' => $eachProduct->product_id,
                   'user_id' => $user_id,
                   'qty' => $eachProduct->qty,
                   'sale_price' => $eachProduct->price
               ]);
           }
           $paymentMethod = SSLCommerz::InitiatePayment($customer, $payable, $tran_id, $email);
           DB::commit();
           return ResponseHelper::out('success', array([
               'payment_method' => $paymentMethod,
               'vat' => $vat,
               'total' => $total,
               'payable' => $payable
           ]), 200);
       }catch (Exception $e){
           DB::rollBack();
           return ResponseHelper::out('fail',$e,200);
       }
   }

   public function InvoiceList(Request $request):JsonResponse
   {
       $user_id = $request->header('id');
       $data = Invoice::where('user_id',$user_id)->get();
       return ResponseHelper::out('success',$data,200);
   }

    public function InvoiceProductList(Request $request):JsonResponse
    {
        $user_id = $request->header('id');
        $invoice_id= $request->input('invoice_id');
        $data = InvoiceProduct::where(['user_id'=>$user_id,'invoice_id'=>$invoice_id])->get();
        return ResponseHelper::out('success',$data,200);
    }

    public function PaymentSuccess(Request $request){
       SSLCommerz::InitiateSuccess($request->query('tran_id'));
    }

    public function PaymentCancel(Request $request){
        SSLCommerz::InitiateCancel($request->query('tran_id'));
    }

    public function PaymentFail(Request $request){
        SSLCommerz::InitiateFail($request->query('tran_id'));
    }

    public function PaymentIPN(Request $request){
        SSLCommerz::InitiateIPN($request->input('tran_id'),$request->input('status'),$request->input('val_id'));
    }

}
