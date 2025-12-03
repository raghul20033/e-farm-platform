document.addEventListener("DOMContentLoaded", function() {
  fetch("../backend/get_notifications.php")
    .then(res => res.text())
    .then(data => document.getElementById("notifications").innerHTML = data);

  fetch("../backend/get_transactions.php")
    .then(res => res.text())
    .then(data => document.getElementById("transactions").innerHTML = data);
});
