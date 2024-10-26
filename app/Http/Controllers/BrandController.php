<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{

    public function BrandList():JsonResponse{
        $data = Brand::all();
        return ResponseHelper::out('success',$data,200);
    }

    public function AddBrand(Request $request)
    {
        // Validate input data

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
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

        try {
            // Process the image file
            $img = $request->file('image');
            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$user_id}-{$t}-{$file_name}";
            $img_url = "uploads/{$img_name}";

            // Upload the image to the public/uploads directory
            $img->move(public_path('uploads'), $img_name);

            // Save product to the database
            $brand = Brand::create([
                'brandName' => $request->input('name'),
                'brandImg' => $img_url,
                'user_id' => $user_id
            ]);


            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully',
                'product' => $brand
            ], 201);
        } catch (\Exception $e) {
            // Handle exceptions and return error response
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

   public function UpdateBrand(Request $request){

       $user_id=$request->header('id');
       $brand_id=$request->input('id');

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

           return Brand::where('id',$brand_id)->where('user_id',$user_id)->update([
               'brandName'=>$request->input('name'),
               'brandImg'=>$img_url,
           ]);

       }

       else {
           return Brand::where('id',$brand_id)->where('user_id',$user_id)->update([
               'brandName'=>$request->input('name'),
           ]);
       }

   }


    function DeleteBrand(Request $request)
    {
        $user_id=$request->header('id');
        $brand_id=$request->input('id');
        $filePath=$request->input('file_path');
        File::delete($filePath);
        return Brand::where('id',$brand_id)->where('user_id',$user_id)->delete();

    }


}
