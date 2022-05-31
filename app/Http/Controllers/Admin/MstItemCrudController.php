<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MstItemRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MstItemCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MstItemCrudController extends CrudController
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
        CRUD::setModel(\App\Models\MstItem::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/mst-item');
        CRUD::setEntityNameStrings('mst item', 'mst items');
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
        CRUD::column('code');
        CRUD::column('name_en');
        CRUD::column('name_lc');
        CRUD::column('description');
        CRUD::column('category_id');
        CRUD::column('subcategory_id');
        CRUD::column('supplier_id');
        CRUD::column('brand_id');
        CRUD::column('unit_id');
        CRUD::column('stock_alert_minimum');
        CRUD::column('tax_vat');
        CRUD::column('discount_mode_id');
        CRUD::column('is_taxable');
        CRUD::column('is_nonclaimable');
        CRUD::column('is_active');
        CRUD::column('created_by');
        CRUD::column('updated_by');
        CRUD::column('deleted_by');
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
        CRUD::setValidation(MstItemRequest::class);

        CRUD::field('id');
        CRUD::field('code');
        CRUD::field('name_en');
        CRUD::field('name_lc');
        CRUD::field('description');
        CRUD::field('category_id');
        CRUD::field('subcategory_id');
        CRUD::field('supplier_id');
        CRUD::field('brand_id');
        CRUD::field('unit_id');
        CRUD::field('stock_alert_minimum');
        CRUD::field('tax_vat');
        CRUD::field('discount_mode_id');
        CRUD::field('is_taxable');
        CRUD::field('is_nonclaimable');
        CRUD::field('is_active');
        CRUD::field('created_by');
        CRUD::field('updated_by');
        CRUD::field('deleted_by');
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
