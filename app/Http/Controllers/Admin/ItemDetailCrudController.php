<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\ItemDetailRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ItemDetailCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ItemDetailCrudController extends BaseCrudController
{
   

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\ItemDetail::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/item-detail');
        CRUD::setEntityNameStrings('item detail', 'item details');
    }

   public function getItemDetails(){
    return view('reporting.itemDetail');
   }
    
}
