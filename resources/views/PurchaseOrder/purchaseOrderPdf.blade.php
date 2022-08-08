@extends('pdfFormat.pdfMain')

@section('styles')
    <style>
        @page{
            size: A4 landscape;
            /* size: A4 portrait;   */
            margin-top: 40px;
            margin-left: 50px;
            margin-right: 20px;
            margin-bottom: 40px;
            text-align: justify;
        } 
        .table-responsive{
            margin-top:5px;
        }
        .col-md-6 hr{
            border: 0.2px solid lightgrey;
            margin-right: 80px;
        }
    </style>
@endsection

@section('content')
    <div class="px-3 mt-4">
        <!-- store name section -->
        <div class="mt-3">
            <div class="row display-inline">
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        <span class="me-1 bold">Store Name: </span> <span>{{$entry->storeEntity->name_en}}</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        <span class="me-1 bold">PO Number: </span> <span>{{$entry->po_number??'n/a'}}</span>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        <span class="me-1 bold">PO Date: </span> <span>{{$entry->po_date?$entry->po_date:'n/a'}}</span>
                    </div>
                </div>
            </div>
            <div class="row display-inline">
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        <span class="me-1 bold">Expected Delivery: </span> <span>{{$entry->expected_delivery?$entry->expected_delivery:'n/a'}}</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        <span class="me-1 bold">Approved By:</span> <span>{{$entry->approvedByEntity->name ?? 'n/a'}}</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        <span class="me-1 bold">{{isset($entry->requested_store_id)?"Requested Store":"Supplier"}} :</span> <span>{{isset($entry->requested_store_id)?$entry->requestedStoreEntity->name_en:$entry->supplierEntity->name_en}}</span>
                    </div>
                </div>
                
            </div>
        </div>

        <!-- table for item -->
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
                        <td scope="col">{{$item->purchase_qty}}</td>
                        <td scope="col">{{$item->free_qty??'n/a'}}</td>
                        <td scope="col">{{$item->total_qty}}</td>
                        <td scope="col">{{$item->purchase_price}}</td>
                        <td scope="col">{{$item->discountModeEntity->name_en??'n/a'}}</td>
                        <td scope="col">{{$item->discount??'n/a'}}</td>
                        <td scope="col">{{$item->item_amount}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- bottom table section -->
        <div class="row">
            <div class="col-md-6">
                <spa class="bold">Remarks:</spa>
                <br>
                {{$entry->comments}}
            </div>
            <div class="col-md-6">
                    <span class="bold">Gross Total:</span>
                    <span>{{$entry->gross_amt}}</span>
                <hr>
                    <span class="bold">Total Discount:</span>
                    <span>{{$entry->discount_amt}}</span>
                <hr>
                    <span class="bold">Net Amount:</span>
                    <span>{{$entry->net_amt}}</span>
                <hr>
            </div>
        </div>
    </div>
@endsection
