<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\ItemDetailRequest;
use App\Models\ItemDetail;
use App\Models\MstItem;
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
    public function getItemDetails($itemname)
    {
        
        $itemId=MstItem::select('id')->where('name_en', 'ILIKE', "%$itemname%")->first();
        if(isset($itemId)){
            // remaining qty in the organization
            $itemDetails=ItemDetail::with('storeEntity')->select('item_qty','store_id')->whereItemId($itemId->id)->get();
           

            return view('PartialViews.itemdetails',compact('itemDetails'));
        }
        else{
            dd("no items");
        }
    }

    public function getItemDetailsView()
    {
        return view('reporting.itemDetail');
    }
}
