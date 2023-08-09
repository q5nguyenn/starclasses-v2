$(".pay-item-menu").click(function (e) {
    e.preventDefault();
    $(".pay-item-bank").removeClass("show-pay-item-bank");
    $(this).next().addClass("show-pay-item-bank");
});

//Delete a course in cart
$(".course-profile-delele").click(function (e) {
    let that = $(this);
    e.preventDefault();
    let urlRequest = $(this).data("url");
    console.log(urlRequest);
    $.ajax({
        type: "get",
        url: urlRequest,
        success: function (response) {
            that.parent().parent().fadeOut(300);
            $("#cart-course").html(parseInt($("#cart-course").html()) - 1);
        },
    });
});

//Payment
$("#finish-pay").click(function (e) {
    let that = $(this);
    e.preventDefault();
    let urlRequest = $(this).data("url");
    $.ajax({
        type: "get",
        url: urlRequest,
        success: function (response) {
            $(".popup-pay-success").css("display", "flex");
            setTimeout(() => {
                $(".popup-pay-success").css("display", "none");
                var rootURL = window.location.origin;
                window.open(`${rootURL}/profile/learning`, "_self");
            }, 3000);
        },
    });
});
