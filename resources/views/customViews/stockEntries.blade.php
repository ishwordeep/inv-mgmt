<style>
    #stock-table {
        counter-reset: serial-number;
        /* Set the serial number counter to 0 */
    }

    #stock-table td:first-child:before {
        counter-increment: serial-number;
        /* Increment the serial number counter */
        content: counter(serial-number);
        /* Display the counter */
    }
    
    </style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@extends(backpack_view('blank'))


{{-- @section('header')
    @include('customViews.partialViews.header_content');
@endsection --}}

{{-- Header Content --}}
@section('content')
{{-- <form id="stockEntryForm" action="{{ url($crud->route) }}" method="POST"> --}}
<form id="stockEntryForm" action="{{ url($crud->route) }}" method="POST">
   @csrf
    <div class="card main-container ">
        <div class="row m-3">
            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <span class="input-group-text">PO Number</span>
                    <input type="text" class="form-control" id="purchase_order_number" name="purchase_order_id" placeholder="PO NO">

                    <button class="btn btn-success" type="button" id="fetch_by_po_num_btn">Fetch</button>

                </div>
            </div>
            <div class=" col-sm-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="supplier" style="min-width: 100px;">Supplier</label>
                    <select class="form-select form-control" id="supplier" name="supplier_id" style="min-width: 150px;">
                        <option val='' disabled>--Select--</option>
                        <option value="1">one</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
            <div class=" col-sm-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="requested_store" style="min-width: 100px;">Requested Store</label>
                    <select class="form-select form-control" id="requested_store" name="requested_store_id" style="min-width: 150px;" disabled>
                        <option val='' disabled>--Select--</option>
                        <option value="1">one</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>


            <div class=" col-sm-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Store</label>
                    <select class="form-select form-control" id="inputGroupSelect01" style="min-width: 200px;">
                        <option selected>Choose...</option>
                        <option value="1">one</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>

            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <span class="input-group-text">Invoice Number</span>
                    <input type="text" class="form-control" id="invoice_number" name="invoice_number" placeholder="Invoice Number">
                </div>
            </div>
            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <span class="input-group-text">Invoice Date</span>
                    <input type="date" class="form-control" id="invoice_date" name="invoice_date" placeholder="Invoice Date">
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
                @include('customViews.partialViews.tableHeaderForInv')
            </thead>
            <tbody id="stock-table">
                <tr>
                    <td></td>
                    <td>
                        <div class="input-group">
                            <input type="text" class="form-control p-1 inv_item" data-cntr='' name="" placeholder="Search item..." id='' size="1" style="width:10rem;">
                            <input type="hidden" name="" class="">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 AddQty" data-cntr='' id="" placeholder="Add Qty" name="" size="1" style="width:5rem;">
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
                            <input type="date" class="form-control p-1 ExpiryDate" data-cntr='' id="" placeholder="Expiry Date" name="" size="1" style="width:7rem;" disabled>
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
                    @if($invType==='addRepeaterToStockEntry')
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 TaxVat" data-cntr='' id="" placeholder="Tax/vat" name="" size="1" style="width:5rem;" disabled>
                        </div>
                    </td>
                
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 UnitSale" data-cntr='' id="" placeholder="Unit Sales" name="" size="1" style="width:5rem;" disabled>
                        </div>
                    </td>
                    @endif
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
                {{-- repeaterTable --}}
                <tr id="repeaterRowStock" class="d-none">
                    <td></td>
                    <td>
                        <div class="input-group">
                            <input type="text" class="form-control p-1 inv_item" data-cntr='' name="" placeholder="Search item..." id='' size="1" style="width:10rem;">
                            <input type="hidden" name="" class="">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 AddQty" data-cntr='' id="" placeholder="Add Qty" name="" size="1" style="width:5rem;">
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
                            <input type="date" class="form-control p-1 ExpiryDate" data-cntr='' id="" placeholder="Expiry Date" name="" size="1" style="width:7rem;" disabled>
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
                    @if($invType==='addRepeaterToStockEntry')
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 TaxVat" data-cntr='' id="" placeholder="Tax/vat" name="" size="1" style="width:5rem;" disabled>
                        </div>
                    </td>
                
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 UnitSale" data-cntr='' id="" placeholder="Unit Sales" name="" size="1" style="width:5rem;" disabled>
                        </div>
                    </td>
                    @endif
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
            <button type="button" class="btn btn-primary btn-sm " id="addRepeaterToStockEntry"><i class="las la-plus p-1 text-white  bg-primary" aria-hidden="true"></i>Add More Item</button>
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
                                <input id="" type="numner" name="" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-primary text-white">Total Discount</th>
                            <td>
                                <input id="" type="number" name="" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-primary text-white">Taxable Amount</th>
                            <td>
                                <input id="" type="number" name="" class="form-control">
                            </td>

                        </tr>
                        <tr>
                            <th class="bg-primary text-white">Tax Total</th>
                            <td>
                                <input id="" type="number" name="" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-primary text-white">Other Charges</th>
                            <td>
                                <input id="" type="number" name="" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-primary text-white">Net Amount</th>
                            <td>
                                <input id="" type="number" name="" class="form-control bg-secondary">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="main-container mb-4">
        <div class="d-flex justify-content-end">
            <div class="d-flex justify-content-end">
                <input id="status" type="hidden" name="status_id" value="">
                <button id="save" type="submit" class="btn btn-primary  mr-1">Save</button>
                <button id="approve" type="submit" class="btn btn-success  mr-1">Approve</button>
                <button id="cancel" class="btn btn-danger  mr-1">Cancel</button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('after_scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@endsection
