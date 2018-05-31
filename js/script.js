$(document).ready(function () {
    $(window).scroll(function () {
        if ($(window).scrollTop() > 100) {
            $('#navbar').addClass('fixed-top');
        }
        if ($(window).scrollTop() < 101) {
            $('#navbar').removeClass('fixed-top');
        }
    });
    $("button#add_cart").click(function () {
        $.get("product/cart.php?act=add&id=" + $(this).val(), function (data) {
            alert(data);
        });

        $("button#add_cart[value='" + $(this).val() + "']").attr('disabled', 'disabled');
        $("button#add_cart[value='" + $(this).val() + "']").attr('class', 'btn btn-secondary');
        let cart_length = parseInt($("span#cart_length").text()[0]) + 1;
        $("span#cart_length").text(cart_length);
        $("span#cart_length").attr("class", "badge badge-danger");
    });
});