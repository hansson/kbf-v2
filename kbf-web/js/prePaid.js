function handlePrePaid(response) {
    resetPersonInfo();
    var triggerNextStep = false;
    if (response.feeValid && response.feeValid != "-") {
        show($("#climb"));
        if (runningOutDate(response.feeValid)) {
            show($("#personInfoAttentionClimb"));
        } else {
            show($("#personInfoClimb"));
        }
        triggerNextStep = true;
        $("#personInfoClimbUntil").html(response.feeValid);
    } else if (response.left && response.left != "-") {
        show($("#ten"));
        if (response.left == 0) {
            show($("#personInfoNoTen"));
            $("#personInfoTenUntil").html(0);
        } else if (runningOutCard(response.left)) {
            show($("#personInfoAttentionTen"));
            $("#personInfoTenUntil").html(cardValue(response.left));
            triggerNextStep = true;
        } else {
            show($("#personInfoTen"));
            $("#personInfoTenUntil").html(cardValue(response.left));
            triggerNextStep = true;
        }
    } else {
        show($("#climb"));
        show($("#personInfoNoClimb"));
        $("#personInfoClimbUntil").html("Ingen giltig betalning");
    }

    if (response.memberValid) {
        show($("#member"));
        if (response.memberValid == "-") {
            show($("#personInfoNoMember"));
        } else if (runningOutDate(response.memberValid)) {
            show($("#personInfoAttentionMember"));
        } else {
            show($("#personInfoMember"));
        }
        $("#personInfoMemberUntil").html(response.memberValid);
    }

    if (triggerNextStep && doAfterShowInfo) {
        doAfterShowInfo();
    }

    $("#prePaidNumber").val("");
}

function resetPersonInfo() {
    //Ten
    hide($("#ten"));
    hide($("#personInfoNoTen"));
    hide($("#personInfoAttentionTen"));
    hide($("#personInfoTen"));
    //Climb
    hide($("#climb"));
    hide($("#personInfoNoClimb"));
    hide($("#personInfoAttentionClimb"));
    hide($("#personInfoClimb"));
    //Member
    hide($("#member"));
    hide($("#personInfoNoMember"));
    hide($("#personInfoAttentionMember"));
    hide($("#personInfoMember"));
}