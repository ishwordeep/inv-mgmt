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
                        <span class="me-1" style="font-weight: bold;">Buyer Name: </span> <span>{{$entry->full_name}}</span>
                    </div>
                </div>
                {{-- Bill Number --}}
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        <span class="me-1" style="font-weight: bold;">Invoice Number: </span>
                        <span>{{$entry->invoice_number?($entry->invoice_number):'n/a'}}</span>
                    </div>
                </div>
                {{-- Return Number --}}
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        <span class="me-1" style="font-weight: bold;">Bill Date: </span>
                        <span>{{$entry->invoice_date?$entry->invoice_date:'n/a'}}</span>
                    </div>
                </div>
            </div>
            <div class="row display-inline">
                @if($entry->bill_type ==2)
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        <span class="me-1" style="font-weight: bold;">Pan/Vat: </span> <span>{{$entry->pan_vat}}</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        <span class="me-1" style="font-weight: bold;">Company Name: </span>
                        <span>{{$entry->company_name}}</span>
                    </div>
                </div>
                @endif
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        <span class="me-1" style="font-weight: bold;">Contact Number: </span>
                        <span>{{$entry->contact_number}}</span>
                    </div>
                </div>
            </div>
            <div class="row display-inline">
                <div class="col-lg-3 col-md-4">
                    <div class="mb-3">
                        <span class="me-1" style="font-weight: bold;">Transaction Date: </span>
                        <span>{{$entry->transaction_date}}</span>
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
                            <th scope="col">Item Name</th>
                            <th scope="col">Total Qty</th>
                            <!-- <th scope="col">Unit </th> -->
                            <th scope="col">Unit Price</th>
                            <th scope="col">Tax/Vat</th>
                            <th scope="col">Amount</th>

                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td scope="col">{{$item->item_id}}</td>
                            <td scope="col">{{$item->total_qty}}</td>
                            <!-- <td scope="col">{{$item->unit_id}}</td> -->
                            <td scope="col">{{$item->unit_price}}</td>
                            <td scope="col">{{$item->tax_vat??'0'}}</td>
                            <td scope="col">{{$item->item_total}}</td>
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
                        <span style="font-weight: bold;">Remarks:</span>
                        {{$entry->remarks?? 'n/a'}}
                    </div>
                    <div class="">
                        <span style="font-weight: bold;">Aprroved By:</span>
                        {{$entry->createdByEntity->name}}
                    </div>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm table-borderless text-dark">
                        <tr>
                            <td class="font-weight-bold">Gross total:</td>
                            <td>{{$entry->gross_total}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Total Disc:</td>
                            <td>{{$entry->total_discount}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Net Amount:</td>
                            <td>{{$entry->net_amount}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Receipt Amount:</td>
                            <td>{{$entry->receipt_amt}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Due Amount:</td>
                            <td>{{$entry->due_amt}}</td>
                        </tr>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection