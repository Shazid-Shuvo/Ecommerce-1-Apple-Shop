<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function CreateBrand(Request $request):JsonResponse{

        $user_id=$request->header('id');
        $brandName = $request->input('brandName');
        $img=$request->file('image');

        $t=time();
        $file_name=$img->getClientOriginalName();
        $img_name="{$t}-{$file_name}";
        $img_url="uploads/{$img_name}";

        // Upload File
        $img->move(public_path('uploads'),$img_name);

        $data=Brand::create([
            'brandName'=>$brandName,
            'image'=>$img_url,
            'user_id'=>$user_id
        ]);

        return ResponseHelper::out('success',$data,200);
    }
   public function BrandList():JsonResponse{
       $data = Brand::all();
       return ResponseHelper::out('success',$data,200);
   }
}
