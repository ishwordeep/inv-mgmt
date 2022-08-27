<?php

namespace App\Http\Controllers\Dashboard;

use App\Base\BaseCrudController;
use App\Http\Controllers\Controller;
use App\Models\MstItem;
use App\Models\MstStore;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends BaseCrudController
{
    public function index(){
        $data['store_qty']=MstStore::all()->count();
        $data['user_qty']=User::all()->count();
        $data['total_qty']=MstItem::all()->count();
        $data['active_qty']=MstItem::whereIsActive(true)->count();
        $data['inactive_qty']=MstItem::whereIsActive(false)->count();
        return view('dashboard.index',['data'=>$data]);
    }
    public function totalActiveStock(){
        $data['title'] = "Active Stocks";
        $data['items']=MstItem::whereIsActive(true)->get();
        return view('dashboard.items',['data'=>$data]);
    }
    public function totalInactiveStock(){
        $data['title'] = "Inactive Stocks";
        $data['items']=MstItem::whereIsActive(false)->get();
        return view('dashboard.items',['data'=>$data]);
    }
    public function greenZonedStock(){
        $data['title'] = "Green Zoned Stocks";
        $data['specifiedColor']='bg-success';
        return view('dashboard.items',['data'=>$data]);
    }
    public function yellowZonedStock(){
        $data['title'] = "Yellow Zoned Stocks";
        $data['specifiedColor']='bg-warning';
        
        return view('dashboard.items',['data'=>$data]);
    }
    public function redZonedStock(){
        $data['po']=true;
        $data['specifiedColor']='bg-danger';
        $data['title'] = "Red Zoned Stocks";

        $data['items']=DB::table('item_details')
            ->join('mst_items', 'mst_items.id', 'item_details.item_id')
            ->select('mst_items.*','item_details.*')
            ->get();
            dd($data['items']);
        
        // $rrr = DB::table('item_details')
        // ->join('mst_items', 'mst_items.id', '=', 'item_details.item_id')
        // ->select('mst_items.*')
        // ->get();
        // dd($rrr);
        $data['items']=MstItem::whereIsActive(false)->get();
        return view('dashboard.items',['data'=>$data]);
    }
}
