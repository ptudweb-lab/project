$(document).ready(function () {
    $("input#ship_type_1").click(function () { 
        let price1 = parseInt(removeDot($("span#total_price").text()));
        let price2 = formatMoney(price1 + 10000);
        $("span#total_cost").text(price2);
     });
     $("input#ship_type_2").click(function () { 
        let price1 = parseInt(removeDot($("span#total_price").text()));
        let price2 = formatMoney(price1);
        $("span#total_cost").text(price2);
     });
});

function formatMoney(num) {
    let str = num.toString();
    return str.replace(/\d/g, function(c, i, a) {
        return i && ((a.length - i) % 3 === 0) ? '.' + c : c;
    });
}

function removeDot(str) {
    var out = '';
    //let j = 0;
    for(let i=0; i < str.length; i++) {
        if (str[i] != '.') {
            out += str[i];
            //j++;
        }
    }
    return out;
}