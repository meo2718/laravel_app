<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComponentTestController;
use App\Http\Controllers\LifeCycleTestController;
use App\Http\Controllers\User\ItemController;
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

Route::get('/', function () {
    //prefix設定
    return view('user.welcome');
});

//userのルート 
    Route::middleware('auth:users')->group(function(){
        //'/'で一覧画面遷移→ログアウト後'/'に遷移するようにRouteServiceProviderに記載
        Route::get('/', [ItemController::class, 'index'])->name('items.index');
        Route::match(['get','post'],'edit/{shop}', [ItemController::class, 'edit'])->name('items.edit');
});

Route::get('/component-test1', [ComponentTestController::class, 'showComponent1']);
Route::get('/component-test2', [ComponentTestController::class, 'showComponent2']);
Route::get('/servicecontainer-test', [LifeCycleTestController::class, 'showServiceControllerTest']);
Route::get('/serviceprovider-test', [LifeCycleTestController::class, 'showServiceProviderTest']);
require __DIR__.'/auth.php';