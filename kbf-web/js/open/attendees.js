function addAttendee(attendee) {
    var row = "<tr id=\"attendee_" + attendee.id + "\">";
    row += "<td>" + attendee.nameOrPnr + "</td>";
    row += "<td>" + attendee.shoes + "</td>";
    row += "<td>" + attendee.climbingFee + "</td>";
    row += "<td>" + attendee.chalk + "</td>";
    row += "</tr>";
    $("#openTable").append(row);
}