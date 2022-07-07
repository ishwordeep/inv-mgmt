<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;

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
        CRUD::setEntityNameStrings('', 'Users');
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

            $this->addStoreField(),
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
    public function store()
    {
        $this->crud->hasAccessOrFail('create');
        $user = backpack_user();
       

        $request = $this->crud->validateRequest();
        $request->request->set('created_by', $user->id);
        $request->request->set('updated_by', $user->id);



        //save full_name, email and password for sending email
        // $email_details = [
        //     'full_name' => $request->name,
        //     'email' => $request->email,
        //     'password' => $request->password,
        // ];


        //encrypt password
        $request = $this->handlePasswordInput($request);

      
        DB::beginTransaction();
        try {
            $item = $this->crud->create($request->except(['save_action', '_token', '_method', 'http_referrer']));
            // if ($item && env('SEND_MAIL_NOTIFICATION') == TRUE) {
            //     $this->send_mail($email_details);
            // }

            // $this->client_user->notify(new TicketCreatedNotification($item));

            \Alert::success(trans('backpack::crud.insert_success'))->flash();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
        }

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }


    public function update()
    {
        $this->crud->hasAccessOrFail('update');
        $user = backpack_user();

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        //save full_name, email and password for sending email
        // $email_details = [
        //     'full_name' => $request->name,
        //     'email' => $request->email,
        //     'password' => $request->password,
        // ];
        //encrypt password
        $request = $this->handlePasswordInput($request);

        DB::beginTransaction();
        try {
            $item = $this->crud->update(
                $request->get($this->crud->model->getKeyName()),
                $request->except(['save_action', '_token', '_method', 'http_referrer'])
            );

            // if($item && env('SEND_MAIL_NOTIFICATION') == TRUE){
            //     $this->send_mail($email_details);
            // }
            \Alert::success(trans('backpack::crud.update_success'))->flash();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
        }
        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }

    /**
     * Handle password input fields.
     */
    protected function handlePasswordInput($request)
    {
        // Encrypt password if specified.
        if ($request->input('password')) {
            $request->request->set('password', \Hash::make($request->input('password')));
        } else {
            $request->request->remove('password');
        }

        return $request;
    }
}
