
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
                // Make location editable
                const locationDiv = document.getElementById('location');
                const currentLocation = locationDiv.textContent;
                originalData.location = currentLocation;
                locationDiv.innerHTML = `<input type="text" value="${currentLocation}">`;
                document.getElementById('personalSave').classList.add('active');
            } 
            else if (section === 'qualification') {
                // Enable editing for qualifications
                const qualItems = document.querySelectorAll('.qualification-item');
                originalData.qualifications = [];
                
                qualItems.forEach((item, index) => {
                    const title = item.querySelector('.qualification-title').textContent;
                    const institution = item.querySelector('.qualification-institution').textContent;
                    const year = item.querySelector('.qualification-year').textContent;
                    const description = item.querySelector('.qualification-description').textContent;
                    
                    originalData.qualifications.push({title, institution, year, description});
                    
                    item.querySelector('.qualification-title').contentEditable = true;
                    item.querySelector('.qualification-institution').contentEditable = true;
                    item.querySelector('.qualification-year').contentEditable = true;
                    item.querySelector('.qualification-description').contentEditable = true;
                    
                    item.style.background = '#fff8e1';
                });
                
                document.getElementById('qualificationSave').classList.add('active');
            }
            else if (section === 'timeslots') {
                // Enable time slot checkboxes
                const checkboxes = document.querySelectorAll('#timeSlotsGrid input[type="checkbox"]');
                originalData.timeslots = {};
                
                checkboxes.forEach(checkbox => {
                    originalData.timeslots[checkbox.id] = checkbox.checked;
                    checkbox.disabled = false;
                });
                
                document.getElementById('timeslotsSave').classList.add('active');
            }
        }

        function cancelEdit(section) {
            if (section === 'personal') {
                const locationDiv = document.getElementById('location');
                locationDiv.textContent = originalData.location;
                document.getElementById('personalSave').classList.remove('active');
            }
            else if (section === 'qualification') {
                const qualItems = document.querySelectorAll('.qualification-item');
                
                qualItems.forEach((item, index) => {
                    const original = originalData.qualifications[index];
                    item.querySelector('.qualification-title').textContent = original.title;
                    item.querySelector('.qualification-institution').textContent = original.institution;
                    item.querySelector('.qualification-year').textContent = original.year;
                    item.querySelector('.qualification-description').textContent = original.description;
                    
                    item.querySelector('.qualification-title').contentEditable = false;
                    item.querySelector('.qualification-institution').contentEditable = false;
                    item.querySelector('.qualification-year').contentEditable = false;
                    item.querySelector('.qualification-description').contentEditable = false;
                    
                    item.style.background = '#f8fafc';
                });
                
                document.getElementById('qualificationSave').classList.remove('active');
            }
            else if (section === 'timeslots') {
                const checkboxes = document.querySelectorAll('#timeSlotsGrid input[type="checkbox"]');
                
                checkboxes.forEach(checkbox => {
                    checkbox.checked = originalData.timeslots[checkbox.id];
                    checkbox.disabled = true;
                });
                
                document.getElementById('timeslotsSave').classList.remove('active');
            }
            
            editingSection = null;
            originalData = {};
        }

        function saveSection(section) {
            if (section === 'personal') {
                const locationInput = document.querySelector('#location input');
                const newLocation = locationInput.value.trim();
                
                if (!newLocation) {
                    alert('Location cannot be empty.');
                    return;
                }
                
                document.getElementById('location').textContent = newLocation;
                document.getElementById('personalSave').classList.remove('active');
                
                alert('Personal details updated successfully!');
            }
            else if (section === 'qualification') {
                const qualItems = document.querySelectorAll('.qualification-item');
                
                qualItems.forEach(item => {
                    item.querySelector('.qualification-title').contentEditable = false;
                    item.querySelector('.qualification-institution').contentEditable = false;
                    item.querySelector('.qualification-year').contentEditable = false;
                    item.querySelector('.qualification-description').contentEditable = false;
                    item.style.background = '#f8fafc';
                });
                
                document.getElementById('qualificationSave').classList.remove('active');
                
                alert('Qualifications updated successfully!');
            }
            else if (section === 'timeslots') {
                const checkboxes = document.querySelectorAll('#timeSlotsGrid input[type="checkbox"]');
                
                checkboxes.forEach(checkbox => {
                    checkbox.disabled = true;
                });
                
                document.getElementById('timeslotsSave').classList.remove('active');
                
                alert('Time slots updated successfully!');
            }
            
            editingSection = null;
            originalData = {};
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
            
            document.getElementById('profilePic').src = selectedPhoto;
            alert('Profile picture updated successfully!');
            closePhotoModal();
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
   