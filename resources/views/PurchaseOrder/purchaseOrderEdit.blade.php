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

@section('header')
    <section class="container-fluid">
	  <h2>
	  	<span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
      	<small id="datatable_info_stack">{!! $crud->getSubheading() ?? '' !!}</small>

        @if($crud->hasAccess('create'))
          <small><a href="{{ url($crud->route) }}" class="d-print-none font-sm"><i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
        @endif
	  </h2>
	</section>
@endsection

@php 
@endphp

{{-- Header Content --}}
@section('content')
<form id="purchaseOrderForm" action="{{ url($crud->route).'/'.$entry->id }}" method="POST">
    @method('PUT')
    @csrf
    <div class="card main-container ">
        <div class="row m-3">
            <div class=" col-sm-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="po_type" style="min-width: 100px; ">PO Type</label>
                    <select class="form-select form-control" id="po_type" name="po_type_id" style="min-width: 150px; ">
                        @foreach($data['po_types'] as $type)
                        <option value={{$type->id}} {{ $entry->po_type_id === $type->id ? 'selected' : '' }}>{{$type->name_en}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class=" col-sm-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="supplier" style="min-width: 100px;">Supplier</label>
                    <select class="form-select form-control" id="supplier" name="supplier_id" style="min-width: 100px;">
                        <option val='' >--Select--</option>
                        @foreach($data['suppliers'] as $supplier)
                        <option value={{$supplier->id}} {{ $entry->supplier_id === $supplier->id ? 'selected' : '' }}>{{$supplier->name_en}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class=" col-sm-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01" style="min-width: 100px;">Store</label>
                    <select class="form-select form-control" id="inputGroupSelect01" name="store_id" style="min-width: 100px;">
                        @foreach($data['stores'] as $store)
                        <option value={{$store->id}} {{ $entry->store_id === $store->id ? 'selected' : '' }}>{{$store->name_en}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class=" col-sm-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="requested_store" style="min-width: 100px;">Requested Store</label>
                    <select class="form-select form-control" id="requested_store" name="requested_store_id" style="min-width: 100px;" >
                        <option val='' >--Select--</option>
                        @foreach($data['requested_stores'] as $store)
                        <option value={{$store->id}} {{ $entry->requested_store_id === $store->id ? 'selected' : '' }}>{{$store->name_en}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="expectedDateAD" style="min-width: 100px;">Expected Delivery</label>
                    <input type="date" value="{{ $entry->expected_delivery }}" id="expectedDateAD" name='expected_delivery' value="" class="form-control" placeholder="Entry Date" style="min-width: 100px;">
                </div>
            </div>

        </div>
    </div>

    {{-- Item Entry Table --}}
    <div class="table-responsive card mb-1">
        <table class="table" id="repeaterTable" style="min-width: 1000px;">
            <thead>
                @include('partialViews.tableHeaderForInv')
            </thead>
            <tbody id="po-table">
                {{-- first row --}}
                @foreach($items as $key => $item)
                    @php 
                        $i = $loop->iteration;
                    @endphp
                    <tr>
                        <td></td>
                        <td>
                            <div class="input-group">
                                <input type="text" value="{{ $item->itemEntity->name_en }}" class="form-control p-1 inv_item" data-cntr="{{ $i }}" name="inv_item[{{ $i }}]" placeholder="Search item..." id='inv_item-{{ $i }}' size="1" style="width:10rem;">
                                <input type="hidden" id="inv_item_hidden-{{ $i }}" value="{{ $item->item_id }}" name="inv_item_hidden[{{ $i }}]" class="inv_item_hidden">
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="number" value="{{ $item->purchase_qty }}" class="form-control p-1 AddQty" data-cntr="{{ $i }}" id="AddQty-{{ $i }}" placeholder="Add Qty" name="purchase_qty[{{ $i }}]" size="1" style="width:5rem;">
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="number" value="{{ $item->free_qty }}" class="form-control p-1 FreeQty" data-cntr="{{ $i }}" id="FreeQty-{{ $i }}" placeholder="Free Qty" name="free_qty[{{ $i }}]" size="1" style="width:5rem;" >
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="number" value="{{ $item->total_qty }}" class="form-control p-1 TotalQty" data-cntr="{{ $i }}" id="TotalQty-{{ $i }}" placeholder="Total Qty" name="total_qty[{{ $i }}]" size="1" style="width:5rem;" readonly>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="number" value="{{ $item->purchase_price }}" class="form-control p-1 UnitCost" data-cntr="{{ $i }}" id="UnitCost-{{ $i }}" placeholder="Unit Cost" name="purchase_price[{{ $i }}]" size="1" style="width:5rem;" >
                            </div>
                        </td>

                        <td>
                            <div class="input-group">
                                <select class="form-select form-control DiscountMode" data-cntr="{{ $i }}" id="DiscountMode-{{ $i }}" name="discount_mode_id[{{ $i }}]" style="min-width: 73px;" >
                                    <option value="1" {{ $entry->discount_mode_id === 1 ? 'selected' : '' }}>%</option>
                                    <option value="2" {{ $entry->discount_mode_id === 2 ? 'selected' : '' }}>NRS</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="number" value="{{ $item->discount }}" class="form-control p-1 Discount" data-cntr="{{ $i }}" id="Discount-{{ $i }}" placeholder="Discount" name="discount[{{ $i }}]" size="1" style="width:5rem;" >
                            </div>
                        </td>

                        <td>
                            <div class="input-group">
                                <input type="number" value="{{ $item->item_amount }}" class="form-control p-1 TotalAmount" data-cntr="{{ $i }}" id="TotalAmount-{{ $i }}" placeholder="Total Amount" name="item_amount[{{ $i }}]" size="1" style="width:5rem;" readonly>
                            </div>
                        </td>
                        <td>
                            <div class="input-group" style="width:5rem;">
                                <i class="las la-trash p-1 text-danger destroyRepeater d-none" aria-hidden="true"></i>
                            </div>
                        </td>
                    </tr>
                @endforeach
                {{-- Repeater row --}}
                <tr id="repeaterRowPO" class="d-none">
                    <td></td>
                    <td>
                        <div class="input-group">
                            <input type="text" class="form-control p-1 inv_item" data-cntr='' name="" placeholder="Search item..." size="1" style="width:10rem;">
                            <input type="hidden" name="" class="inv_item_hidden">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 AddQty" data-cntr='' id="" placeholder="Add Qty" name="" size="1" style="width:5rem;">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 FreeQty" data-cntr='' id="" placeholder="Free Qty" name="" size="1" style="width:5rem;" >
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 TotalQty" data-cntr='' id="" placeholder="Total Qty" name="" size="1" style="width:5rem;" readonly>
                        </div>
                    </td>
                    {{-- <td>
                            <div class="input-group">
                                <input type="date" class="form-control p-1 ExpiryDate" data-cntr='' id=""
                                    placeholder="Expiry Date" name="" size="1" style="width:7rem;" >
                            </div>
                        </td> --}}
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 UnitCost" data-cntr='' id="" placeholder="Unit Cost" name="" size="1" style="width:5rem;" >
                        </div>
                    </td>

                    <td>
                        <div class="input-group">
                            <select class="form-select form-control DiscountMode" data-cntr='' id="" style="min-width: 73px;" >
                                <option value="1">%</option>
                                <option value="2">NRS</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" class="form-control p-1 Discount" data-cntr='' id="" placeholder="Discount" name="" size="1" style="width:5rem;" >
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
    </div>
    <div class="mb-2">
        <button type="button" class="btn btn-primary btn-sm " id="addRepeaterToPO"><i class="las la-plus p-1 text-white  bg-primary" aria-hidden="true"></i>Add More Item</button>
    </div>

    <div class="main-container card">
        <div class="row m-3">
            <div class="col-md-6 col-sm-12">
                <div class="input-group mb-3">
                    <span class="input-group-text">Remarks</span>
                    <textarea class="form-control comment" value="{{ $entry->comments }}" name="comments" placeholder="Remarks" rows="5"></textarea>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <table class="table table-sm table-bordered">
                    <tbody>
                        <tr>
                            <th class="bg-primary text-white">Gross Total</th>
                            <td>
                                <input id="gross_amt" value="{{ $entry->gross_amt }}" type="numner" name="gross_amt" class="form-control" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-primary text-white">Total Discount</th>
                            <td>
                                <input id="total_disc_amt" value="{{ $entry->discount_amt }}" type="number" name="discount_amt" class="form-control" readonly>
                            </td>
                        </tr>

                        <tr>
                            <th class="bg-primary text-white">Net Amount</th>
                            <td>
                                <input id="net_amt" value="{{ $entry->net_amt }}" type="number" name="net_amt" class="form-control bg-secondary" readonly>
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
            <button id="save" type="submit" class="btn btn-primary  mr-1">Update</button>
            <button id="approve" type="submit" class="btn btn-success  mr-1">Approve</button>
            <button id="cancel" class="btn btn-danger  mr-1">Cancel</button>
        </div>
    </div>
</form>
@endsection

@section('after_scripts')
    @include('invScripts.common')
    @include('invScripts.purchaseOrder')
    @include('PurchaseOrder.numericalPO')
@endsection
