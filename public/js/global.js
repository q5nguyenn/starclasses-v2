import { debounce } from "./utilities.js";

$("#signout").click(handleSignOut);
$("#signout-mobile").click(handleSignOut);
function handleSignOut(e) {
    e.preventDefault();
    $.ajax({
        type: "get",
        url: "http://127.0.0.1:8000/logout",
        success: function (response) {
            $(".loading").css("display", "flex");
            setTimeout(() => {
                $(".loading").css("display", "flex");
                window.open("http://127.0.0.1:8000/", "_self");
            }, 500);
        },
    });
}

//Scroll Auto hide menu Nav
var lastScrollTop = 0;
$(window).scroll(function () {
    var heightNav = $(".navs").outerHeight(true);
    var st = $(this).scrollTop();
    if (st > lastScrollTop) {
        $(".navs").addClass("navs-hide");
        $(".navs").removeClass("navs-show");
    }
    if (st < lastScrollTop) {
        $(".navs").removeClass("navs-hide");
        $(".navs").addClass("navs-show");
    }
    lastScrollTop = st;
});

//Show hide Categories
$(".tab-item").hover(
    debounce(function (e) {
        e.preventDefault();
        let faculty = $(this).attr("data-faculty");
        $("img").attr("width", "500");
        $(".tab-item-inner").addClass("tab-hide");
        $(".tab-item-inner").removeClass("tab-show");
        $(`[data-faculty-parent=${faculty}]`).addClass("tab-show");
        $(`[data-faculty-parent=${faculty}]`).removeClass("tab-hide");
    }, 300),
    function () {}
);
$(".nav-menu").hover(
    function () {},
    function () {
        $(".tab-item-inner").addClass("tab-hide");
        $(".tab-item-inner").removeClass("tab-show");
    }
);

// Thiết lập vị trí ô tìm kiếm
$(".search-result-popup").outerWidth($("#nav-search").outerWidth());
$(".search-result-popup").offset({
    left: $("#nav-search").offset().left,
    top: $(".navs").outerHeight(true),
});

$("#search-item").keyup(
    debounce(function () {
        let value = $(this).val();
        let urlRequest = route_search + "?keyword=" + value;
        let htmlResult = "";
        if ($.trim(value) == "") {
            $(".search-result-popup").removeClass("show-search-popup");
        } else {
            $.ajax({
                type: "get",
                url: urlRequest,
                success: function (response) {
                    htmlResult = "";
                    if (response.length == 0) {
                        htmlResult = `<i class="bi bi-clipboard-x"></i> No results found!`;
                    } else htmlResult = "";
                    response.forEach((item) => {
                        let result = hightlight(item["name"], value);
                        if (item["field"] == "course") {
                            htmlResult += `<a class="search-result-item-popup" href="/course/${item["slug"]}">
																	<i class="bi bi-search"></i> ${result}
																</a > `;
                        } else {
                            htmlResult += `<a class="search-result-item-popup" href="/teacher/${item["slug"]}">
																	<i class="bi bi-search"></i> ${result}
																</a > `;
                        }
                    });
                    $(".search-result-popup").html(htmlResult);
                    $(".search-result-popup").addClass("show-search-popup");
                },
            });
        }
    }, 300)
);

$("#search-item").blur(function (e) {
    setTimeout(() => {
        $(".search-result-popup").removeClass("show-search-popup");
        $(this).val("");
    }, 300);
});
// $(".search-box").focusout(function () {
// 	$(this).val('');
// 	$(".search-result-popup").hide();
// });

// Hight ligh string
function hightlight(str, keyword) {
    let index = str.toLowerCase().indexOf(keyword.toLowerCase());
    let string1 = str.slice(0, index);
    let string2 = str.slice(index, index + keyword.length);
    let string3 = str.slice(index + keyword.length);
    return `${string1}<b>${string2}</b>${string3}`;
}

// Loading giả
function loading() {
    $(".loading").css("display", "flex");
    setTimeout(() => {
        $(".loading").css("display", "flex");
    }, 500);
}

//Online Users Count
setInterval(() => {
    let fake_number = Math.floor(Math.random() * 100) + 900;
    let urlRequest = $(".count-online-value").data("url");
    $.ajax({
        type: "get",
        url: urlRequest,
        success: function (response) {
            let onlineUsersCount = parseInt(response);
            $(".count-online-value").html(onlineUsersCount + fake_number);
        },
    });
}, 5000);

// Popup new student
let lastIntervalRun = 0;
setInterval(() => {
    let currentTime = Date.now();
    let popup = $(".new-student");
    let urlRequest = popup.data("url");
    if (currentTime - lastIntervalRun >= 10000) {
        lastIntervalRun = currentTime;
        $.ajax({
            type: "get",
            url: urlRequest,
            success: function (response) {
                if (response["status"] == -1) return;
                popup.attr(
                    "href",
                    "http://127.0.0.1:8000/course/" + response["course_slug"]
                );
                $(".new-student-thumbnail").attr(
                    "src",
                    response["user_thumbnail"]
                );
                $(".new-student-name").html(response["user_name"]);
                $(".new-student-thumbnail").html(response["user_thumbnail"]);
                $(".new-teacher-name").html(response["teacher_name"]);
                $(".new-course-name").html(response["course_name"]);
            },
        });
    }

    popup.animate({ left: "25px" });
    setTimeout(() => {
        popup.animate({ left: "-1000px" });
    }, 3000);
}, 10000);

// Chat app
$(".chat-icon").click(function (e) {
    showHideBoxChat();
});
$(".box-minimize").click(function (e) {
    showHideBoxChat();
});

$(".box-chat-button").click(function (e) {
    e.preventDefault();
    $(this).css("display", "none");
    $(".guest-input").css("display", "flex");
    $(".box-chat-content-intro").hide();
    let urlRequest = $(this).data("url");
    $.ajax({
        type: "get",
        url: urlRequest,
        success: function (response) {
            let employee = response["employee"];
            if (response["newEmployee"]) {
                loadingHello(employee);
                loadingChat();
            }
        },
    });
});

$(".guest-input").submit(function (e) {
    $(".box-chat-content").scrollTop($(".box-chat-content")[0].scrollHeight);
    e.preventDefault();
    let content = $("#message-content").val().trim();
    $("#message-content").val("");
    if (content !== "") {
        $(".box-chat-content").append(
            `<div class="guest-chat"><span>${content}</span></div>`
        );
    }
    let urlRequest = $(this).data("url");
    let data = {
        content: content,
    };
    $.ajax({
        type: "get",
        url: urlRequest,
        data: data,
        success: function (response) {
            $(".box-chat-content").scrollTop(
                $(".box-chat-content")[0].scrollHeight
            );
        },
    });
});

//Loading chat
function showHideBoxChat() {
    $(".box-chat").toggleClass("box-show box-hide");
    console.log(hasConversation);
    if ($(".box-chat").hasClass("box-show") && hasConversation) {
        loadingChat();
        setTimeout(() => {
            $(".box-chat-content").scrollTop(
                $(".box-chat-content")[0].scrollHeight
            );
        }, 1000);
    } else {
        clearInterval(reloadChat);
    }
}

function loadingHello(employee) {
    watting(employee);
    setTimeout(() => {
        $(".box-chat-content").html(`<div class="admin-chat">
				<div class="admin-chat-avatar">
					<img src="${employee["thumbnail"]}" alt="">
				</div>
				<div class="admin-chat-content">
					Hello! My name is ${employee["name"]}. Can I help you?
				</div>
			</div>`);
    }, 1000);
}

function watting(employee) {
    $(".box-chat-content").append(`<div class="admin-chat loading-chat-temp">
																		<div class="admin-chat-avatar">
																			<img src="${employee["thumbnail"]}" alt="">
																		</div>
																		<div class="admin-chat-content">
																			<div class="loading-chat">
																			<div>
																			<span></span>
																			<span></span>
																			<span></span>
																			</div>
																			</div>
																		</div>
																	</div>`);
    $(".box-chat-content").scrollTop($(".box-chat-content")[0].scrollHeight);
    setTimeout(() => {
        $(".loading-chat-temp").remove();
    }, 1000);
}

let reloadChat;
function loadingChat() {
    $(".box-chat-button").css("display", "none");
    $(".guest-input").css("display", "flex");
    $(".box-chat-content-intro").hide();
    reloadChat = setInterval(() => {
        getAllMessage();
    }, 1000);
}

function getAllMessage() {
    $.ajax({
        type: "get",
        url: get_message,
        success: function (response) {
            let newMessage = response["newMessage"];
            let messsages = response["messages"];
            let employee = response["employee"];
            let htmlString = "";
            messsages.forEach((message) => {
                if (message["sender"] == employee["unique_id"]) {
                    htmlString += `<div class="admin-chat">
																<div class="admin-chat-avatar">
																	<img src="${employee["thumbnail"]}" alt="">
																</div>
																<div class="admin-chat-content">
																${message["content"]}
																</div>
															</div>`;
                } else {
                    htmlString += `<div class="guest-chat"><span>${message["content"]}</span></div>`;
                }
            });
            if (newMessage > 0) {
                watting(employee);
                setTimeout(() => {
                    $(".box-chat-content").html(htmlString);
                }, 1000);
            } else {
                $(".box-chat-content").html(htmlString);
            }
        },
    });
}
