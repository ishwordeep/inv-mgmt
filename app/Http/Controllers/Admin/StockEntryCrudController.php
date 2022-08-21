<?php

namespace App\Http\Controllers\Admin;

use PDF;
use Carbon\Carbon;
use App\Models\MstItem;
use App\Models\MstStore;
use App\Models\StockItem;
use App\Models\ItemDetail;
use App\Models\MstBatchNo;
use App\Models\StockEntry;
use App\Models\BatchDetail;
use App\Models\MstSupplier;
use App\Models\MstSupStatus;
use App\Models\PurchaseOrder;
use App\Models\MstDiscountMode;
use App\Base\BaseCrudController;
use App\Models\PurchaseOrderItem;
use Illuminate\Support\Facades\DB;
use Prologue\Alerts\Facades\Alert;
use App\Models\MstStockAdjustmentNo;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StockEntryRequest;
use Illuminate\Queue\Console\BatchesTableCommand;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class StockEntryCrudController extends BaseCrudController
{
    public function setup()
    {
        CRUD::setModel(\App\Models\StockEntry::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/stock-entry');
        CRUD::setEntityNameStrings('', 'Stock Entries');
        $this->user = backpack_user();
    }

    public function create()
    {
        $this->crud->hasAccessOrFail('create');

        $data = $this->getCreateData();

        return view('StockEntry.stockEntries', $data);
    }

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        $request = $this->crud->validateRequest();
        // dd($request->all());

        $stockInput = $request->only([
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
            'po_number',
            'status_id',
        ]);

        $stockInput['created_by'] = $this->user->id;

        $statusCheck = $request->status_id == MstSupStatus::APPROVED;

        if ($statusCheck) {

            $latestId = StockEntry::latest()
                ->where('status_id', MstSupStatus::APPROVED)
                ->first()->id ?? 0;
            $stockInput['stock_adjustment_number'] = (MstStockAdjustmentNo::first()->sequence_code . '-') . ($latestId + 1);
            $stockInput['entry_date'] = Carbon::now()->toDateString();
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
            
            foreach ($request->inv_item_hidden as $key => $val) {
                if(isset($request->inv_item_hidden[$key])){
                $itemArr = [
                    'stock_id' => $stock->id,
                    'item_id' => $request->inv_item_hidden[$key],
                    'add_qty' => $request->purchase_qty[$key],
                    'free_qty' => $request->free_qty[$key],
                    'total_qty' => $request->total_qty[$key],
                    'discount_mode_id' => $request->discount_mode_id[$key],
                    'discount' => $request->discount[$key],
                    'unit_cost_price' => $request->purchase_price[$key],
                    'unit_sales_price' => $request->unit_sale[$key],
                    'expiry_date' => $request->expiry_date[$key],
                    'tax_vat' => $request->taxvat[$key],
                    'amount' => $request->item_amount[$key],
                ];
               
                if($statusCheck=='2'){
                    $this->saveItemQtyDetails($itemArr);
                }
                $stockItem = StockItem::create($itemArr);
            }
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Stock added successfully',
                'url' => backpack_url('/stock-entry/'. $stock->id.'/show'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return response()->json([
                'status' => 'failed',
                'message' => "Failed to create stock. Please contact your administrator." . $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        $this->crud->hasAccessOrFail('show');
        // get entry ID from Request (makes sure its the last ID for nested resources)
        $id = $this->crud->getCurrentEntryId() ?? $id;
        
        $data = $this->getData($id);

        return view('StockEntry.StockEntriesShow', [
            'entry' => $data['entry'],
            'items' => $data['items'],
            'crud' => $data['crud'],
        ]);
    }

    public function edit($id){
        $this->crud->hasAccessOrFail('update');

        $id = $this->crud->getCurrentEntryId() ?? $id;
        $edit_data = $this->getData($id);
        $data = $this->getCreateData();

        return view('StockEntry.stockEntriesEdit', [
            'data' => $data,
            'entry' => $edit_data['entry'],
            'items' => $edit_data['items'],
            'crud' => $edit_data['crud'],
        ]);
    }

    public function update(){
        $this->crud->hasAccessOrFail('update');
        $request = $this->crud->validateRequest();
        $id = $this->crud->getCurrentEntryId();

        $stockInput = $request->only([
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
            'po_number',
            'status_id',
        ]);

        DB::beginTransaction();
        try{
            $statusCheck = $request->status_id;
            
            if ($statusCheck == MstSupStatus::CANCELLED) {
                PurchaseOrder::whereId($id)->update(['status_id' => MstSupStatus::CANCELLED]);
            }else{
                $latestId = StockEntry::latest()
                ->where('status_id', MstSupStatus::APPROVED)
                ->first()->id ?? 0;
                $stockInput['stock_adjustment_number'] = (MstStockAdjustmentNo::first()->sequence_code . '-') . ($latestId + 1);
                $stockInput['entry_date'] = Carbon::now()->toDateString();
                $stockInput['approved_by'] = $this->user->id;
            }

            if (!$request->itemWiseDiscount) {
                $stockInput['flat_discount'] = $request->flat_discount;
                $itemDiscount = null;
            } else {
                $stockInput['flat_discount'] = null;
            }


            $stock = StockEntry::whereId($id)->update($stockInput);
            StockItem::whereStockId($id)->delete();

            foreach ($request->inv_item_hidden as $key => $val) {

                if(isset($request->inv_item_hidden[$key])){
                    $itemArr = [
                        'stock_id' => $id,
                        'item_id' => $request->inv_item_hidden[$key],
                        'add_qty' => $request->purchase_qty[$key],
                        'free_qty' => $request->free_qty[$key],
                        'total_qty' => $request->total_qty[$key],
                        'discount_mode_id' => $request->discount_mode_id[$key],
                        'discount' => $request->discount[$key],
                        'unit_cost_price' => $request->purchase_price[$key],
                        'unit_sales_price' => $request->unit_sale[$key],
                        'expiry_date' => $request->expiry_date[$key],
                        'tax_vat' => $request->taxvat[$key],
                        'amount' => $request->item_amount[$key],
                    ];
                
                    $stockItem = StockItem::create($itemArr);
                    if($statusCheck=='2'){
                    $this->saveItemQtyDetails($itemArr);
                    }

                }   
            }
            
            DB::commit();

            Alert::success(trans('backpack::crud.insert_success'))->flash();
            return response()->json([
                'status' => true,
                'url' => backpack_url('/stock-entry/'. $id.'/show'),
            ]);
        }catch(\Throwable $th){
            dd($th);
            DB::rollback();
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
        // dd("hell",$this->user);
        $arr = [
            'store_id' => $this->user->store_id,
            'item_id' => $itemArr['item_id'],
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

    public function getData($id){
        $data = [];

        if ($this->crud->get('show.softDeletes') && in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this->crud->model))) {
            $data['entry'] = $this->crud->getModel()->withTrashed()->findOrFail($id);
        } else {
            $data['entry'] = $this->crud->getEntry($id);
        }
        $data['items'] = $data['entry']->stockItemsEntity;
        $data['crud'] = $this->crud;
        
        return $data;
    }

    public function getCreateData(){
        $filtered_items = [];

        $items = MstItem::where('is_active', 'true')->get(['id', 'name_en']);

        foreach ($items as $item) {
            array_push($filtered_items, [
                'id' => $item->id,
                'name' => $item->name_en
            ]);
        }

        $data['item_lists'] = $filtered_items;
        $data['invType'] = 'addRepeaterToStockEntry';
        $data['suppliers'] = MstSupplier::whereIsActive(true)->select('id', 'name_en')->get();
        $data['crud'] = $this->crud;
        $data['saveAction'] = $this->crud->getSaveAction();
        $data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.add') . ' ' . $this->crud->entity_name;
        
        if ($this->user->user_level === config('users.user_level.store_user')) {
            $stores = MstStore::whereIsActive(true)->whereId($this->user->store_id)->select('id', 'name_en')->get();
            $requested_stores = MstStore::whereIsActive(true)->where('id', '<>', $this->user->store_id)->select('id', 'name_en')->get();
        } else {
            $stores = MstStore::whereIsActive(true)->select('id', 'name_en')->get();
            $requested_stores = MstStore::whereIsActive(true)->select('id', 'name_en')->get();
        }

        $data['stores'] = $stores;
        return $data;
    }

    public function seSendMail($id){
        $data = $this->getData($id);
        $data['store_email'] = MstStore::whereId($data['entry']->store_id)->pluck('email')->first();
        
        $pdf = PDF::loadView('StockEntry.stockEntriesPdf', $data);

        try{
            if(isset($data['store_email'])){
                    Mail::send('test',$data, function($message) use($pdf,$data) {
                        $message->to($data['store_email'])
                        ->from(env('MAIL_USERNAME'))
                        ->subject('Stock Entry')
                        ->attachData($pdf->output(),'StockEntry.pdf');
                    });
                \Alert::success(trans('Email sent successfully'))->flash();
            }else{
                \Alert::error(trans('Some problem occured during sending the email.'))->flash();
            }
        }catch(Exception $e){
            dd($e);
        }
        return redirect()->back();
    }

    public function sePrintPdf($id){
        $data = $this->getData($id);

        $pdf = PDF::loadView('StockEntry.stockEntriesPdf', $data);
        return $pdf->stream('StockEntry.pdf');
    }
}
