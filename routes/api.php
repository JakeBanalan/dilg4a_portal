<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AppItemController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\RFQController;
use App\Http\Controllers\RICTUController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CRUDController;
use App\Http\Controllers\AbstractController;
use App\Http\Controllers\HRSController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PositionController;



use App\Models\AppItemModel;
use App\Models\PurchaseRequestItemModel;
use App\Models\PurchaseRequestModel;
use App\Models\RICTUModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    // Protected routes here
    Route::get('/authenticated', function (Request $request) {
        return response()->json(['authenticated' => true]);
    });
    
    // // Other protected routes...
});
// Route::get('/authenticated', function (Request $request) {
//     return response()->json(['authenticated' => auth()->check()]);
// });



Route::middleware('api')->group(function () {
    Route::get('fetchAppData', [AppItemController::class, 'fetchAppData']);
});

Route::middleware('api')->group(function () {
    Route::get('get_purchase_request_details', [PurchaseRequestController::class, 'getPurchaseRequestDetails']);
});

Route::middleware('api')->group(function () {
    Route::get('getPurchaseOrder', [SupplierController::class, 'getPurchaseOrder']);
});
Route::middleware('api')->group(function () {
    Route::get('appitems', [AppItemController::class, 'getAppData']);
});

Route::middleware('api')->group(function () {
    Route::get('fetch_ict_request/{status}', [RICTUController::class, 'fetch_ict_request']);
});

Route::middleware('api')->group(function () {
    Route::get('load_abstract_data', [AbstractController::class, 'load_abstract_data']);
});

Route::middleware('api')->group(function () {
    Route::get('getPurchaseRequest', [PurchaseRequestController::class, 'getPurchaseRequest']);
});

Route::middleware('api')->group(function () {
    Route::get('generatePurchaseRequestNo', [PurchaseRequestController::class, 'generatePurchaseRequestNo']);
});

Route::middleware('api')->group(function () {
    Route::get('generateRFQNo', [RFQController::class, 'generateRFQNo']);
});


Route::middleware('api')->group(function () {
    Route::get('generateAbstractNo', [AbstractController::class, 'generateAbstractNo']);
});

Route::middleware('api')->group(function () {
    Route::get('generatePurchaseOrderNo', [PurchaseOrderController::class, 'generatePurchaseOrderNo']);
});


Route::middleware('api')->group(function () {
    Route::get('fetch_created_abstract', [AbstractController::class, 'fetch_created_abstract']);
});

Route::middleware('api')->group(function () {
    Route::get('generateICTControlNo', [RICTUController::class, 'generateICTControlNo']);
});
Route::middleware('api')->group(function () {
    Route::get('fetchSubmittedPurchaseRequest', [RFQController::class, 'fetchSubmittedPurchaseRequest']);
});

Route::middleware('api')->group(function () {
    Route::get('fetch_rfq', [RFQController::class, 'fetch_rfq']);
});

Route::middleware('api')->group(function () {
    Route::get('fetch_supplier', [SupplierController::class, 'fetch_supplier']);
});

Route::middleware('api')->group(function () {
    Route::get('generateStockNumber', [AppItemController::class, 'generateStockNumber']);
});



Route::middleware('api')->group(function () {
    Route::get('countTotalItem/{cur_year}', [AppItemController::class, 'countTotalItem']);
});


Route::middleware('api')->group(function () {
    Route::get('countICTRequest/{cur_year}', [RICTUController::class,'countICTRequest']);
});

Route::middleware('api')->group(function () {
    Route::get('countDRAFT/{status}', [RICTUController::class,'countDRAFT']);
});

Route::middleware('api')->group(function () {
    Route::get('countPurchaseRequestStatistics/{cur_year}', [PurchaseRequestController::class,'countPurchaseRequestStatistics']);
});

Route::middleware('api')->group(function () {
    Route::get('getActiveAccounts', [HRSController::class,'getActiveAccounts']);
});

Route::middleware('api')->group(function () {
    Route::get('countCancelledPR/{userId}', [PurchaseRequestController::class, 'countCancelledPR']);
});


Route::middleware('api')->group(function () {
    Route::get('countUserTotalPR/{userId}', [PurchaseRequestController::class, 'countUserTotalPR']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchCartItemInfo/{itemSelected}', [PurchaseRequestController::class, 'fetchCartItemInfo']);
});


Route::middleware('api')->group(function () {
    Route::get('app_category', [AppItemController::class, 'app_category']);
});


Route::middleware('api')->group(function () {
    Route::get('viewPurchaseRequest/{id}', [PurchaseRequestController::class, 'viewPurchaseRequest']);
});

Route::middleware('api')->group(function () {
    Route::get('get_app_details/{id}', [PurchaseRequestController::class, 'get_app_details']);
});

Route::middleware('api')->group(function () {
    Route::get('viewRFQItems/{id}', [RFQController::class, 'viewRFQItems']);
});
Route::middleware('api')->group(function () {
    Route::get('fetchUser/{userId}',[UserController::class, 'fetchUserData']);
});

Route::middleware('api')->group(function () {
    Route::get('getICTData/{id}',[RICTUController::class, 'getICTData']);
});
Route::middleware('api')->group(function () {
    Route::get('getUserDetails/{id}',[UserController::class, 'getUserDetails']);
});



Route::middleware('api')->group(function () {
    Route::get('getPosition',[PositionController::class, 'getPosition']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchEventData',[CalendarController::class, 'fetchEventData']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchEventDetails',[CalendarController::class, 'fetchEventDetails']);
});

Route::post('/logout', [UserController::class, 'logout']);


// Route::post('logout', function (Request $request) {
//     $request->user()->token()->revoke(); // Revoke the user's access token
//     // Clear any other cached data or session information if necessary
//     return response()->json(['message' => 'Successfully logged out']);
// })->middleware('auth:api');
Route::post('login',[UserController::class,'login']);
// Route::post('logout',[UserController::class,'logout']);


Route::post('updateUserDetails',[UserController::class,'updateUserDetails']);
Route::post('post_add_appItem',[AppItemController::class,'post_add_appItem']);
Route::post('post_create_ict_request',[RICTUController::class,'post_create_ict_request']);
Route::post('post_update_cart',[PurchaseRequestController::class,'post_update_cart']);
Route::post('post_insert_pritem',[PurchaseRequestController::class,'post_insert_pritem']);
Route::post('post_remove_pritem',[PurchaseRequestController::class,'post_remove_pritem']);
Route::post('post_insert_purchaseNo',[PurchaseRequestController::class,'post_insert_purchaseNo']);
Route::post('post_create_purchaseRequest',[PurchaseRequestController::class,'post_create_purchaseRequest']);
Route::post('post_update_purchaseRequestDetailsForm',[PurchaseRequestController::class,'post_update_purchaseRequestDetailsForm']);
Route::post('fetchCart', [PurchaseRequestController::class, 'fetchCart']);
Route::post('fetchPurchaseReqData', [PurchaseRequestController::class, 'fetchPurchaseReqData']);
Route::post('fetchSubmittedtoGSS', [PurchaseRequestController::class, 'fetchSubmittedtoGSS']);
Route::post('fetch_app_item', [SupplierController::class, 'fetch_app_item']);
Route::post('fetch_app_item_details', [SupplierController::class, 'fetch_app_item_details']);
Route::post('fetchPurchaseRequestData', [PurchaseOrderController::class, 'fetchPurchaseRequestData']);
Route::post('fetch_winner_supplier', [PurchaseOrderController::class, 'fetch_winner_supplier']);
Route::post('fetch_supplier_quotation', [SupplierController::class, 'fetch_supplier_quotation']);
Route::post('fetch_supplier_title', [SupplierController::class, 'fetch_supplier_title']);
Route::post('post_supplier_quote', [SupplierController::class, 'post_supplier_quote']);
Route::post('post_create_abstract', [AbstractController::class, 'post_create_abstract']);
Route::post('post_create_po',[PurchaseOrderController::class,'post_create_po']);
Route::post('total_amount', [PurchaseRequestController::class, 'total_amount']);    
// Route::post('post_update_status', 'PurchaseRequestController@post_update_status')->name('post.update.status');
Route::post('post_update_status',[PurchaseRequestController::class,'post_update_status']);
Route::post('post_addCode',[PurchaseRequestController::class,'post_addCode']);
Route::post('fetch_ict_req_details',[RICTUController::class,'fetch_ict_req_details']);


Route::post('post_complete',[CRUDController::class,'post_complete']);
Route::post('post_received_ict_request',[CRUDController::class,'post_received_ict_request']);
Route::post('getSmallestQuotationsForItems',[SupplierController::class,'getSmallestQuotationsForItems']);




// R F Q
Route::post('post_create_rfq',[RFQController::class,'post_create_rfq']);

//CALENDAR
//C A L E N D A R 
Route::post('PostEventData',[CalendarController::class,'PostEventData']);
Route::post('PostUpdateEvent',[CalendarController::class,'PostUpdateEvent']);
Route::post('post_create_event',[CalendarController::class,'post_create_event']);



//C A L E N D A R 
Route::post('PostEventData',[CalendarController::class,'PostEventData']);
Route::post('PostUpdateEvent',[CalendarController::class,'PostUpdateEvent']);




// E X P O R T
// routes/web.php or routes/api.php
Route::middleware('api')->group(function () {
    Route::get('export-purchase-request/{id}', [PurchaseRequestController::class, 'viewPurchaseRequest']);
});

Route::middleware('api')->group(function () {
    Route::get('export-rfq/{id}', [RFQController::class, 'viewRFQItems']);
});

Route::middleware('api')->group(function () {
    Route::get('export-abstract/{id}', [AbstractController::class, 'load_abstract_info']);
});








