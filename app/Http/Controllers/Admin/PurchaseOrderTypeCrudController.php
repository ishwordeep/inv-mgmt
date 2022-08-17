<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\PurchaseOrderTypeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Database\Console\Migrations\BaseCommand;

/**
 * Class PurchaseOrderTypeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PurchaseOrderTypeCrudController extends BaseCrudController
{
   

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\PurchaseOrderType::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/purchase-order-type');
        CRUD::setEntityNameStrings('purchase order type', 'purchase order types');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $columns = [
            $this->addRowNumberColumn(),
            $this->addNameEnColumn(),
            $this->addNameLcColumn(),
            $this->addIsActiveColumn(),
        ];
        $this->crud->addColumns(array_filter($columns));
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PurchaseOrderTypeRequest::class);

        $fields = [
            $this->addNameEnField(),
            $this->addNameLcField(),
            $this->addIsActiveField(),
            $this->addDescriptionField(),
        ];
        $this->crud->addFields(array_filter($fields));
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
