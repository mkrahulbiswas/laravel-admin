var overlay, swiper = new Swiper(".vertical-swiper", {
        slidesPerView: 2,
        spaceBetween: 10,
        mousewheel: !0,
        loop: !0,
        direction: "vertical",
        autoplay: {
            delay: 2500,
            disableOnInteraction: !1
        }
    }),
    layoutRightSideBtn = document.querySelector(".layout-rightside-btn");
layoutRightSideBtn && (Array.from(document.querySelectorAll(".layout-rightside-btn")).forEach(function (e) {
    var t = document.querySelector(".layout-rightside-col");
    e.addEventListener("click", function () {
        t.classList.contains("d-block") ? (t.classList.remove("d-block"), t.classList.add("d-none")) : (t.classList.remove("d-none"), t.classList.add("d-block"))
    })
}), window.addEventListener("resize", function () {
    var e = document.querySelector(".layout-rightside-col");
    e && Array.from(document.querySelectorAll(".layout-rightside-btn")).forEach(function () {
        window.outerWidth < 1699 || 3440 < window.outerWidth ? e.classList.remove("d-block") : 1699 < window.outerWidth && e.classList.add("d-block")
    }), "semibox" == document.documentElement.getAttribute("data-layout") && (e.classList.remove("d-block"), e.classList.add("d-none"))
}), overlay = document.querySelector(".overlay")) && document.querySelector(".overlay").addEventListener("click", function () {
    1 == document.querySelector(".layout-rightside-col").classList.contains("d-block") && document.querySelector(".layout-rightside-col").classList.remove("d-block")
}), window.addEventListener("load", function () {
    var e = document.querySelector(".layout-rightside-col");
    e && Array.from(document.querySelectorAll(".layout-rightside-btn")).forEach(function () {
        window.outerWidth < 1699 || 3440 < window.outerWidth ? e.classList.remove("d-block") : 1699 < window.outerWidth && e.classList.add("d-block")
    }), "semibox" == document.documentElement.getAttribute("data-layout") && 1699 < window.outerWidth && (e.classList.remove("d-block"), e.classList.add("d-none"))
});
