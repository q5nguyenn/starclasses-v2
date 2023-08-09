$(document).ready(function () {
    $(".tb-row").click(function (e) {
        let urlRequest = $(this).data("url");
        if (typeof urlRequest == "undefined") {
            return;
        } else {
            window.location = $(this).data("url");
        }
    });

    $(".tb-row")
        .mouseenter(function () {
            $(this)
                .find(".action-delete")
                .removeClass("invisible")
                .addClass("visible");
        })
        .mouseleave(function () {
            $(this)
                .find(".action-delete")
                .removeClass("visible")
                .addClass("invisible");
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
                    success: function (response) {
                        if (response["status"] == 1) {
                            that.parent().parent().fadeOut(500);
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: response["message"],
                                // footer: '<a href="">Why do I have this issue?</a>',
                            });
                        }
                    },
                });
            }
        });
    });
});
