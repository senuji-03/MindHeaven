/* ============================================================
   Counselor Profile — JavaScript
   Handles: Edit Profile Modal, Photo Upload
   ============================================================ */

// ── Modal State ──────────────────────────────────────────────
let activeTab = 'personal';
let isSaving  = false;

// ── Open / Close Edit Modal ──────────────────────────────────
function openEditModal() {
    // Populate Personal tab
    document.getElementById('edit_full_name').value = PROFILE_DATA.full_name || '';
    document.getElementById('edit_phone').value      = PROFILE_DATA.phone     || '';

    // Populate Professional tab
    document.getElementById('edit_spec').value = PROFILE_DATA.spec || '';
    document.getElementById('edit_exp').value  = PROFILE_DATA.exp  || '';
    document.getElementById('edit_bio').value  = PROFILE_DATA.bio  || '';

    // Populate Qualifications tab
    renderQualificationRows(PROFILE_DATA.qualifications || []);

    // Reset to first tab
    switchTab('personal');

    // Clear any old messages
    setModalMessage('', '');

    // Show modal
    const modal = document.getElementById('editProfileModal');
    modal.style.display = 'flex';
    // Small delay so CSS flex is set before adding open class (transition)
    requestAnimationFrame(() => modal.classList.add('open'));
}

function closeEditModal() {
    const modal = document.getElementById('editProfileModal');
    modal.classList.remove('open');
    setTimeout(() => { modal.style.display = 'none'; }, 280);
}

// ── Tab Switching ────────────────────────────────────────────
function switchTab(tabName) {
    // Deactivate all tabs & content panels
    document.querySelectorAll('.modal-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.modal-tab-content').forEach(c => c.classList.remove('active'));

    // Activate selected
    document.getElementById('tab-' + tabName).classList.add('active');
    document.getElementById('tabcontent-' + tabName).classList.add('active');
    activeTab = tabName;
}

// ── Qualification Rows (inside modal) ────────────────────────
function renderQualificationRows(qualifications) {
    const list = document.getElementById('editQualList');
    list.innerHTML = '';

    if (qualifications.length === 0) {
        list.innerHTML = `
            <div class="empty-qual-hint">
                <i class="fa-solid fa-graduation-cap"></i>
                No qualifications yet. Click <strong>Add Qualification</strong> to begin.
            </div>`;
        return;
    }

    qualifications.forEach(q => addQualificationRow(q));
}

function addQualificationRow(data = {}) {
    const list = document.getElementById('editQualList');

    // Remove empty hint if present
    const hint = list.querySelector('.empty-qual-hint');
    if (hint) hint.remove();

    const id          = data.id          || '';
    const title       = data.title       || '';
    const institution = data.institution || '';
    const year        = data.year        || '';
    const description = data.description || '';

    const row = document.createElement('div');
    row.className = 'qual-form-row';
    row.dataset.qualId = id;

    row.innerHTML = `
        <div class="qual-form-inner-row">
            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Title / Degree</label>
                <input type="text" class="form-input qual-title" value="${escHtml(title)}" placeholder="e.g. BSc Psychology">
            </div>
            <button type="button" class="delete-qual-row-btn" title="Remove" onclick="removeQualRow(this)">
                <i class="fa-solid fa-trash-can"></i>
            </button>
        </div>
        <div class="form-row" style="margin-bottom:0.8rem;">
            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Institution</label>
                <input type="text" class="form-input qual-institution" value="${escHtml(institution)}" placeholder="University / College name">
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Year / Period</label>
                <input type="text" class="form-input qual-year" value="${escHtml(year)}" placeholder="e.g. 2018 – 2022">
            </div>
        </div>
        <div class="form-group" style="margin-bottom:0;">
            <label class="form-label">Description (optional)</label>
            <textarea class="form-textarea qual-description" rows="2" placeholder="Brief description...">${escHtml(description)}</textarea>
        </div>
    `;

    list.appendChild(row);
}

function removeQualRow(btn) {
    const row  = btn.closest('.qual-form-row');
    const list = document.getElementById('editQualList');
    row.remove();

    // Show empty hint if nothing remains
    if (list.querySelectorAll('.qual-form-row').length === 0) {
        list.innerHTML = `
            <div class="empty-qual-hint">
                <i class="fa-solid fa-graduation-cap"></i>
                No qualifications yet. Click <strong>Add Qualification</strong> to begin.
            </div>`;
    }
}

// ── Save All Sections ────────────────────────────────────────
async function saveProfileModal() {
    if (isSaving) return;

    const fullName = document.getElementById('edit_full_name').value.trim();
    const phone    = document.getElementById('edit_phone').value.trim();
    const spec     = document.getElementById('edit_spec').value.trim();
    const exp      = document.getElementById('edit_exp').value.trim();
    const bio      = document.getElementById('edit_bio').value.trim();

    if (!fullName) {
        switchTab('personal');
        setModalMessage('Full Name cannot be empty.', 'error');
        document.getElementById('edit_full_name').focus();
        return;
    }

    if (phone && !/^[0-9]{10}$/.test(phone)) {
        switchTab('personal');
        setModalMessage('Mobile number must be exactly 10 digits.', 'error');
        document.getElementById('edit_phone').focus();
        return;
    }

    isSaving = true;
    const saveBtn = document.getElementById('saveProfileBtn');
    saveBtn.disabled = true;
    saveBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving…';
    setModalMessage('', '');

    try {
        // 1. Personal + Professional in one call (they share the same endpoint)
        const profileRes = await fetch('/MindHeaven/public/counselor/updateProfile', {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                full_name:        fullName,
                phone_number:     phone,
                specialization:   spec,
                years_experience: exp,
                bio:              bio,
            }),
        });
        const profileData = await profileRes.json();

        if (!profileData.success) {
            throw new Error(profileData.message || 'Failed to update profile details.');
        }

        // 2. Qualifications sync
        const qualRows = document.querySelectorAll('#editQualList .qual-form-row');
        const qualifications = [];
        qualRows.forEach(row => {
            qualifications.push({
                id:          row.dataset.qualId || '',
                title:       row.querySelector('.qual-title').value.trim(),
                institution: row.querySelector('.qual-institution').value.trim(),
                year:        row.querySelector('.qual-year').value.trim(),
                description: row.querySelector('.qual-description').value.trim(),
            });
        });

        const qualRes  = await fetch('/MindHeaven/public/api/counselor/qualifications/sync', {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ qualifications }),
        });
        const qualData = await qualRes.json();

        if (!qualData.success) {
            throw new Error(qualData.message || 'Failed to sync qualifications.');
        }

        // ── Update displayed values in-page ──────────────────
        setEl('profileName',   fullName);
        setEl('profileSpec',   spec || 'Counselor');
        setEl('view_full_name', fullName);
        setEl('view_phone',    phone);
        setEl('view_spec',     spec);
        setEl('view_exp',      exp);
        setEl('view_bio',      bio);

        // Update in-memory data
        PROFILE_DATA.full_name = fullName;
        PROFILE_DATA.phone     = phone;
        PROFILE_DATA.spec      = spec;
        PROFILE_DATA.exp       = exp;
        PROFILE_DATA.bio       = bio;

        setModalMessage('Profile updated successfully!', 'success');

        // Reload after short delay so qualification IDs are refreshed from DB
        setTimeout(() => {
            closeEditModal();
            location.reload();
        }, 1200);

    } catch (err) {
        console.error(err);
        setModalMessage(err.message || 'An error occurred. Please try again.', 'error');
        isSaving = false;
        saveBtn.disabled = false;
        saveBtn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Save Changes';
    }
}

// ── Helpers ──────────────────────────────────────────────────
function setEl(id, text) {
    const el = document.getElementById(id);
    if (el) el.textContent = text;
}

function setModalMessage(msg, type) {
    const el = document.getElementById('editModalMsg');
    el.textContent = msg;
    el.className   = 'edit-modal-msg' + (type ? ' ' + type : '');
}

function escHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

// ── Photo Upload Functions (unchanged) ───────────────────────
let selectedPhoto = null;

function openPhotoModal() {
    document.getElementById('photoModal').style.display = 'block';
}

function closePhotoModal() {
    document.getElementById('photoModal').style.display = 'none';
    selectedPhoto = null;
    document.getElementById('photoUpload').value = '';
}

function previewPhoto(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            selectedPhoto = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

function uploadPhoto() {
    if (!selectedPhoto) {
        alert('Please select a photo first.');
        return;
    }
    const fileInput = document.getElementById('photoUpload');
    const file      = fileInput.files[0];
    if (!file) {
        alert('No file found.');
        return;
    }
    const formData = new FormData();
    formData.append('profile_picture', file);

    fetch('/MindHeaven/public/counselor/uploadProfilePhoto', {
        method: 'POST',
        body: formData,
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('profilePic').src = data.url;
            alert('Profile picture updated successfully!');
            closePhotoModal();
        } else {
            alert(data.message || 'Failed to update profile picture.');
        }
    })
    .catch(err => {
        console.error(err);
        alert('An error occurred.');
    });
}

// Close modals when clicking backdrop
window.onclick = function(event) {
    const photoModal = document.getElementById('photoModal');
    if (event.target === photoModal) {
        closePhotoModal();
    }
    const editModal = document.getElementById('editProfileModal');
    if (event.target === editModal) {
        closeEditModal();
    }
};

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    console.log('Counselor Profile loaded successfully!');
});