<script>
    $(document).ready(function() {
        $('#fetch_by_po_num_btn').click(function() {
            let po_num = $('#purchase_order_number').val();
            url = "http://inv_mgmt.test/admin/get-podetails/" + po_num;
            $.get(url).then(function(response) {
                if (response.nodata === 'nodata') {
                    Swal.fire("No Data Found")
                } else {
                    let pod = response.pod;
                    $("#stock-table").html(response.view)
                }
            });
        });
    });
    $('#stockEntryForm').validate({
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
                    let data = $('#stockEntryForm').serialize();
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
</script>
