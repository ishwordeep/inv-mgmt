<script>
    $(document).ready(function() {
        $('#item_name').change(function(){
            let url = '{{ route("getitemdetails",":itemname") }}'
            url = url.replace(':itemname', $(this).val());
            $.get(url).then(function(response) {
               $('#item-details-content').html(response);
            })
        })
    });

</script>