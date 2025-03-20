const adminBtn = document.getElementById('admin-btn');
const dropdown = document.getElementById('admin-dropdown');

adminBtn.addEventListener('click', function (event) {
    event.stopPropagation();
    dropdown.classList.toggle('show');
});

window.addEventListener('click', function () {
    if (dropdown.classList.contains('show')) {
        dropdown.classList.remove('show');
    }
});
