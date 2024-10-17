<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Helper\ResponseHelper;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class UserController extends Controller
{
    function dash():View{
        return view('pages.dash-page');
    }
    function userRegistrationPage():View{
        return view('pages.registration-page');
    }
    function userLoginPage():View{
        return view('pages.login-page');
    }
    function sendOtpCodePage():View{
        return view('pages.send-otp');
    }
    function verifyOtpPage():View{
        return view('pages.verify-otp');
    }
    function resetPasswordPage():View{
        return view('pages.reset-pass');
    }

    public function userRegistration(Request $request)
    {
        try {
            // Validate incoming request
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:4'
            ]);

            // If validation fails, return JSON error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => $validator->errors()->first()
                ], 400);
            }

            // Hash password and set role
            $email = $request->input('email');
            $password = Hash::make($request->input('password'));
            $role = 'user';
            $otp=0;

            // Create user record in the database
            User::create([
                'email' => $email,
                'password' => $password,
                'role' => $role , // Ensure 'role' is fillable
                'otp'=>$otp
            ]);

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'User registration successful'
            ], 200);

        } catch (\Exception $e) {
            // Log any exceptions to the log file for debugging
            \Log::error('Registration Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'failed',
                'message' => 'User registration failed'
            ], 500);
        }
    }

    public function userLogin(Request $request)
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

        if (  $user->password === $request->input('password') ||  // Plain text check
            Hash::check($request->input('password'), $user->password) ) {
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

    function sendOtpCode(Request $request){
        $email = $request->input('email');
        $otp = rand(1000,9999);
        $count= User::where('email','=',$email)->count();
        if ($count==1){
            Mail::to($email)->send(new OTPmail($otp));
            User::where('email','=',$email)->update(['otp'=>$otp]);
            return response()->json([
                'status'=>'success',
                'message'=>'OTP send to your email successfully',
            ],'200');
        }
        else{
            return response()->json([
                'status'=>'failed',
                'message'=>'unauthorized'
            ],'401');
        }
    }
    function verifyOtp(Request $request){
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email','=',$email)->
        where('otp','=',$otp)->count();
        if ($count==1){

            User::where('email','=',$email)->update(['otp'=>'0']);

            $token = jwtToken::CreateTokenForSetPassword($request->input('email'));
            return response()->json([
                'status'=>'success',
                'message'=>'Otp verification successful',
            ],'200')->cookie('token',$token,60*24*30);
        }

        else{
            return response()->json([
                'status'=>'failed',
                'message'=>'unauthorized'
            ],'401');
        }
    }
    function resetPassword(Request $request){
        try {
            $email = $request->header('email');
            $password = $request->input('password');
            User::where('email', '=', $email)->update(['password' => $password]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request successful',
            ], '200');
        }
        catch (Exception $exception){
            return response()->json([
                'status'=>'failed',
                'message'=>'unauthorized'
            ],'401');
        }
    }
    function userLogout(){
        return redirect('/userLogin')->cookie('token','',-1);
    }
}
