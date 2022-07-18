
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
                // $(this).attr("data-cntr", 5);
                let currentObj=$(this).closest('tr');
                $(this).closest('tr').find('input,select').attr('data-cntr', ui.item.id);

                //set Name
                $(currentObj).find('.inv_item').attr("id", "inv_item-" + ui.item.id).attr('name','inv_item['+ui.item.id+']');
                $(currentObj).find('.inv_item_hidden').attr("id", "inv_item_hidden-" + ui.item.id).attr('name','inv_item_hidden['+ui.item.id+']');
                $(currentObj).find('.AddQty').attr("id", "AddQty-" + ui.item.id).attr('name','purchase_qty['+ui.item.id+']');
                $(currentObj).find('.FreeQty').attr("id", "FreeQty-" + ui.item.id).attr('name','free_qty['+ui.item.id+']');
                $(currentObj).find('.TotalQty').attr("id", "TotalQty-" + ui.item.id).attr('name','total_qty['+ui.item.id+']');
                $(currentObj).find('.ExpiryDate').attr("id", "ExpiryDate-" + ui.item.id).attr('name','expiry_date['+ui.item.id+']');
                $(currentObj).find('.UnitCost').attr("id", "UnitCost-" + ui.item.id).attr('name','purchase_price['+ui.item.id+']');
                $(currentObj).find('.DiscountMode').attr("id", "DiscountMode-" + ui.item.id).attr('name','discount_mode_id['+ui.item.id+']');
                $(currentObj).find('.Discount').attr("id", "Discount-" + ui.item.id).attr('name','discount['+ui.item.id+']');
                $(currentObj).find('.TotalAmount').attr("id", "TotalAmount-" + ui.item.id).attr('name','item_amount['+ui.item.id+']');

                enableFieldsForPO(ui.item.id)
                $('#inv_item_hidden-'+ui.item.id).val(ui.item.id);
            }
        }
    });
    
    function enableFieldsForPO(row){
        $('#AddQty-'+row).prop("disabled", false)
        $('#FreeQty-'+row).prop("disabled", false)
        $('#ExpiryDate-'+row).prop("disabled", false)
        $('#UnitCost-'+row).prop("disabled", false)
        $('#DiscountMode-'+row).prop("disabled", false)
        $('#Discount-'+row).prop("disabled", false)
    }


    // End Autocomplete
    $('#save').on('click', function() {
        $('#status').val(1);
    });
    $('#approve').on('click', function() {
        $('#status').val(2);
    });
    $('#cancel').on('click', function() {
        $('#status').val(3);
    });
    // Save Action
    $('#purchaseOrderForm').validate({
        submitHandler: function(form) {
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!'
            }).then((confirmResponse) => {
                if (confirmResponse.isConfirmed) {
                    let data = $('#purchaseOrderForm').serialize();
                    let url = form.action;
                    axios.post(url, data).then((response) => {
                        window.location.href = response.data.url;
                    }, (error) => {
                        swal("Error !", error.response.data.message, "error")
                    });
                }
            });
        }
    });
});
