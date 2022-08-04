<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {

        let availableTags = [{
            'id': ""
            , 'text': "Search an item.."
        }, ];

        let all_items = '<?php echo isset($item_lists) ? json_encode($item_lists) : "[]" ?>';
        if (typeof all_items != 'undefined') {
            JSON.parse(all_items).forEach(function(item, index) {
                availableTags.push({
                    'id': item.id
                    , 'label': item.name
                , });
            });
        }

        $(".inv_item").autocomplete({
            source: availableTags
            , minLength: 1
            , select: function(event, ui) {
                let present = false;
                if (present) {} else {
                    console.log("first auto")

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

                    enableFieldsForPO(ui.item.id)
                    $('#inv_item_hidden-' + ui.item.id).val(ui.item.id);
                }
            }
        });

        $("#addRepeaterToStockEntry,#addRepeaterToPO,#addRepeaterToSales").click(function() {
            repeater($(this).attr("id"));
        });

        function repeater(type) {
            if (type === "addRepeaterToStockEntry") {
                let tr = $("#repeaterRowStock").clone(true);
                tr.removeAttr("class");
                $("#stock-table").append(tr);
            }
            if (type === "addRepeaterToPO") {
                let tr = $("#repeaterRowPO").clone(true);
                tr.removeAttr("class");
                $("#po-table").append(tr);
            }
            if (type === "addRepeaterToSales") {
                let tr = $("#repeaterRowSales").clone(true);
                tr.removeAttr("class");
                $("#sales-table").append(tr);
            }
            $(".destroyRepeater").removeClass("d-none");
            console.log("REpeater::", availableTags)
            $(".inv_item").autocomplete({
                source: availableTags
                , minLength: 1
                , select: function(event, ui) {
                    debugger;
                    let present = false;
                    if (present) {
                        alert("I am present");
                    } else {
                        console.log("rep auto")
                        let currentObj = $(this).closest("tr");
                        $(this).closest("tr").find("input,select").attr("data-cntr", ui.item.id);

                        //set Name
                        $(currentObj).find(".inv_item").attr("id", "inv_item-" + ui.item.id).attr("name", "inv_item[" + ui.item.id + "]");
                        $(currentObj).find(".inv_item_hidden").attr("id", "inv_item_hidden-" + ui.item.id).attr("name", "inv_item_hidden[" + ui.item.id + "]");
                        $(currentObj).find(".AddQty").attr("id", "AddQty-" + ui.item.id).attr("name", "purchase_qty[" + ui.item.id + "]");
                        $(currentObj).find(".FreeQty").attr("id", "FreeQty-" + ui.item.id).attr("name", "free_qty[" + ui.item.id + "]");
                        $(currentObj).find(".TotalQty").attr("id", "TotalQty-" + ui.item.id).attr("name", "total_qty[" + ui.item.id + "]");
                        $(currentObj).find(".ExpiryDate").attr("id", "ExpiryDate-" + ui.item.id).attr("name", "expiry_date[" + ui.item.id + "]");
                        $(currentObj).find(".UnitCost").attr("id", "UnitCost-" + ui.item.id).attr("name", "purchase_price[" + ui.item.id + "]");
                        $(currentObj).find(".DiscountMode").attr("id", "DiscountMode-" + ui.item.id).attr("name", "discount_mode_id[" + ui.item.id + "]");
                        $(currentObj).find(".Discount").attr("id", "Discount-" + ui.item.id).attr("name", "discount[" + ui.item.id + "]");
                        $(currentObj).find(".TaxVat").attr("id", "TaxVat-" + ui.item.id).attr("name", "taxvat[" + ui.item.id + "]"); //stock entries
                        $(currentObj).find(".UnitSale").attr("id", "UnitSale-" + ui.item.id).attr("name", "unit_sale[" + ui.item.id + "]"); //stock entries
                        $(currentObj).find(".TotalAmount").attr("id", "TotalAmount-" + ui.item.id).attr("name", "item_amount[" + ui.item.id + "]");

                        enableFieldsForPO(ui.item.id);
                        $("#inv_item_hidden-" + ui.item.id).val(ui.item.id);
                    }
                }
            , });
        }

        $(".destroyRepeater").click(function() {
            destroyRepeaterFunction(this);
        });

        function destroyRepeaterFunction(obj) {
            let test = "";
            let currentInvType = $(obj).closest("tbody").attr("id");
            test = "#" + currentInvType + " tr";
            let NumberOfRows = $(test).length;
            // here 3 because,one column is hidden:: first row+current row+hidden row
            if (NumberOfRows === 3) {
                ~$(".destroyRepeater").addClass("d-none");
            }
            $(obj).closest("tr")[0].remove();
        }

        function enableFieldsForPO(row) {
            $("#AddQty-" + row).prop("disabled", false);
            $("#FreeQty-" + row).prop("disabled", false);
            $("#ExpiryDate-" + row).prop("disabled", false);
            $("#UnitCost-" + row).prop("disabled", false);
            $("#DiscountMode-" + row).prop("disabled", false);
            $("#Discount-" + row).prop("disabled", false);
            $("#TaxVat-" + row).prop("disabled", false);
            $("#UnitSale-" + row).prop("disabled", false);
        }
       

        $('#save').on('click', function() {
            // checkIfAtleastOneItem($(this))
            $('#status').val(1);
        });
        $('#approve').on('click', function() {
            $('#status').val(2);
        });
        $('#cancel').on('click', function() {
            $('#status').val(3);
        });

    });

</script>
