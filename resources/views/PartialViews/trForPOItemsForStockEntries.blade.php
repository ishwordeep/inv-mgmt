@foreach($poItems as $key=>$item)

<tr>
    <td></td>
    <td>
        <div class="input-group">
            <input type="text" value="{{$item->itemEntity->name_en}}" class="form-control p-1 inv_item" data-cntr='{{ $key }}'  placeholder="Search item..." id='' size="1" style="width:10rem;">
            <input type="hidden" value="{{$item->item_id}}" name='inv_item_hidden[{{$key}}]' id='inv_item_hidden-{{$key}}' class="inv_item_hidden">
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" value="{{$item->purchase_qty}}" class="form-control p-1 AddQty" data-cntr='{{$key}}' id="AddQty-{{ $key }}"  placeholder="Add Qty" name="purchase_qty[{{ $key }}]" size="1" style="width:5rem;">
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" value="{{$item->free_qty}}" class="form-control p-1 FreeQty" data-cntr='{{$key}}' id="FreeQty-{{ $key }}" placeholder="Free Qty" name="free_qty[{{ $key }}]" size="1" style="width:5rem;" >
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" value="{{$item->total_qty}}" class="form-control p-1 TotalQty" data-cntr='{{$key}}' id="TotalQty-{{ $key }}" placeholder="Total Qty" name="total_qty[{{ $key }}]" size="1" style="width:5rem;" readonly>
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="date" class="form-control p-1 ExpiryDate" data-cntr='{{$key}}' id="ExpiryDate-{{ $key }}" placeholder="Expiry Date" name="expiry_date[{{ $key }}]" size="1" style="width:7rem;" >
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" value="{{$item->purchase_price}}" class="form-control p-1 UnitCost" data-cntr='{{$key}}' id="UnitCost-{{ $key }}" placeholder="Unit Cost" name="purchase_price[{{ $key }}]" size="1" style="width:5rem;" >
        </div>
    </td>

    <td>
        <div class="input-group">
            <select class="form-select form-control DiscountMode" data-cntr='{{$key}}' id="DiscountMode-{{ $key }}" name="discount_mode_id[{{ $key }}]" style="min-width: 73px;" >
                <option value="1">%</option>
                <option value="2">NRS</option>
            </select>
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" value="{{$item->discount}}" class="form-control p-1 Discount" data-cntr='{{$key}}' id="Discount-{{ $key }}" placeholder="Discount" name="discount[{{ $key }}]" size="1" style="width:5rem;" >
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" class="form-control p-1 TaxVat" data-cntr='{{$key}}' id="TaxVat-{{ $key }}" placeholder="Tax/vat" name="taxvat[{{ $key }}]" size="1" style="width:5rem;" >
        </div>
    </td>

    <td>
        <div class="input-group">
            <input type="number" class="form-control p-1 UnitSale" data-cntr='{{$key}}' id="UnitSale-{{ $key }}"placeholder="Unit Sales" name="unit_sale[{{ $key }}]" size="1" style="width:5rem;" >
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" class="form-control p-1 TotalAmount" data-cntr='{{$key}}' id="TotalAmount-{{ $key }}" placeholder="Total Amount" name="item_amount[{{ $key }}]" size="1" style="width:5rem;" readonly>
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


@include_once('invScripts.common')
@include('StockEntry.numericalStockEntry')
<script>
    $(document).ready(function() {
        $('.AddQty,.TaxVat,.Discount,.FreeQty').trigger('keyup');
    });
</script>

