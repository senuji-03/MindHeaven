/**
 * Forum Index Page Scripts
 * Handles search interactions, filtering, and role-based UI adjustments.
 */

document.addEventListener('DOMContentLoaded', () => {
    initFilters();
    initSearch();
});

/**
 * Initialize Filter Buttons
 */
function initFilters() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            btn.classList.add('active');
            
            const filterType = btn.dataset.filter;
            console.log(`Filter selected: ${filterType}`);
            // In a real app, this would trigger an AJAX call or filter the list
        });
    });
}

/**
 * Initialize Search functionality
 */
function initSearch() {
    const searchInput = document.getElementById('threadSearch');
    
    if(searchInput) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            // Mock client-side filtering for demo purposes
            const threads = document.querySelectorAll('.thread-card');
            
            threads.forEach(thread => {
                const title = thread.querySelector('.thread-title').textContent.toLowerCase();
                if(title.includes(query)) {
                    thread.style.display = 'flex';
                } else {
                    thread.style.display = 'none';
                }
            });
        });
    }
}
