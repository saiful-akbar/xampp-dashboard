/**
 * Handle delete
 * 
 * @param {string} href
 * 
 * @return void
 */
const handleDelete = (href) => {
  const confirmation = confirm('Are you sure you want to delete this data?');

  if (confirmation) {
    window.location.href = href;
  }
}
