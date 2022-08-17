<?php

namespace App\Http\Controllers\Admin;

use PDF;
use Mail;
use Carbon\Carbon;
use App\Models\MstItem;
use App\Models\MstStore;
use App\Models\MstSupplier;
use App\Models\MstSupStatus;
use Illuminate\Http\Request;
use App\Models\MstPoSequence;
use App\Models\PurchaseOrder;
use App\Models\MstDiscountMode;
use App\Base\BaseCrudController;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseOrderType;
use Illuminate\Support\Facades\DB;
use Prologue\Alerts\Facades\Alert;
use App\Http\Requests\PurchaseOrderRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class PurchaseOrderCrudController extends BaseCrudController
{
    public function setup()
    {
        CRUD::setModel(\App\Models\PurchaseOrder::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/purchase-order');
        CRUD::setEntityNameStrings('', 'Purchase Orders');
        $this->user = backpack_user();
    }

    protected function setupListOperation()
    {
        CRUD::column('po_number');
        CRUD::column('po_date');
        CRUD::column('expected_delivery');
        CRUD::column('approved_by');
        CRUD::column('gross_amt');
        CRUD::column('discount_amt');
        CRUD::column('tax_amt');
        CRUD::column('other_charges');
        CRUD::column('net_amt');
        CRUD::column('comments');
        CRUD::column('store_id');
        CRUD::column('supplier_id');
        CRUD::column('po_type_id');
        CRUD::column('requested_store_id');
    }

    public function create()
    {
        $this->crud->hasAccessOrFail('create');

        $data = $this->getCreateData();

        return view('PurchaseOrder.purchaseOrder', $data);
    }

    public function store()
    {
        $this->crud->hasAccessOrFail('create');
        $request = $this->crud->validateRequest();

        if (isset($request)) {
            $purchaseOrderDetails = $request->only([
                'status_id',
                'po_type_id',
                'supplier_id',
                'store_id',
                'requested_store_id',
                'expected_delivery',
                'approved_by',
                'gross_amt',
                'discount_amt',
                'tax_amt',
                'net_amt',
                'comments',
            ]);

            $request->status_id=(int)$request->status_id;

            if ($request->status_id === MstSupStatus::APPROVED) {
                // if (!$this->user->is_po_approver) abort(401);
                
                $latestId =PurchaseOrder::where('status_id', MstSupStatus::APPROVED)->count() ?? 0;
                // dd($request->status_id,$latestId);

                $purchaseOrderDetails['po_number'] = (MstPoSequence::first()->sequence_code).($latestId + 1);
                // dd((MstPoSequence::first()->sequence_code),$purchaseOrderDetails['po_number']);

                $purchaseOrderDetails['po_date'] = Carbon::now()->toDateString();
                $purchaseOrderDetails['approved_by'] = $this->user->id;
            }

            DB::beginTransaction();
            try {
                $POId = PurchaseOrder::create($purchaseOrderDetails);

                foreach ($request->inv_item_hidden as $key => $val) {
                    $itemArray = [
                        'po_id' => $POId->id,
                        'purchase_qty' => $request->purchase_qty[$key],
                        'free_qty' => $request->free_qty[$key],
                        'total_qty' => $request->purchase_qty[$key]+$request->free_qty[$key],
                        'discount_mode_id' => $request->discount_mode_id[$key],
                        'discount' => $request->discount[$key],
                        'purchase_price' => $request->purchase_price[$key],
                        'item_amount' =>312,
                        'item_id' => $request->inv_item_hidden[$key],
                    ];
                    PurchaseOrderItem::create($itemArray);
                }

                DB::commit();

                // return response()->json([
                    //     'status' => true,
                    //     'url' => backpack_url('/purchase-order/'. $POId->id.'/show'),
                    // ]);

                Alert::success(trans('backpack::crud.insert_success'))->flash();
                return redirect(backpack_url('/purchase-order/'. $POId->id.'/show'));
            } catch (\Throwable $th) {
                dd($th);
                DB::rollback();

                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage()
                ], 404);
            }
        }
    }

    public function show($id)
    {
        $this->crud->hasAccessOrFail('show');
        // get entry ID from Request (makes sure its the last ID for nested resources)
        $id = $this->crud->getCurrentEntryId() ?? $id;

        $data = $this->getData($id);

        return view('PurchaseOrder.purchaseOrderShow', [
            'entry' => $data['entry'],
            'items' => $data['items'],
            'crud' => $data['crud'],
        ]);
    }

    public function edit($id)
    {
        $this->crud->hasAccessOrFail('update');

        $id = $this->crud->getCurrentEntryId() ?? $id;
        $edit_data = $this->getData($id);
        $data = $this->getCreateData();

        return view('PurchaseOrder.purchaseOrderEdit', [
            'data' => $data,
            'entry' => $edit_data['entry'],
            'items' => $edit_data['items'],
            'crud' => $edit_data['crud'],
        ]);
    }

    public function update()
    {
        $this->crud->hasAccessOrFail('update');
        $request = $this->crud->validateRequest();
        $id = $this->crud->getCurrentEntryId();

        if (isset($request)) {
            $purchaseOrderDetails = $request->only([
                'status_id',
                'po_type_id',
                'supplier_id',
                'store_id',
                'requested_store_id',
                'expected_delivery',
                'approved_by',
                'gross_amt',
                'discount_amt',
                'tax_amt',
                'net_amt',
                'comments',
            ]);

            $request->status_id=(int)$request->status_id;

            if ($request->status_id === MstSupStatus::APPROVED) {                
                $latestId =PurchaseOrder::where('status_id', MstSupStatus::APPROVED)->count() ?? 0;
                $purchaseOrderDetails['approved_by'] = $this->user->id;
            }

            DB::beginTransaction();
            try{
                $POId = PurchaseOrder::whereId($id)->update($purchaseOrderDetails);
                dd($request->inv_item_hidden);
            }catch (\Throwable $th) {
                dd($th);
                DB::rollback();
            }
        }
    }

    public function poPrintPdf($id){
        $data = $this->getData($id);

        $pdf = PDF::loadView('PurchaseOrder.purchaseOrderPdf', $data);
        return $pdf->stream('PurchaseOrder.pdf');
    }

    public function poSendMail($id){
        $data = $this->getData($id);
        $data['store_email'] = MstStore::whereId($data['entry']->store_id)->pluck('email')->first();
        
        $pdf = PDF::loadView('PurchaseOrder.purchaseOrderPdf', $data);

        try{
            if(isset($data['store_email'])){
                    Mail::send('test',$data, function($message) use($pdf,$data) {
                        $message->to($data['store_email'])
                        ->from(env('MAIL_USERNAME'))
                        ->subject('Purchase Order')
                        ->attachData($pdf->output(),'PurchaseOrder.pdf');
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

    public function getData($id){
        // get the info for that entry (include softDeleted items if the trait is used)
        if ($this->crud->get('show.softDeletes') && in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this->crud->model))) {
            $data['entry'] = $this->crud->getModel()->withTrashed()->findOrFail($id);
        } else {
            $data['entry'] = $this->crud->getEntry($id);
        }
        $data['items'] = $data['entry']->purchaseItemsEntity;
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
        $data['invType'] = 'addRepeaterToPO';
        $data['crud'] = $this->crud;
        $data['saveAction'] = $this->crud->getSaveAction();
        $data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.add') . ' ' . $this->crud->entity_name;

        $data['po_types'] = PurchaseOrderType::whereIsActive(true)->select('id', 'name_en')->get();
        $data['suppliers'] = MstSupplier::whereIsActive(true)->select('id', 'name_en')->get();
        $data['discount_mode'] = MstDiscountMode::whereIsActive(true)->select('id', 'name_en')->get();
        
        if ($this->user->user_level === config('users.user_level.store_user')) {
            $stores = MstStore::whereIsActive(true)->whereId($this->user->store_id)->select('id', 'name_en')->get();
            $requested_stores = MstStore::whereIsActive(true)->where('id', '<>', $this->user->store_id)->select('id', 'name_en')->get();
        } else {
            $stores = MstStore::whereIsActive(true)->select('id', 'name_en')->get();
            $requested_stores = MstStore::whereIsActive(true)->select('id', 'name_en')->get();
        }

        $data['stores'] = $stores;
        $data['requested_stores'] = $requested_stores;

        return $data;
    }
}
