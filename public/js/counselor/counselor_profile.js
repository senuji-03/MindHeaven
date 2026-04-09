
        // Simulate session count update
        let sessionCount = 247;
        
        function updateSessionCount() {
            // This would typically fetch from a database
            document.getElementById('totalSessions').textContent = sessionCount;
        }

        // Navigation Functions
        function showNotifications() {
            alert('Notifications:\n• New appointment request from John Doe\n• Reminder: Session with Sarah in 30 mins\n• Weekly report is ready');
        }

        function showMessages() {
            alert('Messages:\n• Sarah Johnson: Thank you for yesterday\'s session\n• Michael Chen: Can we reschedule tomorrow\'s appointment?\n• System: Weekly feedback summary available');
        }

        // Edit Section Functions
        let editingSection = null;
        let originalData = {};

        function editSection(section) {
            if (editingSection) {
                alert('Please save or cancel the current edit first.');
                return;
            }

            editingSection = section;
            
            if (section === 'personal') {
                const fullNameObj = document.getElementById('c_full_name');
                const phoneObj = document.getElementById('c_phone');
                
                originalData.fullName = fullNameObj.textContent;
                originalData.phone = phoneObj.textContent;
                
                fullNameObj.contentEditable = true;
                phoneObj.contentEditable = true;
                fullNameObj.style.background = '#fff8e1';
                phoneObj.style.background = '#fff8e1';
                
                document.getElementById('personalSave').classList.add('active');
            } 
            else if (section === 'professional') {
                const specObj = document.getElementById('c_spec');
                const expObj = document.getElementById('c_exp');
                const bioObj = document.getElementById('c_bio');
                
                originalData.spec = specObj.textContent;
                originalData.exp = expObj.textContent;
                originalData.bio = bioObj.textContent;
                
                specObj.contentEditable = true;
                expObj.contentEditable = true;
                bioObj.contentEditable = true;
                specObj.style.background = '#fff8e1';
                expObj.style.background = '#fff8e1';
                bioObj.style.background = '#fff8e1';
                
                document.getElementById('professionalSave').classList.add('active');
            }
            else if (section === 'qualification') {
                const list = document.getElementById('qualificationList');
                originalData.qualificationHTML = list.innerHTML;
                
                const qualItems = document.querySelectorAll('.qualification-item');
                
                qualItems.forEach((item) => {
                    item.querySelector('.qualification-title').contentEditable = true;
                    item.querySelector('.qualification-institution').contentEditable = true;
                    item.querySelector('.qualification-year').contentEditable = true;
                    item.querySelector('.qualification-description').contentEditable = true;
                    
                    item.style.background = '#fff8e1';
                    
                    if (!item.querySelector('.delete-qual-btn')) {
                        const delBtn = document.createElement('button');
                        delBtn.className = 'delete-qual-btn';
                        delBtn.innerHTML = '🗑️';
                        delBtn.style.cssText = 'position: absolute; right: 10px; top: 10px; background: none; border: none; cursor: pointer; font-size: 1.2rem;';
                        delBtn.onclick = function() {
                            if (confirm('Delete this qualification?')) {
                                item.remove();
                            }
                        };
                        item.style.position = 'relative';
                        item.appendChild(delBtn);
                    }
                });
                
                document.getElementById('qualificationSave').classList.add('active');
            }
        }

        function cancelEdit(section) {
            if (section === 'personal') {
                const fullNameObj = document.getElementById('c_full_name');
                const phoneObj = document.getElementById('c_phone');
                
                fullNameObj.textContent = originalData.fullName;
                phoneObj.textContent = originalData.phone;
                
                fullNameObj.contentEditable = false;
                phoneObj.contentEditable = false;
                fullNameObj.style.background = '';
                phoneObj.style.background = '';
                
                document.getElementById('personalSave').classList.remove('active');
            }
            else if (section === 'professional') {
                const specObj = document.getElementById('c_spec');
                const expObj = document.getElementById('c_exp');
                const bioObj = document.getElementById('c_bio');
                
                specObj.textContent = originalData.spec;
                expObj.textContent = originalData.exp;
                bioObj.textContent = originalData.bio;
                
                specObj.contentEditable = false;
                expObj.contentEditable = false;
                bioObj.contentEditable = false;
                specObj.style.background = '';
                expObj.style.background = '';
                bioObj.style.background = '';
                
                document.getElementById('professionalSave').classList.remove('active');
            }
            else if (section === 'qualification') {
                const list = document.getElementById('qualificationList');
                list.innerHTML = originalData.qualificationHTML;
                document.getElementById('qualificationSave').classList.remove('active');
            }
            
            editingSection = null;
            originalData = {};
        }

        function saveSection(section) {
            if (section === 'personal') {
                const fullNameObj = document.getElementById('c_full_name');
                const phoneObj = document.getElementById('c_phone');
                
                const fullName = fullNameObj.textContent.trim();
                const phone = phoneObj.textContent.trim();
                
                if (!fullName) {
                    alert('Full Name cannot be empty.');
                    return;
                }
                
                fetch('/MindHeaven/public/counselor/updateProfile', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ full_name: fullName, phone_number: phone })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fullNameObj.contentEditable = false;
                        phoneObj.contentEditable = false;
                        fullNameObj.style.background = '';
                        phoneObj.style.background = '';
                        document.getElementById('personalSave').classList.remove('active');
                        alert('Personal details updated successfully!');
                        editingSection = null;
                        originalData = {};
                    } else {
                        alert(data.message || 'Failed to update personal details.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('An error occurred.');
                });
            }
            else if (section === 'professional') {
                const specObj = document.getElementById('c_spec');
                const expObj = document.getElementById('c_exp');
                const bioObj = document.getElementById('c_bio');
                
                const spec = specObj.textContent.trim();
                const exp = expObj.textContent.trim();
                const bio = bioObj.textContent.trim();
                
                fetch('/MindHeaven/public/counselor/updateProfile', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ specialization: spec, years_experience: exp, bio: bio })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        specObj.contentEditable = false;
                        expObj.contentEditable = false;
                        bioObj.contentEditable = false;
                        specObj.style.background = '';
                        expObj.style.background = '';
                        bioObj.style.background = '';
                        document.getElementById('professionalSave').classList.remove('active');
                        alert('Professional details updated successfully!');
                        editingSection = null;
                        originalData = {};
                    } else {
                        alert(data.message || 'Failed to update professional details.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('An error occurred.');
                });
            }
            else if (section === 'qualification') {
                const qualItems = document.querySelectorAll('.qualification-item:not(.empty-state)');
                const qualifications = [];
                
                qualItems.forEach(item => {
                    qualifications.push({
                        id: item.dataset.id || '',
                        title: item.querySelector('.qualification-title').textContent.trim(),
                        institution: item.querySelector('.qualification-institution').textContent.trim(),
                        year: item.querySelector('.qualification-year').textContent.trim(),
                        description: item.querySelector('.qualification-description').textContent.trim(),
                    });
                });
                
                fetch('/MindHeaven/public/api/counselor/qualifications/sync', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ qualifications: qualifications })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Qualifications successfully updated!');
                        location.reload(); // Reload to reflect any new DB IDs
                    } else {
                        alert(data.message || 'Failed to update qualifications.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('An error occurred.');
                });
            }
        }

        function addQualification() {
            if (editingSection && editingSection !== 'qualification') {
                alert('Please save or cancel the current edit first.');
                return;
            }
            
            const list = document.getElementById('qualificationList');
            
            // Remove empty state if present
            const emptyState = list.querySelector('.empty-state');
            if (emptyState) {
                list.innerHTML = '';
            }
            
            if (editingSection !== 'qualification') {
                if (!emptyState) {
                    originalData.qualificationHTML = list.innerHTML;
                } else {
                    originalData.qualificationHTML = '<div class="qualification-item empty-state" style="text-align: center; color: #888;">No qualifications added yet. Click Add to create one.</div>';
                }
                
                editingSection = 'qualification';
                document.getElementById('qualificationSave').classList.add('active');
                
                const qualItems = document.querySelectorAll('.qualification-item:not(.empty-state)');
                qualItems.forEach((item) => {
                    item.querySelector('.qualification-title').contentEditable = true;
                    item.querySelector('.qualification-institution').contentEditable = true;
                    item.querySelector('.qualification-year').contentEditable = true;
                    item.querySelector('.qualification-description').contentEditable = true;
                    item.style.background = '#fff8e1';
                    
                    if (!item.querySelector('.delete-qual-btn')) {
                        const delBtn = document.createElement('button');
                        delBtn.className = 'delete-qual-btn';
                        delBtn.innerHTML = '🗑️';
                        delBtn.style.cssText = 'position: absolute; right: 10px; top: 10px; background: none; border: none; cursor: pointer; font-size: 1.2rem;';
                        delBtn.onclick = function() {
                            if (confirm('Delete this qualification?')) {
                                item.remove();
                                if (document.querySelectorAll('.qualification-item').length === 0) {
                                    list.innerHTML = '<div class="qualification-item empty-state" style="text-align: center; color: #888;">No qualifications added yet. Click Add to create one.</div>';
                                }
                            }
                        };
                        item.style.position = 'relative';
                        item.appendChild(delBtn);
                    }
                });
            }

            const newItemHTML = `
                <div class="qualification-item" style="background: #fff8e1; position: relative;">
                    <div class="qualification-header">
                        <div>
                            <div class="qualification-title" contenteditable="true">New Qualification</div>
                            <div class="qualification-institution" contenteditable="true">Institution Name</div>
                        </div>
                        <span class="qualification-year" contenteditable="true">Year</span>
                    </div>
                    <p class="qualification-description" contenteditable="true">Description</p>
                    <button class="delete-qual-btn" style="position: absolute; right: 10px; top: 10px; background: none; border: none; cursor: pointer; font-size: 1.2rem;" onclick="if(confirm('Delete this qualification?')) this.parentElement.remove();">🗑️</button>
                </div>
            `;
            list.insertAdjacentHTML('afterbegin', newItemHTML);
        }

        // Photo Upload Functions
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
                }
                reader.readAsDataURL(file);
            }
        }

        function uploadPhoto() {
            if (!selectedPhoto) {
                alert('Please select a photo first.');
                return;
            }
            
            const fileInput = document.getElementById('photoUpload');
            const file = fileInput.files[0];
            
            if (!file) {
                 alert('No file found.');
                 return;
            }
            
            const formData = new FormData();
            formData.append('profile_picture', file);
            
            fetch('/MindHeaven/public/counselor/uploadProfilePhoto', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
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

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('photoModal');
            if (event.target === modal) {
                closePhotoModal();
            }
        }

        // Simulate automatic session count update
        setInterval(() => {
            // This would typically be triggered by actual session completions
            // For demo purposes, we'll increment occasionally
            if (Math.random() > 0.99) { // Very rare random increment for demo
                sessionCount++;
                updateSessionCount();
            }
        }, 10000); // Check every 10 seconds

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateSessionCount();
            console.log('Counselor Profile loaded successfully!');
        });
   