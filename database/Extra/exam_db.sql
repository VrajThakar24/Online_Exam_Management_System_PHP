-- -- Create the database
-- CREATE DATABASE IF NOT EXISTS online_exam_db;
-- USE online_exam_db;

-- Users Table (Admin, Teacher, Student)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    role ENUM('admin', 'teacher', 'student') NOT NULL
);

-- Sample Users
INSERT INTO users (username, password, role) VALUES
('admin', 'admin123', 'admin'),
('teacher1', 'teach123', 'teacher'),
('student1', 'stud123', 'student');

-- -- Subjects Table
-- CREATE TABLE subjects (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     name VARCHAR(100) NOT NULL
-- );

-- -- Questions Table
-- CREATE TABLE questions (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     subject_id INT,
--     question TEXT,
--     option_a VARCHAR(255),
--     option_b VARCHAR(255),
--     option_c VARCHAR(255),
--     option_d VARCHAR(255),
--     correct_option CHAR(1),
--     FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
-- );

-- -- Exams Table
-- CREATE TABLE exams (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     subject_id INT,
--     title VARCHAR(100),
--     total_questions INT,
--     duration_minutes INT,
--     FOREIGN KEY (subject_id) REFERENCES subjects(id)
-- );

-- -- Exam_Questions Table (map exam to specific questions)
-- CREATE TABLE exam_questions (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     exam_id INT,
--     question_id INT,
--     FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE,
--     FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
-- );

-- -- Results Table
-- CREATE TABLE results (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     student_id INT,
--     exam_id INT,
--     score INT,
--     total INT,
--     timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
--     FOREIGN KEY (student_id) REFERENCES users(id),
--     FOREIGN KEY (exam_id) REFERENCES exams(id)
-- );
