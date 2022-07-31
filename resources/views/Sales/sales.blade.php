<style>
    #sales-table {
        counter-reset: serial-number;
        /* Set the serial number counter to 0 */
    }

    #sales-table td:first-child:before {
        counter-increment: serial-number;
        /* Increment the serial number counter */
        content: counter(serial-number);
        /* Display the counter */
    }

</style>

<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"> -->
<!-- <script src="{{ asset('customJS/stock.js') }}"></script> -->
@extends(backpack_view('blank'))

{{-- @section('header')
    @include('customViews.partialViews.header_content');
@endsection --}}
@php
@endphp
{{-- Header Content --}}
@section('content')
{{-- <form id="stockEntryForm" action="{{ url($crud->route) }}" method="POST"> --}}
<form id="purchaseOrderForm" action="{{ url($crud->route) }}" method="POST">
    @csrf
    <div class="card main-container ">
        <div class="row m-3">

            <div class=" col-sm-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="bill_tyle" style="min-width: 100px;">Bill Type</label>
                    <select class="form-select form-control" id="bill_tyle" name="bill_tyle" style="min-width: 100px;">
                        <option value="1">Individual</option>
                        <option value="2">Corporate</option>
                    </select>
                </div>
            </div>

            <div class=" col-sm-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01" style="min-width: 100px;">Store</label>
                    <select class="form-select form-control" id="inputGroupSelect01" name="store_id" style="min-width: 100px;">
                        @foreach($stores as $store)
                        <option value={{$store->id}}>{{$store->name_en}}</option>
                        @endforeach
                    </select>
                </div>
            </div>



            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="invvoice_number" style="min-width: 100px;">Invoice Number</label>
                    <input type="text" id="invvoice_number" name='invvoice_number' value="" class="form-control" placeholder="Inv Num" style="min-width: 100px;">
                </div>
            </div>
            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="transaction_date" style="min-width: 100px;">Transaction Date</label>
                    <input type="date" id="transaction_date" name='transaction_date' value="" class="form-control" placeholder="Approved Date" style="min-width: 100px;">
                </div>
            </div>
            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="company_name" style="min-width: 100px;">Company Name</label>
                    <input type="text" id="company_name" name='company_name' value="" class="form-control" placeholder="Company Name" style="min-width: 100px;">
                </div>
            </div>
            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="pan_vat" style="min-width: 100px;">Pan/Vat Number</label>
                    <input type="text" id="pan_vat" name='pan_vat' value="" class="form-control" placeholder="Pan/Vat Number" style="min-width: 100px;">
                </div>
            </div>
            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="full_name" style="min-width: 100px;"> Full Name</label>
                    <input type="text" id="full_name" name='full_name' value="" class="form-control" placeholder=" Full Name" style="min-width: 100px;">
                </div>
            </div>
            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="address" style="min-width: 100px;">Address</label>
                    <input type="text" id="address" name='address' value="" class="form-control" placeholder="Address" style="min-width: 100px;">
                </div>
            </div>
            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="contact_number" style="min-width: 100px;">Contact Number</label>
                    <input type="text" id="contact_number" name='contact_number' value="" class="form-control" placeholder="Contact Number" style="min-width: 100px;">
                </div>
            </div>



            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="expectedDateAD" style="min-width: 100px;">Invoice Date</label>
                    <input type="date" id="expectedDateAD" name='expected_delivery' value="" class="form-control" placeholder="Entry Date" style="min-width: 100px;">
                </div>
            </div>
            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <span class="input-group-text">Item Wise Discount</span>

                    <input type="checkbox" checked="true" name="itemWiseDiscount" id="itemWiseDiscount" class="form-control">
                </div>
            </div>
            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <span class="input-group-text">Discount</span>
                    <input type="text" name="" id="bulkDiscount" class="form-control" disabled>
                </div>
            </div>

        </div>
    </div>

    {{-- Item Entry Table --}}
    <div class="table-responsive card">
        <table class="table" id="repeaterTable" style="min-width: 1000px;">
            <thead>

                <tr class="text-white" style="background-color: #192840">
                    <th scope="col">S.N.</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Add Qty</th>
                    <th scope="col">Free Qty</th>
                    <th scope="col">Total Qty</th>

                    <th scope="col">Unit Cost </th>
                    <th scope="col">Disc Mode</th>
                    <th scope="col">Discount</th>

                    <th scope="col">Amount</th>
                    <th scope="col" style="width: 6rem">Action</th>
                </tr>

            </thead>
            <tbody id="sales-table">
                {{-- first row --}}
                <tr>
                    <td></td>
                    <td>
                        <div class="input-group">
                            <input type="text" class="form-control p-1 inv_item" data-cntr='' name="" placeholder="Search item..." id='' size="1" style="width:10rem;">
                            <input type="hidden" name="" class="inv_item_hidden">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <select class="form-select form-control Unit" data-cntr='' id="" style="min-width: 73px;" disabled>
                                <option value="1">Kg</option>
                                <option value="2">Pound</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 AddQty" data-cntr='' id="" placeholder="Add Qty" name="" size="1" style="width:5rem;" >
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 FreeQty" data-cntr='' id="" placeholder="Free Qty" name="" size="1" style="width:5rem;" disabled>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 TotalQty" data-cntr='' id="" placeholder="Total Qty" name="" size="1" style="width:5rem;" readonly>
                        </div>
                    </td>
                  
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 UnitCost" data-cntr='' id="" placeholder="Unit Cost" name="" size="1" style="width:5rem;" disabled>
                        </div>
                    </td>

                    <td>
                        <div class="input-group">
                            <select class="form-select form-control DiscountMode" data-cntr='' id="" style="min-width: 73px;" disabled>
                                <option value="1">%</option>
                                <option value="2">NRS</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 Discount" data-cntr='' id="" placeholder="Discount" name="" size="1" style="width:5rem;" disabled>
                        </div>
                    </td>

                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 TotalAmount" data-cntr='' id="" placeholder="Total Amount" name="" size="1" style="width:5rem;" readonly>
                        </div>
                    </td>
                    <td>
                        <div class="input-group" style="width:5rem;">
                            <i class="las la-trash p-1 text-danger destroyRepeater d-none" aria-hidden="true"></i>
                        </div>
                    </td>
                </tr>
                {{-- Repeater row --}}
               
                <tr id="repeaterRowSales" class="d-none">
                    <td></td>
                    <td>
                        <div class="input-group">
                            <input type="text" class="form-control p-1 inv_item" data-cntr='' name="" placeholder="Search item..." id='' size="1" style="width:10rem;">
                            <input type="hidden" name="" class="inv_item_hidden">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <select class="form-select form-control Unit" data-cntr='' id="" style="min-width: 73px;" disabled>
                                <option value="1">Kg</option>
                                <option value="2">Pound</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 AddQty" data-cntr='' id="" placeholder="Add Qty" name="" size="1" style="width:5rem;" disabled>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 FreeQty" data-cntr='' id="" placeholder="Free Qty" name="" size="1" style="width:5rem;" disabled>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 TotalQty" data-cntr='' id="" placeholder="Total Qty" name="" size="1" style="width:5rem;" readonly>
                        </div>
                    </td>
                  
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 UnitCost" data-cntr='' id="" placeholder="Unit Cost" name="" size="1" style="width:5rem;" disabled>
                        </div>
                    </td>

                    <td>
                        <div class="input-group">
                            <select class="form-select form-control DiscountMode" data-cntr='' id="" style="min-width: 73px;" disabled>
                                <option value="1">%</option>
                                <option value="2">NRS</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 Discount" data-cntr='' id="" placeholder="Discount" name="" size="1" style="width:5rem;" disabled>
                        </div>
                    </td>

                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 TotalAmount" data-cntr='' id="" placeholder="Total Amount" name="" size="1" style="width:5rem;" readonly>
                        </div>
                    </td>
                    <td>
                        <div class="input-group" style="width:5rem;">
                            <i class="las la-trash p-1 text-danger destroyRepeater d-none" aria-hidden="true"></i>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
        <div>
            <button type="button" class="btn btn-primary btn-sm " id="addRepeaterToSales"><i class="las la-plus p-1 text-white  bg-primary" aria-hidden="true"></i>Add More Item</button>
        </div>
    </div>

    <div class="main-container card">
        <div class="row m-3">
            <div class="col-md-6 col-sm-12">
                <div class="input-group mb-3">
                    <span class="input-group-text">Remarks</span>
                    <textarea class="form-control comment" name="comments" placeholder="Remarks" rows="5"></textarea>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <table class="table table-sm table-bordered">
                    <tbody>
                        <tr>
                            <th class="bg-primary text-white">Gross Total</th>
                            <td>
                                <input id="" type="numner" name="gross_amt" class="form-control" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-primary text-white">Total Discount</th>
                            <td>
                                <input id="" type="number" name="discount_amt" class="form-control" readonly>
                            </td>
                        </tr>

                        <tr>
                            <th class="bg-primary text-white">Net Amount</th>
                            <td>
                                <input id="" type="number" name="net_amt" class="form-control bg-secondary" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-primary text-white">Receipt Amount</th>
                            <td>
                                <input id="" type="number" name="receipt_amt" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-primary text-white">Due Amount</th>
                            <td>
                                <input id="" type="number" name="due_amt" class="form-control bg-secondary" readonly>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="main-container mb-4">
        <div class="d-flex justify-content-end">
            <input id="status" type="hidden" name="status_id" value="">
            <button id="save" type="submit" class="btn btn-primary  mr-1">Save</button>
            <button id="approve" type="submit" class="btn btn-success  mr-1">Approve</button>
            <button id="cancel" class="btn btn-danger  mr-1">Cancel</button>
        </div>
    </div>
</form>
@endsection

@section('after_scripts')
@include('invScripts.common')
@endsection
