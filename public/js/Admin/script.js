function viewReport(userId) {
  alert("Viewing mental assessment report for " + userId);
}

function like(id) {
  let count = document.getElementById(id);
  count.textContent = parseInt(count.textContent) + 1;
}

function dislike(id) {
  let count = document.getElementById(id);
  count.textContent = parseInt(count.textContent) + 1;
}
