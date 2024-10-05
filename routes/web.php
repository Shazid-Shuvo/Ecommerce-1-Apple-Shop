<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

//Page route for login and reg

Route::get('/userRegistration', [userController::class,'userRegistrationPage']);
Route::get('/userLogin', [userController::class,'userLoginPage']);
Route::get('/sendOtp', [userController::class,'sendOtpCodePage']);
Route::get('/verifyOtp', [userController::class,'verifyOtpPage']);
Route::get('/resetPassword', [userController::class,'resetPasswordPage'])
    ->middleware(tokenVerificationMiddleware::class);

//API route for login and reg

Route::post('/user-registration', [userController::class, 'userRegistration']);
Route::post('/user-login', [userController::class,'userLogin']);
Route::post('/otp-send', [userController::class,'sendOtpCode']);
Route::post('/otp-verify', [userController::class,'verifyOtp']);
Route::post('/reset-password', [userController::class,'resetPassword'])
    ->middleware(tokenVerificationMiddleware::class);
Route::get('/user-profile',[UserController::class,'UserProfile'])
    ->middleware([TokenVerificationMiddleware::class]);
Route::post('/user-update',[UserController::class,'updateProfile'])
    ->middleware([TokenVerificationMiddleware::class]);


//API ROUTES/ Brand List

Route::get("/BrandList",[BrandController::class,'BrandList']);
Route::post("/CreateBrand",[BrandController::class,'CreateBrand']);

// Category List

Route::get("/CategoryList",[CategoryController::class,'CategoryList']);

// Product List

Route::get("/ListProductByCategory/{id}",[ProductController::class,'ListProductByCategory']);
Route::get("/ListProductByBrand/{id}",[ProductController::class,'ListProductByBrand']);
Route::get("/ListProductByRemark/{remark}",[ProductController::class,'ListProductByRemark']);

//Customer

Route::post("/CreateProfile",[ProfileController::class,'CreateProfile'])
    ->middleware(TokenVerificationMiddleware::class);
Route::get("/ReadProfile",[ProfileController::class,'ReadProfile'])
    ->middleware(TokenVerificationMiddleware::class);

//Product Review

Route::post("/CreateProductReview",[ProductController::class,'CreateReview'])
    ->middleware(TokenVerificationMiddleware::class);

//Product Wish

Route::get("/ProductWishList",[ProductController::class,'ProductWishList'])->middleware(TokenVerificationMiddleware::class);;
Route::post("/CreateWishList",[ProductController::class,'CreateWishList'])->middleware(TokenVerificationMiddleware::class);;
Route::post("/DeleteWishList",[ProductController::class,'DeleteWishList'])->middleware(TokenVerificationMiddleware::class);;

//Product CArt

Route::get("/ProductCartList",[ProductController::class,'ProductCartList'])->middleware(TokenVerificationMiddleware::class);;
Route::post("/CreateCartList",[ProductController::class,'CreateCartList'])->middleware(TokenVerificationMiddleware::class);;
Route::post("/DeleteWishList",[ProductController::class,'DeleteWishList'])->middleware(TokenVerificationMiddleware::class);;

//sliders

Route::get("/ListProductSlider",[ProductController::class,'ListProductSlider']);

// Product Details

Route::get("/ProductDetailsById/{id}",[ProductController::class,'ProductDetailsById']);
Route::get("/ListReviewProduct/{product_id}",[ProductController::class,'ListReviewProduct']);

//Policy

Route::get("/PolicyByType/{type}",[PolicyController::class,'PolicyByType']);

//Page routes

Route::post("/userLogin",[UserController::class,'UserLogin']);
Route::post("/verifyLogin",[UserController::class,'VerifyLogin']);

//Invoice and Payment

Route::post("/CreateInvoice",[InvoiceController::class,'CreateInvoice'])
    ->middleware(TokenVerificationMiddleware::class);
Route::get("/InvoiceList",[InvoiceController::class,'InvoiceList'])
    ->middleware(TokenVerificationMiddleware::class);
Route::get("/InvoiceProductList",[InvoiceController::class,'InvoiceProductList'])
    ->middleware(TokenVerificationMiddleware::class);

//Payment

Route::post("/PaymentSuccess",[InvoiceController::class,'PaymentSuccess']);
Route::post("/PaymentCancel",[InvoiceController::class,'PaymentCancel']);
Route::post("/PaymentFail",[InvoiceController::class,'PaymentFail']);



//Page Route

Route::get("/HomePage",[HomeController::class,'HomePage']);





//Logout
Route::get('/logout',[UserController::class,'UserLogout']);
