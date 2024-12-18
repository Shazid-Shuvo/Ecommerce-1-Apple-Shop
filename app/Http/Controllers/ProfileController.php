<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\CustomerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class ProfileController extends Controller
{
    function ProfilePage(){
        return view("pages.profile-page");
    }

    public function CreateProfile(Request $request):JsonResponse
    {
        try {
            $user_id = $request->header('id');
            $request->merge(['user_id'=>$user_id]);
          $data=  CustomerProfile::updateOrCreate([
                'user_id' => $user_id
                  ],
              $request->input()
          );
            return ResponseHelper::out('success', $data, 200);
        }catch (Exception $e){
            return ResponseHelper::out('success', $e, 200);
        }
    }

    public function ReadProfile(Request $request):JsonResponse{
        $user_id = $request->header('id');
        $data = CustomerProfile::where('user_id',$user_id)->with('user')->first();
        return ResponseHelper::out('success', $data, 200);
    }
}
