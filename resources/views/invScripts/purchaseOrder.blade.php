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
</script>