<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\MstStoreRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MstStoreCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MstStoreCrudController extends BaseCrudController
{
  
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\MstStore::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/mst-store');
        CRUD::setEntityNameStrings('', 'Stores');
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
            $this->addCodeColumn(),
            $this->addNameEnColumn(),
            $this->addNameLcColumn(),
            [
                'name'      => 'logo', // The db column name
                'label'     => 'Logo', // Table column heading
                'type'      => 'image',
                // 'prefix' => 'folder/subfolder/',
                // image from a different disk (like s3 bucket)
                'disk'   => 'uploads', 
                // optional width/height if 25px is not ok with you
                'height' => '30px',
                'width'  => '30px',
            ],
            // $this->addCountryColumn(),
            // $this->addProvinceColumn(),
            // $this->addDistrictColumn(),
            $this->addAddressColumn(),
            $this->addEmailColumn(),
            $this->addPhoneColumn(),
            $this->addIsActiveColumn(),
        ];
        $this->crud->addColumns(array_filter($columns));

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
        CRUD::setValidation(MstStoreRequest::class);

     
        $fields = [
            $this->addReadOnlyCodeField(),
            $this->addNameEnField(),
            $this->addNameLcField(),
            $this->addCountryField(),
            $this->addProvinceField(),
            $this->addDistrictField(),
            $this->addAddressField(),
            $this->addEmailField(),
            $this->addPhoneField(),
            [
				'name' => 'logo',
				'type' => 'image',
				'label' => 'Logo',
				'disk'   => 'uploads',
			],
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
