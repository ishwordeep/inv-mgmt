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
                    <label class="input-group-text" for="inputGroupSelect01" style="min-width: 100px; ">PO Type</label>
                    <select class="form-select form-control" id="inputGroupSelect01" style="min-width: 150px; ">
                        <option selected>Choose...</option>
                        <option value="1">one</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
            <div class=" col-sm-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01" style="min-width: 100px;">Supplier</label>
                    <select class="form-select form-control" id="inputGroupSelect01" style="min-width: 150px;">
                        <option selected>Choose...</option>
                        <option value="1">one</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
            <div class=" col-sm-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01" style="min-width: 100px;">Requested Store</label>
                    <select class="form-select form-control" id="inputGroupSelect01" style="min-width: 150px;">
                        <option selected>Choose...</option>
                        <option value="1">one</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
            <div class=" col-sm-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01" style="min-width: 100px;">Store</label>
                    <select class="form-select form-control" id="inputGroupSelect01" style="min-width: 150px;">
                        <option selected>Choose...</option>
                        <option value="1">one</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
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
               @include('customViews.partialViews.newTrForInv')
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
