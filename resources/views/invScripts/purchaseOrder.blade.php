<script>
    $(document).ready(function () {
    $("#po_type").change(function () {
        let val = $(this).find(":selected").val();
        $("#supplier").prop('selectedIndex',0);
        $("#requested_store").prop('selectedIndex',0);
        if (val === "1") {
            $("#supplier").attr("disabled", false);
            $("#requested_store").attr("disabled", true);
        }
        if (val === "2") {
            $("#requested_store").attr("disabled", false);
            $("#supplier").attr("disabled", true);
        }
    });
});
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
</script>