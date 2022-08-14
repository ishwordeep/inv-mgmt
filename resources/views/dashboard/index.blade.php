<link rel="stylesheet" type="text/css" href="{{ asset('/css/dashboard.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@extends(backpack_view('blank'))

@section('content')
<style>
    .dashboard-heading {
        width: 100%;
        color: #192840 !important;
        margin: 20px 20px;
        padding-left: 10px;
    }

</style>

{{-- Organization Overview --}}
<div class="container-fluid m-0 p-0 pb-5 px-3 mb-3 mt-3" style="background: white;">
    <div class="row">
        <div class="dashboard-heading">
            <h3>
                Organization Overview
            </h3>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <a href="">
                <div class="card-counter success">
                    <i class="fa fa-building"></i>
                    <span class="count-numbers" id="">12</span>
                    <span class="count-name">Total Stores</span>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <a href="">
                <div class="card-counter info">
                    <i class="fa fa-sitemap"></i>
                    <span class="count-numbers" id="">12</span>
                    <span class="count-name">Total Items</span>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-md-6 col-xs-12">
            <a href="">
                <div class="card-counter purple">
                    <i class="fa fa-user"></i>
                    <span class="count-numbers" id="">22</span>
                    <span class="count-name">Total Users</span>
                </div>
            </a>
        </div>
    </div>
</div>

{{-- Stock Details --}}
<div class="container-fluid m-0 p-0 pb-5 px-3 mt-3" style="background: white;">
    <div class="row">
        <div class="dashboard-heading">
            <h3>
                Item Status
            </h3>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <a href="#">
                <div class="card-counter primary">
                    <i class="fa fa-barcode"></i>
                    <span class="count-numbers" id="">1212</span>
                    <span class="count-name">Total Stocks</span>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <a href="#">
                <div class="card-counter success">
                    <i class="fa fa-check"></i>
                    <span class="count-numbers" id="">34</span>
                    <span class="count-name">Total Active Stocks</span>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <a href="#">
                <div class="card-counter danger">
                    <i class="fa fa-window-close"></i>
                    <span class="count-numbers" id="">34</span>
                    <span class="count-name">Total Inactive Stocks</span>
                </div>
            </a>
        </div>
    </div>
</div>



{{-- Stock Alert Details --}}
<div class="container-fluid m-0 p-0 pb-5 px-3 mt-3" style="background: white;">
    <div class="row">
        <div class="dashboard-heading">
            <h3>
                 Stock Alert Zone
            </h3>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <a href="#">
                <div class="card-counter success">
                    <i class="fa fa-barcode"></i>
                    <span class="count-numbers" id="">1212</span>
                    <span class="count-name">Green</span>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <a href="#">
                <div class="card-counter warning">
                    <i class="fa fa-check"></i>
                    <span class="count-numbers" id="">34</span>
                    <span class="count-name">Yellow</span>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
            <a href="#">
                <div class="card-counter danger">
                    <i class="fa fa-window-close"></i>
                    <span class="count-numbers" id="">34</span>
                    <span class="count-name">Red</span>
                </div>
            </a>
        </div>
    </div>
</div>

@endsection
