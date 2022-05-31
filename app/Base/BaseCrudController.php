<?php

namespace App\Base;

use App\Base\Operations\ListOperation;
use App\Base\Operations\ShowOperation;
use App\Base\Operations\CreateOperation;
use App\Base\Operations\DeleteOperation;
use App\Base\Operations\UpdateOperation;
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

}