<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\LoginSocialiteController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\route\RouteContoller;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/* --- Auth --- */

Route::get('/', [LoginController::class, 'index'])->name('login');

Route::resource('register', RegisterController::class);
Route::resource('login', LoginController::class);

Route::get('/{provider}/login', [LoginSocialiteController::class, 'redirect'])->name('provider.login');
Route::get('/{provider}/callback', [LoginSocialiteController::class, 'callback'])->name('provider.login.callback');

// forgot password
Route::get('/forgot-password', [RouteContoller::class, 'forgotPass'])->name('get-forgotpass');
Route::post('/reset-password', [LoginController::class, 'postForgotPass'])->name('post-resetpass');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');
Route::post('/post-resetpassword', [LoginController::class, 'postResetPassword'])->name('password.update');
/* --- Auth --- */

/* Route Controller*/

Route::middleware('auth')->group(function () {

    // home
    Route::get('/{role}/home', [RouteContoller::class, 'home'])->name('home');

    // profile page

    Route::get('/profile/{slug}', [RouteContoller::class, 'profile'])->name('profile');
    Route::put('/change-ava', [ProfileController::class, 'changeFotoProfile'])->name('change-ava');
    Route::put('/change-prof', [ProfileController::class, 'changeProfile'])->name('change-profile');
    // profile page

    // verif email
    Route::post('/email/verification-notification', function (Request $request) {
        try {
            //code...
            $request->user()->sendEmailVerificationNotification();

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Success Verification link sent!'
                ]);
            }
            return back()->with('message', 'Verification link sent!');
        } catch (\Throwable $th) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Error ' . $th->getMessage()
                ]);
            }
            return back()->with('error', 'Error ' . $th->getMessage());
        }
    })->name('verification.send');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        try {

            $request->fulfill();

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Success Email verified'
                ]);
            }

            return redirect()->back()->with('success', 'Email verified');
        } catch (\Throwable $th) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Error ' . $th->getMessage()
                ]);
            }
            return redirect()->back()->with('error', 'Error ' . $th->getMessage());
        }
    })->name('verification.verify');

    // crud user
    Route::get('/{role}/data-pengguna', [RouteContoller::class, 'dataPengguna'])->name('user.list');
    Route::resource('user', UserController::class);
    Route::post('/user/deleteAll', [UserController::class, 'deleteSelected'])->name('user.select.destroy');

    // delete profile
    Route::post('/delete-account', [ProfileController::class, 'destroyProfile'])->name('profile.destroy');

    //user create with excel
    Route::post('/user-import', [UserController::class, 'createUserExcel'])->name('user.import.store');
    // crud user

    // downloads file
    Route::get('/download/{filename}', [RouteContoller::class, 'download'])->name('download.file');

    // logout
    Route::post('/logout', [RouteContoller::class, 'logout'])->name('logout');

    // Produk
    Route::get('/{role}/product', [RouteContoller::class, 'productList'])->name('product.index');
    Route::get('/{role}/product/{kodeProd}', [RouteContoller::class, 'productDetail'])->name('product.detail');
    // crud Produk
    Route::get('/admin/create/product', [ProdukController::class, 'create'])->name('product.create');
    Route::post('/admin/store/product', [ProdukController::class, 'store'])->name('product.store');
    Route::post('/product/deleteAll', [ProdukController::class, 'deleteSelected'])->name('product.select.destroy');
    Route::put('/admin/update/product', [ProdukController::class, 'update'])->name('product.update');
    //produk create with excel
    Route::post('/produk-import', [ProdukController::class, 'createProdukExcel'])->name('produk.import.store');
    // change img prod
    Route::put('/admin/update/product-image', [ProdukController::class, 'updateImgProd'])->name('produk.image.update');

    // carts
    Route::get('/{role}/my-cart/{user_id}', [RouteContoller::class, 'myCart'])->name('cart.myCart');
    Route::post('/add-to-cart/{kodeProd}', [CartController::class, 'addToCart'])->name('cart.addProduct');
    Route::put('/update-qty/{newQty}', [CartController::class, 'updateQty'])->name('cart.qty.update');
    Route::delete('/delete-cart/{cartId}', [CartController::class, 'deleteCart'])->name('cart.product.delete');
    Route::post('/checkout-cart', [CartController::class, 'checkout'])->name('cart.checkout');

    // transaksi
    Route::get('/{role}/transactions', [RouteContoller::class, 'transactionList'])->name('transaction.index');
    Route::get('/{role}/transaction/{id}', [RouteContoller::class, 'transactionDetail'])->name('transaction.detail');
    Route::post('/pay-transaction', [TransaksiController::class, 'payTransaction'])->name('transaction.pay');
    Route::get('/{role}/receipt/{trxID}', [RouteContoller::class, 'receiptTrx'])->name('transaction.receipt');
    Route::post('/transactions/success/{trxID}', [TransaksiController::class, 'successTransaction'])->name('transaction.success');
    Route::post('/transactions/cancel/{trxID}', [TransaksiController::class, 'cancelTransaction'])->name('transaction.cancel');

    // mail
    Route::get('/mail-receipt/{trxID}/{email}', [MailController::class, 'sendReceipt'])->name('mail.receipt');

    // check midtrans
    Route::get('/test-mid', [CartController::class, 'getSnapToken']);
});

/* Route Controller*/
