<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Helper\ResponseHelper;
use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AdminController extends Controller
{
    function AdminDashboard(Request $request): View|RedirectResponse {
        $role = $request->header('role');

        // Check if the role exists and is 'admin'
        if ($role !== 'admin') {
            return redirect("/userLogin");  // Return the redirect response
        }

        // Render the admin dashboard view
        return view('pages.admin.admin-dashboard');
    }

    function AddProductPage():View{
        return view('admin.add-product');
    }
    function BrandPage():View{
        return view('pages.admin.brand-page');
    }
    function AdminLoginPage():View{
        return view('admin.admin-login');
    }
    public function AdminLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()
            ], 400);
        }

        // Fetch the user based on the email
        $user = User::where('email', $request->input('email'))->first();
        if($user->role=='admin') {
            if ($user->password === $request->input('password') ||
                Hash::check($request->input('password'), $user->password)) {
                // Password matches, generate a token
                $token = JWTToken::CreateToken($user->email, $user->id, $user->role);

                return response()->json([
                    'status' => 'success',
                    'message' => 'User login successful'
                ], 200)->cookie('token', $token, 60 * 24 * 30); // Token stored as a cookie
            } else {
                // Authentication failed
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Invalid email or password'
                ], 401);
            }
        }
}


    public function AddProduct(Request $request)
    {
        try {
        // Validate input data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'short_des' => 'required|string',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
            'discount_price' => 'required|numeric',
            'stock' => 'required|integer',
            'star' => 'required|numeric|min:0|max:5',
            'remark' => 'required|string',
            'category' => 'required',
            'brand' => 'required',
            'image'=>'required'
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Get headers
        $user_id = $request->header('id');
        $role = $request->header('role');

        // Check if user is admin
        if ($role !== 'admin') {
            return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorized access'
            ], 401);
        }

        // Check if image file is present
        if (!$request->hasFile('image')) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Image is required'
            ], 400);
        }


            // Process the image file
            $img = $request->file('image');
            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$user_id}-{$t}-{$file_name}";
            $img_url = "uploads/{$img_name}";

            // Upload the image to the public/uploads directory
            $img->move(public_path('uploads'), $img_name);

            // Save product to the database
            $product = Product::create([
                'name' => $request->input('name'),
                'title' => $request->input('title'),
                'short_des' => $request->input('short_des'),
                'price' => $request->input('price'),
                'discount' => $request->input('discount'),
                'discount_price' => $request->input('discount_price'),
                'stock' => $request->input('stock'),
                'star' => $request->input('star'),
                'remark' => $request->input('remark'),
                'image' => $img_url,
                'category_id' => $request->input('category'),
                'brand_id' => $request->input('brand'),
                'user_id' => $user_id
            ]);

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully',
                'product' => $product
            ], 201);
        } catch (\Exception $e) {
            // Handle exceptions and return error response
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    function updateProduct(Request $request)
    {
        $user_id=$request->header('id');
        $product_id=$request->input('id');

        if ($request->hasFile('image')) {

            // Upload New File
            $img=$request->file('image');
            $t=time();
            $file_name=$img->getClientOriginalName();
            $img_name="{$user_id}-{$t}-{$file_name}";
            $img_url="uploads/{$img_name}";
            $img->move(public_path('uploads'),$img_name);

            // Delete Old File
            $filePath=$request->input('file_path');
            File::delete($filePath);

            // Update Product

            return Product::where('id',$product_id)->where('user_id',$user_id)->update([
                'name' => $request->input('name'),
                'title' => $request->input('title'),
                'short_des' => $request->input('short_des'),
                'price' => $request->input('price'),
                'discount' => $request->input('discount'),
                'discount_price' => $request->input('discount_price'),
                'stock' => $request->input('stock'),
                'star' => $request->input('star'),
                'remark' => $request->input('remark'),
                'image' => $img_url,
                'category_id' => $request->input('category'),
                'brand_id' => $request->input('brand'),
                'user_id' => $user_id
            ]);

        }

        else {
            return Product::where('id',$product_id)->where('user_id',$user_id)->update([
                'name' => $request->input('name'),
                'title' => $request->input('title'),
                'short_des' => $request->input('short_des'),
                'price' => $request->input('price'),
                'discount' => $request->input('discount'),
                'discount_price' => $request->input('discount_price'),
                'stock' => $request->input('stock'),
                'star' => $request->input('star'),
                'remark' => $request->input('remark'),
                'category_id' => $request->input('category'),
                'brand_id' => $request->input('brand'),
                'user_id' => $user_id
            ]);
        }
    }

    function deleteProduct(Request $request)
    {
        $user_id=$request->header('id');
        $product_id=$request->input('id');
        $filePath=$request->input('file_path');
        File::delete($filePath);
        return Product::where('id',$product_id)->where('user_id',$user_id)->delete();

    }

}



