<tr>
    <td></td>
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
            <select class="form-select form-control" id="inputGroupSelect01" style="min-width: 73px;">
                <option value="2">%</option>
                <option value="3">NRS</option>
            </select>
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" class="form-control p-1" id="" placeholder="Discount" name="" size="1" style="width:5rem;">
        </div>
    </td>
    @if($invType==='addRepeaterToStockEntry')
    <td>
        <div class="input-group">
            <input type="number" class="form-control p-1" id="" placeholder="Tax/vat" name="" size="1" style="width:5rem;">
        </div>
    </td>

    <td>
        <div class="input-group">
            <input type="number" class="form-control p-1" id="" placeholder="Unit Sales" name="" size="1" style="width:5rem;">
        </div>
    </td>
    @endif
    <td>
        <div class="input-group">
            <input type="number" class="form-control p-1" id="" placeholder="Total Amount" name="" size="1" style="width:5rem;">
        </div>
    </td>
    <td>
        <div class="input-group" style="width:5rem;">
            <i class="las la-trash p-1 text-danger destroyRepeater d-none" aria-hidden="true"></i>
        </div>
    </td>
</tr>
<script>
    $(".destroyRepeater").click(function() {
        let test = '';
        let currentInvType = $(this).closest('tbody').attr('id')
        test = "#" + currentInvType + " tr"
        let NumberOfRows = $(test).length;
        if (NumberOfRows === 2) {
            $('.destroyRepeater').addClass('d-none');
        }
        $(this).closest("tr")[0].remove();
    });

</script>
