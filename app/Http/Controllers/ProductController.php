<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\CustomerProfile;
use App\Models\Product;
use App\Models\ProductCart;
use App\Models\ProductDetails;
use App\Models\ProductReview;
use App\Models\ProductSlider;
use App\Models\ProductWish;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  public function ListProductByCategory(Request $request):JsonResponse{
       $data=Product::where('category_id',$request->id)->with('brand','category')->get();
       return ResponseHelper::out('success',$data,200);
   }

    public function ListProductByBrand(Request $request):JsonResponse{
        $data=Product::where('brand_id',$request->id)->with('brand','category')->get();
        return ResponseHelper::out('success',$data,200);
    }
   public function ListProductByRemark(Request $request):JsonResponse{
        $data=Product::where('remark',$request->remark)->with('brand','category')->get();
        return ResponseHelper::out('success',$data,200);
    }

    public function ListProductSlider():JsonResponse
    {
        $data = ProductSlider::all();
        return ResponseHelper::out('success',$data,200);
    }

    public function ProductDetailsById(Request $request):JsonResponse{
        $data=ProductDetails::where('product_id',$request->id)->with('product','product.category','product.brand')->get();
        return ResponseHelper::out('success',$data,200);
    }

    public function ListReviewProduct(Request $request):JsonResponse{
      $data = ProductReview::where('product_id',$request->product_id)->
          with(['profile'=>function($query){
              $query->select('id','cus_name');
          }]);
        return ResponseHelper::out('success',$data,200);
    }

    public function CreateReview(Request $request):JsonResponse
    {
        $user_id = $request->header('id');
        $profile = CustomerProfile::where('user_id',$user_id)->first();
        if($profile){
            $request->merge(['customer_id'=>$profile->id]);
            $data = ProductReview::updateOrCreate([
                'customer_id'=>$profile->id,
                'product_id'=>$request->input('product_id')],
                $request->input()
            );
            return ResponseHelper::out('success',$data,200);
        }else{
            return ResponseHelper::out('Fail','Customer Profile does not exist',200);
        }
    }

    public function ProductWishList(Request $request):JsonResponse{
        $user_id = $request->header('id');
        $data = ProductWish::where('user_id',$user_id)->with('product')->get();
        return ResponseHelper::out('success',$data,200);
    }

    public function CreateWishList(Request $request):JsonResponse{
        $user_id = $request->header('id');
        $data=  ProductWish::updateOrCreate(
            [
            'user_id' => $user_id,
            'product_id'=>$request->input('product_id')
            ],
            [
            'user_id' => $user_id,
            'product_id'=>$request->input('product_id')
            ],
            $request->input()
        );
        return ResponseHelper::out('success',$data,200);
    }

    public function DeleteWishList(Request $request):JsonResponse{
        $user_id = $request->header('id');
        $data=  ProductWish::where([
            'user_id'=>$user_id,
            'product_id'=>$request->input('product_id')]
        )->delete();
        return ResponseHelper::out('success',$data,200);
    }

    public function CreateCartList(Request $request):JsonResponse
    {
        $user_id = $request->header('id');
        $product_id = $request->input('product_id');
        $color = $request->input('color');
        $size = $request->input('size');
        $qty = $request->input('qty');
        $Price = 0;
        $productDetails = Product::whrere('id', '=', $product_id)->first();
        if ($productDetails->discount) {
            $Price = $productDetails->discount_price;
        } else {
            $Price = $productDetails->price;
        }
        $totalPrice = $qty * $Price;

        $data=  ProductCart::updateOrCreate(
            [
                'user_id' => $user_id,
                'product_id'=>$product_id
            ],
            [
                'user_id' => $user_id,
                'product_id'=>$product_id,
                'color'=>$color,
                'qty'=>$qty,
                'size'=>$size,
                'price'=>$Price
            ]);
        return ResponseHelper::out('success',$data,200);

    }

    public function ProductCartList(Request $request):JsonResponse{
        $user_id = $request->header('id');
        $data = ProductCart::where('user_id',$user_id)->with('product')->get();
        return ResponseHelper::out('success',$data,200);
    }

    public function DeleteCartList(Request $request):JsonResponse{
        $user_id = $request->header('id');
        $data=  ProductWish::where([
                'user_id'=>$user_id,
                'product_id'=>$request->input('product_id')]
        )->delete();
        return ResponseHelper::out('success',$data,200);
    }

    function createProduct(Request $request):JsonResponse
    {
        $user_id=$request->header('id');

        // Prepare File Name & Path
        $img=$request->file('image');

        $t=time();
        $file_name=$img->getClientOriginalName();
        $img_name="{$user_id}-{$t}-{$file_name}";
        $img_url="uploads/{$img_name}";


        // Upload File
        $img->move(public_path('uploads'),$img_name);


        // Save To Database
        $data= Product::create([
            'name'=>$request->input('name'),
            'title'=>$request->input('title'),
            'short_des'=>$request->input('short_des'),
            'price'=>$request->input('price'),
            'discount'=>$request->input('discount'),
            'discount_price'=>$request->input('discount_price'),
            'stock'=>$request->input('stock'),
            'star'=>$request->input('star'),
            'remark'=>$request->input('remark'),
            'unit'=>$request->input('unit'),
            'quantity'=>$request->input('quantity'),
            'image'=>$img_url,
            'category'=>$request->input('category'),
            'user_id'=>$user_id
        ]);

        return ResponseHelper::out('success',$data,200);
    }





}
