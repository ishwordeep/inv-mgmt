<?php

use App\Http\Controllers\Admin\ItemDetailCrudController;
use App\Http\Controllers\Admin\MstItemCrudController;
use App\Http\Controllers\Admin\StockEntryCrudController;
use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('mst-country', 'MstCountryCrudController');
    Route::crud('mst-province', 'MstProvinceCrudController');
    Route::crud('mst-district', 'MstDistrictCrudController');
    Route::crud('mst-organization', 'MstOrganizationCrudController');
    Route::crud('mst-unit', 'MstUnitCrudController');
    Route::crud('mst-discount-mode', 'MstDiscountModeCrudController');
    Route::crud('mst-category', 'MstCategoryCrudController');
    Route::crud('mst-subcategory', 'MstSubcategoryCrudController');
    Route::crud('mst-supplier', 'MstSupplierCrudController');
    Route::crud('mst-gender', 'MstGenderCrudController');
    Route::crud('mst-invoice-sequence', 'MstInvoiceSequenceCrudController');
    Route::crud('mst-po-sequence', 'MstPoSequenceCrudController');
    Route::crud('mst-purchase-return-sequence', 'MstPurchaseReturnSequenceCrudController');
    Route::crud('mst-store', 'MstStoreCrudController');
    Route::crud('mst-sup-status', 'MstSupStatusCrudController');
    Route::crud('mst-payment-mode', 'MstPaymentModeCrudController');
    Route::crud('mst-return-reason', 'MstReturnReasonCrudController');
    Route::crud('mst-stock-adjustment-no', 'MstStockAdjustmentNoCrudController');
    Route::crud('mst-batch-no', 'MstBatchNoCrudController');
    Route::crud('mst-brand', 'MstBrandCrudController');
    Route::crud('mst-item', 'MstItemCrudController');
    Route::crud('user', 'UserCrudController');
    Route::crud('stock-entry', 'StockEntryCrudController');
    Route::crud('stock-item', 'StockItemCrudController');
    Route::crud('purchase-order', 'PurchaseOrderCrudController');
    Route::crud('purchase-order-item', 'PurchaseOrderItemCrudController');
    Route::crud('purchase-order-type', 'PurchaseOrderTypeCrudController');

    //AJAX call
    Route::get('get-podetails/{po_num}', [StockEntryCrudController::class,'fetchPurchaseOrderDetails'])->name('get-purchase-order-details');



    //API
    Route::get('api/subCategoryEntity/{category_id}', [MstItemCrudController::class, 'getSubCategoryAPI']);


  
    Route::crud('batch-detail', 'BatchDetailCrudController');
    Route::crud('item-detail', 'ItemDetailCrudController');
    Route::crud('sale', 'SaleCrudController');
    Route::crud('sale-item', 'SaleItemCrudController');

    // Reporting Route
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('item-detail',[ItemDetailCrudController::class,'getItemDetails'])->name('item-details');
    Route::get('report/active-items',[DashboardController::class,'totalActiveStock'])->name('active-items');
    Route::get('report/inactive-items',[DashboardController::class,'totalInactiveStock'])->name('inactive-items');
    Route::get('report/green-zoned-items',[DashboardController::class,'greenZonedStock'])->name('green-zoned-items');
    Route::get('report/yellow-zoned-items',[DashboardController::class,'yellowZonedStock'])->name('yellow-zoned-items');
    Route::get('report/red-zoned-items',[DashboardController::class,'redZonedStock'])->name('red-zoned-items');
}); // this should be the absolute last line of this file
