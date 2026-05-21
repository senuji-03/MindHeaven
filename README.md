# MindHeaven 🕊️

> A comprehensive digital platform designed to bridge the mental health support gap between university students and professional counselors, fostering a healthier academic environment.

MindHeaven is a dedicated mental health and university life platform built with an ethical, personalized approach. It empowers undergraduate students to access counseling resources, track daily habits, participate in supportive forums, and manage crises, while providing powerful tools for counselors, administrators, and university representatives to offer support.

---

## ✨ Key Features

MindHeaven offers robust, role-based functionality tailored to different user types:

### 🎓 For Undergraduate Students
* **Counseling Appointments:** Seamlessly book and manage one-on-one sessions with university counselors.
* **Habit Tracking:** Build and track daily, weekly, or custom habits to improve personal well-being.
* **Peer Support Forums:** Engage in moderated, safe discussion forums with fellow students.
* **Crisis Support & Emergency Response:** Immediate access to emergency contacts, call responders, and crisis intervention tools.
* **Resource Hub:** Explore curated mental health articles, podcasts, and guides.
* **Journaling:** Private digital journaling to reflect on daily emotions and progress.

### 🧑‍⚕️ For Counselors
* **Schedule Management:** Set available timeslots, accept appointments, and manage patient sessions.
* **Session Notes:** Securely document session histories and student progress.
* **Chat Integration:** Communicate directly with students through a secure messaging system.

### 🏛️ For University Representatives & Moderators
* **Event Management:** Create and promote university mental health events and awareness campaigns.
* **Forum Moderation:** Review flagged posts, enforce community guidelines, and maintain a safe digital environment.
* **Donation & Resource Tracking:** Manage university resources and track campaign donations.

### 🛡️ For Administrators
* **System Oversight:** Manage all user roles, approve new counselor registrations, and handle suspended accounts.
* **System-Wide Analytics:** Monitor platform usage, crisis reports, and overall system health.

---

## 🛠️ Technology Stack

* **Frontend:** HTML5, Vanilla CSS (Custom Design System), JavaScript
* **Backend:** PHP (Custom MVC Architecture)
* **Database:** MySQL
* **Styling/UI:** Modern UI with Glassmorphism, tailored typography (DM Sans), and responsive layouts.

---

## 🚀 Local Setup & Installation

To run MindHeaven locally, you will need a server environment like **XAMPP** or **WAMP**.

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/senuji-03/MindHeaven.git
   ```
2. **Move to Server Directory:**
   * Move the cloned `MindHeaven` folder into your local server's root directory (e.g., `C:\xampp\htdocs\MindHeaven`).
3. **Database Setup:**
   * Open phpMyAdmin (usually `http://localhost/phpmyadmin`).
   * Create a new database named `mindheaven` (or match the name in your config file).
   * Import the provided `.sql` database schema and seed files located in the `database/` folder.
4. **Configuration:**
   * Update the database connection variables in your config file (typically `app/config/config.php` or similar) with your local database credentials.
5. **Run the Application:**
   * Start Apache and MySQL in your XAMPP Control Panel.
   * Visit `http://localhost/MindHeaven` in your browser.

---

## 🎨 Design System

MindHeaven utilizes a highly custom, premium design system focusing on:
* **Rich Aesthetics:** Curated, harmonious color palettes to promote calmness and clarity.
* **Dynamic Interactions:** Smooth micro-animations and hover effects for an engaging user experience.
* **Clean Architecture:** Consistent CSS styling following modern best practices without relying heavily on bulky external frameworks.

---

## 🤝 Contributing

We welcome contributions to make MindHeaven better! 
1. Checkout the `integration-branch` for the latest ongoing work.
2. Ensure any new features adhere to the `DESIGN_SYSTEM.md`.
3. Please test your code locally before pushing and submitting merge requests to the `master` branch.

---
*Developed with care to make mental healthcare more accessible for university students.*
