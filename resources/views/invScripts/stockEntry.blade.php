<script>
    $(document).ready(function() {
        $('#fetch_by_po_num_btn').click(function() {
            debugger;
            let po_num = $('#purchase_order_number').val();
            url = "http://inv_mgmt.test/admin/get-podetails/" + po_num;
            console.log("URL::", url)
            $.get(url).then(function(response) {
                debugger;
                if (response.nodata === 'nodata') {
                    Swal.fire("No Data Found")
                } else {
                    let pod = response.pod;
                    $("#stock-table").html(response.view)
                }
            });
        });
    });
</script>
