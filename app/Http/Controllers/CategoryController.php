<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public function CreateCategory(Request $request):JsonResponse{

        $user_id=$request->header('id');
        $CategoryName = $request->input('CategoryName');
        $img=$request->file('image');

        $t=time();
        $file_name=$img->getClientOriginalName();
        $img_name="{$t}-{$file_name}";
        $img_url="uploads/{$img_name}";

        // Upload File
        $img->move(public_path('uploads'),$img_name);

        $data=Category::create([
            'categoryName'=>$CategoryName,
            'categoryImg'=>$img_url,
            'user_id'=>$user_id
        ]);

        return ResponseHelper::out('success',$data,200);
    }
    public function CategoryList():JsonResponse{
        $data = Category::all();
        return ResponseHelper::out('success',$data,200);
    }
}
