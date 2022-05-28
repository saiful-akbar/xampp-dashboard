import "../vendor/jquery/jquery-3.6.0.min.js";
import "../vendor/bootstrap/js/bootstrap.bundle.min.js";

(function () {
  [...document.querySelectorAll('[data-bs-toggle="tooltip"]')].map(
    (el) => new bootstrap.Tooltip(el)
  );
})();
