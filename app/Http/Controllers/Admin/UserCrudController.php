<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends BaseCrudController
{


    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
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
            $this->addNameColumn(),
            [
                'name' => 'user_level',
                'label' => 'User Level',
                'type' => 'radio',
                'options' =>
                [
                    1 => "System User",
                    2 => "Organization User",
                    3 => "Store User",
                ],
            ],
            $this->addEmailColumn(),
            $this->addPhoneColumn(),
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
        CRUD::setValidation(UserRequest::class);

        $fields = [
            $this->addReadOnlyCodeField(),
            $this->addNameField(),
            $this->addEmailField(),
            $this->addPasswordField(),
            $this->addPhoneField(),
            [
                'name'        => 'user_level', // the name of the db column
                'label'       => 'User Level', // the input label
                'type'        => 'radio',
                'default'     =>3,
                'options'     => [
                    // the key will be stored in the db, the value will be shown as label; 
                    2 => "Organization User",
                    3 => "Store User"
                ],
                // optional
                'inline'      => true, // show the radios all on the same line?
            ],
            $this->addIsActiveField(),
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
