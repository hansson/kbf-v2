function handlePaymentItems() {
    $("input[id^='item_']").change(function () {
        //Recalculate price
        var total = 0;
        var nameOrPersonalNumber = $("#item_pnr").val();
        var member = false;
        if (checkPersonalNumber(nameOrPersonalNumber)) {
            member = true;
        }
        for (var i = 0; i < items.length; i++) {
            var item = items[i];
            var html_item = $("#item_" + item.id);
            if (item.item_type === "checkbox" && html_item.is(":checked")) {
                if (item.price_member && member) {
                    total += item.price_member;
                } else {
                    total += item.price;
                }
            } else if (item.item_type === "amount" && html_item.val() > 0) {
                if (html_item.val() > 100) {
                    html_item.val(0);
                } else {
                    if (item.price_member && member) {
                        total += item.price_member * html_item.val();
                    } else {
                        total += item.price * html_item.val();
                    }
                }
            }
        }
        $("#total").html("Totalt: " + total + " kr");
    });
}

function itemFromCheckbox(checkbox, item, request, requestBuilder) {
    var requestItem = undefined;
    if(checkbox.is(":checked")) {
        requestItem = requestBuilder(item,request);
    }
    return requestItem;
}

function itemsFromAmount(amount, item, request, requestBuilder) {
    var items = [];
    for(var i = 0 ; i < amount.val() ; i++) {
        items.push(requestBuilder(item,request));
    }
    return items;
}