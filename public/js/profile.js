import { previewUploadImage, checkEmpty } from "./utilities.js";
//Select2
$(".js-province-tokenizer").select2({
    placeholder: "Choose a province",
});
$(".js-error-tokenizer").select2({
    placeholder: "Choose the type of support",
});

// Show frame by value
if (frame != 8) {
    $(`.profile-cover-menu-item[frame=8]`).hide();
} else {
    $(".profile-cover-menu-item").each(function () {
        $(this).removeClass("is-active");
    });
    $(".profile-frame").each(function () {
        $(this).hide();
    });
    $(`.profile-frame[data-frame=${frame}]`).show();
    $(`.profile-cover-menu-item[frame=${frame}]`).show();
    $(`.profile-cover-menu-item[frame=${frame}]`).addClass("is-active");
}
$(".profile-cover-menu-item").each(function () {
    $(this).removeClass("is-active");
});
$(`.profile-cover-menu-item[frame=${frame}]`).addClass("is-active");
$(".profile-frame").each(function () {
    $(this).hide();
});
$(`.profile-frame[data-frame=${frame}]`).show();

// Delete course in  wishlist or cart
$(".course-profile-delele").click(function (e) {
    e.preventDefault();
    let that = $(this);
    let urlRequest = $(this).data("url");
    console.log(urlRequest);
    $.ajax({
        type: "get",
        url: urlRequest,
        success: function (response) {
            that.parent().parent().fadeOut(300);
            $("#cart-course").show();
            if (urlRequest.includes("/cart/")) {
                $("#cart-course").html(parseInt($("#cart-course").html()) - 1);
                if ($("#cart-course").html() == 0) {
                    $("#cart-course").hide();
                    return;
                }
            }
        },
    });
});

//Change Password
$('[id="checkbox1"]').change(function (e) {
    e.preventDefault();
    if ($(this).is(":checked")) {
        $('[data-frame="8"] .input').attr("type", "text");
    } else {
        $('[data-frame="8"] .input').attr("type", "password");
    }
});

// checkImage = checkImage($("#thumbnail"), $(".profile-frame-avatar img"));
// $("#btn-request").click(function (e) {
//     e.preventDefault();
//     checkAddress = checkEmpty(
//         $("#error"),
//         "*You must choose the type of support.",
//         "n"
//     );
//     checkAddress = checkEmpty(
//         $("#error-desc"),
//         "*Description field cannot be left blank.",
//         "pn"
//     );
// });

$(".profile-notification-item").click(function (e) {
    e.preventDefault();
    var clickedElement = this;
    $.each($(".profile-notification-item"), function (index, element) {
        if (element !== clickedElement) {
            $(element).find(".profile-notification-item-avatar").hide(300);
            $(element).find(".profile-notification-item-content").hide(300);
            $(element).find(".profile-notification-item-to").hide(300);
            $(element).find(".profile-notification-item-email").hide(300);
        }
    });
    $(this).find(".profile-notification-item-avatar").toggle(300);
    $(this).find(".profile-notification-item-content").toggle(300);
    $(this).find(".profile-notification-item-to").toggle(300);
    $(this).find(".profile-notification-item-email").toggle(300);
    $(this).find(".notification-unread").removeClass("notification-unread");
    let urlRequest = $(this).data("url");
    $.ajax({
        type: "get",
        url: urlRequest,
        success: function (response) {
            if (response["noticeCount"] == 0) {
                $(".user-notification-point").hide();
                return;
            }
            if (response["decrease"] == -1) {
                $(".user-notification-point").html(
                    parseInt($(".user-notification-point").html()) - 1
                );
            }
        },
    });
});
$(".profile-notification-item").hover(
    function () {
        $(this).find(".action-delete").show();
        $(this).find(".profile-notification-item-date").hide();
    },
    function () {
        $(this).find(".action-delete").hide();
        $(this).find(".profile-notification-item-date").show();
    }
);

$("#active-code").click(function (e) {
    e.preventDefault();
    let name = $("#code").val();
    if (!name) {
        $(this).prev().html("*Voucher field cannot be left blank.");
    } else {
        $(this).prev().html("&nbsp;");
        let urlRequest = $(this).data("url") + "?name=" + name;
        $.ajax({
            type: "get",
            url: urlRequest,
            success: function (response) {
                let message = response["icon"];
                message += response["message"];
                if (response["data"] != null) {
                    message += `</br>You have successfully activated the <b> <a href="http://127.0.0.1:8000/course/${response["data"]["slug"]}">${response["data"]["name"]}</a> </b>`;
                    $(".user-notification-point").show();
                    $(".user-notification-point").html(
                        parseInt($(".user-notification-point").html()) + 1
                    );
                }
                $(".voucher-content").html(message);
            },
        });
    }
});

// Hàm kiểm tra avatar
previewUploadImage($("#thumbnail"), $(".profile-frame-avatar img"));

var divHeight = $(".reply-notification-body").height();
var editor = new FroalaEditor("#content", {
    fontFamilyDefault: "Arial, sans-serif",
    heightMin: 222,
});

$(".btn-reply").click(function (e) {
    // e.stopPropagation();
    e.preventDefault();
    $("#btn-send").html('<i class="bi bi-send"></i> Send');
    $("#btn-send").attr("data-url", notification_store);
    let urlRequest = $(this).attr("href");
    $(".js-user-tokenizer").val([]).trigger("change");
    $.ajax({
        type: "get",
        url: urlRequest,
        success: function (response) {
            $(".popup-reply-notification").show(300);
            let htmlString = '<option value = "" > < /option>';
            let users = response["users"];
            if (response["type"] == "compose") {
                $("#title").focus();
                let to_user = response["to_user"];
                users.forEach((user) => {
                    htmlString += `<option value="${user["id"]}">
					${user["email"]}</option>`;
                });
            } else if (response["type"] == "reply") {
                let to_user = response["to_user"];
                users.forEach((user) => {
                    htmlString += `<option value="${user["id"]}" ${
                        to_user["id"] == user["id"] ? "selected" : ""
                    }>
					${user["email"]}</option>`;
                });
                $("#title").val("Re: " + response["notification"]["title"]);
                editor.html.set("");
                $("#content").val("");
                editor.events.focus();
            } else {
                // editor.events.focus();
                $(".js-user-tokenizer").focus();
                let to_user = response["to_user"];
                users.forEach((user) => {
                    htmlString += `<option value="${user["id"]}">
					${user["email"]}</option>`;
                });
                $("#title").val("Fwd: " + response["notification"]["title"]);
                editor.html.set(response["notification"]["content"]);
                $("#content").val(response["notification"]["content"]);
            }
            $("#users").html(htmlString);
        },
    });
    // $('.popup-reply-notification').show(300);
    // window.location.href = $(this).attr("href");
});
$(".btn-edit").click(function (e) {
    // e.stopPropagation();
    e.preventDefault();
    $("#btn-send").html('<i class="bi bi-upload"></i> Save');
    $("#btn-send").attr("data-url", notification_save);
    let urlRequest = $(this).attr("href");
    $(".js-user-tokenizer").val([]).trigger("change");
    $.ajax({
        type: "get",
        url: urlRequest,
        success: function (response) {
            $(".popup-reply-notification").show(300);
            let htmlString = '<option value = "" > < /option>';
            let users = response["users"];
            let to_user = response["to_user"];
            let to_userIDs = to_user.map((user) => user.id);
            users.forEach((user) => {
                htmlString += `<option value="${user["id"]}" ${
                    to_userIDs.includes(user["id"]) ? "selected" : ""
                }>
					${user["email"]}</option>`;
            });
            $("#title").val(response["notification"]["title"]);
            editor.html.set(response["notification"]["content"]);
            $("#content").val(response["notification"]["content"]);
            $("#notification-id").val(response["notification"]["id"]);
            $("#users").html(htmlString);
        },
    });
    $(".popup-reply-notification").show(300);
    // window.location.href = $(this).attr("href");
});
$(".reply-notification-icon").click(function (e) {
    e.preventDefault();
    $(".popup-reply-notification").hide(300);
});
$(".js-user-tokenizer").select2({
    placeholder: "Select accounts",
});

$("#btn-send").click(function (e) {
    e.preventDefault();
    let urlRequest = $(this).attr("href");
    let checkUserTo = checkEmpty(
        $("#users"),
        "*User field cannot be left blank.",
        "pn"
    );
    let checkTitle = checkEmpty(
        $("#title"),
        "*Title field cannot be left blank.",
        "pn"
    );
    let checkContent = checkEmpty(
        $("#content"),
        "*Content field cannot be left blank.",
        "pn"
    );
    urlRequest = $(this).data("url");
    if (checkUserTo && checkTitle && checkContent) {
        let data = $("#notification-store").serialize();
        $.ajax({
            type: "POST",
            url: urlRequest,
            data: data,
            success: function (response) {
                $(".popup-reply-notification").hide(300);
                location.reload();
            },
        });
    }
});

$(".action-delete").click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    let urlRequest = $(this).data("url");
    let that = $(this);
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "get",
                url: urlRequest,
                success: function (data) {
                    that.closest(".profile-notification-item").fadeOut(500);
                },
            });
        }
    });
});

// Report;
previewUploadImage($("#image-report01"), $("#img-report01"));
previewUploadImage($("#image-report02"), $("#img-report02"));
previewUploadImage($("#image-report03"), $("#img-report03"));
