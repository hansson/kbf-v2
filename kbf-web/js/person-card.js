function decideIcons(response) {
    if(response.memberUntil && moreThanOneMonthLeft(response.memberUntil)) {
        show($('#personInfoMember'));
        hide($('#personInfoAttentionMember'));
        hide($('#personInfoNoMember'))
    } else if(response.memberUntil && !moreThanOneMonthLeft(response.memberUntil)) {
        hide($('#personInfoMember'));
        show($('#personInfoAttentionMember'));
        hide($('#personInfoNoMember'))
    } else if(!response.memberUntil) {
        hide($('#personInfoMember'));
        hide($('#personInfoAttentionMember'));
        show($('#personInfoNoMember'))
    }
    
    if(canClimb(response) && !runningOut(response)) {
        show($('#personInfoClimb'));
        hide($('#personInfoAttentionClimb'));
        hide($('#personInfoNoClimb'))
    } else if(canClimb(response)) {
        hide($('#personInfoClimb'));
        show($('#personInfoAttentionClimb'));
        hide($('#personInfoNoClimb'))
    } else if(!canClimb(response)) {
        hide($('#personInfoClimb'));
        hide($('#personInfoAttentionClimb'));
        show($('#personInfoNoClimb'))
    }
};

function canClimb(response) {
    var canClimb = false;
    if(response.climbUntil) {
        var now = moment();
        var climbUntil = moment(climbUntil);
        canClimb = !now.isAfter(climbUntil); 
    }

    if(!canClimb && response.tenCardLeft) {
        canClimb = response.tenCardLeft > 0;
    }

    return canClimb;
}

function showClimbUntilInformation(response) {
    if(response.memberUntil) {
        $('#personInfoMemberUntil').html("Medlem till och med: " + response.memberUntil);
    } else {
        $('#personInfoMemberUntil').html("Ej medlem")
    }

    if(response.climbUntil) {
        $('#personInfoClimbUntil').html("Klättringsavgift till och med: " + response.climbUntil);
    }

    if(response.tenCardLeft) {
        $('#personInfoTenCardLeft').html("Gånger kvar på 10-kort: " + response.tenCardLeft);
    }
};


function runningOut(response) {
    if(response.climbUntil && moreThanOneMonthLeft(response.climbUntil)) {
        return false;
    } else if(response.tenCardLeft > 2) {
        return false;
    } else {
        return true;
    }
}


function moreThanOneMonthLeft(date) {
    var inOneMonth = moment().add(1, 'months');
    var until = moment(date);
    return inOneMonth.isBefore(until);
};