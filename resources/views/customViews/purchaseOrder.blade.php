<style>
    #po-table {
        counter-reset: serial-number;
        /* Set the serial number counter to 0 */
    }

    #po-table td:first-child:before {
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

    <div class="card main-container ">
        <div class="row m-3">

            <div class=" col-sm-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="po_type" style="min-width: 100px; ">PO Type</label>
                    <select class="form-select form-control" id="po_type" style="min-width: 150px; ">
                        @foreach($po_types as $type)
                        <option value={{$type->id}}>{{$type->name_en}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class=" col-sm-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="supplier" style="min-width: 100px;">Supplier</label>
                    <select class="form-select form-control" id="supplier" style="min-width: 150px;" disabled>
                        <option val='' disabled>--Select--</option>
                        @foreach($suppliers as $supplier)
                        <option value={{$supplier->id}}>{{$supplier->name_en}}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class=" col-sm-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01" style="min-width: 100px;">Store</label>
                    <select class="form-select form-control" id="inputGroupSelect01" style="min-width: 150px;">
                        @foreach($stores as $store)
                        <option value={{$store->id}}>{{$store->name_en}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class=" col-sm-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="requested_store" style="min-width: 100px;">Requested Store</label>
                    <select class="form-select form-control" id="requested_store" style="min-width: 150px;" disabled>
                        <option val='' disabled>--Select--</option>
                        @foreach($requested_stores as $store)
                        <option value={{$store->id}}>{{$store->name_en}}</option>
                        @endforeach
                    </select>
                </div>
            </div>



            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="stockDateAD" style="min-width: 100px;">PO Date</label>
                    <input type="date" id="stockDateAD" name='entry_date' value="" class="form-control" placeholder="Entry Date" style="min-width: 150px;">
                </div>
            </div>
            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="expectedDateAD" style="min-width: 100px;">Expected Delivery</label>
                    <input type="date" id="expectedDateAD" name='entry_date' value="" class="form-control" placeholder="Entry Date" style="min-width: 150px;">
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
            <tbody id="po-table">
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
                            <input type="number" class="form-control p-1" data-cntr='' id="" placeholder="Add Qty" name="" size="1" style="width:5rem;">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1" data-cntr='' id="" placeholder="Free Qty" name="" size="1" style="width:5rem;">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1" data-cntr='' id="" placeholder="Total Qty" name="" size="1" style="width:5rem;">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="date" class="form-control p-1" data-cntr='' id="" placeholder="Expiry Date" name="" size="1" style="width:7rem;">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1" data-cntr='' id="" placeholder="Unit Cost" name="" size="1" style="width:5rem;">
                        </div>
                    </td>

                    <td>
                        <div class="input-group">
                            <select class="form-select form-control" data-cntr='' id="inputGroupSelect01" style="min-width: 73px;">
                                <option value="2">%</option>
                                <option value="3">NRS</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1" data-cntr='' id="" placeholder="Discount" name="" size="1" style="width:5rem;">
                        </div>
                    </td>

                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1" data-cntr='' id="" placeholder="Total Amount" name="" size="1" style="width:5rem;">
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
            <button type="button" class="btn btn-primary btn-sm " id="addRepeaterToPO"><i class="las la-plus p-1 text-white  bg-primary" aria-hidden="true"></i>Add More Item</button>
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
            <button id="" type="submit" class="btn btn-primary  mr-1">Save</button>
            <button id="" type="submit" class="btn btn-success  mr-1">Approve</button>
            <button id="" class="btn btn-danger  mr-1">Cancel</button>
        </div>
    </div>
</form>
@endsection

@section('after_scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
@endsection
