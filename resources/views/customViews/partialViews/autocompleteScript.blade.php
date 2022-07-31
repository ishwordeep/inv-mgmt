<script>
    $(document).ready(function() {
    console.log("oK")
        debugger;
    let availableTags = [{
        'id': "",
        'text': "Search an item.."
    }, ];

   let all_items = '<?php echo isset($item_lists) ? json_encode($item_lists) : "[]" ?>';
    if (typeof all_items != 'undefined') {
        JSON.parse(all_items).forEach(function(item, index) {
            availableTags.push({
                'id': item.id,
                'label': item.name
            , });
        });
    }

    $(".inv_item").autocomplete({
        source: availableTags, minLength: 1,
        select: function(event, ui) {
            let present = false;
            if (present) {} else {
                // $(this).attr("data-cntr", 5);
                let currentObj = $(this).closest('tr');
                $(this).closest('tr').find('input,select').attr('data-cntr', ui.item.id);

                //set Name
                $(currentObj).find('.inv_item').attr("id", "inv_item-" + ui.item.id).attr('name', 'inv_item[' + ui.item.id + ']');
                $(currentObj).find('.inv_item_hidden').attr("id", "inv_item_hidden-" + ui.item.id).attr('name', 'inv_item_hidden[' + ui.item.id + ']');
                $(currentObj).find('.AddQty').attr("id", "AddQty-" + ui.item.id).attr('name', 'purchase_qty[' + ui.item.id + ']');
                $(currentObj).find('.FreeQty').attr("id", "FreeQty-" + ui.item.id).attr('name', 'free_qty[' + ui.item.id + ']');
                $(currentObj).find('.TotalQty').attr("id", "TotalQty-" + ui.item.id).attr('name', 'total_qty[' + ui.item.id + ']');
                $(currentObj).find('.ExpiryDate').attr("id", "ExpiryDate-" + ui.item.id).attr('name', 'expiry_date[' + ui.item.id + ']');
                $(currentObj).find('.UnitCost').attr("id", "UnitCost-" + ui.item.id).attr('name', 'purchase_price[' + ui.item.id + ']');
                $(currentObj).find('.DiscountMode').attr("id", "DiscountMode-" + ui.item.id).attr('name', 'discount_mode_id[' + ui.item.id + ']');
                $(currentObj).find('.Discount').attr("id", "Discount-" + ui.item.id).attr('name', 'discount[' + ui.item.id + ']');
                $(currentObj).find('.TaxVat').attr("id", "TaxVat-" + ui.item.id).attr('name', 'taxvat[' + ui.item.id + ']'); //stock entries
                $(currentObj).find('.UnitSale').attr("id", "UnitSale-" + ui.item.id).attr('name', 'unit_sale[' + ui.item.id + ']'); //stock entries
                $(currentObj).find('.TotalAmount').attr("id", "TotalAmount-" + ui.item.id).attr('name', 'item_amount[' + ui.item.id + ']');

                // enableFieldsForPO(ui.item.id)
                $('#inv_item_hidden-' + ui.item.id).val(ui.item.id);
            }
        }
    });
})

</script>