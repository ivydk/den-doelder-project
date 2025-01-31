<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Authorization\AdminController;
use App\Http\Controllers\Authorization\DriverController;
use App\Http\Controllers\BacklogController;
use App\Http\Controllers\ControlController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PlacementController;
use App\Http\Controllers\PreControlController;
use App\Http\Controllers\ProductionLineController;
use App\Http\Controllers\QualityControlController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::resource('/', AuthenticatedSessionController::class);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('authenticatedSession.destroy');
Route::get('redirects', [HomeController::class, 'index']);

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Orders
|--------------------------------------------------------------------------
*/

Route::resource('/orders', OrderController::class)->except('index');
Route::get('/orders/{order}/conversion', [OrderController::class, 'conversion'])->name('orders.conversion');
Route::get('/orders/{order}/start', [OrderController::class, 'start'])->name('orders.start');
Route::get('/orders/{order}/end', [OrderController::class, 'end'])->name('orders.end');
Route::get('/data', [OrderController::class, 'data'])->name('orders.data');

/*
|--------------------------------------------------------------------------
| Backlog
|--------------------------------------------------------------------------
*/

Route::resource('/backlog', BacklogController::class)->except(['delete', 'show']);
Route::get('/backlog/{backlog}/resolve', [BacklogController::class, 'resolve'])->name('backlog.resolve');

/*
|--------------------------------------------------------------------------
| QualityControl
|--------------------------------------------------------------------------
*/

Route::resource('/qualityControl', QualityControlController::class)->except(['index', 'show', 'delete']);
Route::get('/qualityControl/{order}', [QualityControlController::class, 'index'])->name('qualityControl.index');

/*
|--------------------------------------------------------------------------
| Pallet Locations
|--------------------------------------------------------------------------
*/

Route::resource('/placements', PlacementController::class);
Route::resource('/locations', LocationController::class);


/*
|--------------------------------------------------------------------------
| File upload
|--------------------------------------------------------------------------
*/

Route::get('file-upload', [FileUploadController::class, 'index'])->name('file-upload.index');
Route::post('store', [FileUploadController::class, 'store'])->name('file-upload.store');
Route::get('/pdf/{file}', function ($file) {
    $path = public_path('/storage/files/D4QyUTWQq9BF9vBabztsfuTiKc735a4RI7hwsDlZ.pdf');

    $header = [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . $file . '"'
    ];
    return response()->file($path, $header);
})->name('pdf');

Route::get('get-name', [FileUploadController::class, 'getName']);
/*
|--------------------------------------------------------------------------
| Language
|--------------------------------------------------------------------------
*/

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);

    return redirect()->back();
});

/*
|--------------------------------------------------------------------------
| Pre control list
|--------------------------------------------------------------------------
*/

Route::resource('pre-controls', PreControlController::class)->only('store');
Route::get('orders/{order}/pre-controls/create', [PreControlController::class, 'create'])->name('pre-controls.create');
Route::get('/pre-controls/{order}', [PreControlController::class, 'show'])->name('pre-controls.show');

/*
|--------------------------------------------------------------------------
| Production Routes
|--------------------------------------------------------------------------
*/

Route::resource('production-lines', ProductionLineController::class)->only(['show']);

/*
|--------------------------------------------------------------------------
| Control list
|--------------------------------------------------------------------------
*/

Route::resource('/controls', ControlController::class)->only('store');
Route::get('orders/{order}/controls/create', [ControlController::class, 'create'])->name('controls.create');
Route::get('/controls/{order}', [ControlController::class, 'show'])->name('controls.show');

/*
|--------------------------------------------------------------------------
| Driver Routes
|--------------------------------------------------------------------------
|
| Here is where you can driver web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "driver" middleware group. Now create something great!
|
*/

Route::middleware(['driver'])->group(function () {
    Route::get('/driver_dashboard', [DriverController::class, 'dashboard']);
    Route::put('/orders/{id}/driver_done', [OrderController::class, 'driverDone'])->name('orders.driverDone');

});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::resource('users', UserController::class);

});

/*
|--------------------------------------------------------------------------
| Password forgotten
|--------------------------------------------------------------------------
|
| Here is where we request the password reset link and handel the form
| submission. These routes are loaded by the RouteServiceProvider within
| a group which contains the "guest" middleware group.
|
*/

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);

})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);

})->middleware('guest')->name('password.update');
