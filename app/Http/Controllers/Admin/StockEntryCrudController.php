<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\StockEntryRequest;
use App\Models\MstDiscountMode;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class StockEntryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StockEntryCrudController extends BaseCrudController
{


    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\StockEntry::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/stock-entry');
        CRUD::setEntityNameStrings('', 'Stock Entries');
    }
    public function create()
    {
        $this->crud->hasAccessOrFail('create');

        // prepare the fields you need to show
        $this->data['invType'] = 'addRepeaterToStockEntry';
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->crud->getSaveAction();
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.add') . ' ' . $this->crud->entity_name;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('customViews.stockEntries', $this->data);
    }

    public function fetchPurchaseOrderDetails($po_num)
    {
        $pod = PurchaseOrder::where('po_number', $po_num)->first();

        if (isset($pod)) {
            $discount_modes = MstDiscountMode::all();
            $poItems = PurchaseOrderItem::wherePoId($pod->id)->get();
            $data = [
                'view' => view('customViews.partialViews.trForPOItemsForStockEntries', compact('poItems', 'discount_modes'))->render(),
                'pod' => $pod,
            ];
            return ($data);
        } else {
            return response()->json([
                'nodata' => 'nodata'
            ]);
        }
    }
}
