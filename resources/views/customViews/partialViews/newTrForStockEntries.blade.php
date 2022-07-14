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
            <i class="las la-trash p-1 text-danger destroyRepeater " aria-hidden="true"></i>
        </div>
    </td>
</tr>
<script>
    $(".destroyRepeater").click(function() {
        // console.log('Hello',$(this).closest("tr")[0])
        $(this).closest("tr")[0].remove();

    });

</script>
