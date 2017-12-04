function addAttendee(attendee) {
    var row = "<tr id=\"attendee_" + attendee.id + "\">";
    row += "<td id=\"name_" + attendee.id + "\">" + attendee.nameOrPnr.split("+")[0] + "</td>";
    row += "<td>" + attendee.total + "</td>";
    row += "<td><button id=\"receipt-row-" + attendee.id + "\" type=\"button\" class=\"btn btn-success form-control\" data-toggle=\"modal\" data-target=\"#receiptModal\" data-receipt=\"" + attendee.receipt + "\"><i class=\"fa fa-file-o\"></i></button></td>";
    row += "<td><button id=\"remove-row-" + attendee.id + "\" type=\"button\" class=\"btn btn-danger form-control\" data-toggle=\"modal\" data-target=\"#deleteModal\"><i class=\"fa fa-trash\"></i></button></td>";
    row += "</tr>";
    $("#openTable").append(row);

    $("#receipt-row-" + attendee.id).click(function (evt) {
        var receiptId = evt.currentTarget.id.split("-")[2];
        var receipt = evt.currentTarget.getAttribute("data-receipt");
        $("#receiptName").html($("#name_" + receiptId).html());
        $("#receiptId").html(receiptId);
        $("#receiptToken").html(receipt);
        $("#receiptEmail").val("");
    });

    $("#remove-row-" + attendee.id).click(function (evt) {
        var deleteId = evt.currentTarget.id.split("-")[2];
        $("#deleteName").html($("#name_" + deleteId).html());
        $("#deleteId").html(deleteId);
    });
}