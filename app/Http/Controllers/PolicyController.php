<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Policy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    function PolicyPage(){
        return view('pages.policy-page');
    }
    function PolicyByType(Request $request):JsonResponse{
        $data=Policy::where('type','=',$request->type)->first();
        return ResponseHelper::out('success',$data,200);
    }
}
