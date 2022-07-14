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
                    <label class="input-group-text" for="inputGroupSelect01">Store</label>
                    <select class="form-select" id="inputGroupSelect01" style="min-width: 200px;">
                        <option selected>Choose...</option>
                        <option value="1">one</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>

            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <span class="input-group-text">Entry Date</span>
                    <input type="date" id="stockDateAD" name='entry_date' value="" class="form-control" placeholder="Entry Date">
                </div>
            </div>


            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <span class="input-group-text">Item Wise Discount</span>

                    <input type="checkbox" checked="true" name="" id="" class="">
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
                    <th scope="col">Add Qty</th>
                    <th scope="col">Free Qty</th>
                    <th scope="col">Total Qty</th>
                    <th scope="col">Expiry Date </th>
                    <th scope="col">Unit Cost </th>
                    <th scope="col">Unit Sales</th>
                    <th scope="col">Discount</th>
                    <th scope="col">Tax/vat</th>
                    <th scope="col">Amount</th>
                    <th scope="col" style="width: 6rem">Action</th>
                </tr>
            </thead>
            <tbody id="stock-table">
                <tr>
                    <td>1</td>
                    <td>
                        <div class="input-group">
                            <input type="text" class="form-control p-1" name="" placeholder="Search item..." id='' size="1" style="width:10rem;">
                            <input type="hidden" name="" class="">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1" id="" placeholder="Add Qty" name="" size="1" style="width:5rem;">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1" id="" placeholder="Free Qty" name="" size="1" style="width:5rem;">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1" id="" placeholder="Total Qty" name="" size="1" style="width:5rem;">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="date" class="form-control p-1" id="" placeholder="Expiry Date" name="" size="1" style="width:7rem;">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1" id="" placeholder="Unit Cost" name="" size="1" style="width:5rem;">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1" id="" placeholder="Unit Sales" name="" size="1" style="width:5rem;">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1" id="" placeholder="Discount" name="" size="1" style="width:5rem;">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1" id="" placeholder="Tax/vat" name="" size="1" style="width:5rem;">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1" id="" placeholder="Total Amount" name="" size="1" style="width:5rem;">
                        </div>
                    </td>
                    <td>
                        <div class="input-group" style="width:5rem;">
                            <i class="las la-trash p-1 text-danger destroyRepeater" aria-hidden="true"></i>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
        <div>
            <button type="button" class="btn btn-primary btn-sm " id="addRepeater"><i class="las la-plus p-1 text-white  bg-primary"aria-hidden="true"></i>Add More Item</button>
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
            <button id="" type="submit" class="btn btn-primary  mr-1">Save</button>
            <button id="" type="submit" class="btn btn-success  mr-1">Approve</button>
            <button id="" class="btn btn-danger  mr-1">Cancel</button>
        </div>
    </div>
</form>
@endsection
