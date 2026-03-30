UPDATE users SET role = 'university_representative' WHERE role = 'university_rep';
ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'undergraduate', 'counselor', 'moderator', 'call_responder', 'university_representative', 'donor') NOT NULL;
