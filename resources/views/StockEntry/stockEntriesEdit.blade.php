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
    .error{
        color:red;
    }
</style>

@extends(backpack_view('blank'))

@include('header')

@php
@endphp

{{-- Header Content --}}
@section('content')
<form id="stockEntryForm" action="{{ url($crud->route).'/'.$entry->id }}" method="POST">
    @method('PUT')
    @csrf
    <div class="card main-container ">
        <div class="row m-3">
            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <span class="input-group-text">PO Number</span>
                    <input type="text" value="{{ $entry->po_number }}" class="form-control" id="purchase_order_number" name="po_number" placeholder="PO NO">
                    <button class="btn btn-success" type="button" id="fetch_by_po_num_btn">Fetch</button>

                </div>
            </div>

            <div class=" col-sm-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="supplier" style="min-width: 100px;">Supplier <span class="text-danger">*</span></label>
                    <select class="form-select form-control" id="supplier" name="supplier_id" style="min-width: 150px;" required>
                        <option value='' disabled>--Select--</option>
                        @foreach($data['suppliers'] as $supplier)
                            <option value="{{ $supplier->id }}" {{ $entry->supplier_id === $supplier->id ? 'selected' : '' }}>{{ $supplier->name_en }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class=" col-sm-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="requested_store" style="min-width: 100px;">Requested Store</label>
                    <select class="form-select form-control" id="requested_store" name="requested_store_id" style="width:120px;" disabled>
                        <option ue='' disabled>--Select--</option>
                        @foreach($data['stores'] as $store)
                            <option value={{$store->id}} {{ $entry->requested_store_id === $store->id ? 'selected' : '' }}>{{$store->name_en}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class=" col-sm-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01" style="min-width: 100px;">Store <span class="text-danger">*</span></label>
                    <select class="form-select form-control" id="inputGroupSelect01" name="store_id" style="min-width:150px;" required>
                        <option selected value="">Choose...</option>
                        @foreach($data['stores'] as $store)
                            <option value={{$store->id}} {{ $entry->store_id === $store->id ? 'selected' : '' }}>{{$store->name_en}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <label class="input-group-text" style="min-width: 100px;">Invoice Number <span class="text-danger">*</span></label>
                    <input type="text" value="{{ $entry->invoice_number }}" class="form-control" id="invoice_number" name="invoice_number" placeholder="Invoice Number" style="min-width: 150px;" required>
                </div>
            </div>

            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <label class="input-group-text" style="min-width: 100px;">Invoice Date <span class="text-danger">*</span></label>
                    <input type="date" value="{{ $entry->invoice_date }}" class="form-control" id="invoice_date" name="invoice_date" placeholder="Invoice Date" style="min-width: 150px;" required>
                </div>
            </div>

            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <label class="input-group-text" style="min-width: 100px;">Item Wise Discount <span class="text-danger">*</span></label>
                    <input type="checkbox" checked="true" name="itemWiseDiscount" id="itemWiseDiscount" class="form-control" style="min-width: 150px;" required>
                </div>
            </div>

            <div class=" col-sm-4 ">
                <div class="input-group mb-3">
                    <label class="input-group-text" style="min-width: 100px;">Discount <span class="text-danger">*</span></label>
                    <input type="text" name="" id="bulkDiscount" class="form-control" style="min-width: 150px;" disabled>
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
            <tbody id="stock-table">
                @foreach($items as $key => $item)
                    <tr>
                        <td></td>
                        <td>
                            <div class="input-group">
                                <input type="text" value="{{ $item->itemEntity->name_en }}" class="form-control p-1 inv_item" data-cntr='{{ $key }}' name="" placeholder="Search item..." id='inv_item-{{ $key }}' size="1" style="width:10rem;" required>
                                <input type="hidden" value="{{ $item->item_id }}" id="inv_item_hidden-{{ $key }}" name="inv_item_hidden[{{ $key }}]" class="inv_item_hidden">
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="number" min="0" value="{{ $item->add_qty }}" class="form-control p-1 AddQty" data-cntr='{{ $key }}' id="AddQty-{{ $key }}" placeholder="Add Qty" name="purchase_qty[{{ $key }}]" size="1" style="width:5rem;" required>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="number" min="0" value="{{ $item->free_qty }}" class="form-control p-1 FreeQty" data-cntr='{{ $key }}' id="FreeQty-{{ $key }}" placeholder="Free Qty" name="free_qty[{{ $key }}]" size="1" style="width:5rem;" required>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="number" min="0" value="{{ $item->total_qty }}" class="form-control p-1 TotalQty" data-cntr='{{ $key }}' id="TotalQty-{{ $key }}" placeholder="Total Qty" name="total_qty[{{ $key }}]" size="1" style="width:5rem;" readonly>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="date" value="{{ $item->expiry_date }}" class="form-control p-1 ExpiryDate" data-cntr='{{ $key }}' id="ExpiryDate-{{ $key }}" placeholder="Expiry Date" name="expiry_date[{{ $key }}]" size="1" style="width:7rem;" required>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="number" min="0" value="{{ $item->unit_cost_price }}" class="form-control p-1 UnitCost" data-cntr='{{ $key }}' id="UnitCost-{{ $key }}" placeholder="Unit Cost" name="purchase_price[{{ $key }}]" size="1" style="width:5rem;" required>
                            </div>
                        </td>
                    
                        <td>
                            <div class="input-group">
                                <select class="form-select form-control DiscountMode" data-cntr='{{ $key }}' id="DiscountMode-{{ $key }}" name="discount_mode_id[{{ $key }}]" style="min-width: 73px;" required>
                                    <option value="1" {{ $entry->discount_mode_id === 1 ? 'selected' : '' }}>%</option>
                                    <option value="2" {{ $entry->discount_mode_id === 2 ? 'selected' : '' }}>NRS</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="number" min="0" value="{{ $item->discount }}" class="form-control p-1 Discount" data-cntr='{{ $key }}' id="Discount-{{ $key }}" placeholder="Discount" name="discount[{{ $key }}]" size="1" style="width:5rem;" required>
                            </div>
                        </td>
                        @if($data['invType'] === 'addRepeaterToStockEntry')
                            <td>
                                <div class="input-group">
                                    <input type="number" min="0" value="{{ $item->tax_vat }}" class="form-control p-1 TaxVat" data-cntr='{{ $key }}' id="TaxVat-{{ $key }}" placeholder="Tax/vat" name="taxvat[{{ $key }}]" size="1" style="width:5rem;" required>
                                </div>
                            </td>
                        
                            <td>
                                <div class="input-group">
                                    <input type="number" min="0" value="{{ $item->unit_sales_price }}" class="form-control p-1 UnitSale" data-cntr='{{ $key }}' id="UnitSale-{{ $key }}" placeholder="Unit Sales" name="unit_sale[{{ $key }}]" size="1" style="width:5rem;" required>
                                </div>
                            </td>
                        @endif
                        <td>
                            <div class="input-group">
                                <input type="number" min="0" value="{{ $item->amount }}" class="form-control p-1 TotalAmount" data-cntr='{{ $key }}' id="TotalAmount-{{ $key }}" placeholder="Total Amount" name="item_amount[{{ $key }}]" size="1" style="width:5rem;" readonly>
                            </div>
                        </td>
                        <td>
                            <div class="input-group" style="width:5rem;">
                                <i class="las la-trash p-1 text-danger destroyRepeater d-none" aria-hidden="true"></i>
                            </div>
                        </td>
                    </tr>
                @endforeach

                {{-- repeaterTable --}}
                <tr id="repeaterRowStock" class="d-none">
                    <td></td>
                    <td>
                        <div class="input-group">
                            <input type="text" class="form-control p-1 inv_item" data-cntr='' name="" placeholder="Search item..." id='' size="1" style="width:10rem;" required>
                            <input type="hidden"  class="inv_item_hidden">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" min="0" class="form-control p-1 AddQty" data-cntr='' id="" placeholder="Add Qty" size="1" style="width:5rem;" required>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" min="0" class="form-control p-1 FreeQty" data-cntr='' id="" placeholder="Free Qty"  size="1" style="width:5rem;" required>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" min="0" class="form-control p-1 TotalQty" data-cntr='' id="" placeholder="Total Qty" size="1" style="width:5rem;" readonly>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="date" class="form-control p-1 ExpiryDate" data-cntr='' id="" placeholder="Expiry Date"  size="1" style="width:7rem;" required>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" min="0" class="form-control p-1 UnitCost" data-cntr='' id="" placeholder="Unit Cost"  size="1" style="width:5rem;" required>
                        </div>
                    </td>
                
                    <td>
                        <div class="input-group">
                            <select class="form-select form-control DiscountMode" data-cntr='' id="" style="min-width: 73px;" required>
                                <option value="1">%</option>
                                <option value="2">NRS</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" min="0" class="form-control p-1 Discount" data-cntr='' id="" placeholder="Discount"  size="1" style="width:5rem;" required>
                        </div>
                    </td>
                    @if($data['invType'] === 'addRepeaterToStockEntry')
                    <td>
                        <div class="input-group">
                            <input type="number" min="0" class="form-control p-1 TaxVat" data-cntr='' id="" placeholder="Tax/vat"  size="1" style="width:5rem;" required>
                        </div>
                    </td>
                
                    <td>
                        <div class="input-group">
                            <input type="number" min="0" class="form-control p-1 UnitSale" data-cntr='' id="" placeholder="Unit Sales" size="1" style="width:5rem;" required>
                        </div>
                    </td>
                    @endif
                    <td>
                        <div class="input-group">
                            <input type="number" min="0" class="form-control p-1 TotalAmount" data-cntr='' id="" placeholder="Total Amount"size="1" style="width:5rem;" readonly>
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
        <button type="button" class="btn btn-primary btn-sm " id="addRepeaterToStockEntry"><i class="las la-plus p-1 text-white  bg-primary" aria-hidden="true"></i>Add More Item</button>
    </div>
    
    <div class="main-container card">
        <div class="row m-3">
            <div class="col-md-6 col-sm-12">
                <div class="input-group mb-3">
                    <span class="input-group-text">Remarks</span>
                    <textarea class="form-control comment" name="remarks" placeholder="Remarks" rows="5">{{ $entry->remarks }}</textarea>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <table class="table table-sm table-bordered">
                    <tbody>
                        <tr>
                            <th class="bg-primary text-white">Gross Total</th>
                            <td>
                                <input id="gross_amt" value="{{ $entry->gross_total }}" type="numner" name="gross_total" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-primary text-white">Total Discount</th>
                            <td>
                                <input id="total_disc_amt" value="{{ $entry->total_discount }}" type="number" min="0" name="total_discount" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-primary text-white">Taxable Amount</th>
                            <td>
                                <input id="taxableAmt" value="{{ $entry->taxable_amount }}" type="number" min="0" name="taxable_amount" class="form-control">
                            </td>

                        </tr>
                        <tr>
                            <th class="bg-primary text-white">Tax Total</th>
                            <td>
                                <input id="totalTaxAmt" value="{{ $entry->total_tax }}" type="number" min="0" name="total_tax" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-primary text-white">Other Charges</th>
                            <td>
                                <input id="other_charges" type="number" min="0" name="other_charges" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-primary text-white">Net Amount</th>
                            <td>
                                <input id="net_amt" value="{{ $entry->net_amount }}" type="number" min="0" name="net_amount" class="form-control bg-secondary">
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
                <button id="save" type="submit" class="btn btn-primary  mr-1">Update</button>
                <button id="approve" type="submit" class="btn btn-success  mr-1">Approve</button>
                <button id="cancel" class="btn btn-danger  mr-1">Cancel</button>
            </div>
        </div>
    </div>
</form>
@endsection


@section('after_scripts')
    @include('invScripts.common')
    @include('invScripts.stockEntry')
    @include('StockEntry.numericalStockEntry')
@endsection