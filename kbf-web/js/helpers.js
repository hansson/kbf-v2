function hide(element) {
    if(!element.hasClass('hidden')) {
        element.addClass('hidden');
    }
};

function show(element) {
    if(element.hasClass('hidden')) {
        element.removeClass('hidden');
    }
    $('html, body').animate({
        scrollTop: element.offset().top
    }, 10);
};

function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

function checkPersonalNumber(pnr) {
    var pnrIncludesDash = pnr.indexOf("-")
    if ((pnrIncludesDash > -1 && pnr.length > 8) || (!pnrIncludesDash > -1 && pnr.length > 6)) {
        pnr = pnr.substring(2, pnr.length);
    }

    return new RegExp(/[0-9]{6}(-[0-9]){0,1}/).test(pnr) && (pnr.length == 6 || (pnrIncludesDash && pnr.length == 8));
};

function runningOutDate(valid) {
    if(moreThanOneMonthLeft(valid)) {
        return false;
    } else {
        return true;
    }
};

function runningOutCard(left) {
    left--;
    if(left > 2) {
        return false;
    } else {
        return true;
    }
};

function moreThanOneMonthLeft(date) {
    var inOneMonth = moment().add(1, 'months');
    var until = moment(date);
    return inOneMonth.isBefore(until);
};


function initi18n() {
    $("#switch-en").on("click", function() {
        $.cookie("language", "en");
        switchToEn();
    });

    $("#switch-sv").on("click", function() {
        $.cookie("language", "sv");
        $(".sv").each(function() {
            show($(this));
        }) 
        $(".en").each(function() {
            hide($(this));
        })
        hide($("#switch-sv"));
        show($("#switch-en"));
    });

    var language = $.cookie("language");
    if(language === "en") {
        switchToEn();
    }
}

function switchToEn() {
        $(".en").each(function() {
            show($(this));
        }) 
        $(".sv").each(function() {
            hide($(this));
        })
        hide($("#switch-en"));
        show($("#switch-sv"));
}

function logoutIfNotSet(field) {
    if(!field || field == null || field == -1) {
        window.location = "login.php?error=1"
        return true;
    }
    return false;
}