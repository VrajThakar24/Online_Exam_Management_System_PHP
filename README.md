# 🚀 Online Examination Management System (OEMS)

Online Examination Management System (OEMS) built using PHP, MySQL, HTML, CSS, and JavaScript. Features include secure login, timed exams, random MCQs, auto evaluation, and an admin panel for efficient exam management. Designed for a smooth and user-friendly online testing experience.

---

## 👨‍💻 Developers

* Vraj Thakar (@VrajThakar24)
* Pankaj Yadav (@pankajyadav24)

---

## 📄 License

This project is licensed under the MIT License.

---

## 📌 Features

* 🔐 Secure Login System (Admin, Teacher, Student)
* ⏱️ Timed Exams with Auto Submission
* 🎯 Randomized MCQs from Database
* 🔄 Next/Previous Question Navigation
* 📊 Instant Result Calculation
* 🛠️ Admin Panel for Exam & Question Management
* 👨‍🏫 Teacher Module Support
* 💾 Structured MySQL Database

---

## 🛠️ Tech Stack

* Frontend: HTML, CSS, JavaScript
* Backend: PHP
* Database: MySQL

---

## ⚙️ Installation & Setup

### 1️⃣ Requirements

* XAMPP / WAMP / LAMP
* Web Browser

### 2️⃣ Steps to Run

1. Clone the repository:

   ```
   git clone https://github.com/VrajThakar24/Online_Exam_Management_System_PHP.git
   ```

2. Move the project folder to:

   ```
   htdocs (for XAMPP)
   ```

3. Start:

   * Apache
   * MySQL

4. Open phpMyAdmin

5. Create database:

   ```
   online_exam_db
   ```

6. Import SQL file:

   ```
   database/online_exam_db.sql
   ```

7. Configure Email (SMTP) ⚠️ IMPORTANT:

   Update email and app password in the following files:

   * `result.php`
   * `result2.php`
   * `forget_password.php`
   * `exam_reminder.php`

   Example configuration:

   ```php
   $mail->Username = "your-email@gmail.com";
   $mail->Password = "your-app-password";
   ```

   👉 Use Gmail App Password (not your normal password)

8. Run project in browser:

   ```
   http://localhost/Online_Exam_Management_System_PHP
   ```

---

## 🗄️ Database

Database file is available at:

```
/database/online_exam_db.sql
```

---

## 🔑 Demo Credentials

### 👨‍💼 Admin

* Username: `admin`
* Password: `Admin@2409`

### 👨‍🏫 Teacher

* Username: `teacher_01`
* Password: `misam@092`

### 👨‍🎓 Students

* Username: `202324114` | Password: `Ashwin@114`
* Username: `202324127` | Password: `Nikhil@127`
* Username: `202324131` | Password: `Nishant@131`

---

## 📸 Screenshots

### 🔐 Login Page

![Login Screenshot](https://github.com/user-attachments/assets/a2b6d38c-0ef8-40cf-bbe8-0d8857be53a8)

### 📊 Student Dashboard

![Student Dashboard](https://github.com/user-attachments/assets/6a54bb64-81e8-41de-b124-745dfb998a91)

---

## 🚀 Future Enhancements

* Negative Marking System
* Performance Analytics Dashboard
* Email Notifications
* Certificate Generation

---

## ⭐ Support

If you found this project useful, consider giving it a ⭐ on GitHub!
