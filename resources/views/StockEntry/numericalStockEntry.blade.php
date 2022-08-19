<script>
    $(document).ready(function() {
        $(".AddQty, .Discount,.UnitCost,.FreeQty, .TaxVat, #other_charges").keyup(function() {
            let currentRow = $(this).closest('tr');
            setAllThings(currentRow);

        });
        $(".DiscountMode").change(function() {
            let currentRow = $(this).closest('tr');
            setAllThings(currentRow);
        });



        function setAllThings(row) {
            let purchaseOrderQty = checkNan(parseInt($(row).find(".AddQty").val()));
            let freeQty = checkNan(parseInt($(row).find(".FreeQty").val()));
            let purchasePrice = checkNan(parseInt($(row).find(".UnitCost").val()));
            let totalQty = calcTotalQty(purchaseOrderQty, freeQty)


            let discountMode = $(row).find(".DiscountMode").val();
            let discount = checkNan(parseFloat($(row).find(".Discount").val()));
            let itemDiscount = calcItemDiscount(purchaseOrderQty, purchasePrice, discountMode, discount);
            let itemAmount = calcItemAmount(purchaseOrderQty, purchasePrice, itemDiscount);


            //Everything setter
            $(row).find(".TotalAmount").val(itemAmount);
            $(row).find(".TotalQty").val(totalQty);
            calcBillAmount();
        }

        function calcBillAmount() {
            let grossAmt = 0;
            let totalDiscAmt = 0;
            let netAmt = 0;
            let taxableAmt = 0;
            let totalTaxAmt = 0;
            let other_charges = 0;

            $(".inv_item").each(function() {

                if ($(this).val()) {
                    let currRow = $(this).closest('tr');
                    let currItemAmt = checkNan(parseFloat($(currRow).find('.TotalAmount').val()));

                    let purchaseOrderQty = checkNan(parseInt($(currRow).find(".AddQty").val()));
                    let purchasePrice = checkNan(parseInt($(currRow).find(".UnitCost").val()));
                    let discountMode = $(currRow).find(".DiscountMode").val();
                    let discount = checkNan(parseFloat($(currRow).find(".Discount").val()));

                    // if($('#itemWiseDiscount').is(':checked'))){
                        let itemDiscount = calcItemDiscount(purchaseOrderQty, purchasePrice, discountMode,discount);
                    // }
                    // else{
                    // let itemDiscount = calcItemDiscount(purchaseOrderQty, purchasePrice, discountMode, 0);
                    // }
                    if (parseFloat(checkNan($(currRow).find('.TaxVat').val())) > 0) {
                        let taxRate = parseFloat(checkNan($(currRow).find('.TaxVat').val()));

                        taxableAmt = taxableAmt + (purchaseOrderQty * purchasePrice - itemDiscount);
                        totalTaxAmt = totalTaxAmt + (purchaseOrderQty * purchasePrice - itemDiscount) * taxRate * 0.01;
                    }
                    grossAmt = grossAmt + purchaseOrderQty * purchasePrice;
                    totalDiscAmt = totalDiscAmt + itemDiscount;
                    // console.log(grossAmt, totalDiscAmt, taxableAmt, totalTaxAmt);


                }
            });

            netAmt = grossAmt - totalDiscAmt + totalTaxAmt;
            $('#gross_amt').val(grossAmt);
            $('#total_disc_amt').val(totalDiscAmt);
            $('#taxableAmt').val(taxableAmt);
            $('#totalTaxAmt').val(totalTaxAmt);
            $('#net_amt').val(netAmt);
        }



        function checkNan(val) {
            return !isNaN(val) ? val : 0;
        }

        function calcTotalQty(purchaseOrderQty, freeQty) {
            return purchaseOrderQty + freeQty;
        }

        function calcItemDiscount(purchaseOrderQty, purchasePrice, discountMode, discount) {
            if (purchaseOrderQty === 0 || purchasePrice === 0 || discount === 0) {
                return 0;
            }

            let itemAmount = purchaseOrderQty * purchasePrice;
            if (discountMode === '1') {
                return discount * itemAmount / 100;
            }
            if (discountMode === '2') {
                return discount;
            }
        }

        function calcItemAmount(purchaseOrderQty, purchasePrice, itemDiscount) {
            if (purchaseOrderQty === 0 || purchasePrice === 0) {
                return 0;
            }
            return purchaseOrderQty * purchasePrice - itemDiscount;
        }
        $(".destroyRepeater").click(function() {
            destroyRepeaterFunction(this);
            calcBillAmount()

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


    });

</script>
