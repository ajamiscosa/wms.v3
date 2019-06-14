<?php

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

Route::get('/', 'PageController@index');
Route::get('/login', 'PageController@login')->name('login');
Route::post('/api/login', 'UserController@androidlogin');
Route::post('/login', 'UserController@login');
Route::get('/logout', 'PageController@logout');
Route::get('/update-password','PageController@changepw');
Route::post('/update-password','UserController@changepw');

Route::get('/product-line', 'ProductLineController@index');
Route::get('/product-line/new', 'ProductLineController@create');
Route::post('/product-line/store', 'ProductLineController@store');
Route::post('/product-line/update/{id}', 'ProductLineController@update');
Route::post('/product-line/void/{id}', 'ProductLineController@void');
Route::get('/product-line/data', 'ProductLineController@data');
Route::get('/product-line/select-data', 'ProductLineController@getSelectData');
Route::get('/product-line/glselectdata', 'ProductLineController@glselectdata');
Route::get('/product-line/view/{id}', 'ProductLineController@show');
Route::get('/product-line/update/{id}', 'ProductLineController@edit');
Route::delete('/product-line/delete/{id}', 'ProductLineController@destroy');

Route::get('/product', 'ProductController@index');
Route::get('/product/new', 'ProductController@create');
Route::post('/product/store', 'ProductController@store');
Route::get('/product/update/{product}', 'ProductController@edit');
Route::post('/product/update/{product}', 'ProductController@update');
Route::get('/product/data', 'ProductController@data');
Route::get('/product/view/{product}', 'ProductController@show');
Route::post('/product/toggle/{product}', 'ProductController@toggle');
Route::get('/product/{product}/current-stocks','ProductController@currentstocks');
Route::get('/product/{product}/transactions', 'ProductController@transactions');
Route::get('/product/{product}/data', 'ProductController@productdata');

Route::get('/product/{product}/quote/new', 'QuoteController@create');
Route::post('/product/{product}/quote/store', 'QuoteController@store');
Route::get('/product/{product}/quote', 'QuoteController@index');
Route::get('/product/{product}/quote/data', 'QuoteController@data');

Route::get('/product/{product}/barcode', 'ProductController@previewBarcode');
Route::get('/product/{product}/qrcode', 'ProductController@previewQrCode');



Route::get('/vendor/selectdata', 'SupplierController@selectdata');
Route::post('/quote/store', 'QuoteController@store');
Route::get('/quote/document/{file}', 'QuoteController@viewDocument');

Route::get('/pending-quote', 'QuoteController@viewPendingQuotes');
Route::get('/for-quotation', 'PurchaseOrderController@showItemsForQuotation');

Route::get('/order-item','PurchaseOrderController@showItemsReadyForPO');
Route::get('/order-item/po-items','PurchaseOrderController@getOrderItemsReadyForPO');
Route::get('/order-item/quote-items', 'PurchaseOrderController@getOrderItemData');
Route::get('/order-item/for-quote-approval','PurchaseOrderController@getItemsForQuotationApproval');
Route::get('/order-item/quote/{lineItem}', 'PurchaseOrderController@orderitemquote');
Route::get('/order-item/lineitem/{id}/quote/view', 'PurchaseOrderController@productquoteview');
//Route::post('/order-item/store','PurchaseOrderController@store');
Route::post('/order-item/store','OrderItemController@store');

//Route::get('/issuance', 'IssuanceReceiptController@index');
Route::get('/issuance/data','IssuanceReceiptController@getRequestsReadyForIssuance');
Route::get('/issuance', 'IssuanceReceiptController@create');
Route::post('/issuance/{id}/receiving/update', 'IssuanceReceiptController@store');
Route::get('/issuance/{id}', 'IssuanceReceiptController@getRequestDataForIssuance');
Route::get('/issuance/{id}/transactions','IssuanceReceiptController@getReceiptTransactionsOfIssuance');



Route::get('/inventory-log', 'InventoryLogController@index'); // read only lang to. Rekta na sa Model pag create.

Route::get('/stock-adjustment', 'StockAdjustmentController@index');
Route::get('/stock-adjustment/new', 'StockAdjustmentController@create');
Route::post('/stock-adjustment/store', 'StockAdjustmentController@store');
Route::get('/stock-adjustment/update/{id}', 'StockAdjustmentController@edit');
Route::post('/stock-adjustment/update/{id}', 'StockAdjustmentController@update');
Route::post('/stock-adjustment/{id}/void', 'StockAdjustmentController@void');
Route::post('/stock-adjustment/{id}/approve', 'StockAdjustmentController@approve');
Route::get('/stock-adjustment/data', 'StockAdjustmentController@data');
Route::get('/stock-adjustment/view/{id}', 'StockAdjustmentController@show');
Route::get('/stock-adjustment/product-data', 'StockAdjustmentController@getProductList');
Route::get('/stock-adjustment/location-data', 'StockAdjustmentController@locationdata');

Route::get('/stock-transfer', 'StockTransferController@index');
Route::get('/stock-transfer/new', 'StockTransferController@create');
Route::post('/stock-transfer/store', 'StockTransferController@store');
Route::get('/stock-transfer/update/{id}', 'StockTransferController@edit');
Route::post('/stock-transfer/update/{id}', 'StockTransferController@update');
Route::post('/stock-transfer/{id}/void', 'StockTransferController@void');
Route::post('/stock-transfer/{id}/approve', 'StockTransferController@approve');
Route::get('/stock-transfer/data', 'StockTransferController@data');
Route::get('/stock-transfer/view/{id}', 'StockTransferController@show');
Route::get('/stock-transfer/product-data', 'StockTransferController@productdata');
Route::get('/stock-transfer/location-data/{product}', 'StockTransferController@productlocationdata');
Route::get('/stock-transfer/location-data', 'StockTransferController@locationdata');

Route::get('/item-type', 'ItemTypeController@index');
Route::get('/item-type/new', 'ItemTypeController@create');
Route::post('/item-type/store', 'ItemTypeController@store');
Route::get('/item-type/update/{type}', 'ItemTypeController@edit');
Route::post('/item-type/update/{type}', 'ItemTypeController@update');
Route::post('/item-type/{type}/void', 'ItemTypeController@void');
Route::get('/item-type/data','ItemTypeController@data');
Route::get('/item-type/view/{type}','ItemTypeController@show');
Route::post('/item-type/toggle/{type}','ItemTypeController@toggle');

Route::get('/damaged-stock-transfer', 'DamagedInventoryTransferController@index');
Route::get('/damaged-stock-transfer/new', 'DamagedInventoryTransferController@create');
Route::post('/damaged-stock-transfer/store', 'DamagedInventoryTransferController@store');
Route::get('/damaged-stock-transfer/update/id', 'DamagedInventoryTransferController@edit');
Route::post('/damaged-stock-transfer/update', 'DamagedInventoryTransferController@update');
Route::post('/damaged-stock-transfer/void', 'DamagedInventoryTransferController@void');

Route::get('/purchase-order', 'PurchaseOrderController@index');
Route::post('/purchase-order/store', 'PurchaseOrderController@store');
Route::get('/purchase-order/view/{id}', 'PurchaseOrderController@show');
Route::get('/purchase-order/draft/{id}', 'PurchaseOrderController@create');
Route::get('/purchase-order/update/{id}', 'PurchaseOrderController@edit');

Route::post('/purchase-order/{purchaseOrder}/update', 'PurchaseOrderController@update');
Route::post('/purchase-order/{purchaseOrder}/submit', 'PurchaseOrderController@submit');
Route::post('/purchase-order/{purchaseOrder}/approve', 'PurchaseOrderController@approve');

Route::get('/purchase-order/data/{status}', 'PurchaseOrderController@getPurchaseOrderData');
Route::post('/purchase-order/{id}/toggle', 'PurchaseOrderController@toggle');
Route::post('/purchase-order/{id}/void', 'PurchaseOrderController@void');
Route::delete('/purchase-order/{id}/delete', 'PurchaseOrderController@destroy');

Route::get('/purchase-order/select-data', 'PurchaseOrderController@getSelectDataForRR');
Route::get('/purchase-order/{id}/order-items', 'PurchaseOrderController@getOrderItemsForRR');
Route::get('/purchase-order/{id}/receiving', 'ReceiveOrderController@create');
Route::post('/purchase-order/{id}/receiving/update', 'ReceiveOrderController@store');
Route::get('/purchase-order/{id}/download','PurchaseOrderController@generatePurchaseOrderForm');
Route::get('/purchase-order/{id}/data','PurchaseOrderController@getPurchaseOrderDataByOrderNumber');



Route::get('/receive-order', 'ReceiveOrderController@showReceivingForm');
Route::get('/receive-order/new', 'ReceiveOrderController@create');
Route::post('/receive-order/store', 'ReceiveOrderController@store');
Route::get('/receive-order/view/{ro}', 'ReceiveOrderController@show');
Route::get('/receive-order/update/{id}', 'ReceiveOrderController@edit');
Route::post('/receive-order/update/{id}', 'ReceiveOrderController@update');
Route::post('/receive-order/void', 'ReceiveOrderController@void');
Route::get('/receive-order/data', 'ReceiveOrderController@data');
Route::get('/receive-order/{id}/transactions','ReceiveOrderController@getReceiptTransactionsOfPurchaseOrder');
//
Route::get('/receive-order/{id}/download', 'ReceiveOrderController@generateReceivingForm');

Route::get('/purchase-return', 'PurchaseReturnController@index');
Route::get('/purchase-return/{PO}/new', 'PurchaseReturnController@create');
Route::get('/purchase-return/view/{PO}', 'PurchaseReturnController@show');
Route::post('/purchase-return/store', 'PurchaseReturnController@store');
Route::get('/purchase-return/update/{id}', 'PurchaseReturnController@edit');
Route::post('/purchase-return/update/{id}', 'PurchaseReturnController@update');
Route::post('/purchase-return/void', 'PurchaseReturnController@disable');
Route::get('/purchase-return/data', 'PurchaseReturnController@data');

Route::get('/purchase-invoice', 'BillController@index');
Route::get('/purchase-invoice/{po}/new', 'BillController@create');
Route::post('/purchase-invoice/store', 'BillController@store');
Route::get('/purchase-invoice/view/{id}', 'BillController@show');
Route::get('/purchase-invoice/update/{id}', 'BillController@edit');
Route::post('/purchase-invoice/update/{id}', 'BillController@update');
Route::post('/purchase-invoice/disable', 'BillController@disable');
Route::delete('/purchase-invoice/delete', 'BillController@delete');
Route::get('/purchase-invoice/data', 'BillController@data');

Route::get('/suppliers-payment', 'PaymentController@index');
Route::get('/suppliers-payment/new', 'PaymentController@create');
Route::post('/suppliers-payment/store', 'PaymentController@store');
Route::get('/suppliers-payment/update/id', 'PaymentController@edit');
Route::post('/suppliers-payment/update', 'PaymentController@update');
Route::post('/suppliers-payment/void', 'PaymentController@void');
Route::delete('/suppliers-payment/delete', 'PaymentController@delete');



Route::get('/reports','ReportController@index');
Route::get('/reports/inventory-log', 'ReportController@showInventoryLogReport');
Route::get('/reports/inventory-balance', 'ReportController@showInventoryBalanceReport');
Route::get('/reports/inventory-balance/export', 'ReportController@exportInventoryBalanceReport');
Route::get('/reports/issuance-log', 'ReportController@showIssuanceReport');
Route::get('/reports/issuance-log/export', 'ReportController@exportIssuanceReport');
Route::get('/reports/receiving-log', 'ReportController@showReceivingReport');
Route::get('/reports/receiving-log/export', 'ReportController@exportReceivingReport');
Route::get('/reports/supplies-pchem', 'ReportController@showSuppliesAndProcessChemReport');
Route::get('/reports/consumption/{product}/view', 'ReportController@showConsumptionReportOfProduct');
Route::get('/reports/consumption/{product}/export', 'ReportController@exportConsumptionReport');
Route::get('/reports/consumption/{product}/variables/{var}', 'ReportController@getVariablesForConsumptionReportOfProduct');

Route::get('/reports/consumption', 'ReportController@showConsumptionReport');

Route::get('/reports/item-movement', 'ReportController@showItemMovementReport');
Route::get('/reports/item-movement/export', 'ReportController@exportItemMovementReport');


Route::get('/reports/pr-status', 'ReportController@showPurchaseRequestStatusReport');
Route::get('/reports/recent-suppliers', 'ReportController@showRecentlyAddedSuppliersReport');
Route::get('/reports/recent-suppliers/export', 'ReportController@exportSupplierReport');
Route::get('/reports/purchase-order-log', 'ReportController@showPurchaseOrdersReport');
Route::get('/reports/purchase-order-log/export', 'ReportController@exportPurchaseOrdersReport');

Route::get('/reports/custom-po-list', 'ReportController@showCustomPOList');
Route::get('/reports/custom-po-list/export', 'ReportController@exportCustomPOList');


Route::get('/reports/recent-items', 'ReportController@showRecentlyAddedItemsReport');
Route::get('/reports/recent-items/export', 'ReportController@exportItemsReport');


Route::get('/reports/adjustments', 'ReportController@showStockAdjustmentsReport');
Route::get('/reports/adjustments/export', 'ReportController@exportAdjustmentReport');



Route::get('/capex', 'CAPEXController@index');
Route::get('/capex/new', 'CAPEXController@create');
Route::post('/capex/store', 'CAPEXController@store');
Route::get('/capex/update/{id}', 'CAPEXController@edit');
Route::post('/capex/{id}/update', 'CAPEXController@update');
Route::post('/capex/{id}/toggle', 'CAPEXController@toggle');
Route::get('/capex/data', 'CAPEXController@data');
Route::get('/capex/view/{id}', 'CAPEXController@show');
Route::get('/capex/export', 'CAPEXController@export');



Route::get('/account', 'UserController@index');
Route::get('/account/new', 'UserController@create');
Route::post('/account/store', 'UserController@store');
Route::get('/account/{user}/update', 'UserController@edit');
Route::post('/account/{user}/update', 'UserController@update');
Route::post('/account/{user}/toggle', 'UserController@toggle');
Route::get('/account/data', 'UserController@data');
Route::get('/account/view/{user}', 'UserController@show');

Route::get('/gl', 'GeneralLedgerController@index');
Route::get('/gl/new', 'GeneralLedgerController@create');
Route::post('/gl/store', 'GeneralLedgerController@store');
Route::get('/gl/update/{id}', 'GeneralLedgerController@edit');
Route::post('/gl/update/{gl}', 'GeneralLedgerController@update');
Route::post('/gl/toggle/{gl}', 'GeneralLedgerController@toggle');
Route::get('/gl/data', 'GeneralLedgerController@data');
Route::get('/gl/departments', 'GeneralLedgerController@departments');
Route::get('/gl/view/{gl}', 'GeneralLedgerController@show');
Route::get('/gl/selectdata', 'GeneralLedgerController@selectdata');

Route::get('/department', 'DepartmentController@index');
Route::get('/department/new', 'DepartmentController@create');
Route::post('/department/store', 'DepartmentController@store');
Route::get('/department/update/{id}', 'DepartmentController@edit');
Route::post('/department/update/{department}', 'DepartmentController@update');
Route::post('/department/toggle/{department}', 'DepartmentController@toggle');
Route::get('/department/data', 'DepartmentController@data');
Route::get('/department/view/{department}', 'DepartmentController@show');
Route::get('/department/approverdata', 'DepartmentController@approverdata');
Route::get('/department/parentdata', 'DepartmentController@parentdata');
Route::get('/department/gldata', 'DepartmentController@gldata');
Route::get('/department/costcenter/select-data', 'DepartmentController@getCostCenterData');

Route::get('/location', 'LocationController@index');
Route::get('/location/new', 'LocationController@create');
Route::post('/location/store', 'LocationController@store');
Route::get('/location/update/{id}', 'LocationController@edit');
Route::get('/location/view/{id}', 'LocationController@show');
Route::post('/location/update/{warehouse}', 'LocationController@update');
Route::post('/location/toggle/{warehouse}', 'LocationController@toggle');
Route::get('/location/data', 'LocationController@data');
Route::get('/location/select-data', 'LocationController@locationdata');

Route::get('/category', 'CategoryController@index');
Route::get('/category/new', 'CategoryController@create');
Route::post('/category/store', 'CategoryController@store');
Route::get('/category/update/{category}', 'CategoryController@edit');
Route::post('/category/update/{category}', 'CategoryController@update');
Route::post('/category/disable', 'CategoryController@disable');
Route::post('/category/toggle/{category}', 'CategoryController@toggle');
Route::get('/category/data', 'CategoryController@data');
Route::get('/category/view/{category}', 'CategoryController@show');
Route::get('/category/select-data', 'CategoryController@getSelectData');

Route::get('/currency', 'CurrencyController@index');
// Route::get('/currency/new', 'CurrencyController@create');
// Route::post('/currency/store', 'CurrencyController@store');
// Route::get('/currency/update', 'CurrencyController@update');
Route::post('/currency/update', 'CurrencyController@update');
// Route::post('/currency/disable', 'CurrencyController@disable');
// Route::post('/currency/toggle/{currency}', 'CurrencyController@toggle');
Route::get('/currency/data', 'CurrencyController@data');
// Route::get('/currency/view/{currency}', 'CurrencyController@show');
Route::post('/currency/update-rate', 'CurrencyController@updaterate');

Route::get('/uom', 'UnitOfMeasureController@index');
Route::get('/uom/new', 'UnitOfMeasureController@create');
Route::post('/uom/store', 'UnitOfMeasureController@store');
Route::get('/uom/update/{id}', 'UnitOfMeasureController@edit');
Route::post('/uom/update/{uom}', 'UnitOfMeasureController@update');
Route::post('/uom/toggle/{uom}', 'UnitOfMeasureController@toggle');
Route::get('/uom/data', 'UnitOfMeasureController@data');
Route::get('/uom/view/{uom}', 'UnitOfMeasureController@show');
Route::get('/uom/select-data', 'UnitOfMeasureController@getSelectData');

Route::get('/role', 'RoleController@index');
Route::get('/role/new', 'RoleController@create');
Route::post('/role/store', 'RoleController@store');
Route::get('/role/update/{roles}', 'RoleController@edit');
Route::post('/role/update/{roles}', 'RoleController@update');
Route::post('/role/toggle/{roles}', 'RoleController@toggle');
Route::get('/role/data', 'RoleController@data');
Route::get('/role/view/{roles}', 'RoleController@show');

Route::get('/rs', 'RequisitionController@index');
Route::post('/rs/store', 'RequisitionController@store');
Route::get('/rs/data', 'RequisitionController@rsdata');
Route::get('/rs/department-data', 'RequisitionController@getDepartmentData');
Route::get('/rs/gl-data/{type}/{department}', 'RequisitionController@getGeneralLedgerDataOfDepartmentForSelect');
Route::get('/rs/approver-data/{department}', 'RequisitionController@getApproverDataOfDepartmentForSelect');

Route::get('/issuance-request/', 'RequisitionController@showIssuanceRequestIndexPage');
Route::get('/issuance-request/new', 'RequisitionController@showCreateIssuanceRequestForm');
Route::get('/issuance-request/edit/{id}', 'RequisitionController@showEditIssuanceRequestForm');
Route::post('/issuance-request/edit/{id}', 'RequisitionController@update');
Route::post('/issuance-request/store', 'RequisitionController@store');
Route::get('/issuance-request/data/{status}', 'RequisitionController@getIssuanceRequestList');
Route::get('/issuance-request/view/{issuance}', 'RequisitionController@showIssuanceRequestByOrderNumber');
Route::post('/issuance-request/{issuance}/toggle', 'RequisitionController@toggleIssuanceRequest');
Route::post('/issuance-request/{issuance}/void', 'RequisitionController@voidIssuanceRequest');
Route::get('/issuance-request/{issuance}/data', 'RequisitionController@getIssuanceDataByOrderNumber');
Route::get('/issuance-request/{issuance}/download', 'RequisitionController@generateIssueSlip');


Route::get('/purchase-request/', 'RequisitionController@showPurchaseRequestIndexPage');
Route::get('/purchase-request/new', 'RequisitionController@showCreatePurchaseRequestForm');
Route::get('/purchase-request/edit/{id}', 'RequisitionController@showPurchaseRequestEditForm');
Route::post('/purchase-request/edit/{id}', 'RequisitionController@update');
Route::post('/purchase-request/store', 'RequisitionController@store');
Route::get('/purchase-request/data/{status}', 'RequisitionController@getPurchaseRequestList');
Route::get('/purchase-request/view/{purchase}', 'RequisitionController@showPurchaseRequestByOrderNumber');
Route::post('/purchase-request/{purchase}/toggle', 'RequisitionController@togglePurchaseRequestStatus');
Route::post('/purchase-request/{purchase}/void', 'RequisitionController@voidPurchaseRequest');
Route::get('/purchase-request/{purchase}/download', 'RequisitionController@generateCanvassReport');

Route::get('/special-request','RequisitionController@showCreateSpecialRequestForm');
Route::get('/special-request/new-line-item','RequisitionController@addNewLineItem');
Route::get('/special-request/new-line-service','RequisitionController@addNewLineService');







Route::get('/vendor','SupplierController@index');
Route::get('/vendor/new', 'SupplierController@create');
Route::post('/vendor/store', 'SupplierController@store');
Route::get('/vendor/view/{supplier}', 'SupplierController@show');
Route::get('/vendor/update/{supplier}', 'SupplierController@edit');
Route::post('/vendor/update/{supplier}', 'SupplierController@update');
Route::post('/vendor/toggle/{supplier}', 'SupplierController@toggle');
Route::get('/vendor/data', 'SupplierController@data');
Route::get('/vendor/{supplier}/product','SupplierController@productlist');





Route::get('/data-management','PageController@datamgmt');
Route::post('/data-management/product/add','ProductController@addProductFromAjax');



Route::get('/term', 'TermController@index');
Route::get('/term/new', 'TermController@create');
Route::post('/term/store', 'TermController@store');
Route::get('/term/update/{term}', 'TermController@edit');
Route::post('/term/update/{term}', 'TermController@update');
Route::post('/term/disable', 'TermController@disable');
Route::post('/term/toggle/{term}', 'TermController@toggle');
Route::get('/term/data', 'TermController@data');
Route::get('/term/view/{term}', 'TermController@show');
Route::get('/term/selectdata', 'TermController@selectdata');

Route::post('/session/addToList', 'SessionController@addToList');
Route::post('/session/removeFromList', 'SessionController@removeFromList');

Route::get('/restocking', 'RequisitionController@showForRestockingList');
Route::get('/deferred', 'RequisitionController@showDeferredForRestockingList');



Route::get('/ship-via', 'ShippingMethodController@index');
Route::get('/ship-via/new', 'ShippingMethodController@create');
Route::post('/ship-via/store', 'ShippingMethodController@store');
Route::get('/ship-via/update/{shipvia}', 'ShippingMethodController@edit');
Route::post('/ship-via/update/{shipvia}', 'ShippingMethodController@update');
Route::post('/ship-via/disable', 'ShippingMethodController@disable');
Route::post('/ship-via/toggle/{shipvia}', 'ShippingMethodController@toggle');
Route::get('/ship-via/data', 'ShippingMethodController@data');
Route::get('/ship-via/view/{shipvia}', 'ShippingMethodController@show');
Route::get('/ship-via/select-data', 'ShippingMethodController@getSelectData');




Route::get('/test/mail', function() {
    // Path or name to the blade template to be rendered
    $template_path = 'mail.test';

    \Illuminate\Support\Facades\Mail::send($template_path, [], function($message) {
        // Set the receiver and subject of the mail.
        $message->to('aron.amiscosa@mvpadvisorygroup.com', 'Receiver Name')->subject('Laravel Test Mail');
        // Set the sender
        $message->from('aron.amiscosa@mvpadvisorygroup.com','Test Mail');
    });

    echo "success";
});

Route::get('/test/removeUnboundProducts', function(){
    $products = \App\Product::where('UniqueID','LIKE','%-TEMP')->get();
    foreach($products as $product) {
        if(!$product->hasPurchaseRequests()) {
            $product->delete();
        }
    }

    $products = \App\Product::where('UniqueID','LIKE','SERV-%')->get();
    foreach($products as $product) {
        if(!$product->hasPurchaseRequests()) {
            $product->delete();
        }
    }
});

Route::get('/test1', function(){
   $product = new \App\Product();
   dd($product->getNextServiceSeriesNumber());
});

Route::get('/sessiontest', function() {
   dd(session()->all());
});

Route::post('/rs/addToDeferList', 'RequisitionController@addToDeferList');
Route::post('/rs/addArrayToDeferList', 'RequisitionController@addArrayToDeferList');

Route::get('/rs/{table}','RequisitionController@getRequisitionList');
Route::post('/rs/{table}/addToList', 'RequisitionController@addToRequisitionList');
Route::post('/rs/{table}/addArrayToList', 'RequisitionController@addArrayToRequisitionList');
Route::post('/rs/{table}/removeFromList', 'RequisitionController@removeFromRequisitionList');
Route::get('/rs/{table}/raw','RequisitionController@getRequisitionListAsArray');
Route::get('/rs/{table}/count','RequisitionController@getRequisitionListCount');
Route::post('/rs/{table}/check', 'RequisitionController@canCreateRequest');



Route::post('/deferred/restore', 'RequisitionController@restoreDeferredItem');









Route::get('/testponumber', function(){

    $latestPO = new \App\PurchaseOrder();
    $latestPO = $latestPO->latest()->first();

    $today = \Carbon\Carbon::today();

    $series = 1;


    if($latestPO) {
        if(strpos($latestPO->OrderNumber,$today->format('my'))!==false) {
            $series = $latestPO->Series + 1;
        }
    }

    $orderNumber = sprintf("%s%s",
//                    $category,
//                    $supplier->SupplierType==1?"PH":"US",
        \Carbon\Carbon::today()->format('my'),
        str_pad($series,3,'0',STR_PAD_LEFT)
    );

    dd($orderNumber);
});


Route::get('/test/averageUsage', function(){
    $product = App\Product::find(9);
    // dd($product->IssuanceReceipts());
    dd($product->getAverageUsage('W'));
});

Route::get('/test/obsolete', function(){
    $product = App\Product::find(2);
    dd($product->getItemObsolescenceRisk());
});

Route::get('/test/weeklystockadj', function(){

    $today = Carbon\Carbon::today();
    $today->startOfWeek(Carbon\Carbon::MONDAY);
    $today->endOfWeek(Carbon\Carbon::SUNDAY);
    $issuanceReceipt = new App\IssuanceReceipt();
    $issuanceReceipts = $issuanceReceipt->all();
    $issuanceReceipts = $issuanceReceipts
        ->where('Received','>=',$today->startOfMonth())
        ->where('Received','<=',$today->endOfMonth());

    foreach($issuanceReceipts as $issuanceReceipt) {
        $product = $issuanceReceipt->getLineItem()->Product();
        $product->MinimumQuantity = $product->getMinimumStockLevel();
        $product->SafetyStockQuantity = $product->getSafetyStockCount();
        $product->MaximumQuantity = $product->getMaximumStockLevel();
        $product->save();
    }
});

Route::get('/test/barcode', function (){

    echo \App\Classes\BarcodeHelper::GenerateBarcodeImageFromString("MSL-135",1);
});

Route::get('/test/qrcode', function (){

    echo \App\Classes\BarcodeHelper::GenerateQRDataFromString("MSL-135",1);
});

Route::get('/test/excel', function(){
    $file = \Illuminate\Support\Facades\Storage::url('/app/template/RR-TEMPLATE.xls');
    Excel::load($file, function($reader) {

        $reader->sheet(0, function($sheet) {

            $sheet->cell('E2', function($cell) {

                $cell->setValue("well shit");

            });

        });

    })->download('xlsx');
});

Route::get('/test/excel/1', function(){
    $file = \Illuminate\Support\Facades\Storage::url('/app/template/prcr.xlsx');
    Excel::load($file, function($reader) {

        $reader->sheet(0, function($sheet) {

            $sheet->cell('L6', function($cell) {

                $cell->setValue(\Carbon\Carbon::today()->format('F d, Y'));

            });
        });

    })
    ->setFilename('whatever')
    ->export('xlsx');
});

Route::get('/test/role/{role}', function($role) {
    dd(\App\Role::FindUserWithRole($role)->Person());
});

ROute::get('/test/fullquote/{pr}', function($pr){
    $rs = \App\Requisition::where('OrderNumber','=',$pr)->firstOrFail();
    return $rs->isFullyQuoted()==1?'2':'Q';
});

Route::get('/test/gl/{type}', function ($type){
   dd(\App\GeneralLedger::getGeneralLedgerCodesFor($type));
});


Route::get('/test/template/prcr/{data}', function($data) {
    $rs = new \App\Requisition();
    $pr = $rs->where('OrderNumber','=', $data)->firstOrFail();



    return view('report.templates.prcr', ['data'=>$pr]);

//    $pdf = PDF::loadView('report.templates.prcr', ['data'=>$pr]);
//    $pdf->setPaper('A4','landscape');
//    $pdf->setWarnings(false);
//
//
//    return $pdf->download('invoice.pdf');

//    $output = $dompdf->output();
//    file_put_contents('Brochure.pdf', $output);

//    return view('report.templates.prcr', ['data'=>$pr]);
});

Route::get('/test/export', function(){



});

Route::get('/seed/issuance', function() {
    $itemList = array(586,4884,5043,1962,3830);

    foreach($itemList as $item) {
        for($i=0;$i<50;$i++) {
            $date1 = new DateTime();
            $date2 = new DateTime('now - 50 days');
            $randomDate = \App\Classes\Helper::generateRandomDateInRange($date2, $date1);
            $random_hour = rand(0,23);
            $random_min = rand(0,59);
            $random_sec = rand(0,59);

            $randDate = \Carbon\Carbon::parse($randomDate." ".$random_hour.":".$random_min.":".$random_sec);

            $lineItemIndex = rand(0,5);

            $lineItem = new \App\LineItem();
            $lineItem->Product = $itemList[$lineItemIndex];
            $issuance = new \App\IssuanceReceipt();

        }
    }
});