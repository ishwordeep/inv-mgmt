<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\MstSupplierRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MstSupplierCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MstSupplierCrudController extends BaseCrudController
{
    
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\MstSupplier::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/mst-supplier');
        CRUD::setEntityNameStrings('mst supplier', 'mst suppliers');
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
        CRUD::column('country_id');
        CRUD::column('province_id');
        CRUD::column('district_id');
        CRUD::column('address');
        CRUD::column('email');
        CRUD::column('contact_person');
        CRUD::column('contact_number');
        CRUD::column('description');
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
        CRUD::setValidation(MstSupplierRequest::class);

        
       
        $fields = [
            $this->addReadOnlyCodeField(),
            $this->addNameEnField(),
            $this->addNameLcField(),
            $this->addCountryField(),
            $this->addProvinceField(),
            $this->addDistrictField(),
            $this->addAddressField(),
            [
                'name'=>'contact_person',
                'type'=>'text',
                'label'=>'Contact Person',
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            $this->addEmailField(),
            $this->addPhoneField(),
            $this->addDescriptionField(),
            $this->addIsActiveField(),
        ];
        $this->crud->addFields(array_filter($fields));

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
