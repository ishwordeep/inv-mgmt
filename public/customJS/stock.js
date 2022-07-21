
$(document).ready(function () {
    $("#addRepeaterToStockEntry,#addRepeaterToPO").click(function () {
        repeater()
    });
    $(".destroyRepeater").click(function () {
        destroyRepeaterFunction(this)
    });

    function destroyRepeaterFunction(obj){
        let test = '';
        let currentInvType = $(obj).closest('tbody').attr('id')
        test = "#" + currentInvType + " tr";
        let NumberOfRows = $(test).length;
        // here 3 because,one column is hidden
        if (NumberOfRows === 3) {
            $('.destroyRepeater').addClass('d-none');
        }
        $(obj).closest("tr")[0].remove();
    }

    // Autocomplete
    let availableTags = [{
        id: ""
        , text: "Search an item.."
    , }, ];
    
    // let all_items = '[{"id":1,"name":"Item1"},{"id":2,"name":"Item2"},{"id":3,"name":"Item3"}]'
    let all_items ="<?php echo ($item_lists)?>";

    JSON.parse(all_items).forEach(function(item, index) {
        availableTags.push({
            id: item.id
            , label: item.name
        , });
    });
    $(".inv_item").autocomplete({
        source: availableTags, 
        minLength: 1,
        select: function(event, ui) {
            let present = false;
            if (present) {
                debugger;
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
                $(currentObj).find('.TaxVat').attr("id", "TaxVat-" + ui.item.id).attr('name','taxvat['+ui.item.id+']');//stock entries
                $(currentObj).find('.UnitSale').attr("id", "UnitSale-" + ui.item.id).attr('name','unit_sale['+ui.item.id+']');//stock entries
                $(currentObj).find('.TotalAmount').attr("id", "TotalAmount-" + ui.item.id).attr('name','item_amount['+ui.item.id+']');

                enableFieldsForPO(ui.item.id)
                $('#inv_item_hidden-'+ui.item.id).val(ui.item.id);
            }
        }
    });



    function autocompleteFunction(){
       
    }

    
    function repeater(){
        let tr = $('#repeaterRow').clone(true);
        tr.removeAttr('class');
        $('#po-table').append(tr);
        
        $(".destroyRepeater").removeClass("d-none");
        let str=(tr).find('.inv_item');

        $(str).autocomplete({
            source: availableTags,
            minLength: 1,
            select: function(event, ui) {
                let present = false;
                if (present) {
                    debugger;
                } else {
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
                    $(currentObj).find('.TaxVat').attr("id", "TaxVat-" + ui.item.id).attr('name','taxvat['+ui.item.id+']');//stock entries
                    $(currentObj).find('.UnitSale').attr("id", "UnitSale-" + ui.item.id).attr('name','unit_sale['+ui.item.id+']');//stock entries
                    $(currentObj).find('.TotalAmount').attr("id", "TotalAmount-" + ui.item.id).attr('name','item_amount['+ui.item.id+']');
    
                    enableFieldsForPO(ui.item.id)
                    $('#inv_item_hidden-'+ui.item.id).val(ui.item.id);
                }
            }
        });
    }
    
    function enableFieldsForPO(row){
        $('#AddQty-'+row).prop("disabled", false)
        $('#FreeQty-'+row).prop("disabled", false)
        $('#ExpiryDate-'+row).prop("disabled", false)
        $('#UnitCost-'+row).prop("disabled", false)
        $('#DiscountMode-'+row).prop("disabled", false)
        $('#Discount-'+row).prop("disabled", false)
        $('#TaxVat-'+row).prop("disabled", false)
        $('#UnitSale-'+row).prop("disabled", false)
    }


    // End Autocomplete
    $('.AddQty').on('keyup', function() {
        debugger;
    });

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
