/* Shared CSS for Moderate Forum Module Header and Tabs */

.toolbar {
    background: var(--surface);
    padding: 1.25rem 1.5rem;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    margin-bottom: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    border: 1px solid var(--border);
}

.tabs {
    display: flex;
    gap: 0.5rem;
}

.tab {
    padding: 0.6rem 1.25rem;
    border: 1.5px solid var(--border);
    background: var(--surface);
    color: var(--text-secondary);
    border-radius: var(--radius-full);
    cursor: pointer;
    transition: all 0.25s ease;
    font-weight: 500;
    font-size: 0.9rem;
    text-decoration: none;
    display: inline-block;
}

.tab.active,
.tab:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    box-shadow: 0 4px 12px rgba(61, 139, 110, 0.25);
}
