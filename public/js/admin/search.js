$("#nav-search").submit(function (e) {
    e.preventDefault();
});

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

$(".search-result-popup").outerWidth($("#nav-search").outerWidth());
$(".search-result-popup").offset({
    left: $("#nav-search").offset().left,
    top: $(".navs").outerHeight(true),
});

$("#search-item").keyup(
    debounce(function (e) {
        $(".search-result-popup").fadeIn(300);
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
                        htmlResult += `<a class="search-result-item-popup" href="/admin/${item["field"]}/edit?id=${item["id"]}">
																	<i class="bi bi-search"></i> ${result}
																</a > `;
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
        $(".search-result-popup").fadeOut(300);
        $(".search-result-popup").removeClass("show-search-popup");
        $(this).val("");
    }, 300);
});

// Debounce
function debounce(func, wait, immediate) {
    var timeout;
    return function executedFunction() {
        var context = this;
        var args = arguments;
        var later = function () {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

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
