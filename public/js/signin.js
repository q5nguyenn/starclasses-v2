$(document).ready(function () {
    // Show and hide password
    $("#checkbox1").change(function (e) {
        e.preventDefault();
        if ($(this).is(":checked")) {
            $(".input-password").attr("type", "text");
        } else {
            $(".input-password").attr("type", "password");
        }
    });
});
