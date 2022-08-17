<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\MstDistrictRequest;
use App\Models\MstProvince;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MstDistrictCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MstDistrictCrudController extends BaseCrudController
{
   

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\MstDistrict::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/mst-district');
        CRUD::setEntityNameStrings('', 'Districts');
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
            $this->addProvinceColumn(),
         
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
        CRUD::setValidation(MstDistrictRequest::class);

      

        $fields = [
            $this->addReadOnlyCodeField(),
            $this->addNameEnField(),
            $this->addNameLcField(),
            [
                'name'  => 'province_id',
                'label' => 'Province',
                'type' => 'select2',
                'entity' => 'provinceEntity',
                'attribute' => 'name_en',
                'model' => MstProvince::class,
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
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
