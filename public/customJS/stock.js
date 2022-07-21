$(document).ready(function () {
    $("#itemWiseDiscount").on("change", function () {
        if ($(this).is(":checked")) {
            $("#bulkDiscount").prop("disabled", true);
        } else {
            $("#bulkDiscount").prop("disabled", false);
        }
    });
    $('#fetch_by_po_num_btn').click(function(){
        
       
        let url = "{{ route('get-purchase-order-details',':po_num') }}"
        let po_num=$('#purchase_order_number').val();
        url = url.replace(':po_num', po_num);
        console.log("URL::",url)
        $.get(url).then(function(response) {
            debugger;
            if(response.nodata==='nodata'){
                Swal.fire("No Data Found")
            }else{
                // debugger;

                
                let pod=response.pod;
                $('#inv-qty-header').remove();
                $('#action-header').remove();
                
               

                $("#grn_type").val(pod.purchase_order_type_id).attr('disabled','disabled');
                $("#store").val(pod.store_id).attr('disabled','disabled');
                $("#supplier").val(pod.supplier_id).attr('disabled','disabled');
                $("#grn-table-body").html(response.view);
                $("#po_date").val(pod.po_date.slice(0,10)).attr('disabled','disabled');

            }
       
       
         })
       
       
    });
});

