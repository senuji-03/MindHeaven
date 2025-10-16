 
 // Sample appointment data
        let appointments = [
            {
                id: 1,
                patientName: "Sarah Johnson",
                email: "sarah.johnson@email.com",
                phone: "+1 234-567-8901",
                reason: "Anxiety and stress management",
                requestedDate: "2024-08-24",
                requestedTime: "10:30",
                duration: "60 minutes",
                mediaType: "video",
                status: "pending",
                urgency: "medium",
                notes: "First time consultation. Patient mentioned experiencing high levels of stress at work.",
                requestDate: "2024-08-20"
            },
            {
                id: 2,
                patientName: "Michael Chen",
                email: "michael.chen@email.com",
                phone: "+1 234-567-8902",
                reason: "Academic pressure and burnout",
                requestedDate: "2024-08-24",
                requestedTime: "14:00",
                duration: "45 minutes",
                mediaType: "audio",
                status: "pending",
                urgency: "high",
                notes: "Student struggling with final exams. Needs immediate support.",
                requestDate: "2024-08-21"
            },
            {
                id: 3,
                patientName: "Emily Davis",
                email: "emily.davis@email.com",
                phone: "+1 234-567-8903",
                reason: "Social anxiety and relationship issues",
                requestedDate: "2024-08-25",
                requestedTime: "11:00",
                duration: "60 minutes",
                mediaType: "video",
                status: "accepted",
                urgency: "low",
                notes: "Follow-up session. Patient has shown good progress.",
                requestDate: "2024-08-19"
            },
            {
                id: 4,
                patientName: "David Wilson",
                email: "david.wilson@email.com",
                phone: "+1 234-567-8904",
                reason: "Depression and mood disorders",
                requestedDate: "2024-08-23",
                requestedTime: "15:30",
                duration: "60 minutes",
                mediaType: "video",
                status: "rejected",
                urgency: "medium",
                notes: "Patient requested specific time slot that was not available.",
                requestDate: "2024-08-22"
            },
            {
                id: 5,
                patientName: "Lisa Thompson",
                email: "lisa.thompson@email.com",
                phone: "+1 234-567-8905",
                reason: "Family counseling session",
                requestedDate: "2024-08-26",
                requestedTime: "16:00",
                duration: "90 minutes",
                mediaType: "video",
                status: "pending",
                urgency: "medium",
                notes: "Family session including spouse. Marriage counseling required.",
                requestDate: "2024-08-21"
            }
        ];

        let currentRescheduleId = null;

        // Navigation Functions
        function showNotifications() {
            alert('Notifications:\n• New appointment request from John Doe\n• Reminder: Session with Sarah in 30 mins\n• Weekly report is ready');
        }

        function showMessages() {
            alert('Messages:\n• Sarah Johnson: Thank you for yesterday\'s session\n• Michael Chen: Can we reschedule tomorrow\'s appointment?\n• System: Weekly feedback summary available');
        }

        // Render appointments
        function renderAppointments(appointmentsToRender = appointments) {
            const appointmentsList = document.getElementById('appointmentsList');
            
            if (appointmentsToRender.length === 0) {
                appointmentsList.innerHTML = `
                    <div style="text-align: center; padding: 3rem; color: #64748b;">
                        <h3>No appointments found</h3>
                        <p>No appointments match your current filters.</p>
                    </div>
                `;
                return;
            }

            appointmentsList.innerHTML = appointmentsToRender.map(appointment => `
                <div class="appointment-card ${appointment.status}" data-id="${appointment.id}">
                    <div class="appointment-header">
                        <div class="patient-info">
                            <h4>${appointment.patientName}</h4>
                            <p>${appointment.reason}</p>
                        </div>
                        <div class="time-info">
                            <div class="date-time">${formatDate(appointment.requestedDate)} at ${formatTime(appointment.requestedTime)}</div>
                            <div class="duration">${appointment.duration}</div>
                        </div>
                        <div class="media-type ${appointment.mediaType}-call">
                            ${appointment.mediaType === 'video' ? '🎥' : '🎧'} ${appointment.mediaType.charAt(0).toUpperCase() + appointment.mediaType.slice(1)} Call
                        </div>
                        <div class="status-badge status-${appointment.status}">
                            ${appointment.status}
                        </div>
                        <div class="initial-actions">
                            <button class="btn btn-view" onclick="toggleDetails(${appointment.id})">
                                <span id="viewText-${appointment.id}">View</span>
                            </button>
                        </div>
                    </div>
                    <div class="appointment-details" id="details-${appointment.id}">
                        <div class="details-grid">
                            <div class="detail-section">
                                <h5>Patient Information</h5>
                                <div class="detail-item">
                                    <span class="detail-label">Email:</span>
                                    <span class="detail-value">${appointment.email}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Phone:</span>
                                    <span class="detail-value">${appointment.phone}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Request Date:</span>
                                    <span class="detail-value">${formatDate(appointment.requestDate)}</span>
                                </div>
                            </div>
                            <div class="detail-section">
                                <h5>Appointment Details</h5>
                                <div class="detail-item">
                                    <span class="detail-label">Urgency:</span>
                                    <span class="detail-value">${appointment.urgency.charAt(0).toUpperCase() + appointment.urgency.slice(1)}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Duration:</span>
                                    <span class="detail-value">${appointment.duration}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Media Type:</span>
                                    <span class="detail-value">${appointment.mediaType.charAt(0).toUpperCase() + appointment.mediaType.slice(1)} Call</span>
                                </div>
                            </div>
                        </div>
                        ${appointment.notes ? `
                            <div class="detail-section" style="margin-bottom: 1.5rem;">
                                <h5>Notes</h5>
                                <p style="color: #64748b; line-height: 1.5;">${appointment.notes}</p>
                            </div>
                        ` : ''}
                        <div class="action-section">
                            <div class="action-buttons">
                                ${appointment.status === 'pending' ? `
                                    <button class="btn btn-accept" onclick="updateStatus(${appointment.id}, 'accepted')">Accept</button>
                                    <button class="btn btn-reject" onclick="updateStatus(${appointment.id}, 'rejected')">Reject</button>
                                ` : ''}
                                <button class="btn btn-reschedule" onclick="reschedule('${appointment.patientName}', '${appointment.reason}', ${appointment.id})">Reschedule</button>
                                ${appointment.status === 'accepted' ? `
                                    <button class="btn btn-save" onclick="saveToCalendar(${appointment.id})">Save to Calendar</button>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Toggle appointment details
        function toggleDetails(id) {
            const details = document.getElementById(`details-${id}`);
            const viewText = document.getElementById(`viewText-${id}`);
            
            if (details.classList.contains('show')) {
                details.classList.remove('show');
                viewText.textContent = 'View';
            } else {
                details.classList.add('show');
                viewText.textContent = 'Hide';
            }
        }

        // Update appointment status
        function updateStatus(id, status) {
            const appointment = appointments.find(app => app.id === id);
            if (appointment) {
                appointment.status = status;
                showSuccessMessage(`Appointment ${status} successfully!`);
                renderAppointments();
            }
        }

        // Format date for display
        function formatDate(dateString) {
            const date = new Date(dateString);
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            
            if (date.toDateString() === today.toDateString()) {
                return 'Today';
            } else if (date.toDateString() === tomorrow.toDateString()) {
                return 'Tomorrow';
            } else {
                return date.toLocaleDateString('en-US', { 
                    weekday: 'short', 
                    month: 'short', 
                    day: 'numeric' 
                });
            }
        }

        // Format time for display
        function formatTime(timeString) {
            const [hours, minutes] = timeString.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour % 12 || 12;
            return `${displayHour}:${minutes} ${ampm}`;
        }

        // Filter appointments
        function filterAppointments() {
            const statusFilter = document.getElementById('statusFilter').value;
            const dateFilter = document.getElementById('dateFilter').value;
            const patientSearch = document.getElementById('patientSearch').value.toLowerCase();

            let filteredAppointments = appointments.filter(appointment => {
                const statusMatch = statusFilter === 'all' || appointment.status === statusFilter;
                const dateMatch = !dateFilter || appointment.requestedDate === dateFilter;
                const patientMatch = !patientSearch || appointment.patientName.toLowerCase().includes(patientSearch);
                
                return statusMatch && dateMatch && patientMatch;
            });

            renderAppointments(filteredAppointments);
        }

        // Reschedule appointment
        function reschedule(patientName, reason, appointmentId) {
            currentRescheduleId = appointmentId;
            
            // Populate patient info
            const patientInfoDiv = document.getElementById('reschedulePatientInfo');
            patientInfoDiv.innerHTML = `
                <h4>${patientName}</h4>
                <p>Current reason: ${reason}</p>
            `;
            
            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('newDate').min = today;
            document.getElementById('newDate').value = today;
            
            // Show modal
            document.getElementById('rescheduleModal').style.display = 'block';
        }

        // Submit reschedule
        function submitReschedule() {
            const newDate = document.getElementById('newDate').value;
            const newTime = document.getElementById('newTime').value;
            const reason = document.getElementById('rescheduleReason').value;
            
            if (!newDate || !newTime || !reason) {
                alert('Please fill in all required fields.');
                return;
            }
            
            // Update appointment
            const appointment = appointments.find(app => app.id === currentRescheduleId);
            if (appointment) {
                appointment.requestedDate = newDate;
                appointment.requestedTime = newTime;
                appointment.notes = appointment.notes + `\n\nRescheduled: ${reason}`;
                
                showSuccessMessage(`Appointment rescheduled successfully!\nNew Date: ${formatDate(newDate)}\nNew Time: ${formatTime(newTime)}`);
                renderAppointments();
            }
            
            closeModal('rescheduleModal');
        }

        // Save to calendar
        function saveToCalendar(appointmentId) {
            const appointment = appointments.find(app => app.id === appointmentId);
            if (!appointment) return;

            // Simulate saving to calendar and dashboard
            // In a real application, this would make API calls to update the backend
            
            // Create calendar event object
            const calendarEvent = {
                id: appointment.id,
                title: `Session with ${appointment.patientName}`,
                date: appointment.requestedDate,
                time: appointment.requestedTime,
                duration: appointment.duration,
                type: appointment.mediaType,
                reason: appointment.reason,
                patient: {
                    name: appointment.patientName,
                    email: appointment.email,
                    phone: appointment.phone
                }
            };

            // Store in localStorage to simulate backend storage
            let calendarEvents = JSON.parse(localStorage.getItem('calendarEvents') || '[]');
            let upcomingAppointments = JSON.parse(localStorage.getItem('upcomingAppointments') || '[]');
            
            // Check if already exists to avoid duplicates
            const existingCalendarIndex = calendarEvents.findIndex(event => event.id === appointment.id);
            const existingUpcomingIndex = upcomingAppointments.findIndex(app => app.id === appointment.id);
            
            if (existingCalendarIndex === -1) {
                calendarEvents.push(calendarEvent);
                localStorage.setItem('calendarEvents', JSON.stringify(calendarEvents));
            }
            
            // Create upcoming appointment object for dashboard
            const upcomingAppointment = {
                id: appointment.id,
                patientName: appointment.patientName,
                reason: appointment.reason,
                date: appointment.requestedDate,
                time: appointment.requestedTime,
                mediaType: appointment.mediaType,
                status: 'confirmed'
            };
            
            if (existingUpcomingIndex === -1) {
                upcomingAppointments.push(upcomingAppointment);
                localStorage.setItem('upcomingAppointments', JSON.stringify(upcomingAppointments));
            }

            showSuccessMessage(`Appointment saved to calendar successfully!\nPatient: ${appointment.patientName}\nDate: ${formatDate(appointment.requestedDate)}\nTime: ${formatTime(appointment.requestedTime)}`);
            
            // Optional: You can also mark this appointment as 'scheduled' to distinguish from just 'accepted'
            appointment.status = 'scheduled';
            renderAppointments();
        }

        // Show success message
        function showSuccessMessage(message) {
            const successDiv = document.getElementById('successMessage');
            successDiv.textContent = message;
            successDiv.classList.add('show');
            
            setTimeout(() => {
                successDiv.classList.remove('show');
            }, 5000);
        }

        // Close modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            // Reset forms when closing
            if (modalId === 'rescheduleModal') {
                document.getElementById('rescheduleForm').reset();
                currentRescheduleId = null;
            }
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const rescheduleModal = document.getElementById('rescheduleModal');
            
            if (event.target === rescheduleModal) {
                closeModal('rescheduleModal');
            }
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            renderAppointments();
            console.log('Appointment Management loaded successfully!');
            
            // Set today's date as default for date filter
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('dateFilter').value = '';
        });

        // Additional utility functions for integration

        // Function to add new appointment request (can be called from other parts of the system)
        function addNewAppointmentRequest(appointmentData) {
            const newId = Math.max(...appointments.map(app => app.id)) + 1;
            const newAppointment = {
                id: newId,
                ...appointmentData,
                status: 'pending',
                requestDate: new Date().toISOString().split('T')[0]
            };
            
            appointments.unshift(newAppointment); // Add to beginning of array
            renderAppointments();
            showSuccessMessage('New appointment request received!');
        }

        // Function to get appointment statistics
        function getAppointmentStats() {
            const stats = {
                total: appointments.length,
                pending: appointments.filter(app => app.status === 'pending').length,
                accepted: appointments.filter(app => app.status === 'accepted').length,
                rejected: appointments.filter(app => app.status === 'rejected').length,
                scheduled: appointments.filter(app => app.status === 'scheduled').length
            };
            
            return stats;
        }

        // Export functions for use in other pages
        window.appointmentManager = {
            addNewAppointmentRequest,
            getAppointmentStats,
            appointments: () => appointments // Return copy of appointments
        };