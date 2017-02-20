function addAttendee(attendee) {
    var row = "<tr id=\"attendee_" + attendee.id + "\">";
    row += "<td id=\"name_"+ attendee.id +"\">" + attendee.nameOrPnr + "</td>";
    row += "<td>" + attendee.total + "</td>";
    row += "<td><button id=\"remove-row-" + attendee.id + "\" type=\"button\" class=\"btn btn-danger form-control\" data-toggle=\"modal\" data-target=\"#deleteModal\"><i class=\"fa fa-trash\"></i></button></td>";
    row += "</tr>";
    $("#openTable").append(row);

    $("#remove-row-" + attendee.id).click(function(evt) {
        var deleteId = evt.target.id.split("-")[2];
        $("#deleteName").html($("#name_" + deleteId).html());
        $("#deleteId").html(deleteId);
    });
}