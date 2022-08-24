<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Models\Sale;
use App\Models\MstItem;
use App\Models\MstStore;
use App\Models\SaleItem;
use App\Models\ItemDetail;
use App\Models\MstSupStatus;
use App\Models\PurchaseOrder;
use App\Base\BaseCrudController;
use App\Models\PurchaseOrderItem;
use App\Http\Requests\SaleRequest;
use Illuminate\Support\Facades\DB;
use Prologue\Alerts\Facades\Alert;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class SaleCrudController extends BaseCrudController
{
    public function setup()
    {
        CRUD::setModel(\App\Models\Sale::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/sale');
        CRUD::setEntityNameStrings('sale', 'sales');
        $this->user=backpack_user();
    }

    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('store_id');
        CRUD::column('invoice_number');
        CRUD::column('invoice_date');
        CRUD::column('created_by');
        CRUD::column('approved_by');
        CRUD::column('transaction_date');
        CRUD::column('bill_type');
        CRUD::column('company_name');
        CRUD::column('pan_vat');
        CRUD::column('full_name');
        CRUD::column('address');
        CRUD::column('contact_number');
        CRUD::column('discount_mode_id');
        CRUD::column('discount');
        CRUD::column('flat_discount');
        CRUD::column('gross_total');
        CRUD::column('total_discount');
        CRUD::column('taxable_amount');
        CRUD::column('total_tax');
    }

    public function create()
    {
        $this->crud->hasAccessOrFail('create');
        $data = $this->getCreateData();
        
        return view('Sales.sales', $data);
    }

    public function store()
    {
        $this->crud->hasAccessOrFail('create');
        $request = $this->crud->validateRequest();

        if (isset($request)) {
            $saleDetails = $request->only([
                'bill_type',
                'store_id',
                'invoice_number',
                'transaction_date',
                'company_name',
                'pan_vat',
                'full_name',
                'address',
                'contact_number',
                'expected_delivery',
                'comment',
                'gross_amt',
                'discount_amt',
                'net_amt',
                'receipt_amt',
                'due_amt',
                'status_id',
            ]);

            $request->status_id=(int)$request->status_id;
            $approved_by = null;

            if ($request->status_id === MstSupStatus::APPROVED) {                
                $latestId = Sale::where('status_id', MstSupStatus::APPROVED)->count() ?? 0;
                $approved_by = $this->user->id;
            }

            DB::beginTransaction();
            try {
                $sales = Sale::create([
                    'bill_type' => $request->bill_type,
                    'store_id' => $request->store_id,
                    'invoice_number' => $request->invoice_number,
                    'transaction_date' => $request->transaction_date,
                    'company_name' => $request->company_name,
                    'pan_vat' => $request->pan_vat,
                    'full_name' => $request->full_name,
                    'address' => $request->address,
                    'contact_number' => $request->contact_number,
                    'invoice_date' => $request->expected_delivery,
                    'remarks' => $request->comment,
                    'gross_total' => $request->gross_amt,
                    'total_discount' => $request->discount_amt,
                    'net_amount' => $request->net_amt,
                    'receipt_amt' => $request->receipt_amt,
                    'due_amt' => $request->due_amt,
                    'status_id' => $request->status_id,
                    'approved_by' => $approved_by,
                ]);

                foreach ($request->inv_item_hidden as $key => $val) {
                    $itemArray = [
                        'sales_id' => $sales->id,
                        'item_id' => $request->inv_item_hidden[$key],
                        'add_qty' => $request->purchase_qty[$key],
                        'free_qty' => $request->free_qty[$key],
                        'total_qty' => $request->purchase_qty[$key]+$request->free_qty[$key],
                        'unit_price' => $request->purchase_price[$key],
                        'discount_mode_id' => $request->discount_mode_id[$key],
                        'discount' => $request->discount[$key],
                        'item_total' =>$request->item_amount[$key],
                    ];
                    $here = SaleItem::create($itemArray);
                }

                DB::commit();

                Alert::success(trans('backpack::crud.insert_success'))->flash();
                return response()->json([
                        'status' => true,
                        'url' => backpack_url('/sale/'. $sales->id.'/show'),
                ]);

                // return redirect(backpack_url('/purchase-order/'. $POId->id.'/show'));
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

        return view('Sales.salesShow', [
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

        return view('Sales.saleEdit', [
            'data' => $data,
            'entry' => $edit_data['entry'],
            'items' => $edit_data['items'],
            'crud' => $edit_data['crud'],
            'item_lists'=>$data['item_lists']
        ]);
    }

    public function update(){
        $this->crud->hasAccessOrFail('update');
        $request = $this->crud->validateRequest();
        $id = $this->crud->getCurrentEntryId();

        if (isset($request)) {
            $saleDetails = $request->only([
                'bill_type',
                'store_id',
                'invoice_number',
                'transaction_date',
                'company_name',
                'pan_vat',
                'full_name',
                'address',
                'contact_number',
                'expected_delivery',
                'comment',
                'gross_amt',
                'discount_amt',
                'net_amt',
                'receipt_amt',
                'due_amt',
                'status_id',
            ]);

            $request->status_id=(int)$request->status_id;
            $approved_by = null;

            DB::beginTransaction();
            try {
                if ($request->status_id == MstSupStatus::CANCELLED) {
                    PurchaseOrder::whereId($id)->update(['status_id' => MstSupStatus::CANCELLED]);
                }else {                
                    $latestId = Sale::where('status_id', MstSupStatus::APPROVED)->count() ?? 0;
                    $approved_by = $this->user->id;

                    $sales = Sale::whereId($id)->update([
                        'bill_type' => $request->bill_type,
                        'store_id' => $request->store_id,
                        'invoice_number' => $request->invoice_number,
                        'transaction_date' => $request->transaction_date,
                        'company_name' => $request->company_name,
                        'pan_vat' => $request->pan_vat,
                        'full_name' => $request->full_name,
                        'address' => $request->address,
                        'contact_number' => $request->contact_number,
                        'invoice_date' => $request->expected_delivery,
                        'remarks' => $request->comment,
                        'gross_total' => $request->gross_amt,
                        'total_discount' => $request->discount_amt,
                        'net_amount' => $request->net_amt,
                        'receipt_amt' => $request->receipt_amt,
                        'due_amt' => $request->due_amt,
                        'status_id' => $request->status_id,
                        'approved_by' => $approved_by,
                    ]);
                    SaleItem::whereSalesId($id)->delete();

                    foreach ($request->inv_item_hidden as $key => $val) {
                        $itemArray = [
                            'sales_id' => $id,
                            'item_id' => $request->inv_item_hidden[$key],
                            'add_qty' => $request->purchase_qty[$key],
                            'free_qty' => $request->free_qty[$key],
                            'total_qty' => $request->purchase_qty[$key]+$request->free_qty[$key],
                            'unit_price' => $request->purchase_price[$key],
                            'discount_mode_id' => $request->discount_mode_id[$key],
                            'discount' => $request->discount[$key],
                            'item_total' =>$request->item_amount[$key],
                        ];
                        $here = SaleItem::create($itemArray);
                    }
                }
                DB::commit();

                Alert::success(trans('backpack::crud.insert_success'))->flash();
                return response()->json([
                        'status' => true,
                        'url' => backpack_url('/sale/'. $id.'/show'),
                ]);

                // return redirect(backpack_url('/purchase-order/'. $POId->id.'/show'));
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

    public function salePrintPdf($id){
        $data = $this->getData($id);

        $pdf = PDF::loadView('Sales.salesPdf', $data);
        return $pdf->stream('SalesPdf.pdf');
    }

    public function getItemQuantity($itemid){
        $availableQty=ItemDetail::select('item_qty')->whereItemId($itemid)->whereStoreId($this->user->store_id)->first();

        return response()->json([
            'qty' => $availableQty,
        ]);
    }

    public function getCreateData(){
        $filtered_items = [];

        $items = MstItem::where('is_active', 'true')->get(['id', 'name_en']);
        $stores = MstStore::where('is_active',true)->get();

        foreach ($items as $item) {
            array_push($filtered_items, [
                'id' => $item->id,
                'name' => $item->name_en
            ]);
        }
        $data['stores'] = $stores;
        $data['item_lists'] = $filtered_items;
        $data['crud'] = $this->crud;
        $data['saveAction'] = $this->crud->getSaveAction();
        $data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.add') . ' ' . $this->crud->entity_name;

        return $data;
    }

    public function getData($id){
        $data = [];
             
        $data['entry'] = $this->crud->getEntry($id);
        $data['items'] = $data['entry']->saleItemsEntity;
        $data['crud'] = $this->crud;

        return $data;
    }
}
