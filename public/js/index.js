import { debounce } from "./utilities.js";

// Slide picture
var slideImgWrapper = $(".slide-imgs");
var slideImgs = $(".slide-img");
var slideDots = $(".slide-dots span");
var sliderImgWidth = slideImgs.eq(0).outerWidth();
var currentIndex = 0;
var newIndex = 0;

slideDots.each(function (index, item) {
    $(item).on(
        "click",
        debounce(
            function (e) {
                newIndex = index;
                if (newIndex === currentIndex) return;
                showSlide(currentIndex, newIndex);
                currentIndex = newIndex;
            },
            500,
            true
        )
    );
});

setInterval(function () {
    if (currentIndex == slideImgs.length - 1) {
        showSlide(currentIndex, 0);
        currentIndex = 0;
    } else {
        showSlide(currentIndex, currentIndex + 1);
        currentIndex++;
    }
}, 5000);

function showSlide(index1, index2) {
    if (index2 > index1) {
        slideImgWrapper.html("");
        slideImgWrapper.append(slideImgs[index1]);
        slideImgWrapper.append(slideImgs[index2]);
        slideImgWrapper.css(
            "transform",
            "translateX(-" + sliderImgWidth + "px)"
        );
        setTimeout(function () {
            slideImgWrapper.css("transition", "unset");
            addLastChild(slideImgWrapper);
            slideImgWrapper.css("transform", "translateX(0)");
        }, 500);
        slideImgWrapper.css("transition", "0.5s");
    }
    if (index2 < index1) {
        slideImgWrapper.html("");
        slideImgWrapper.append(slideImgs[index2]);
        slideImgWrapper.append(slideImgs[index1]);
        slideImgWrapper.css("transition", "unset");
        slideImgWrapper.css(
            "transform",
            "translateX(-" + sliderImgWidth + "px)"
        );
        setTimeout(function () {
            slideImgWrapper.css("transition", "0.5s");
            slideImgWrapper.css("transform", "translateX(0)");
        }, 500);
    }
    var dotCurrent = $(".dot-active");
    dotCurrent.removeClass("dot-active");
    slideDots.eq(index2).addClass("dot-active");
}

var teacherBox = $(".hot-teacher");
var btnPre = $(".teacher-pre");
var btnNext = $(".teacher-next");

// Slide Teacher
teacherBox.on(
    "click",
    debounce(
        function (e) {
            var teacherItem = $(".teacher-item");
            var teacherItemWidth =
                teacherItem.eq(1).offset().left -
                teacherItem.eq(0).offset().left;
            var teacherWrapper = $(".teacher-wrapper");
            if (e.target.matches(".teacher-next")) {
                teacherWrapper.css(
                    "transform",
                    "translateX(-" + teacherItemWidth + "px)"
                );
                setTimeout(function () {
                    teacherWrapper.css("transition", "unset");
                    addLastChild(teacherWrapper);
                    teacherWrapper.css("transform", "translateX(0)");
                }, 300);
                teacherWrapper.css("transition", "0.3s");
            }

            if (e.target.matches(".teacher-pre")) {
                teacherWrapper.css("transition", "unset");
                addFirstChild(teacherWrapper);
                teacherWrapper.css(
                    "transform",
                    "translateX(-" + teacherItemWidth + "px)"
                );
                setTimeout(function () {
                    teacherWrapper.css("transition", "0.3s");
                    teacherWrapper.css("transform", "translateX(0)");
                }, 300);
            }
        },
        300,
        true
    )
);

function addLastChild(slideList) {
    var firstChild = slideList.children().first();
    slideList.append(firstChild);
}

function addFirstChild(slideList) {
    var lastChild = slideList.children().last();
    slideList.prepend(lastChild);
}

// Trending Item
var trendingItem = $(".trending-item");
var trendingItemColumn = $(".trending-item-wrapper-column");
var trendingItemInnerWidth = trendingItem.outerWidth() - 20;
trendingItemColumn.each(function () {
    $(this).css("width", trendingItemInnerWidth + "px");
});

// Mới ra mắt
var trendingDotsNewCourse = $(".new-course .trending-dots span");
trendingDotsNewCourse.each(function (index, item) {
    $(item).on("click", function () {
        var trendingDotNewCourseActive = $(".new-course .dot-active");
        trendingDotNewCourseActive.removeClass("dot-active");
        $(item)
            .parent()
            .prev()
            .css(
                "transform",
                "translateX(" + index * (-trendingItemInnerWidth - 20) + "px)"
            );
        $(item).addClass("dot-active");
    });
});

// Học nhiều
var trendingDotsNewCourse = $(".most-student .trending-dots span");
trendingDotsNewCourse.each(function (index, item) {
    $(item).on("click", function () {
        var trendingDotNewCourseActive = $(".most-student .dot-active");
        trendingDotNewCourseActive.removeClass("dot-active");
        $(item)
            .parent()
            .prev()
            .css(
                "transform",
                "translateX(" + index * (-trendingItemInnerWidth - 20) + "px)"
            );
        $(item).addClass("dot-active");
    });
});

// Khoá học VIP
var trendingDotsNewCourse = $(".vip-course .trending-dots span");
trendingDotsNewCourse.each(function (index, item) {
    $(item).on("click", function () {
        var trendingDotNewCourseActive = $(".vip-course .dot-active");
        trendingDotNewCourseActive.removeClass("dot-active");
        $(item)
            .parent()
            .prev()
            .css(
                "transform",
                "translateX(" + index * (-trendingItemInnerWidth - 20) + "px)"
            );
        $(item).addClass("dot-active");
    });
});
