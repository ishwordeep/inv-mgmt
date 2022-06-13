<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\MstItemRequest;
use App\Models\MstBrand;
use App\Models\MstCategory;
use App\Models\MstDiscountMode;
use App\Models\MstSubcategory;
use App\Models\MstSupplier;
use App\Models\MstUnit;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;


/**
 * Class MstItemCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MstItemCrudController extends BaseCrudController
{


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
        
        // CRUD::column('category_id');
        // CRUD::column('subcategory_id');
        // CRUD::column('supplier_id');
        // CRUD::column('brand_id');
        // CRUD::column('unit_id');
        // CRUD::column('stock_alert_minimum');
        // CRUD::column('tax_vat');
        // CRUD::column('discount_mode_id');
        // CRUD::column('is_taxable');
        // CRUD::column('is_nonclaimable');
        // CRUD::column('is_active');
       
        $columns = [
            $this->addRowNumberColumn(),
            $this->addCodeColumn(),
            $this->addNameEnColumn(),
            $this->addNameLcColumn(),
            $this->addCategoryColumn(),
            $this->addSubCategoryColumn(),
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
        CRUD::setValidation(MstItemRequest::class);




      
        $fields = [
            $this->addReadOnlyCodeField(),
            $this->addNameEnField(),
            $this->addNameLcField(),
            $this->addDescriptionField(),
            $this->addCategoryField(),
            [
                'label'     => 'Sub Category',
                'type'      => 'select2_from_ajax',
                'method' => 'GET',
                'name'      => 'subcategory_id', // the column that contains the ID of that connected entity;
                'model'     => MstSubcategory::class,
                'entity'    => 'subCategoryEntity', // the method that defines the relationship in your Model
                'attribute' => 'name_en', // foreign key attribute that is shown to user
                'data_source' => url("admin/api/subCategoryEntity/category_id"), //api/modelsmallname/tableid from which state is taken
                'minimum_input_length' => 0,
                'dependencies' => ["category_id"],
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
                'attributes' => [
                    'placeholder' => 'Select Category first',
                ]
            ],
            [
                'name'  => 'supplier_id',
                'label' => 'Supplier',
                'type' => 'select2',
                'entity' => 'supplierEntity',
                'attribute' => 'name_en',
                'model' => MstSupplier::class,
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name'  => 'brand_id',
                'label' => 'Brand',
                'type' => 'select2',
                'entity' => 'brandEntity',
                'attribute' => 'name_en',
                'model' => MstBrand::class,
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name'  => 'unit_id',
                'label' => 'Unit',
                'type' => 'select2',
                'entity' => 'unitEntity',
                'attribute' => 'name_en',
                'model' => MstUnit::class,
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name'  => 'discount_mode_id',
                'label' => 'Discount Mode',
                'type' => 'select2',
                'entity' => 'discountModeEntity',
                'attribute' => 'name_en',
                'model' => MstDiscountMode::class,
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name'  => 'stock_alert_minimum',
                'label' => 'Stock Minimum Alert',
                'type' => 'number',
              
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name'  => 'tax_vat',
                'label' => 'Tax/Vat',
                'type' => 'number',
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            $this->addDescriptionField(),
            [
                'name' => 'is_taxable',
                'label' => 'Is Taxable',
                'type' => 'radio',
                'default' => 1,
                'inline' => true,
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
                'options' =>
                [
                    1 => 'Yes',
                    0 => 'No',
                ],
            ],
            [
                'name' => 'is_nonclaimable',
                'label' => 'Is Non-claimable',
                'type' => 'radio',
                'default' => 1,
                'inline' => true,
                'wrapper' => [
                    'class' => 'form-group col-md-4',
                ],
                'options' =>
                [
                    1 => 'Yes',
                    0 => 'No',
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

    public function getSubCategoryAPI(Request $request, $value)
    {
        $search_term = $request->input('q');
        $form = collect($request->input('form'))->pluck('value', 'name');
        $page = $request->input('page');
        $options = MstSubcategory::query(); //model ma query gareko
        // if no category has been selected, show no options
        if (!data_get($form, $value)) { //countryvanne table ma search gareko using id
            return [];
        }
        // if a category has been selected, only show articles in that category
        if (data_get($form, $value)) {
            if ($form[$value] != 8) {
                $category = MstCategory::find($form[$value]);
                $options = $options->where('category_id', $category->id);
            }
        }
        // if a search term has been given, filter results to match the search term
        if ($search_term) {
            //  dd($search_term);
            $options = $options->where('name_en', 'ILIKE', "%$search_term%"); //k tannalako state ho tesaile
        }

        // dd($options->get());

        return $options->paginate(10);
    }
}
