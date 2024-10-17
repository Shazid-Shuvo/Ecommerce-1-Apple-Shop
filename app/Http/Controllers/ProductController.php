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
    function CartListPage(){
        return view('pages.cart-list-page');
    }

    function WishListPage(){
        return view('pages.wish-list-page');
    }
    function ProductByCategoryPage(){
        return view('pages.product-by-category-page');
    }
    function ProductDetailsPage(){
        return view('pages.product-details-page');
    }
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
            'product_id'=>$request->product_id]
        )->delete();
        return ResponseHelper::out('success',$data,200);
    }

        public function CreateCartList(Request $request)
    {
        // Get user_id from header and validate inputs
        $user_id = $request->header('id');
        $product_id = $request->input('product_id');
        $color = $request->input('color');
        $size = $request->input('size');
        $qty = $request->input('qty');

        // Validate required fields
        if (!$user_id || !$product_id || !$qty) {
            return ResponseHelper::out('failed', 'Missing required fields', 400);
        }

        // Retrieve product details
        $productDetails = Product::where('id', '=', $product_id)->first();
        if (!$productDetails) {
            return ResponseHelper::out('failed', 'Product not found', 404);
        }
        if ($productDetails->discount) {
            $Price =$productDetails->price - $productDetails->discount_price;
        } else {
            $Price = $productDetails->price;
        }
        $totalPrice = $qty * $Price;

        // Insert or update the product in the cart
        $data = ProductCart::updateOrCreate(
            [
                'user_id' => $user_id,
                'product_id' => $product_id
            ],
            [
                'user_id' => $user_id,
                'product_id' => $product_id,
                'color' => $color,
                'qty' => $qty,
                'size' => $size,
                'price' => $totalPrice
            ]
        );

    }

    public function ProductCartList(Request $request):JsonResponse{
        $user_id = $request->header('id');
        $data = ProductCart::where('user_id',$user_id)->with('product')->get();
        return ResponseHelper::out('success',$data,200);
    }

    public function DeleteCartList(Request $request):JsonResponse{
        $user_id = $request->header('id');
        $data=  ProductCart::where([
                'user_id'=>$user_id,
                'product_id'=>$request->product_id]
        )->delete();
        return ResponseHelper::out('success',$data,200);
    }

}
