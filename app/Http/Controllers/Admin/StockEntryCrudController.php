<?php

namespace App\Http\Controllers\Admin;

use App\Models\MstSupStatus;
use App\Models\PurchaseOrder;
use App\Models\MstDiscountMode;
use App\Base\BaseCrudController;
use App\Models\PurchaseOrderItem;
use Illuminate\Support\Facades\DB;
use App\Models\MstStockAdjustmentNo;
use App\Http\Requests\StockEntryRequest;
use App\Models\BatchDetail;
use App\Models\ItemDetail;
use App\Models\MstBatchNo;
use App\Models\MstItem;
use App\Models\StockEntry;
use App\Models\StockItem;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Queue\Console\BatchesTableCommand;

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
        $this->user = backpack_user();
    }

    public function create()
    {
        $filtered_items = [];

        $this->crud->hasAccessOrFail('create');

        // prepare the fields you need to show
        $items = MstItem::where('is_active', 'true')->get(['id', 'name_en']);

        foreach ($items as $item) {
            array_push($filtered_items, [
                'id' => $item->id,
                'name' => $item->name_en
            ]);
        }
        $this->data['item_lists'] = $filtered_items;
        $this->data['invType'] = 'addRepeaterToStockEntry';
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->crud->getSaveAction();
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.add') . ' ' . $this->crud->entity_name;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('StockEntry.stockEntries', $this->data);
    }

    public function store()
    {
        // dd("ok");
        $this->crud->hasAccessOrFail('create');

        $request = $this->crud->validateRequest();
        // dd($request->request);

        $stockInput = $request->only([
            'store_id',
            'store_id',
            'remarks',
            'gross_total',
            'total_discount',
            'flat_discount',
            'taxable_amount',
            'total_tax',
            'net_amount',
            'stock_adjustment_number',
            'invoice_number',
            'invoice_date',
            'status_id',
        ]);

        $stockInput['created_by'] = $this->user->id;

        $statusCheck = $request->sup_status_id == MstSupStatus::APPROVED;

        if ($statusCheck) {
            if (!$this->user->is_stock_approver) abort(401);

            $latestId = $this->stockEntries->latest()
                ->where('status_id', MstSupStatus::APPROVED)
                ->first()->id ?? 0;
            $stockInput['adjustment_no'] = (MstStockAdjustmentNo::first()->sequence_code . '-') . ($latestId + 1);
            $stockInput['entry_date'] = '2022/12/12';
            $stockInput['approved_by'] = $this->user->id;
        }

        if (!$request->itemWiseDiscount) {
            $stockInput['flat_discount'] = $request->flat_discount;
            $itemDiscount = null;
        } else {
            $stockInput['flat_discount'] = null;
        }

        try {
            DB::beginTransaction();
            $stock = StockEntry::create($stockInput);
            foreach ($request->mst_item_id as $key => $val) {
                $itemArr = [
                    'stock_id' => $stock->id,
                    'item_id' => $request->itemStockHidden[$key],
                    'add_qty' => $request->add_qty[$key],
                    'free_qty' => $request->free_item[$key],
                    'total_qty' => $request->total_qty[$key],
                    'discount_mode_id' => $request->total_qty[$key],
                    'discount' => isset($itemDiscount) ? $itemDiscount : (isset($request->discount[$key]) ? $request->discount[$key] : null),
                    'unit_cost_price' => $request->unit_cost_price[$key],
                    'unit_sales_price' => $request->unit_sales_price[$key],
                    'expiry_date' => $request->expiry_date[$key],
                    'tax_vat' => $request->tax_vat[$key],
                    'amount' => $request->item_total[$key],
                ];
                if ($statusCheck) {

                    $itemArr['batch_no'] = MstBatchNo::first()->sequence_code . '-' . $stock->id;

                    $this->saveItemQtyDetails();
                    $this->saveBatchQtyDetails($itemArr);
                }

                $stockItem = StockItem::create($itemArr);
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Stock added successfully',
                'route' => url($this->crud->route)
            ]);
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return response()->json([
                'status' => 'failed',
                'message' => "Failed to create stock. Please contact your administrator." . $e->getMessage()
            ]);
        }
    }

    private function saveBatchQtyDetails($itemArr)
    {
        $arr = [
            'store_id' => $this->user->store_id,
            'item_id' => $itemArr['item_id'],
            'created_by' => $this->user->id,
        ];


        $flag = false;

        $arr['batch_no'] = $itemArr['batch_no'];
        $arr['batch_qty'] = $itemArr['total_qty'];
        $arr['batch_price'] = $itemArr['unit_cost_price'];

        BatchDetail::create($arr);
    }

    private function saveItemQtyDetails($itemArr)
    {
        $arr = [
            'store_id' => $this->user->store_id,
            'item_id' => $itemArr['mst_item_id'],
            'created_by' => $this->user->id,
        ];


       
            $arr['item_qty'] = $itemArr['total_qty'];
            $existingItemQty =ItemDetail::where([
                'store_id' => $this->user->store_id,
                'item_id' => $itemArr['item_id'],
            ])->first();

            $flag = $existingItemQty ?? false;
       
        if ($flag) {
            $flag->item_qty = $arr['item_qty']+$existingItemQty->item_qty;
            $flag->save();
        } else {
            ItemDetail::create($arr);
        }
    }

    public function sePrintPdf($id){
        dd('here');
    }

    public function fetchPurchaseOrderDetails($po_num)
    {
        $pod = PurchaseOrder::where('po_number', $po_num)->first();

        if (isset($pod)) {
            $discount_modes = MstDiscountMode::all();
            $poItems = PurchaseOrderItem::wherePoId($pod->id)->get();
            $data = [
                'view' => view('PartialViews.trForPOItemsForStockEntries', compact('poItems', 'discount_modes'))->render(),
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
