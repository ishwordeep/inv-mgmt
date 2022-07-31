<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\SaleRequest;
use App\Models\MstItem;
use App\Models\MstStore;
use App\Models\Sale;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SaleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SaleCrudController extends BaseCrudController
{
   

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Sale::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/sale');
        CRUD::setEntityNameStrings('sale', 'sales');
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
        CRUD::column('net_amount');
        CRUD::column('receipt_amt');
        CRUD::column('due_amt');
        CRUD::column('status_id');
        CRUD::column('remarks');
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
        $stores=MstStore::where('is_active',true)->get();

        foreach ($items as $item) {
            array_push($filtered_items, [
                'id' => $item->id,
                'name' => $item->name_en
            ]);
        }
        $this->data['stores'] = $stores;
        $this->data['item_lists'] = $filtered_items;
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->crud->getSaveAction();
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.add') . ' ' . $this->crud->entity_name;


        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('Sales.sales', $this->data);
    }

    public function show($id)
    {
        // dd("blade[salesShow.blade.php] to be edited");
        $this->crud->hasAccessOrFail('show');

        // get entry ID from Request (makes sure its the last ID for nested resources)
        $id = $this->crud->getCurrentEntryId() ?? $id;
        $data = [];
        // get the info for that entry (include softDeleted items if the trait is used)
     
            $data['entry'] = $this->crud->getEntry($id);
        

        $data['entry'] = $this->crud->getEntry($id);

        $data['items'] = $data['entry']->saleItemsEntity;

        $data['crud'] = $this->crud;

        return view('Sales.salesShow', [
            'entry' => $data['entry'],
            'items' => $data['items'],
            'crud' => $data['crud'],
        ]);
    }
}
