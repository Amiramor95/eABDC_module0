<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\FiMMUserController;
use App\Http\Controllers\DashboardChartTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

Route::get('name', function(){
 return DB::table('CIRCULAR_EVENT_DOCUMENT')->where('CIRCULAR_EVENT_ID',65)->select('DOC_BLOB')->get();
});

//Route::get('casutcreport', [DashboardChartTypeController::class, 'getCasUtcTaggingListReport'])->name('Get report chart');
// Route::get('/get_fimm_login_status', function(Request $request){
//     Log::info( "User ID WEB ===>".$request);
//    // return DB::table('admin_management.USER AS USER')->where('USER.USER_ID',7)->select('USER.ISLOGIN')->get();
//    });
// Route::get('/get_fimm_login_status', 'FiMMUserController@getLoginStatus');

//Route::get('get_fimm_login_status', [FiMMUserController::class, 'getLoginStatus'])->name('Get User Login Status');