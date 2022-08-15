<?php

namespace App\Http\Controllers\Dashboard;

use App\Base\BaseCrudController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends BaseCrudController
{
    public function totalActiveStock(){
        $data['title'] = "Active Stocks";
        return view('dashboard.items',['data'=>$data]);
    }
    public function totalInactiveStock(){
        $data['title'] = "Inactive Stocks";
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
        return view('dashboard.items',['data'=>$data]);
    }
}
