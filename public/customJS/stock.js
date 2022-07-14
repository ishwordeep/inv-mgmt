$(document).ready(function () {
    $("#addRepeaterToStockEntry,#addRepeaterToPO").click(function () {
        let currentId = $(this).attr("id");

        $.ajax({
            type: "GET",
            data: { type: currentId },
            url: "/load-new-tr-stock-entries",
            success: function (response) {
                console.log(response);
                if (currentId === "addRepeaterToStockEntry") {
                    $("#stock-table").append(response);
                }
                if (currentId === "addRepeaterToPO") {
                    $("#po-table").append(response);
                }
                $(".destroyRepeater").removeClass("d-none");
            },
        });
    });
    $(".destroyRepeater").click(function () {
        let test = "";
        let currentInvType = $(this).closest("tbody").attr("id");
        test = "#" + currentInvType + " tr";
        let NumberOfRows = $(test).length;
        if (NumberOfRows === 2) {
            $(".destroyRepeater").addClass("d-none");
        }
        $(this).closest("tr")[0].remove();
    });
});
