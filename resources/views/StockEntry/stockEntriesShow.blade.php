@extends(backpack_view('blank'))

@php

    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      $crud->entity_name_plural => url($crud->route),
      trans('backpack::crud.add') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;

@endphp

@push('after_styles')
    <style>
        .upper-container .col-2 {
            flex: 0 0 auto;
            width: 9.666667%;
        }
        .row *{
            border: transparent !important;
        }
        .input-group-text {
            background-color: transparent !important;
            font-weight: bold;

        }
    </style>
@endpush

@include('header')

@php 
 $status=[
    1=>'text-warning',
    2=>'text-success',
    3=>'text-danger',
    ];  
@endphp

@section('content')
    <div class="card shadow px-3 mt-4">
        <div class="buttons mt-2 text-right">
            <a href="{{ route('seprintpdf', $entry->id) }}" target="_blank" class="btn btn-sm btn-primary"><i class="la la-file-pdf">&nbsp;PDF</i></a>
            <a href="{{ route('sesendemail', $entry->id) }}" class="btn btn-sm btn-primary"><i class="la la-inbox">&nbsp;Email</i></a>
        </div>

        <!-- store name section -->
        <div class="mt-3">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        <span class="me-1" style="font-weight: bold;"> Status: </span> <span class="{{ isset($entry->status_id)? $status[$entry->status_id] : ''}}" style="font-weight: bold;"> {{ucfirst($entry->statusEntity->name_en)}}</span>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        <span class="me-1" style="font-weight: bold;">Store Name: </span> <span>{{$entry->storeEntity->name_en}}</span>
                    </div>
                </div>
               
               
             
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        <span class="me-1" style="font-weight: bold;">PO Number: </span> <span>{{$entry->po_number??'n/a'}}</span>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        <span class="me-1" style="font-weight: bold;">Adjustment Number: </span> <span>{{$entry->stock_adjustment_number?$entry->stock_adjustment_number:'n/a'}}</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        <span class="me-1" style="font-weight: bold;">Invoice Number: </span> <span>{{$entry->invoice_number?$entry->invoice_number:'n/a'}}</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        <span class="me-1" style="font-weight: bold;"> Delivery Date: </span> <span>{{$entry->entry_date?$entry->entry_date:'n/a'}}</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        <span class="me-1" style="font-weight: bold;"> Bill Date: </span> <span>{{$entry->invoice_date?$entry->invoice_date:'n/a'}}</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        <span class="me-1" style="font-weight: bold;">Approved By:</span> <span>{{$entry->approvedByEntity->name ?? 'n/a'}}</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        {{-- <span class="me-1" style="font-weight: bold;">{{isset($entry->requested_store_id)?"Requested Store":"Supplier"}} :</span> <span>{{isset($entry->requested_store_id)?$entry->requestedStoreEntity->name_en:$entry->supplierEntity->name_en}}</span> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- table for item -->
        <div>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                    <tr style="background-color: rgb(241, 241, 241)">
                        <th scope="col">Item</th>
                        <th scope="col">Purchase Qty</th>
                        <th scope="col">Free item</th>
                        <th scope="col">Total Qty</th>
                        <th scope="col">Purchase Price</th>
                        <th scope="col">Disc Mode</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            
                            <td scope="col">{{$item->itemEntity->name_en}}</td>
                            <td scope="col">{{$item->add_qty}}</td>
                            <td scope="col">{{$item->free_qty??'n/a'}}</td>
                            <td scope="col">{{$item->total_qty}}</td>
                            <td scope="col">{{$item->unit_cost_price}}</td>
                            <td scope="col">{{$item->discountModeEntity->name_en??'n/a'}}</td>
                            <td scope="col">{{$item->discount??'n/a'}}</td>
                            <td scope="col">{{$item->amount}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- bottom table section -->
        <div>
            <div class="row">
                <div class="col-md-6 mt-2">
                    <div class="">
                        <span style="font-weight: bold;">Remarks</span>
                        {{$entry->remarks}}
                    </div>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm table-borderless text-dark">
                        <tr>
                            <td class="font-weight-bold">Gross total</td>
                            <td>{{$entry->gross_total}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Total Disc</td>
                            <td>{{$entry->total_discount}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tax Amount</td>
                            <td>{{$entry->total_tax }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Net Amount</td>
                            <td>{{$entry->net_amount}}</td>
                        </tr>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-2">
            <a href="{{ backpack_url('/stock-entry/'. $entry->id.'/edit') }}" class="btn btn-sm btn-success"><i class="la la-edit">&nbsp;Edit</i></a>
        </div>
    </div>
@endsection
