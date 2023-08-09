$(".pay-item-menu").click(function (e) {
    e.preventDefault();
    $(".pay-item-bank").removeClass("show-pay-item-bank");
    $(this).next().addClass("show-pay-item-bank");
});
$(".course-profile-delele").click(function (e) {
    window.history.back();
});
//Payment
$("#finish-pay").click(function (e) {
    e.preventDefault();
    let that = $(this);
    let data = {
        course_id: course_id,
    };
    let urlRequest = $(this).data("url");
    $.ajax({
        type: "get",
        url: urlRequest,
        data: data,
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
