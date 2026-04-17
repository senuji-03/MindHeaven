/* Shared CSS for Moderate Forum Module Header and Tabs */
.main-content { margin-left: 280px; width: calc(100% - 280px); flex: 1; display: flex; flex-direction: column; min-height: 100vh; background: #F5F0E8; }

.topbar {
    background: white;
    padding: 1.5rem 2rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e2e8f0;
}

.topbar h1 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1e293b;
}

.content-wrapper {
    padding: 2rem;
}

.toolbar {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    margin-bottom: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.tabs {
    display: flex;
    gap: 0.5rem;
}

.tab {
    padding: 0.75rem 1.5rem;
    border: none;
    background: #f1f5f9;
    color: #64748b;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
}

.tab.active {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white !important;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.tab:hover:not(.active) {
    background: #e2e8f0;
    color: #475569;
}
