! function () {
    "use strict";
    window.addEventListener("load", function () {
        var t = document.getElementsByClassName("needs-validation");
        t && Array.prototype.filter.call(t, function (e) {
            e.addEventListener("submit", function (t) {
                !1 === e.checkValidity() && (t.preventDefault(), t.stopPropagation()), e.classList.add("was-validated")
            }, !1)
        })
    }, !1)
}();
