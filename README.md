# Mini Learning Management System (Mini LMS)

This project is a **simple Learning Management System (LMS)** built with **Laravel 12** for practice purposes (Olympiad Web Training).  
It demonstrates how to design and implement **user roles, courses, lessons, and enrollments** in a clean and scalable way.

---

## 🔹 Features
- **Role-based Access Control (RBAC)**
    - Admin: Manage users, roles, courses, and lessons
    - Teacher: Create and manage their own courses and lessons
    - Student: Enroll in courses and view lessons

- **Entities & Relations**
    - Users ↔ Roles (Many-to-Many)
    - Users ↔ Courses (Many-to-Many, for enrollments)
    - Courses → Lessons (One-to-Many)
    - Course → Teacher (One-to-Many)

- **Core Functionalities**
    - User authentication and role assignment
    - Course creation by teachers
    - Lesson management inside each course
    - Student enrollment in multiple courses
    - Middleware-based access control

---

## 🔹 Tech Stack
- **Laravel 12 (PHP framework)**
- MySQL (database)
- Eloquent ORM for relationships
- RESTful API tested with Postman

---