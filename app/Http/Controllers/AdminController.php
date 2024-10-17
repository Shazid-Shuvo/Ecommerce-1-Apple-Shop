<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Helper\ResponseHelper;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AdminController extends Controller
{
    function AdminDashboard():View{
        return view('admin.admin-dashboard');
    }
    function AddProductPage():View{
        return view('admin.add-product');
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


    function AddProduct(Request $request):JsonResponse
    {
        $user_id = $request->header('id');
        $role = $request->header('role');
        if ($role == 'admin') {

            // Prepare File Name & Path
            $img = $request->file('image');

            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$user_id}-{$t}-{$file_name}";
            $img_url = "uploads/{$img_name}";


            // Upload File
            $img->move(public_path('uploads'), $img_name);


            // Save To Database
            $data = Product::create([
                'name' => $request->input('name'),
                'title' => $request->input('title'),
                'short_des' => $request->input('short_des'),
                'price' => $request->input('price'),
                'discount' => $request->input('discount'),
                'discount_price' => $request->input('discount_price'),
                'stock' => $request->input('stock'),
                'star' => $request->input('star'),
                'remark' => $request->input('remark'),
                'quantity' => $request->input('quantity'),
                'image' => $img_url,
                'category' => $request->input('category'),
                'brand' => $request->input('brand'),
                'user_id' => $user_id
            ]);

            return ResponseHelper::out('success', $data, 200);
        }else{
            return ResponseHelper::out('only admin can access it', '', 200);
        }
    }

}
