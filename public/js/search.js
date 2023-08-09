import { reloadPage } from "./utilities.js";

// Lưu giữ giá trị scroll
reloadPage();

$("#clear-filter").click(function (e) {
    e.preventDefault();
    let keyword = $("#keyword").val();
    let url = "search?keyword=" + keyword;
    $("[type=radio]").prop("checked", false);
    window.open(url, "_self");
});

$("#filter").change(function (e) {
    e.preventDefault();
    var form = $(this);
    var actionUrl = form.attr("action");
    getHtmlResult(actionUrl);
});

function getHtmlResult(actionUrl) {
    let keyword = $("#keyword").val();
    let sort_by = $('[name="sort_by"]:checked').val();
    let star = $('[name="star"]:checked').val();
    let page = $("#page").val();
    let data = {
        keyword: keyword,
        sort_by: sort_by,
        star: star,
        page: page,
    };
    // thay đổi URL hiển thị trong thanh địa chỉ
    history.pushState(null, "", getUrlDisplay());
    $.ajax({
        type: "get",
        url: actionUrl,
        data: data,
        success: function (response) {
            let htmlResult = "";
            response.forEach((course) => {
                htmlResult += `<a class="search-result-item" href="/course/${
                    course["slug"]
                }">
												<div class="search-result-img">
													<img src="${course["thumbnail"]} " alt="">
												</div>
												<div class="search-result-wrapper">
													<div class="search-result-info">
														<div class="search-result-name">${course["name"]}</div>
														<div class="search-result-desc">${course["description"]}</div>
														<div class="course-teacher-name">${course["teacher_name"]}</div>
														<div class="course-students-count">
															<i class="bi bi-people-fill"></i>
															<span>${course["students"]}</span>
														</div>
														<div class="search-result-star">
															<span>${course["star"]}</span>
															<span class="course-star">
																<i class="bi bi-star-fill"></i>
															</span>
															<span>(${course["number_reviews"]})</span>
														</div>
														<div class="search-result-time">
															<span>04 hours total</span><i class="bi bi-dot"></i>
															<span>Update ${course["updated_at"].split("T")[0]}</span>
														</div>
													</div>
													<div class="search-result-price">
														<div>${course["discount"]}$</div>
														<div>${course["price"]}$</div>
													</div>
												</div>
											</a>`;
            });
            $(".search-result-display").html(htmlResult);
        },
    });
}

function getUrlDisplay() {
    let actionUrl = "";
    let keyword = $("#keyword").val();
    let sort_by = $('[name="sort_by"]:checked').val();
    let star = $('[name="star"]:checked').val();
    let page = $("#page").val();
    keyword = "&keyword=" + keyword;
    sort_by ? (sort_by = "&sort_by=" + sort_by) : (sort_by = "");
    star ? (star = "&star=" + star) : (star = "");
    page ? (page = "&page=" + page) : (page = "");
    actionUrl += "?sort=true" + keyword + sort_by + star + page;
    return actionUrl;
}

// Load tại vị trí mới
$("#view-more").click(function (e) {
    e.preventDefault();
    let nextPage = parseInt($("#page").val()) + 1;
    if (nextPage * 5 > count) {
        $(this).html("That's all");
        return;
    }
    $("#page").val(nextPage);
    var actionUrl = $("#filter").attr("action");
    getHtmlResult(actionUrl);
});

// Show hide filter menu
// Show Hide Menu When Click
var deg = 0;
var searchItems = document.querySelectorAll(".search-item-title");
searchItems.forEach((item) => {
    item.nextElementSibling.classList.add("search-item-hide");
    item.addEventListener("click", function () {
        item.nextElementSibling.classList.toggle("search-item-hide");
        item.nextElementSibling.classList.toggle("search-item-show");
        if (item.lastElementChild.classList.contains("rotate")) {
            item.lastElementChild.style.animation = "none";
            item.lastElementChild.style.animation =
                "rotate-left 0.1s ease-in-out both";
        } else {
            item.lastElementChild.style.animation = "none";
            item.lastElementChild.style.animation =
                "rotate-right 0.1s ease-in-out both";
        }
        if (deg == 0) deg = 180;
        if (deg == 180) deg = 0;
        item.lastElementChild.classList.toggle("rotate");
    });
});
