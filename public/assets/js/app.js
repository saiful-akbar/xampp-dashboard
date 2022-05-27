const handleDelete = (href) => {
  const confirmation = confirm('Are you sure you want to delete this data?');

  if (confirmation) {
    window.location.href = href;
  }
}

(function() {
  [...document.querySelectorAll('[data-bs-toggle="tooltip"]')].map(el => new bootstrap.Tooltip(el));
})();

