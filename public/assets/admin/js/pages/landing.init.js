function windowScroll() {
    var e = document.getElementById("navbar");
    e && (50 <= document.body.scrollTop || 50 <= document.documentElement.scrollTop ? e.classList.add("is-sticky") : e.classList.remove("is-sticky"))
}
window.addEventListener("scroll", function (e) {
    e.preventDefault(), windowScroll()
});
const navLinks = document.querySelectorAll(".nav-item"),
    menuToggle = document.getElementById("navbarSupportedContent");
var bsCollapse = "";

function toggleMenu() {
    document.documentElement.clientWidth < 980 ? bsCollapse.toggle() : bsCollapse = ""
}
navLinks && menuToggle && (window.addEventListener("load", function () {
    window.dispatchEvent(new Event("resize"))
}), window.addEventListener("resize", function () {
    var e = document.documentElement.clientWidth;
    bsCollapse = new bootstrap.Collapse(menuToggle, {
        toggle: !1
    }), e < 980 ? Array.from(navLinks).forEach(e => {
        e.addEventListener("click", () => {
            toggleMenu()
        })
    }) : toggleMenu()
}));
var swiper = new Swiper(".trusted-client-slider", {
    spaceBetween: 30,
    loop: "true",
    slidesPerView: 1,
    autoplay: {
        delay: 1e3,
        disableOnInteraction: !1
    },
    breakpoints: {
        576: {
            slidesPerView: 2
        },
        768: {
            slidesPerView: 3
        },
        1024: {
            slidesPerView: 4
        }
    }
});

function check() {
    var n = document.getElementById("plan-switch"),
        e = document.getElementsByClassName("month"),
        t = document.getElementsByClassName("annual"),
        o = 0;
    Array.from(e).forEach(function (e) {
        1 == n.checked ? (t[o].style.display = "block", e.style.display = "none") : 0 == n.checked && (t[o].style.display = "none", e.style.display = "block"), o++
    })
}
check();
swiper = new Swiper(".client-review-swiper", {
    loop: !1,
    autoplay: {
        delay: 2500,
        disableOnInteraction: !1
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev"
    },
    pagination: {
        clickable: !0,
        el: ".swiper-pagination"
    }
});

function counter() {
    var e = document.querySelectorAll(".counter-value");

    function i(e) {
        return e.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }
    e && e && Array.from(e).forEach(function (l) {
        ! function e() {
            var n = +l.getAttribute("data-target"),
                t = +l.innerText,
                o = n / 250;
            o < 1 && (o = 1), t < n ? (l.innerText = (t + o).toFixed(0), setTimeout(e, 1)) : l.innerText = i(n), i(l.innerText)
        }()
    })
}
counter();
var mybutton = document.getElementById("back-to-top");

function scrollFunction() {
    100 < document.body.scrollTop || 100 < document.documentElement.scrollTop ? mybutton.style.display = "block" : mybutton.style.display = "none"
}

function topFunction() {
    document.body.scrollTop = 0, document.documentElement.scrollTop = 0
}
window.onscroll = function () {
    scrollFunction()
};
