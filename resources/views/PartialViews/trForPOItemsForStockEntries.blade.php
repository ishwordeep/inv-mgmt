@foreach($poItems as $item)

<tr>
    <td></td>
    <td>
        <div class="input-group">
            <input type="text" value="{{$item->itemEntity->name_en}}" class="form-control p-1 inv_item" data-cntr='' name="" placeholder="Search item..." id='' size="1" style="width:10rem;">
            <input type="hidden" value="{{$item->item_id}}" name="inv_item_hidden[]" class="">
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" value="{{$item->purchase_qty}}" class="form-control p-1 AddQty" data-cntr='' id="" placeholder="Add Qty" name="add_qty[]" size="1" style="width:5rem;">
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" value="{{$item->free_qty}}" class="form-control p-1 FreeQty" data-cntr='' id="" placeholder="Free Qty" name="free_item[]" size="1" style="width:5rem;" >
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" value="{{$item->total_qty}}" class="form-control p-1 TotalQty" data-cntr='' id="" placeholder="Total Qty" name="total_qty[]" size="1" style="width:5rem;" readonly>
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="date" class="form-control p-1 ExpiryDate" data-cntr='' id="" placeholder="Expiry Date" name="expiry_date[]" size="1" style="width:7rem;" >
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" value="{{$item->purchase_price}}" class="form-control p-1 UnitCost" data-cntr='' id="" placeholder="Unit Cost" name="unit_cost_price[]" size="1" style="width:5rem;" >
        </div>
    </td>

    <td>
        <div class="input-group">
            <select class="form-select form-control DiscountMode" data-cntr='' id=""  name="discount_mode_id[]" style="min-width: 73px;" >
                <option value="1">%</option>
                <option value="2">NRS</option>
            </select>
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" value="{{$item->discount}}" class="form-control p-1 Discount" data-cntr='' id="" placeholder="Discount" name="discount[]" size="1" style="width:5rem;" >
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" class="form-control p-1 TaxVat" data-cntr='' id="" placeholder="Tax/vat" name="tax_vat[]" size="1" style="width:5rem;" >
        </div>
    </td>

    <td>
        <div class="input-group">
            <input type="number" class="form-control p-1 UnitSale" data-cntr='' id="" placeholder="Unit Sales" name="unit_sales_price[]" size="1" style="width:5rem;" >
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" class="form-control p-1 TotalAmount" data-cntr='' id="" placeholder="Total Amount" name="item_total[]" size="1" style="width:5rem;" readonly>
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
            <input type="text" class="form-control p-1 inv_item" data-cntr='' name="" placeholder="Search item..." id='' size="1" style="width:10rem;">
            <input type="hidden" name="inv_item_hidden[]" class="">
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" class="form-control p-1 AddQty" data-cntr='' id="" placeholder="Add Qty" name="add_qty[]" size="1" style="width:5rem;">
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" class="form-control p-1 FreeQty" data-cntr='' id="" placeholder="Free Qty" name="free_item[]" size="1" style="width:5rem;" >
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" class="form-control p-1 TotalQty" data-cntr='' id="" placeholder="Total Qty" name="total_qty[]" size="1" style="width:5rem;" readonly>
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="date" class="form-control p-1 ExpiryDate" data-cntr='' id="" placeholder="Expiry Date" name="expiry_date[]" size="1" style="width:7rem;" >
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" class="form-control p-1 UnitCost" data-cntr='' id="" placeholder="Unit Cost" name="unit_cost_price[]" size="1" style="width:5rem;" >
        </div>
    </td>

    <td>
        <div class="input-group">
            <select class="form-select form-control DiscountMode" data-cntr='' id="" name="discount_mode_id[]" style="min-width: 73px;" >
                <option value="1">%</option>
                <option value="2">NRS</option>
            </select>
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" class="form-control p-1 Discount" data-cntr='' id="" placeholder="Discount" name="discount[]" size="1" style="width:5rem;" >
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" class="form-control p-1 TaxVat" data-cntr='' id="" placeholder="Tax/vat" name="tax_vat[]" size="1" style="width:5rem;" >
        </div>
    </td>

    <td>
        <div class="input-group">
            <input type="number" class="form-control p-1 UnitSale" data-cntr='' id="" placeholder="Unit Sales" name="unit_sales_price[]" size="1" style="width:5rem;" >
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" class="form-control p-1 TotalAmount" data-cntr='' id="" placeholder="Total Amount" name="item_total[]" size="1" style="width:5rem;" readonly>
        </div>
    </td>
    <td>
        <div class="input-group" style="width:5rem;">
            <i class="las la-trash p-1 text-danger destroyRepeater d-none" aria-hidden="true"></i>
        </div>
    </td>
</tr>

@include_once('invScripts.common')
@include('StockEntry.numericalStockEntry')

