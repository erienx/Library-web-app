function checkInput(input) {
    if (input.value) {
        input.classList.add('has-content');
    } else {
        input.classList.remove('has-content');
    }
}

document.getElementById('search-icon').addEventListener('click', redirectToSearchResults);
document.getElementById('search').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        redirectToSearchResults();
    }
});

function redirectToSearchResults() {
    const searchValue = document.getElementById('search').value;
    if (searchValue.trim()) {
        window.location.href = `/library/search_results.php?search=${encodeURIComponent(searchValue)}`;
    }
}

function initializeSearchInput() {
    const searchInput = document.getElementById('search');
    if (searchInput) {
        const urlParams = new URLSearchParams(window.location.search);
        const searchQuery = urlParams.get('search');
        if (searchQuery) {
            searchInput.value = searchQuery;
        }
        if (window.location.pathname === '/library/index.php' || window.location.pathname === '/library/') {
            searchInput.value = '';
        }

        checkInput(searchInput);
    }
}

window.addEventListener('DOMContentLoaded', initializeSearchInput);
window.addEventListener('pageshow', initializeSearchInput);
