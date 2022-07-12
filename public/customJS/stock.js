$(document).ready(function () {

    $("#addRepeater").click(function () {
        $.ajax({
            type: "GET",
            url: "/load-new-tr-stock-entries",
            success: function (response) {
                $("#stock-table").append(response);
            },
        });
    });

});
