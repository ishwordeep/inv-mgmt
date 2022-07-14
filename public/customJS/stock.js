$(document).ready(function () {
    $("#addRepeaterToStockEntry,#addRepeaterToPO").click(function () {
        let currentId = $(this).attr("id");
        $.ajax({
            type: "GET",
            data:{type:currentId},
            url: "/load-new-tr-stock-entries",
            success: function (response) {
                console.log(response);
                if(currentId==='addRepeaterToStockEntry'){
                    $("#stock-table").append(response);
                }
                if(currentId==='addRepeaterToPO'){
                    $("#po-table").append(response);
                }
            },
        });
    });
    $(".destroyRepeater").click(function () {
        $(this).closest("tr")[0].remove();
    });
});
