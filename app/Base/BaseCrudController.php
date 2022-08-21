<?php

namespace App\Base;

use App\Base\Operations\ListOperation;
use App\Base\Operations\ShowOperation;
use App\Base\Operations\CreateOperation;
use App\Base\Operations\DeleteOperation;
use App\Base\Operations\UpdateOperation;
use App\Models\MstCategory;
use App\Models\MstCountry;
use App\Models\MstDistrict;
use App\Models\MstProvince;
use App\Models\MstStore;
use App\Models\MstSubcategory;
use Backpack\CRUD\app\Http\Controllers\CrudController;


class BaseCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;

    public function __construct()
    {

        if ($this->crud) {
            return;
        }

        $this->middleware(function ($request, $next) {
            $this->crud = app()->make('crud');
            // ensure crud has the latest request
            $this->crud->setRequest($request);
            $this->request = $request;
            $this->setupDefaults();
            $this->setup();
            $this->setupConfigurationForCurrentOperation();
            return $next($request);
        });
        
        // parent::__construct();
    }

    protected function addPlainHtml()
    {
        return   [
            'type' => 'custom_html',
            'name' => 'plain_html_1',
            'value' => '<br>',
        ];
    }
    protected function addColMd8Field(){
        return[
            'type' => 'custom_html',
            'name' => 'col-md-8',
            'value' => '<div class="col-md-8"></div>',
        ];
    }
    protected function addReadOnlyCodeField()
    {
        return [
            'name' => 'code',
            'label' => 'Code',
            'type' => 'hidden',
            'attributes' => [
                'readonly' => true,
            ],
        ];
    }
    protected function addCodeTextField()
    {
        return [
            'name' => 'code_text',
            'label' => 'Code',
            'type' => 'text',
            'wrapper' => [
                'class' => 'form-group col-md-4'
            ],
        ];
    }
    protected function addNameEnField()
    {
        return [
            'name' => 'name_en',
            'label' => 'Name En',
            'type' => 'text',
            
            'wrapper' => [
                'class' => 'form-group col-md-6',
            ],
        ];
    }
    protected function addNameField()
    {
        return [
            'name' => 'name',
            'label' => 'Name',
            'type' => 'text',
            
            'wrapper' => [
                'class' => 'form-group col-md-6',
            ],
        ];
    }
    protected function addNameLcField()
    {
        return [
            'name' => 'name_lc',
            'label' => 'Name Lc',
            'type' => 'text',
           
            'wrapper' => [
                'class' => 'form-group col-md-6',
            ],
        ];
    }
    protected function addEmailField()
    {
        return [
            'name' => 'email',
            'type' => 'email',
            'label' => 'Email',
            'wrapper' => [
                'class' => 'form-group col-md-4',
            ],
        ];
    }
    protected function addPasswordField()
    {
        return [
            'name' => 'password',
            'type' => 'password',
            'label' => 'Password',
            'wrapper' => [
                'class' => 'form-group col-md-4',
            ],
        ];
    }
    protected function addPhoneField()
    {
        return [
            'name' => 'phone',
            'type' => 'number',
            'label' => 'Phone',
            'wrapper' => [
                'class' => 'form-group col-md-4',
            ],
        ];
    }
    protected function addSequenceCodeField()
    {
        return [
            'name' => 'sequence_code',
            'type' => 'text',
            'label' => 'Sequence Code',
            'wrapper' => [
                'class' => 'form-group col-md-4',
            ],
        ];
    }
    protected function addCategoryField()
    {
        return [
            'name'  => 'category_id',
            'label' => 'Category',
            'type' => 'select2',
            'entity' => 'categoryEntity',
            'attribute' => 'name_en',
            'model' => MstCategory::class,
            'wrapper' => [
                'class' => 'form-group col-md-4',
            ],
        ];
    }

    public function addIsActiveField()
    {
        return [
            'name' => 'is_active',
            'label' => 'Is Active',
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
        ];
    }
    protected function addCountryField()
    {
        return [
            'name'  => 'country_id',
            'label' => 'Country',
            'type' => 'select2',
            'entity' => 'countryEntity',
            'attribute' => 'name_en',
            'model' => MstCountry::class,
            'wrapper' => [
                'class' => 'form-group col-md-4',
            ],
            'default'=>1
        ];
    }

    protected function addProvinceField()
    {
        return [
            'name' => 'province_id',
            'type' => "select2_from_ajax",
            'method' => 'GET',
            'label' => 'Province',
            'model' => MstProvince::class,
            'entity' => "provinceEntity", //relatioship which is inside the model
            'attribute' => "name_en", //the field which is needed
            'data_source' => url("api/province/country_id"), //api/modelsmallname/tableid from which state is taken
            'minimum_input_length' => 0,
            'dependencies' => ["country_id"], //id from which state is pulled
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4 current_address',
            ],
            'attributes' => [
                'placeholder' => 'Select country first',
            ]
        ];
    }

    protected function addDistrictField()
    {

        return  [
            'name' => 'district_id',
            'type' => "select2_from_ajax",
            'method' => 'GET',
            'label' => 'District',
            'model' => MstDistrict::class,
            'entity' => "districtEntity", //relatioship which is inside the model
            'attribute' => "name_en", //the field which is needed
            'data_source' => url("api/district/province_id"), //api/modelsmallname/tableid from which state is taken
            'minimum_input_length' => 0,
            'dependencies' => ["province_id"], //id from which state is pulled
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4 current_address',
            ],
            'attributes' => [
                'placeholder' => 'Select Province first',
            ]
        ];
    }

    protected function addAddressField()
    {
        return [
            'name' => 'address',
            'label' => 'Address',
            'type' => 'text',
            'wrapper' => [
                'class' => 'form-group col-md-6',
            ],
        ];
    }
    protected function addDescriptionField()
    {
        return [
            'name' => 'description',
            'label' => 'Description',
            'type' => 'textarea',
            'wrapper' => [
                'class' => 'form-group col-md-12',
            ],
        ];
    }

    public function addStoreField()
    {
        return [
            'name' => 'store_id',
            'type' => 'select',
            'entity' => 'storeEntity',
            'attribute' => 'name_en',
            'model' => MstStore::class,
            'label' => 'Store',
            'wrapper' => [
                'class' => 'form-group col-md-4'
            ],
        ];
    }
    // ############### COLUMNS ###############################
    protected function addRowNumberColumn()
    {
        return [
            'name' => 'row_number',
            'type' => 'row_number',
            'label' => 'S.N.',
        ];
    }
    protected function addCodeColumn()
    {
        return [
            'name' => 'code',
            'label' => 'Code',
            'type' => 'text',
        ];
    }
    protected function addCodeTextColumn()
    {
        return [
            'name' => 'code_text',
            'label' => 'Code',
            'type' => 'text',
        ];
    }
    protected function addNameColumn()
    {
        return [
            'name' => 'name',
            'label' => 'Name',
            'type' => 'text',
        ];
    }
    protected function addNameEnColumn()
    {
        return [
            'name' => 'name_en',
            'label' => 'Name En',
            'type' => 'text',
        ];
    }

    protected function addNameLcColumn()
    {
        return [
            'name' => 'name_lc',
            'label' => 'Name Lc',
            'type' => 'text',
        ];
    }
    protected function addCountryColumn()
    {
        return  [
            'name' => 'country_id',
            'type' => 'select',
            'entity' => 'countryEntity',
            'attribute' => 'name_en',
            'model' => MstCountry::class,
            'label' => 'Country',
        ];
    }
    protected function addProvinceColumn()
    {
        return [
            'name' => 'province_id',
            'type' => 'select',
            'entity' => 'provinceEntity',
            'attribute' => 'name_en',
            'model' => MstProvince::class,
            'label' => 'Province',
        ];
    }
    protected function addDistrictColumn()
    {
        return  [
            'name' => 'district_id',
            'type' => 'select',
            'entity' => 'districtEntity',
            'attribute' => 'name_en',
            'model' => MstDistrict::class,
            'label' => 'District',
        ];
    }
    public function addAddressColumn()
    {
        return [
            'name' => 'address',
            'label' => 'Address',
            'type' => 'text',
        ];
    }
    protected function addCategoryColumn()
    {
        return  [
            'name' => 'category_id',
            'type' => 'select',
            'entity' => 'categoryEntity',
            'attribute' => 'name_en',
            'model' => MstCategory::class,
            'label' => 'Category',
        ];
    }
    protected function addSubCategoryColumn()
    {
        return  [
            'name' => 'subcategory_id',
            'type' => 'select',
            'entity' => 'subCategoryEntity',
            'attribute' => 'name_en',
            'model' => MstSubcategory::class,
            'label' => 'Sub Category',
        ];
    }
    public function addEmailColumn()
    {
        return [
            'name' => 'email',
            'label' => 'Email',
            'type' => 'text',
        ];
    }
    public function addPhoneColumn()
    {
        return [
            'name' => 'phone',
            'label' => 'Phone',
            'type' => 'text',
        ];
    }
    public function addIsActiveColumn()
    {
        return [
            'name' => 'is_active',
            'label' => 'Is Active',
            'type' => 'radio',
            'options' =>
            [
                1 => 'Yes',
                0 => 'No',
            ],
        ];
    }
   
    public function addStoreColumn()
    {
        return [
            'name' => 'store_id',
            'type' => 'select',
            'entity' => 'storeEntity',
            'attribute' => 'name_en',
            'model' => MstStore::class,
            'label' => 'Store',
        ];
    }
    public function addSequenceColumn()
    {
        return [
            'name' => 'sequence_code',
            'type' => 'text',
            'label' => 'Sequence Code',
        ];
    }

}
