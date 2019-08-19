<?php
use App\IssuanceReceipt;
use Carbon\Carbon;
use App\ReceiveOrder;
use App\Classes\DTO\DTO;
use App\PurchaseOrder;
use App\LineItem;

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
Route::get('/product-line/check/{type}/{value}', 'ProductLineController@search');
Route::post('/product-line/toggle/{id}', 'ProductLineController@toggle');

Route::get('/product', 'ProductController@index');
Route::get('/product/new', 'ProductController@create');
Route::post('/product/store', 'ProductController@store');
Route::get('/product/update/{product}', 'ProductController@edit');
Route::post('/product/update/{product}', 'ProductController@update');
Route::get('/product/data', 'ProductController@data');
Route::get('/product/view/{product}', 'ProductController@show')->name('inventory/products/view');
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
Route::post('/quote/{id}/delete', 'QuoteController@destroy');

Route::get('/pending-quote', 'QuoteController@viewPendingQuotes')->name('quote/pending');
Route::get('/for-quotation', 'PurchaseOrderController@showItemsForQuotation')->name('purchasing/purchase-orders/forquote');

Route::get('/order-item','PurchaseOrderController@showItemsReadyForPO')->name('purchasing/purchase-orders/orderitems');
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

Route::get('/stock-adjustment', 'StockAdjustmentController@index')->name('inventory/stock-adjustments/index');
Route::get('/stock-adjustment/new', 'StockAdjustmentController@create')->name('inventory/stock-adjustments/create');
Route::post('/stock-adjustment/store', 'StockAdjustmentController@store');
Route::get('/stock-adjustment/update/{id}', 'StockAdjustmentController@edit');
Route::post('/stock-adjustment/update/{id}', 'StockAdjustmentController@update');
Route::post('/stock-adjustment/{id}/void', 'StockAdjustmentController@void');
Route::post('/stock-adjustment/{id}/approve', 'StockAdjustmentController@approve');
Route::get('/stock-adjustment/data', 'StockAdjustmentController@data');
Route::get('/stock-adjustment/view/{id}', 'StockAdjustmentController@show')->name('inventory/stock-adjustments/view');
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

//Route::get('/item-type', 'ItemTypeController@index');
//Route::get('/item-type/new', 'ItemTypeController@create');
//Route::post('/item-type/store', 'ItemTypeController@store');
//Route::get('/item-type/update/{type}', 'ItemTypeController@edit');
//Route::post('/item-type/update/{type}', 'ItemTypeController@update');
//Route::post('/item-type/{type}/void', 'ItemTypeController@void');
//Route::get('/item-type/data','ItemTypeController@data');
//Route::get('/item-type/view/{type}','ItemTypeController@show');
//Route::post('/item-type/toggle/{type}','ItemTypeController@toggle');

//Route::get('/damaged-stock-transfer', 'DamagedInventoryTransferController@index');
//Route::get('/damaged-stock-transfer/new', 'DamagedInventoryTransferController@create');
//Route::post('/damaged-stock-transfer/store', 'DamagedInventoryTransferController@store');
//Route::get('/damaged-stock-transfer/update/id', 'DamagedInventoryTransferController@edit');
//Route::post('/damaged-stock-transfer/update', 'DamagedInventoryTransferController@update');
//Route::post('/damaged-stock-transfer/void', 'DamagedInventoryTransferController@void');

Route::get('/purchase-order', 'PurchaseOrderController@index')->name('purchasing.purchase-orders.index');
Route::post('/purchase-order/store', 'PurchaseOrderController@store');
Route::get('/purchase-order/view/{id}', 'PurchaseOrderController@show');
Route::get('/purchase-order/draft/{id}', 'PurchaseOrderController@create')->name('purchasing.purchase-orders.create');
Route::get('/purchase-order/update/{id}', 'PurchaseOrderController@edit');

Route::post('/purchase-order/{purchaseOrder}/update', 'PurchaseOrderController@update');
Route::post('/purchase-order/{purchaseOrder}/submit', 'PurchaseOrderController@submit');
Route::post('/purchase-order/{purchaseOrder}/approve', 'PurchaseOrderController@approve');
Route::post('/purchase-order/{purchaseOrder}/reject', 'PurchaseOrderController@reject');

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



Route::get('/receive-order', 'ReceiveOrderController@showReceivingForm')->name('purchasing/receive-orders/receiving');
Route::get('/receive-order/new', 'ReceiveOrderController@create');
Route::post('/receive-order/store', 'ReceiveOrderController@store');
Route::get('/receive-order/view/{ro}', 'ReceiveOrderController@show');
Route::get('/receive-order/update/{id}', 'ReceiveOrderController@edit');
Route::post('/receive-order/update/{id}', 'ReceiveOrderController@update');
Route::post('/receive-order/void', 'ReceiveOrderController@void');
Route::get('/receive-order/data', 'ReceiveOrderController@data');
Route::get('/receive-order/{id}/transactions','ReceiveOrderController@getReceiptTransactionsOfPurchaseOrder');
Route::get('/receive-order/check/{id}','ReceiveOrderController@search'); // ajax DRInvoice <Input>
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
Route::get('/reports/inventory-log', 'ReportController@showInventoryLogReport')->name('report/inventorylog');
Route::get('/reports/inventory-balance', 'ReportController@showInventoryBalanceReport')->name('report/inventorybalance');
Route::get('/reports/inventory-balance/export', 'ReportController@exportInventoryBalanceReport');
Route::get('/reports/issuance-log', 'ReportController@showIssuanceReport')->name('report/issuance');
Route::get('/reports/issuance-log/export', 'ReportController@exportIssuanceReport');
Route::get('/reports/receiving-log', 'ReportController@showReceivingReport')->name('report/receiving');
Route::get('/reports/receiving-log/export', 'ReportController@exportReceivingReport');
Route::get('/reports/supplies-pchem', 'ReportController@showSuppliesAndProcessChemReport');
Route::get('/reports/consumption/{product}/view', 'ReportController@showConsumptionReportOfProduct');
Route::get('/reports/consumption/{product}/export', 'ReportController@exportConsumptionReport');
Route::get('/reports/consumption/{product}/variables/{var}', 'ReportController@getVariablesForConsumptionReportOfProduct');

Route::get('/reports/consumption', 'ReportController@showConsumptionReport');

Route::get('/reports/item-movement', 'ReportController@showItemMovementReport')->name('report/itemmovement');
Route::get('/reports/item-movement/export', 'ReportController@exportItemMovementReport');


Route::get('/reports/pr-status', 'ReportController@showPurchaseRequestStatusReport')->name('report/prstatus');
Route::get('/reports/pr-status/export', 'ReportController@exportPurchaseRequestStatusReport');

Route::get('/reports/recent-suppliers', 'ReportController@showRecentlyAddedSuppliersReport')->name('report/suppliers');
Route::get('/reports/recent-suppliers/export', 'ReportController@exportSupplierReport');
Route::get('/reports/purchase-order-log', 'ReportController@showPurchaseOrdersReport')->name('report/po');
Route::get('/reports/purchase-order-log/export', 'ReportController@exportPurchaseOrdersReport');

Route::get('/reports/custom-po-list', 'ReportController@showCustomPOList')->name('report/custompolist');
Route::get('/reports/custom-po-list/export', 'ReportController@exportCustomPOList');


Route::get('/reports/recent-items', 'ReportController@showRecentlyAddedItemsReport')->name('report/items');
Route::get('/reports/recent-items/export', 'ReportController@exportItemsReport');


Route::get('/reports/adjustments', 'ReportController@showStockAdjustmentsReport')->name('report/adjustments');
Route::get('/reports/adjustments/export', 'ReportController@exportAdjustmentReport');

Route::get('/reports/item-restock', 'ReportController@showItemRestockReport');
Route::get('/reports/item-restock/export', 'ReportController@exportItemRestockReport');

Route::get('/capex', 'CAPEXController@index');
Route::get('/capex/new', 'CAPEXController@create');
Route::post('/capex/store', 'CAPEXController@store');
Route::get('/capex/update/{id}', 'CAPEXController@edit');
Route::post('/capex/{id}/update', 'CAPEXController@update');
Route::post('/capex/{id}/toggle', 'CAPEXController@toggle');
Route::get('/capex/data', 'CAPEXController@data');
Route::get('/capex/view/{id}', 'CAPEXController@show');
Route::get('/capex/export', 'CAPEXController@export');



Route::get('/account', 'UserController@index')->name('settings.accounts.index');
Route::get('/account/new', 'UserController@create')->name('settings.accounts.create');
Route::post('/account/store', 'UserController@store');
Route::get('/account/{user}/update', 'UserController@edit')->name('settings.accounts.update');
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
Route::get('/department/view/{department}', 'DepartmentController@show')->name('settings/departments/view');
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
Route::get('/category/check/{name}', 'CategoryController@search');

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


Route::get('/purchase-request/', 'RequisitionController@showPurchaseRequestIndexPage')->name('rs/purchase/index');
Route::get('/purchase-request/new', 'RequisitionController@showCreatePurchaseRequestForm');
Route::get('/purchase-request/edit/{id}', 'RequisitionController@showPurchaseRequestEditForm');
Route::post('/purchase-request/edit/{id}', 'RequisitionController@update');
Route::post('/purchase-request/store', 'RequisitionController@store');
Route::get('/purchase-request/data/{status}', 'RequisitionController@getPurchaseRequestList');
Route::get('/purchase-request/view/{purchase}', 'RequisitionController@showPurchaseRequestByOrderNumber')->name('rs/purchase/view');
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
Route::get('/vendor/check/{id}', 'SupplierController@search');




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
Route::get('/ship-via/update/{shipvia}', 'ShippingMethodController@edit')->name('settings/shipvia/update');
Route::post('/ship-via/update/{shipvia}', 'ShippingMethodController@update');
Route::post('/ship-via/disable', 'ShippingMethodController@disable');
Route::post('/ship-via/toggle/{shipvia}', 'ShippingMethodController@toggle');
Route::get('/ship-via/data', 'ShippingMethodController@data');
Route::get('/ship-via/view/{shipvia}', 'ShippingMethodController@show');
Route::get('/ship-via/select-data', 'ShippingMethodController@getSelectData');


/**AJAX - SETTINGS MENU - AJAX **/

Route::get('/wl/update/{name}', 'LocationController@search');
Route::get('/via/update/{name}', 'ShippingMethodController@search');
Route::get('/t/update/{name}', 'TermController@search');

Route::get('/d/update/{name}', 'DepartmentController@search');
Route::get('/c/update/{name}', 'CAPEXController@search');
Route::get('/u/update/{name}', 'UserController@search');
Route::get('/r/update/{name}', 'RoleController@search');
Route::get('/uom/ajax/{name}', 'UnitOfMeasureController@search');


/**AJAX - SETTINGS MENU - AJAX **/



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
Route::post('/rs/{table}/check/{id}', 'RequisitionController@canCreateRequest');



Route::post('/deferred/restore', 'RequisitionController@restoreDeferredItem');



//Android routes
Route::post('/api/login', 'AndroidAPIController@androidlogin');
Route::get('/api/login', 'AndroidAPIController@androidlogin');
Route::get('/api/person-data/{id}', 'AndroidAPIController@androidGetPersonData');
Route::get('/api/product/{product}','AndroidAPIController@androidGetProduct');
Route::get('/api/supplier/{supplier}','AndroidAPIController@androidGetSupplier');
Route::get('/api/purchase-order/{supplier}','AndroidAPIController@androidGetPO');
Route::get('/api/purchase-order/data/{purchaseorder}','AndroidAPIController@androidGetPODataByOrderNumber');
Route::get('/api/purchase-order/line-item-product-id/{purchaseorder}','AndroidAPIController@androidGetProductIDByOrderNumber');
Route::get('/api/purchase-order/line-item-product-data/{purchaseorder}','AndroidAPIController@androidGetItemDataByOrderNumber');
Route::get('/api/receive-order/{supplier}','AndroidAPIController@androidGetPendingPO');
Route::get('/api/stock-adjustment/{adjustment}','AndroidAPIController@androidStockAdjustmentStore');
Route::get('/api/purchase-order/receiving-update/{id}','AndroidAPIController@androidReceivingStore');
Route::get('/api/departments','AndroidAPIController@androidGetDepartment');

Route::get('/api/requisition/ir/{id}','AndroidAPIController@androidGetIRByDepartment');
Route::get('/api/requisition/ir-details/{id}','AndroidAPIController@androidGetIRDetails');
Route::get('/api/requisition/ir-items/{id}','AndroidAPIController@androidGetIRItems');
Route::get('/api/requisition/ir-update/{id}','AndroidAPIController@androidIssuanceStore');

Route::get('/api/receive-order/check-drinvoice/{id}','AndroidAPIController@checkDRInvoice');

// end of android routes

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



Route::get('/limitproduct', function(){

    // $lead = \App\User::where('Department', '=', 6)->get();
    // $scandium = \App\User::where('Department', '=', 3)->get();
    // $it = \App\User::where('Department', '=', 16)->get();

    $lead = count(\App\Requisition::where('Type', '=', 'PR')->get());
    $scandium = count(\App\Requisition::where('Type', '=', 'IR')->get());
    $it = count(\App\PurchaseOrder::all());

    // $lead = $lead->Department();
    // dd($lead[0]->Department);
    // $scandiumDept;
    // $itDept;
    $data = [$lead,$scandium,$it];
    // $data = (object)[$lead,$scandium,$it];
    // $data->Lead = $lead;
    // $data->Scandium = $scandium;
    // $data->IT = $it;
    // // return $product->toArray();
    // return dd(response()->json($data));
    return $data;
});




Route::get('/test123', function(){
    $po = new DTO();
    $po->OrderNumber = "POPHXX1903024";

    $lastReceipt = ReceiveOrder::orderByDesc('ID')->first();
    $length = strlen($lastReceipt->OrderNumber);

    $prefix = Carbon::today()->format('ym');
    $currentMonth = substr($lastReceipt->OrderNumber,6,4);
    if($prefix==$currentMonth) {
        $current = substr($lastReceipt->OrderNumber, $length-3);
        $current++;
    }
    else {
        $current = 0;
        $current++;
    }

    
    $rrNumber = sprintf("RR%s%s%s",
        substr($po->OrderNumber,2,4),
        Carbon::today()->format('ym'),
        str_pad($current,3,'0',STR_PAD_LEFT)
    );

    dd($rrNumber);
    
    $lastReceipt = IssuanceReceipt::orderByDesc('OrderNumber')->first();
    $length = strlen($lastReceipt->OrderNumber);

    $prefix = Carbon::today()->format('ym');
    $currentMonth = substr($lastReceipt->OrderNumber,2,4);
    if($prefix==$currentMonth) {
        $current = substr($lastReceipt->OrderNumber, $length-3);
        $current++;
    }
    else {
        $current = 0;
        $current++;
    }

    
            
    $isNumber = sprintf("IS%s%s",
        Carbon::today()->format('ym'),
        str_pad($current,3,'0',STR_PAD_LEFT)
    );

    dd($isNumber);

});

Route::get('/test/mail', function() {

    $mailHelper = new \App\Classes\MailHelper();
    $mailHelper->sendMail('mail.test', [], 'ajamiscosa@gmail.com', 'Application Status');
});

Route::get('/test/file', function(){
    $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'en');
    $purchaseOrder = new PurchaseOrder();
    $orderNumber = "FOUSXX0619006";
    try{
        $po = $purchaseOrder->where('OrderNumber', '=',$orderNumber)->first();
        if($po) {
            $file = Storage::url('/app/template/po.xlsx');


//                $user = User::where('ID','=',$po->Requester)->first();
            $supplier = $po->Supplier();

            $address = array(
                $supplier->AddressLine1,
                $supplier->AddressLine2,
                $supplier->City,
                $supplier->State,
                $supplier->Zip && $supplier->Country?$supplier->Zip." ".$supplier->Country:""
            );



            $dto = new DTO();
            $dto->Address = array_filter($address);

            $dto->VendorName = $supplier->Name;
            $dto->PurchaseOrderNumber = $po->OrderNumber;
            $dto->DateIssued = Carbon::today()->format('n/j/y');
            $dto->VendorID = $supplier->Code;
            $dto->DeliveryDate = $po->DeliveryDate->format('n/j/y');
            $dto->Terms = $po->PaymentTerm()->Description;
            $dto->Currency = $po->Supplier()->Currency()->Code;
            $dto->OrderItems = $po->OrderItems();

            $purchaseRequest = null;
            $counter = 21;
            $total = 0;
            foreach($po->OrderItems() as $orderItem) {
                $lineItem = $orderItem->LineItem();
                $purchaseRequest = $orderItem->Requisition();
//                    $data["A$counter"] = $lineItem->Quantity;
//                    $data["B$counter"] = $lineItem->Product()->UOM()->Abbreviation;
//                    $data["C$counter"] = $lineItem->Product()->Description;
//                    $data["J$counter"] = $orderItem->SelectedQuote()->Amount;
//                    $data["M$counter"] = $orderItem->SelectedQuote()->Amount * $lineItem->Quantity;
                $total += $orderItem->SelectedQuote()->Amount * $lineItem->Quantity;

                $counter++;
            }
//
//                $data["C$counter"] = "X X X NOTHING FOLLOWS X X X";
            $dto->Total = $total;


            $dto->ChargeType = $po->ChargeType=='S'?"STOCKS":substr($purchaseRequest->ChargedTo()->Name, 0, 3);
            $dto->ChargeNo = sprintf("%s/%s",$purchaseRequest->OrderNumber,$dto->ChargeType);
//                $data['D18'] = $chargeNo;

            $purchasingManager = App\Role::findUserWithRole('PurchasingManager');
            $operationsManager = App\Role::findUserWithRole('OperationsDirector');
            $plantManager = App\Role::findUserWithRole('PlantManager');
            $generalManager = App\Role::findUserWithRole('GeneralManager');
            
            $dto->PurchasingManager = $purchasingManager->Person()->AbbreviatedName();
            $dto->OperationsManager = $operationsManager->Person()->AbbreviatedName();

            if($plantManager && $generalManager && $plantManager->ID == $generalManager->ID) {
                $dto->PlantManager = $generalManager->Person()->AbbreviatedName();
                $dto->GeneralManager = "";
            }
            else {
                $dto->PlantManager = $plantManager?$plantManager->Person()->AbbreviatedName():"";
                $dto->GeneralManager = $generalManager?$generalManager->Person()->AbbreviatedName():"";
            }

            $html2pdf->writeHTML(view('report.templates.purchaseorder',['data'=>$dto]));
            $html2pdf->output();


        } else {
            $data = new DTO();
            $data->Title = "Purchase Order $orderNumber";
            $data->Class = "Purchase Order";
            $data->Description = "We cannot not find the $data->Class in the database.";
            return response()
                ->view('errors.404',['data'=>$data]
                    ,404);
        }
    } catch(\Exception $exc) {
        dd($exc);
    }





    $myfile = fopen("testfile.txt", "w+");
});

Route::get('/error',function() {
    return view('errors.404');
});


Route::get('/test/po-data/{year}/{month}', function($year, $month) {
    $startOfMonth = \Carbon\Carbon::create($year, $month, 1);
    $endOfMonth = \Carbon\Carbon::create($year, $month+1, 1)->subDay();
    
    $po = new PurchaseOrder();
    $poList = $po
        ->whereBetween('OrderDate',[$startOfMonth, $endOfMonth])
        ->where('Status','=','A');
    dd($poList->get());
});