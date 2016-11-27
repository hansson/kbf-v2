function hide(element) {
    if(!element.hasClass('hidden')) {
        element.addClass('hidden');
    }
};

function show(element) {
    if(element.hasClass('hidden')) {
        element.removeClass('hidden');
    }
};