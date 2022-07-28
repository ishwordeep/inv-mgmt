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
           ' <i class="las la-trash p-1 text-danger destroyRepeater " aria-hidden="true" onclick="destroyRepeater()"></i>'+
        '</div>'+
    '</td>'+
    '</tr>';
   

    $("#addRepeaterToStockEntry,#addRepeaterToPO").click(function () {
        repeater($(this).attr('id'))
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
        'id': "", 
        'text': "Search an item..", 
    }, ];
    
    // let all_items = '[{"id":1,"name":"Item1"},{"id":2,"name":"Item2"},{"id":3,"name":"Item3"}]';
    if(typeof all_items != 'undefined'){
        JSON.parse(all_items).forEach(function(item, index) {
            availableTags.push({
                'id': item.id, 
                'label': item.name, 
            });
        });
    }


    $(".inv_item").autocomplete({
        source: availableTags, 
        minLength: 1,
        select: function(event, ui) {
            let present = false;
            if (present) {
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

    $("#itemWiseDiscount").on("change", function () {
        if ($(this).is(":checked")) {
            $("#bulkDiscount").prop("disabled", true);
        } else {
            $("#bulkDiscount").prop("disabled", false);
        }
    });
    
    $('#fetch_by_po_num_btn').click(function(){
        
       
        // let url = "{{ route('get-purchase-order-details',':po_num') }}"
        // let po_num=$('#purchase_order_number').val();
        // url = url.replace(':po_num', po_num);
        
        let po_num=$('#purchase_order_number').val();
        url ="http://inv-mgmt.test/admin/get-podetails/"+po_num;
        console.log("URL::",url)
        $.get(url).then(function(response) {
            if(response.nodata==='nodata'){
                Swal.fire("No Data Found")
            }else{
                // debugger;

                
                let pod=response.pod;
                // $('#inv-qty-header').remove();
                // $('#action-header').remove();
                
               

                // $("#grn_type").val(pod.purchase_order_type_id).attr('disabled','disabled');
                // $("#store").val(pod.store_id).attr('disabled','disabled');
                // $("#supplier").val(pod.supplier_id).attr('disabled','disabled');
                $("#stock-table").html(response.view)
                // $("#po_date").val(pod.po_date.slice(0,10)).attr('disabled','disabled');
            }
        });
    });

    $(str).autocomplete({
        source: availableTags,
        minLength: 1,
        select: function(event, ui) {
            let present = false;
            if (present) {
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

    $('#itemWiseDiscount').on('change',function(){
        if($(this).is(':checked')){
            $('#bulkDiscount').prop("disabled", true)
        }
        else{
            $('#bulkDiscount').prop("disabled", false)
        }
    })

    function destroyRepeater(){
        $('.destroyRepeater').closest("tr")[0].remove();
    }
});
