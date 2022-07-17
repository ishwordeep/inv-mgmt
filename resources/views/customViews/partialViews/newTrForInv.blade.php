<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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
    @if($invType==='addRepeaterToStockEntry')
    <td>
        <div class="input-group">
            <input type="number" class="form-control p-1" data-cntr='' id="" placeholder="Tax/vat" name="" size="1" style="width:5rem;">
        </div>
    </td>

    <td>
        <div class="input-group">
            <input type="number" class="form-control p-1" data-cntr='' id="" placeholder="Unit Sales" name="" size="1" style="width:5rem;">
        </div>
    </td>
    @endif
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
@section('after_scripts')
{{-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="{{asset('js/vendor.js')}}"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    $(document).ready(function() {
        // Autocomplete
        let availableTags = [{
            id: ""
            , text: "Search an item.."
        , }, ];
        let all_items = '[{"id":1,"name":"Item1"},{"id":2,"name":"Item2"},{"id":3,"name":"Item3"}]'
        JSON.parse(all_items).forEach(function(item, index) {
            availableTags.push({
                id: item.id
                , label: item.name
            , });
        });

        $(".inv_item").autocomplete({
            source: availableTags
            , minLength: 1
            , select: function(event, ui) {
                // let present = checkIfItemExist(ui.item.id);
                let present = false;
                if (present) {
                    Swal.fire({
                        title: "Item Already Exits !"
                        , confirmButtonText: "OK"
                    , }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            $("#po_item_name-" + dataCntr).val("");

                            return;
                        }
                    });
                } else {
                    $(this).attr("data-cntr", 5);
                    $(this).closest('tr').find('input').attr('data-cntr', 999);

                }
            }
        });


        // End Autocomplete

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
    });

</script> --}}
@endsection
