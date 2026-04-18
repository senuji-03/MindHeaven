/**
 * JOURNALING COMPONENT (Backend Integrated)
 * Handles server-side CRUD and UI interactions for the Journal feature.
 */

class JournalApp {
    constructor() {
        this.entries = this.initData();
        this.isEditing = false;
        this.currentMood = 'neutral';
        this.selectedTags = [];
        this.baseUrl = '/MindHeaven/public/ug/journal';
        
        // Narrative Labels mapping
        this.tagLabels = {
            'stress': 'Processing a Challenge',
            'exams': 'Academic Focus',
            'relationships': 'Social Connection',
            'health': 'Body & Mind',
            'social': 'Shared Moment',
            'other': 'General reflection'
        };

        // Cache DOM elements
        this.listElement = document.getElementById('journalEntriesList');
        this.modal = document.getElementById('journalModal');
        this.form = document.getElementById('journalForm');
        this.newBtn = document.getElementById('newEntryBtn');
        this.closeBtn = document.getElementById('closeEditorBtn');
        this.moodBtns = document.querySelectorAll('.m-pill');
        this.tagBtns = document.querySelectorAll('#categoryTags .tag');
        
        this.searchField = document.getElementById('journalSearch');
        this.topicFilter = document.getElementById('categoryFilter');
        this.deleteBtn = document.getElementById('deleteEntryBtn');
        
        this.init();
    }

    initData() {
        // Load from window variable injected by PHP
        const raw = window.INITIAL_JOURNAL_ENTRIES || [];
        return raw.map(e => ({
            ...e,
            id: parseInt(e.id),
            // Convert comma-separated string from DB back to array for JS
            category_tags: e.category_tags ? e.category_tags.split(',') : []
        }));
    }

    init() {
        // Event Listeners
        this.newBtn.addEventListener('click', () => this.openEditor());
        this.closeBtn.addEventListener('click', () => this.closeEditor());
        
        this.moodBtns.forEach(btn => {
            btn.addEventListener('click', (e) => this.selectMood(e.currentTarget.dataset.mood));
        });

        this.tagBtns.forEach(btn => {
            btn.addEventListener('click', (e) => this.toggleTag(e.currentTarget));
        });
        
        this.form.addEventListener('submit', (e) => this.handleSave(e));
        
        this.searchField.addEventListener('input', () => this.render());
        this.topicFilter.addEventListener('change', () => this.render());
        
        this.deleteBtn.addEventListener('click', () => this.handleDelete());

        // Keyboard support
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modal.classList.contains('open')) {
                this.closeEditor();
            }
        });

        // Click outside modal
        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) this.closeEditor();
        });

        // Word count
        document.getElementById('entryContent').addEventListener('input', (e) => {
            this.updateWordCount(e.target.value);
        });

        this.render();
        this.updateStats();
    }

    render() {
        const query = this.searchField.value.toLowerCase();
        const tFilter = this.topicFilter.value;
        
        let filtered = [...this.entries].sort((a, b) => new Date(b.created_at || b.date) - new Date(a.created_at || a.date));

        // Text Search
        if (query) {
            filtered = filtered.filter(e => 
                e.title.toLowerCase().includes(query) || 
                e.content.toLowerCase().includes(query)
            );
        }

        // Energy/Mood Filter (Simplified to Mood only if needed, but UI is removed for now)
        // Topic/Category Filter
        if (tFilter !== 'all') {
            filtered = filtered.filter(e => e.category_tags && e.category_tags.includes(tFilter));
        }

        if (filtered.length === 0) {
            this.listElement.innerHTML = `
                <div class="empty-state" style="padding: 40px; text-align: center;">
                    <div class="empty-icon" style="font-size: 3rem; opacity: 0.2; margin-bottom: 20px;"><i class="fas fa-feather-alt"></i></div>
                    <h2 style="font-size: 1.2rem; color: var(--text-secondary);">Silence is the canvas...</h2>
                    <p style="font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 20px;">Your first entry is waiting to be written.</p>
                    <button class="btn btn--primary" onclick="window.journalApp.openEditor()">Start Journaling</button>
                </div>
            `;
            return;
        }

        this.listElement.innerHTML = filtered.map(entry => this.createEntryHTML(entry)).join('');
        
        // Attach click listeners to cards
        this.listElement.querySelectorAll('.entry-card').forEach(card => {
            card.addEventListener('click', () => this.openEditor(parseInt(card.dataset.id)));
        });
    }

    createEntryHTML(entry) {
        const dateObj = new Date(entry.created_at || entry.date);
        const dateStr = dateObj.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        const timeStr = dateObj.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        const emoji = this.getEmojiForMood(entry.mood_tag || entry.mood);
        
        const tagsHTML = (entry.category_tags || []).map(tag => {
            const label = this.tagLabels[tag] || tag;
            return `<span class="tag-badge" data-tag="${tag}">${label}</span>`;
        }).join('');
        
        return `
            <div class="entry-card" data-id="${entry.id}">
                <div class="entry-mood-emoji">${emoji}</div>
                <div class="entry-info">
                    <h3 class="entry-title">${this.escapeHTML(entry.title)}</h3>
                    <p class="entry-excerpt">${this.escapeHTML(entry.content)}</p>
                    <div class="entry-tags">
                        ${tagsHTML}
                    </div>
                </div>
                <div class="entry-date-text">
                    ${dateStr}<br>${timeStr}
                </div>
            </div>
        `;
    }

    getEmojiForMood(mood) {
        const map = {
            'ecstatic': '🤩', 'happy': '😊', 'calm': '😌', 
            'neutral': '😐', 'tired': '😴', 'sad': '😔', 'anxious': '😰'
        };
        return map[mood] || '😐';
    }

    toggleTag(element) {
        element.classList.toggle('on');
        const tag = element.dataset.tag;
        if (element.classList.contains('on')) {
            if (!this.selectedTags.includes(tag)) this.selectedTags.push(tag);
        } else {
            this.selectedTags = this.selectedTags.filter(t => t !== tag);
        }
    }

    openEditor(id = null) {
        this.form.reset();
        this.isEditing = !!id;
        this.modal.classList.add('open');
        this.deleteBtn.classList.toggle('hide', !this.isEditing);
        this.selectedTags = [];
        this.tagBtns.forEach(btn => btn.classList.remove('on'));
        
        if (this.isEditing) {
            const entry = this.entries.find(e => e.id === id);
            if (!entry) return;
            
            document.getElementById('entryId').value = entry.id;
            document.getElementById('entryTitle').value = entry.title;
            document.getElementById('entryContent').value = entry.content;
            document.getElementById('entryGratitude').value = entry.gratitude || '';
            document.getElementById('entryHighlight').value = entry.highlight || '';
            document.getElementById('editorDate').textContent = new Date(entry.created_at || entry.date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
            
            this.selectMood(entry.mood_tag || entry.mood);
            this.selectedTags = entry.category_tags || [];
            this.tagBtns.forEach(btn => {
                if (this.selectedTags.includes(btn.dataset.tag)) btn.classList.add('on');
            });

            this.updateWordCount(entry.content);
        } else {
            document.getElementById('entryId').value = '';
            document.getElementById('editorDate').textContent = new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
            this.selectMood('neutral');
            this.updateWordCount('');
        }
        
        document.getElementById('entryTitle').focus();
    }

    closeEditor() {
        this.modal.classList.remove('open');
    }

    selectMood(mood) {
        this.currentMood = mood;
        this.moodBtns.forEach(btn => {
            btn.classList.toggle('sel', btn.dataset.mood === mood);
        });
    }

    updateWordCount(text) {
        const count = text.split(/\s+/).filter(word => word.length > 0).length;
        document.getElementById('wordCount').textContent = `${count} words`;
    }

    async handleSave(e) {
        e.preventDefault();
        
        const saveBtn = this.form.querySelector('button[type="submit"]');
        const originalText = saveBtn.textContent;
        saveBtn.disabled = true;
        saveBtn.textContent = 'Saving...';

        const id = document.getElementById('entryId').value;
        const formData = new FormData();
        if (id) formData.append('id', id);
        formData.append('title', document.getElementById('entryTitle').value);
        formData.append('content', document.getElementById('entryContent').value);
        formData.append('mood_tag', this.currentMood);
        formData.append('category_tags', this.selectedTags.join(','));
        formData.append('gratitude', document.getElementById('entryGratitude').value);
        formData.append('highlight', document.getElementById('entryHighlight').value);

        try {
            const response = await fetch(`${this.baseUrl}/save`, {
                method: 'POST',
                body: formData
            });

            // Handle non-OK responses
            if (!response.ok) {
                const errorText = await response.text();
                console.error('Server Error:', errorText);
                throw new Error(errorText || `Server returned ${response.status}`);
            }

            const result = await response.json();
            
            if (result.status === 'success') {
                const entryData = {
                    id: result.id,
                    title: formData.get('title'),
                    content: formData.get('content'),
                    mood_tag: formData.get('mood_tag'),
                    category_tags: this.selectedTags,
                    gratitude: formData.get('gratitude'),
                    highlight: formData.get('highlight'),
                    created_at: id ? this.entries.find(e => e.id === parseInt(id)).created_at : new Date().toISOString()
                };

                if (this.isEditing) {
                    const index = this.entries.findIndex(e => e.id === parseInt(id));
                    if (index !== -1) this.entries[index] = entryData;
                } else {
                    this.entries.push(entryData);
                }

                this.render();
                this.updateStats();
                this.closeEditor();
            } else {
                alert('Save failed: ' + result.message);
            }
        } catch (error) {
            console.error('Error saving journal:', error);
            alert('A network error occurred. Please check your browser console (F12) for details.');
        } finally {
            saveBtn.disabled = false;
            saveBtn.textContent = originalText;
        }
    }

    async handleDelete() {
        const id = parseInt(document.getElementById('entryId').value);
        if (!confirm('Are you sure? This reflection will be lost forever.')) return;

        const formData = new FormData();
        formData.append('id', id);

        try {
            const response = await fetch(`${this.baseUrl}/delete`, {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                const errorText = await response.text();
                console.error('Server Error:', errorText);
                throw new Error(errorText || `Server returned ${response.status}`);
            }

            const result = await response.json();

            if (result.status === 'success') {
                this.entries = this.entries.filter(e => e.id !== id);
                this.render();
                this.updateStats();
                this.closeEditor();
            } else {
                alert('Delete failed: ' + result.message);
            }
        } catch (error) {
            console.error('Error deleting journal:', error);
            alert('A network error occurred. Check console for details.');
        }
    }

    updateStats() {
        document.getElementById('totalEntriesCount').textContent = this.entries.length;
        const streak = this.calculateStreak();
        document.getElementById('currentStreak').textContent = streak;
    }

    calculateStreak() {
        if (this.entries.length === 0) return 0;
        const dates = this.entries.map(e => new Date(e.created_at || e.date).toDateString());
        const uniqueDates = [...new Set(dates)].sort((a, b) => new Date(b) - new Date(a));
        let streak = 0;
        let today = new Date();
        today.setHours(0,0,0,0);
        let checkDate = new Date(uniqueDates[0]);
        if (Math.floor((today - checkDate) / 86400000) > 1) return 0;
        for (let i = 0; i < uniqueDates.length; i++) {
            if (i === 0) { streak++; continue; }
            let diff = Math.floor((new Date(uniqueDates[i-1]) - new Date(uniqueDates[i])) / 86400000);
            if (diff === 1) streak++; else break;
        }
        return streak;
    }

    capitalize(s) { return s.charAt(0).toUpperCase() + s.slice(1); }
    escapeHTML(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    window.journalApp = new JournalApp();
});
