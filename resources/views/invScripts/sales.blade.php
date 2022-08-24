<script>
    $('#salesForm').validate({
        submitHandler: function(form) {
            Swal.fire({
                title: 'Are you sure?'
                , icon: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#3085d6'
                , cancelButtonColor: '#d33'
                , confirmButtonText: 'Yes, save it!'
            }).then((confirmResponse) => {
                if (confirmResponse.isConfirmed) {
                    let data = $('#salesForm').serialize();
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