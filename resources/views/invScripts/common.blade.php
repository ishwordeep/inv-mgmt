<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {
        let counterArray = [1];
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

        function getLastArrayData() {
            return counterArray[counterArray.length - 1];
        }

        $("#inv_item-1").autocomplete({
            source: availableTags
            , minLength: 1
            , select: function(event, ui) {
                let present = false;
                if (present) {} else {
                    // console.log("first auto")
                    enableFieldsForPO(ui.item.id)
                    $('#inv_item_hidden-1').val(ui.item.id);
                }
            }
        });

        $("#addRepeaterToStockEntry,#addRepeaterToPO,#addRepeaterToSales").click(function() {
            repeater($(this).attr("id"));
        });

        function repeater(type) {
            
            console.log("ROW:", counterArray);
            if (type === "addRepeaterToStockEntry") {
                let tr = $("#repeaterRowStock").clone(true);
                tr.removeAttr("class");
                setIdNameTorepeater(getLastArrayData()+1,tr);
                $("#stock-table").append(tr);
                counterArray.push(getLastArrayData() + 1);
            }

            if (type === "addRepeaterToPO") {
                let tr = $("#repeaterRowPO").clone(true);
                tr.removeAttr("class");
                tr.removeAttr('id');
                setIdNameTorepeater(getLastArrayData() + 1,tr);
                $("#po-table").append(tr);
                counterArray.push(getLastArrayData() + 1);

            }

            if (type === "addRepeaterToSales") {
                let tr = $("#repeaterRowSales").clone(true);
                tr.removeAttr("class");
                $("#sales-table").append(tr);
            }

            $(".destroyRepeater").removeClass("d-none");
            console.log("REpeater::", availableTags)
            
            $("#inv_item-" +getLastArrayData()).autocomplete({
                source: availableTags,
                minLength: 1,
                select: function(event, ui) {
                    let present = false;
                    if (present) {
                        alert("I am present");
                    } else {
                        console.log("rep auto")


                        enableFieldsForPO(ui.item.id);
                        $("#inv_item_hidden-" + getLastArrayData()).val(ui.item.id);
                    }
                }
            , });
        }

        $(".destroyRepeater").click(function() {
            destroyRepeaterFunction(this);
        });

        function setIdNameTorepeater(row,currentObj) {
            $(currentObj).closest("tr").find("input,select").attr("data-cntr", row);
            //set Name/Id
            $(currentObj).find(".inv_item").attr("id", "inv_item-" + row).attr("name", "inv_item[" + row + "]");
            $(currentObj).find(".inv_item_hidden").attr("id", "inv_item_hidden-" + row).attr("name", "inv_item_hidden[" + row + "]");
            $(currentObj).find(".AddQty").attr("id", "AddQty-" + row).attr("name", "purchase_qty[" + row + "]");
            $(currentObj).find(".FreeQty").attr("id", "FreeQty-" + row).attr("name", "free_qty[" + row + "]");
            $(currentObj).find(".TotalQty").attr("id", "TotalQty-" + row).attr("name", "total_qty[" + row + "]");
            $(currentObj).find(".ExpiryDate").attr("id", "ExpiryDate-" + row).attr("name", "expiry_date[" + row + "]");
            $(currentObj).find(".UnitCost").attr("id", "UnitCost-" + row).attr("name", "purchase_price[" + row + "]");
            $(currentObj).find(".DiscountMode").attr("id", "DiscountMode-" + row).attr("name", "discount_mode_id[" + row + "]");
            $(currentObj).find(".Discount").attr("id", "Discount-" + row).attr("name", "discount[" + row + "]");
            $(currentObj).find(".TaxVat").attr("id", "TaxVat-" + row).attr("name", "taxvat[" + row + "]"); //stock entries
            $(currentObj).find(".UnitSale").attr("id", "UnitSale-" + row).attr("name", "unit_sale[" + row + "]"); //stock entries
            $(currentObj).find(".TotalAmount").attr("id", "TotalAmount-" + row).attr("name", "item_amount[" + row + "]");

        }

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
            // indexCntr = counterArray.indexOf(parseInt(this.getAttribute('tr-id')));
            // counterArray.splice(indexCntr, 1);
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
            $('#status').val(1);
        });
        $('#approve').on('click', function() {
            $('#status').val(2);
        });
        $('#cancel').on('click', function() {
            $('#status').val(3);
        });


        //pucrhase order edit autocomplete load
        @if(isset($items))
        let totalItems = {{ $items->count() }};
        for (let i = 0; i < totalItems; i++) {
            console.log(counterArray)
            counterArray.push(i)
            $("#inv_item-"+i).autocomplete({
            source: availableTags
            , minLength: 1
            , select: function(event, ui) {
                let present = false;
                if (present) {} else {
                    // console.log("first auto")
                    debugger;
                    enableFieldsForPO(ui.item.id)
                    $('#inv_item_hidden-'+i).val(ui.item.id);
                }
            }
            });
        }
    @endif

    });


</script>
