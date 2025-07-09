<?php

use App\Models\RICTUModel;
use App\Models\AppItemModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\PurchaseRequestModel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HRSController;
use App\Http\Controllers\QMSController;
use App\Http\Controllers\RFQController;
use App\Http\Controllers\CRUDController;
use App\Http\Controllers\UserController;
use App\Models\PurchaseRequestItemModel;
use App\Http\Controllers\RICTUController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\AppItemController;
use App\Http\Controllers\AbstractController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\QMSQuarterlyLNDController;
use App\Http\Controllers\QMSMonthlyExportController;
use App\Http\Controllers\QMSQuarterlyExportController;
use App\Http\Controllers\DailyTimeRecordController;

use App\Http\Controllers\FundSourceController;


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
    Route::get('fetchFundSources', [FundSourceController::class, 'fetchFundSources']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchAppData', [AppItemController::class, 'fetchAppData']);
});

Route::middleware('api')->group(function () {
    Route::get('get_purchase_request_details', [PurchaseRequestController::class, 'getPurchaseRequestDetails']);
});
Route::get('fetchAppDataById', [AppItemController::class, 'fetchAppDataById']);

Route::middleware('api')->group(function () {
    Route::get('getPurchaseOrder', [SupplierController::class, 'getPurchaseOrder']);
});
Route::middleware('api')->group(function () {
    Route::get('appitems', [AppItemController::class, 'getAppData']);
});

Route::middleware('api')->group(function () {
    Route::get('fetch_ict_request/{status}', [RICTUController::class, 'fetch_ict_request']);
});

Route::middleware('auth:api')->get('/getUserData', [RICTUController::class, 'getUserData']);

Route::middleware('api')->group(function () {
    Route::get('fetch_ict_perUser/{status}/{userID}', [RICTUController::class, 'fetch_ict_perUser']);
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
    Route::get('fetchRFQ', [RFQController::class, 'fetchRFQ']);
});

Route::middleware('api')->group(function () {
    Route::get('fetch_rfq', [RFQController::class, 'fetch_rfq']);
});

Route::middleware('api')->group(function () {
    Route::get('ExportRFQ/{id}', [RFQController::class, 'ExportRFQ']);
});

Route::middleware('api')->group(function () {
    Route::get('fetch_supplier', [SupplierController::class, 'fetch_supplier']);
});

Route::middleware('api')->group(function () {
    Route::get('generate-stock-number', [AppItemController::class, 'generateStockNumber']);
});

Route::middleware('api')->group(function () {
    Route::get('countTotalItem/{cur_year}', [AppItemController::class, 'countTotalItem']);
});

Route::middleware('api')->group(function () {
    Route::get('totalCountICTRequest/{year}', [RICTUController::class, 'totalCountICTrequest']);
});

Route::middleware('api')->group(function () {
    Route::get('totalCountDraft', [RICTUController::class, 'totalCountDraft']);
});

Route::middleware('api')->group(function () {
    Route::get('get-ict-personnel', [RICTUController::class, 'getICTpersonnel']);
});

Route::middleware('api')->group(function () {
    Route::get('/totalCountICTRequest', [RICTUController::class, 'totalCountICTrequest']);
});

Route::middleware('api')->group(function () {
    Route::get('countDRAFT/{userId}', [RICTUController::class, 'countDRAFT']);
    Route::get('/totalCountDraft', [RICTUController::class, 'totalCountDraft']);
});

Route::middleware('auth:api')->get('/getUserData', [RICTUController::class, 'getUserData']);
Route::middleware('api')->group(function () {
    Route::get('/countICTRequest/{userId}', [RICTUController::class, 'countICTRequest']);
});

Route::middleware('api')->group(function () {
    Route::get('/countDRAFT/{userId}', [RICTUController::class, 'countDRAFT']);
});

// Route::middleware('api')->group(function () {
//     Route::get('/countHardwareRequest/{userId}', [RICTUController::class, 'countHardwareRequest']);
//     Route::get('/countSoftwareRequest/{userId}', [RICTUController::class, 'countSoftwareRequest']);
// });

Route::middleware('api')->group(function () {
    Route::get('getActiveAccounts', [HRSController::class, 'getActiveAccounts']);
});

Route::middleware('api')->group(function () {
    Route::get('/monthly-overview', [PurchaseRequestController::class, 'getMonthlyOverview']);
    Route::get('/department-overview', [PurchaseRequestController::class, 'getDepartmentOverview']);
});

Route::middleware('api')->group(function () {
    Route::get('countUserTotalPR/{userId}', [PurchaseRequestController::class, 'countUserTotalPR']);
});

Route::middleware('api')->group(function () {
    Route::get('app_category', [AppItemController::class, 'app_category']);
});

Route::middleware('api')->group(function () {
    Route::get('viewPurchaseRequest/{id}', [PurchaseRequestController::class, 'viewPurchaseRequest']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchRFQItems/{rfqID}', [RFQController::class, 'fetchRFQItems']);
});

Route::middleware('api')->group(function () {
    Route::get('get_app_details/{id}', [PurchaseRequestController::class, 'get_app_details']);
});

Route::middleware('api')->group(function () {
    Route::get('viewRFQItems/{id}', [RFQController::class, 'viewRFQItems']);
});
Route::middleware('api')->group(function () {
    Route::get('fetchUser/{userId}', [UserController::class, 'fetchUserData']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchAllUsers', [UserController::class, 'fetchAllUsers']);
});

Route::middleware('api')->group(function () {
    Route::get('getICTData/{id}', [RICTUController::class, 'getICTData']);
});
Route::middleware('api')->group(function () {
    Route::get('getUserDetails/{id}', [UserManagementController::class, 'getUserDetails']);
});
Route::middleware('api')->group(function () {
    Route::get('getGenderEmpStat', [UserController::class, 'getGenderEmpStatus']);
});

Route::middleware('api')->group(function () {
    Route::get('getPosition', [PositionController::class, 'getPosition']);
});

//CALENDAR GET
Route::middleware('api')->group(function () {
    Route::get('fetchEventData', [CalendarController::class, 'fetchEventData']);
});

Route::middleware('api')->group(function () {
    Route::get('dashboardEventData', [CalendarController::class, 'dashboardEventData']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchEventDetails', [CalendarController::class, 'fetchEventDetails']);
});

//QMS GET
Route::middleware('api')->group(function () {
    Route::get('fetchProcessOwner', [QMSController::class, 'fetchProcessOwner']);
});
Route::middleware('api')->group(function () {
    Route::get('fetchPProcessOwner/{id}', [QMSController::class, 'fetchPProcessOwner']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchProvinceUser/{id}', [QMSController::class, 'fetchProvinceUser']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchPOProcessOwner/{id}', [QMSController::class, 'fetchPOProcessOwner']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchAllUser', [QMSController::class, 'fetchAllUser']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchQualityProcedure/{userId}', [QMSController::class, 'fetchQualityProcedure']);
});
Route::middleware('api')->group(function () {
    Route::get('fetchQualityProcedureAll', [QMSController::class, 'fetchQualityProcedureAll']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchEntryData/{id}', [QMSController::class, 'fetchEntryData']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchQualityObjectives/{id}', [QMSController::class, 'fetchQualityObjectives']);
});

Route::middleware('api')->group(function () {
    Route::get('UpdateQualityObjectives/{id}/{qoeID}', [QMSController::class, 'UpdateQualityObjectives']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchQPdata/{qp_code_id}', [QMSController::class, 'fetchQPdata']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchQoprData/{id}', [QMSController::class, 'fetchQoprData']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchQopHistoryData/{id}', [QMSController::class, 'fetchQopHistoryData']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchQoprEntryData/{id}', [QMSController::class, 'fetchQoprEntryData']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchQOPR', [QMSController::class, 'fetchQOPR']);
});
Route::middleware('api')->group(function () {
    Route::get('fetchQOPRperDivision/{id}', [QMSController::class, 'fetchQOPRperDivision']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchQOPRperProvince/{id}', [QMSController::class, 'fetchQOPRperProvince']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchQOPRUserData/{id}/{qoe_id}', [QMSController::class, 'fetchQOPRUserData']);
});
Route::middleware('api')->group(function () {
    Route::get('fetchQuarterData/{id}/{qoe_id}', [QMSController::class, 'fetchQuarterData']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchMonthlyData/{id}/{qoe_id}', [QMSController::class, 'fetchMonthlyData']);
});

//BUDGET GET

Route::middleware('api')->group(function () {
    Route::get('getPurchaseRequest', [BudgetController::class, 'getPurchaseRequest']);
    Route::get('getPurchaseOrder', [BudgetController::class, 'getPurchaseOrder']);
});

//USER MANAGEMENT GET
Route::middleware('api')->group(function () {
    Route::get('fetchEmployeeData', [UserManagementController::class, 'fetchEmployeeData']);
});

Route::middleware('api')->group(function () {
    Route::get('getProvinces', [UserManagementController::class, 'getProvinces']);
});

Route::middleware('api')->group(function () {
    Route::get('getCityMun/{provID}', [UserManagementController::class, 'getCityMun']);
});

Route::middleware('api')->group(function () {
    Route::get('getAllCityMun', [UserManagementController::class, 'getAllCityMun']);
});

Route::middleware('api')->group(function () {
    Route::get('getOffice', [UserManagementController::class, 'getOffice']);
});

Route::middleware('api')->group(function () {
    Route::get('fetchUserOfficeCount', [UserManagementController::class, 'fetchUserOfficeCount']);
});
Route::middleware('api')->group(function () {
    Route::get('fetchItems/{year?}', [PurchaseRequestController::class, 'fetchItems']);
});

Route::middleware('api')->group(function () {
    Route::get('viewAOQ/{id}', [AbstractController::class, 'viewAOQ']);
});

Route::middleware('api')->group(function () {
    Route::get('fetch_supplier_list', [AbstractController::class, 'fetch_supplier_list']);
});

Route::middleware('api')->group(function () {
    Route::get('fetch_supplier_quote/{id}', [AbstractController::class, 'fetch_supplier_quote']);
});



Route::middleware('auth:api')->post('/logout', [UserController::class, 'logout']);

// Route::post('logout', function (Request $request) {
//     $request->user()->token()->revoke(); // Revoke the user's access token
//     // Clear any other cached data or session information if necessary
//     return response()->json(['message' => 'Successfully logged out']);
// })->middleware('auth:api');
Route::post('login', [UserController::class, 'login']);
// Route::post('logout',[UserController::class,'logout']);

Route::post('updateUserDetails', [UserController::class, 'updateUserDetails']);
Route::post('post_add_appItem', [AppItemController::class, 'post_add_appItem']);
Route::post('app-items', [AppItemController::class, 'post_add_appItem']);
Route::post('updateAppDataById/{id}',  [AppItemController::class, 'post_update_appItem']);
Route::post('post_create_ict_request', [RICTUController::class, 'post_create_ict_request']);
Route::post('post_create_purchaseRequest', [PurchaseRequestController::class, 'post_create_purchaseRequest']);
Route::post('post_update_purchaseRequest', [PurchaseRequestController::class, 'post_update_purchaseRequest']);
Route::post('deletePurchaseRequestItem', [PurchaseRequestController::class, 'deletePurchaseRequestItem']);
Route::post('fetchPurchaseReqData', [PurchaseRequestController::class, 'fetchPurchaseReqData']);
Route::post('fetchPRMonitor', [PurchaseRequestController::class, 'fetchPRMonitor']);
Route::post('perUserPurchaseReqData', [PurchaseRequestController::class, 'perUserPurchaseReqData']);
Route::post('updatePurchaseRequestStatus', [PurchaseRequestController::class, 'updatePurchaseRequestStatus']);
Route::post('fetchSubmittedtoGSS', [PurchaseRequestController::class, 'fetchSubmittedtoGSS']);
Route::post('fetch_app_item', [SupplierController::class, 'fetch_app_item']);
Route::post('fetch_app_item_details', [SupplierController::class, 'fetch_app_item_details']);
Route::post('fetchPurchaseRequestData', [PurchaseOrderController::class, 'fetchPurchaseRequestData']);
Route::post('fetch_winner_supplier', [PurchaseOrderController::class, 'fetch_winner_supplier']);
Route::post('fetch_supplier_quotation', [SupplierController::class, 'fetch_supplier_quotation']);
Route::post('fetch_supplier_title', [SupplierController::class, 'fetch_supplier_title']);
Route::post('post_supplier_quote', [SupplierController::class, 'post_supplier_quote']);
Route::post('post_create_abstract', [AbstractController::class, 'post_create_abstract']);
Route::post('post_create_po', [PurchaseOrderController::class, 'post_create_po']);
Route::post('total_amount', [PurchaseRequestController::class, 'total_amount']);
// Route::post('post_update_status', 'PurchaseRequestController@post_update_status')->name('post.update.status');
Route::post('post_update_status', [PurchaseRequestController::class, 'post_update_status']);
Route::post('post_addCode', [PurchaseRequestController::class, 'post_addCode']);
Route::post('fetch_ict_req_details', [RICTUController::class, 'fetch_ict_req_details']);

Route::post('post_complete', [CRUDController::class, 'post_complete']);
Route::post('post_received_ict_request', [CRUDController::class, 'post_received_ict_request']);
Route::post('getSmallestQuotationsForItems', [SupplierController::class, 'getSmallestQuotationsForItems']);

//BUDGET POST
Route::post('post_addCode', [BudgetController::class, 'insertCode']);
//A B S T R A C T
Route::post('PostAbstract', [AbstractController::class, 'PostAbstract']);
Route::post('PostSupplierQuotation', [AbstractController::class, 'PostSupplierQuotation']);

// R F Q
Route::post('post_create_rfq', [RFQController::class, 'post_create_rfq']);
Route::post('PostUpdateRFQ', [RFQController::class, 'PostUpdateRFQ']);

//CALENDAR
//C A L E N D A R
Route::post('PostEventData', [CalendarController::class, 'PostEventData']);
Route::post('PostUpdateEvent', [CalendarController::class, 'PostUpdateEvent']);
Route::post('post_create_event', [CalendarController::class, 'post_create_event']);

//C A L E N D A R
Route::post('PostEventData', [CalendarController::class, 'PostEventData']);
Route::post('PostUpdateDragDrop', [CalendarController::class, 'PostUpdateDragDrop']);
Route::post('DeleteEvent', [CalendarController::class, 'deleteEvent']);

//QMS POST
Route::post('DeleteProcessOwner', [QMSController::class, 'DeleteProcessOwner']);
Route::post('addProcessOwner', [QMSController::class, 'addProcessOwner']);
Route::post('postQualityProcedure', [QMSController::class, 'postQualityProcedure']);
Route::post('UpdateQualityProcedure', [QMSController::class, 'UpdateQualityProcedure']);
Route::post('postQualityObjectives', [QMSController::class, 'postQualityObjectives']);
Route::post('postUpdateQualityObjectives', [QMSController::class, 'postUpdateQualityObjectives']);
Route::post('DeleteQualityObjective', [QMSController::class, 'DeleteQualityObjective']);
Route::post('deleteQualityProcedure', [QMSController::class, 'deleteQualityProcedure']);
Route::post('postReportEntry', [QMSController::class, 'postReportEntry']);
Route::post('submitReport', [QMSController::class, 'submitReport']);
Route::post('receiveReport', [QMSController::class, 'receiveReport']);
Route::post('returnReport', [QMSController::class, 'returnReport']);
Route::post('completeReport', [QMSController::class, 'completeReport']);
Route::post('deleteRS', [QMSController::class, 'deleteRS']);
Route::post('saveQuarterData', [QMSController::class, 'saveQuarterData']);
Route::post('saveMonthlyData', [QMSController::class, 'saveMonthlyData']);
Route::post('ValidateReportEntry', [QMSController::class, 'ValidateReportEntry']);
Route::post('AddPOProcessOwner', [QMSController::class, 'AddPOProcessOwner']);
Route::post('DeletePOProcessOwner', [QMSController::class, 'DeletePOProcessOwner']);


//U S E R  M A N A G E M E N T
Route::post('PostUser', [UserManagementController::class, 'PostUser']);
Route::post('updateUserSidebar', [UserManagementController::class, 'updateUserSidebar']);

// E X P O R T
// routes/web.php or routes/api.php
Route::middleware('api')->group(function () {
    Route::get('export-purchase-request/{id}', [PurchaseRequestController::class, 'exportPurchaseRequest']);
});

Route::middleware('api')->group(function () {
    Route::get('export-rfq/{id}', [RFQController::class, 'viewRFQItems']);
});

Route::middleware('api')->group(function () {
    Route::get('export-abstract/{absID}', [AbstractController::class, 'ExportAbstract']);
});

Route::middleware('api')->group(function () {
    Route::get('generate-report/{sy}/{sq}/{rt}', [RICTUController::class, 'generate']);
});

Route::middleware('api')->group(function () {
    Route::get('generateReportQ/{id}', [QMSQuarterlyExportController::class, 'generateReport']);
});

Route::middleware('api')->group(function () {
    Route::get('generateReportM/{id}', [QMSMonthlyExportController::class, 'generateReport']);
});

Route::middleware('api')->group(function () {
    Route::get('generateReportQLND/{id}', [QMSQuarterlyLNDController::class, 'generateReport']);
});

Route::prefix('daily-time-records')->group(function () {
    Route::get('/', [DailyTimeRecordController::class, 'index']);
    Route::get('/user/{userId}', [DailyTimeRecordController::class, 'getByUser']);
    Route::put('/user/{userId}', [DailyTimeRecordController::class, 'updateByUser']);
    Route::post('/import', [DailyTimeRecordController::class, 'import']);
    Route::get('/export', [DailyTimeRecordController::class, 'export']);
    Route::post('/bulk', [DailyTimeRecordController::class, 'storeBulk']);
    Route::delete('/{id}', [DailyTimeRecordController::class, 'destroy']);
    Route::get('/{id}', [DailyTimeRecordController::class, 'show']); // wildcard LAST!
    Route::get('/export-user/{userId}', [DailyTimeRecordController::class, 'exportUser']);

});
