
$(document).ready(function () {
    let newTrForPO='<tr>'+
    '<td></td>'+
    '<td>'+
        '<div class="input-group">'+
            '<input type="text" class="form-control p-1 inv_item" name="" placeholder="Search item..." size="1" style="width:10rem;">'+
        '</div>'+
    '</td>'+
    '<td>'+
        '<div class="input-group">'+
           ' <input type="number" class="form-control p-1"  placeholder="Add Qty" name="" size="1" style="width:5rem;">'+
        '</div>'+
    '</td>'+
    '<td>'+
       ' <div class="input-group">'+
            '<input type="number" class="form-control p-1" placeholder="Free Qty" name="" size="1" style="width:5rem;">'+
        '</div>'+
    '</td>'+
    '<td>'+
        '<div class="input-group">'+
            '<input type="number" class="form-control p-1" placeholder="Total Qty" name="" size="1" style="width:5rem;">'+
        '</div>'+
    '</td>'+
    '<td>'+
       ' <div class="input-group">'+
            '<input type="date" class="form-control p-1" placeholder="Expiry Date" name="" size="1" style="width:7rem;">'+
        '</div>'+
    '</td>'+
    '<td>'+
        '<div class="input-group">'+
            '<input type="number" class="form-control p-1" placeholder="Unit Cost" name="" size="1" style="width:5rem;">'+
        '</div>'+
    '</td>'+
    
    '<td>'+
        '<div class="input-group">'+
            '<select class="form-select form-control"   style="min-width: 73px;">'+
                '<option value="2">%</option>'+
                '<option value="3">NRS</option>'+
            '</select>'+
       ' </div>'+
    '</td>'+
    '<td>'+
       ' <div class="input-group">'+
           ' <input type="number" class="form-control p-1"   placeholder="Discount" name="" size="1" style="width:5rem;">'+
       ' </div>'+
    '</td>'+
    '<td>'+
        '<div class="input-group">'+
          '<input type="number" class="form-control p-1" placeholder="Total Amount" name="" size="1" style="width:5rem;">'+
        '</div>'+
    '</td>'+
    '<td>'+
        '<div class="input-group" style="width:5rem;">'+
           ' <i class="las la-trash p-1 text-danger destroyRepeater " aria-hidden="true"></i>'+
        '</div>'+
    '</td>'+
    '</tr>';
   

    $("#addRepeaterToStockEntry,#addRepeaterToPO").click(function () {
        let currentId = $(this).attr("id");
        $("#po-table").append(newTrForPO);
        $(".destroyRepeater").removeClass("d-none");
    });
    $(".destroyRepeater").click(function () {
        $(this).closest("tr")[0].remove();
    });

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
});
