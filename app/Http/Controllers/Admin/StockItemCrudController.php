<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StockItemRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class StockItemCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StockItemCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\StockItem::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/stock-item');
        CRUD::setEntityNameStrings('stock item', 'stock items');
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
        CRUD::column('stock_id');
        CRUD::column('item_id');
        CRUD::column('add_qty');
        CRUD::column('free_qty');
        CRUD::column('total_qty');
        CRUD::column('expiry_date');
        CRUD::column('unit_cost_price');
        CRUD::column('unit_sales_price');
        CRUD::column('discount');
        CRUD::column('tax_vat');
        CRUD::column('amount');
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
    protected function setupCreateOperation()
    {
        CRUD::setValidation(StockItemRequest::class);

        CRUD::field('id');
        CRUD::field('stock_id');
        CRUD::field('item_id');
        CRUD::field('add_qty');
        CRUD::field('free_qty');
        CRUD::field('total_qty');
        CRUD::field('expiry_date');
        CRUD::field('unit_cost_price');
        CRUD::field('unit_sales_price');
        CRUD::field('discount');
        CRUD::field('tax_vat');
        CRUD::field('amount');
        CRUD::field('created_at');
        CRUD::field('updated_at');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
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
