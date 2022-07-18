<?php

namespace App\Http\Controllers\Admin;

use App\Models\MstStore;
use App\Models\MstSupplier;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Base\BaseCrudController;
use App\Models\PurchaseOrderType;
use App\Http\Requests\PurchaseOrderRequest;
use App\Models\MstItem;
use App\Models\MstPoSequence;
use App\Models\MstSupStatus;
use App\Models\PurchaseOrderItem;
use Illuminate\Support\Facades\DB;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PurchaseOrderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PurchaseOrderCrudController extends BaseCrudController
{


    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\PurchaseOrder::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/purchase-order');
        CRUD::setEntityNameStrings('purchase order', 'purchase orders');
        $this->user = backpack_user();
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */

    protected function setupListOperation()
    {
        CRUD::column('id');
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
        CRUD::column('status_id');
        CRUD::column('created_by');
        CRUD::column('created_at');
        CRUD::column('updated_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    public function create()
    {
        $filtered_items = [];
        $this->crud->hasAccessOrFail('create');
        $items = MstItem::where('is_active', 'true')->get(['id', 'name_en']);

        foreach ($items as $item) {
            array_push($filtered_items, [
                'id' => $item->id,
                'name' => $item->name_en
            ]);
        }
        $this->data['item_lists'] = $filtered_items;
        $this->data['invType'] = 'addRepeaterToPO';
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->crud->getSaveAction();
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.add') . ' ' . $this->crud->entity_name;

        $this->data['po_types'] = PurchaseOrderType::whereIsActive(true)->select('id', 'name_en')->get();
        $this->data['suppliers'] = MstSupplier::whereIsActive(true)->select('id', 'name_en')->get();

        if ($this->user->user_level === config('users.user_level.store_user')) {
            $stores = MstStore::whereIsActive(true)->whereId($this->user->store_id)->select('id', 'name_en')->get();
            $requested_stores = MstStore::whereIsActive(true)->where('id', '<>', $this->user->store_id)->select('id', 'name_en')->get();
        } else {
            $stores = MstStore::whereIsActive(true)->select('id', 'name_en')->get();
            $requested_stores = MstStore::whereIsActive(true)->select('id', 'name_en')->get();
        }



        $this->data['stores'] = $stores;
        $this->data['requested_stores'] = $requested_stores;
        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('customViews.purchaseOrder', $this->data);
    }
    public function store()
    {
        $this->crud->hasAccessOrFail('create');
        $request = $this->crud->validateRequest();
        // dd($request->all());
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

            if ($request->status_id === MstSupStatus::APPROVED) {
                if (!$this->user->is_po_approver) abort(401);

                $latestId =PurchaseOrder::latest()->where('status_id', MstSupStatus::APPROVED)->count() ?? 0;
                $purchaseOrderDetails['po_number'] = (MstPoSequence::first()->sequence_code) . ($latestId + 1);
                $purchaseOrderDetails['po_date'] = 2079/12/12;//add current date
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
                        'total_qty' => $request->total_qty[$key],
                        'discount_mode_id' => $request->discount_mode_id[$key],
                        'discount' => $request->discount[$key],
                        'purchase_price' => $request->purchase_price[$key],
                        'item_amount' => $request->item_amount[$key],
                        'item_id' => $request->inv_item_hidden[$key],
                        'expiry_date' => $request->expiry_date[$key],
                    ];
                    PurchaseOrderItem::create($itemArray);
                }

                DB::commit();

                // Alert::success(trans('backpack::crud.insert_success'))->flash();
                return response()->json([
                    'status' => true,
                    'url' => backpack_url('/purchase-order'),
                ]);
            } catch (\Throwable $th) {
                DB::rollback();

                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage()
                ], 404);
            }
        }
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
