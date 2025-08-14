# 🔍 Digital Forensic Evidence Analyzer

> **A comprehensive web-based application for digital forensic investigations - Database Course Project**

[![PHP](https://img.shields.io/badge/PHP-8.2.12-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-10.4.32-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/HTML)
[![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/CSS)
[![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Database Design](#database-design)
- [Installation](#installation)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [Learning Outcomes](#learning-outcomes)
- [Screenshots](#screenshots)
- [Contributing](#contributing)
- [License](#license)

## 🎯 Overview

The Digital Forensic Evidence Analyzer is a sophisticated web-based application designed to streamline digital forensic investigations. Built as a **Database Course Project**, it demonstrates comprehensive understanding of database design principles, SQL programming, and full-stack web development.

This application provides a secure and centralized platform for managing, storing, and analyzing digital evidence, making it an essential tool for law enforcement agencies, corporate security teams, and digital forensics laboratories.

## ✨ Key Features

### 🔐 **User Role Management**
- **Dual Authentication System**: Separate login portals for administrators and investigators
- **Role-Based Access Control**: Privilege management based on user roles
- **Session Security**: Secure session handling with timeout protection

### 📁 **Evidence Management**
- **File Upload System**: Support for multiple file formats (PDF, DOCX, EXE, PCAP)
- **Categorization**: Organized evidence classification (Cybercrime, Malware, Fraud, Network)
- **Metadata Tracking**: Comprehensive evidence documentation with timestamps
- **Chain of Custody**: Maintains evidence integrity and audit trails

### 📊 **Data Visualization & Analytics**
- **Interactive Dashboards**: Real-time charts and graphs using Chart.js
- **Evidence Statistics**: User activity metrics and evidence type distribution
- **Performance Analytics**: Investigator productivity and case progress tracking
- **Dynamic Reporting**: Automated report generation and data export

### 🛡️ **Security Infrastructure**
- **SQL Injection Prevention**: Prepared statements and parameterized queries
- **Password Security**: Bcrypt hashing with salt for user authentication
- **File Validation**: Secure file upload with type and size restrictions
- **Access Control**: Comprehensive permission management system

## 🛠️ Technology Stack

### **Backend Technologies**
- **PHP 8.2.12** - Server-side scripting and application logic
- **MySQL 10.4.32** - Relational database management system
- **Apache Web Server** - HTTP server for web application hosting

### **Frontend Technologies**
- **HTML5** - Semantic markup and structure
- **CSS3** - Responsive design and modern styling
- **JavaScript** - Client-side interactivity and form validation
- **Chart.js** - Data visualization and analytics charts

### **Development Environment**
- **XAMPP** - Integrated development stack
- **Git** - Version control and collaboration
- **VS Code** - Integrated development environment

## 🗄️ Database Design

### **Database Schema**
The project implements a **Third Normal Form (3NF)** database design with the following core tables:

| Table | Purpose | Key Features |
|-------|---------|--------------|
| `users` | User authentication | Password hashing, session management |
| `admin` | Administrator accounts | Role-based access control |
| `evidence` | Evidence storage | File management, categorization, metadata |
| `incidents` | Case tracking | Incident documentation, reporting |
| `investigations` | Investigation management | Status tracking, progress monitoring |
| `comments` | Case notes | Collaboration, audit trails |

### **Advanced Database Features**
- **Foreign Key Constraints**: Maintains referential integrity
- **Triggers**: Automated data validation and default value assignment
- **Indexing**: Optimized query performance for large datasets
- **Transaction Support**: ACID compliance for data consistency

### **Sample Database Queries**
```sql
-- Evidence count per user with JOIN operations
SELECT users.username, COUNT(evidence.id) as evidence_count 
FROM users
LEFT JOIN evidence ON users.id = evidence.user_id
GROUP BY users.id;

-- Evidence type distribution analysis
SELECT type, COUNT(*) as count 
FROM evidence 
GROUP BY type;
```

## 🚀 Installation

### **Prerequisites**
- PHP 8.2 or higher
- MySQL 5.7 or MariaDB 10.4 or higher
- Apache Web Server
- XAMPP (recommended for development)

### **Setup Instructions**

1. **Clone the Repository**
   ```bash
   git clone https://github.com/yourusername/DIGITAL-FORENSIC-EVIDENCE-ANALYZER.git
   cd DIGITAL-FORENSIC-EVIDENCE-ANALYZER
   ```

2. **Database Setup**
   ```bash
   # Import the database schema
   mysql -u root -p < database.sql
   ```

3. **Configure Database Connection**
   - Update database credentials in PHP files
   - Ensure MySQL service is running

4. **File Permissions**
   ```bash
   # Create uploads directory with proper permissions
   mkdir uploads
   chmod 755 uploads
   ```

5. **Access the Application**
   - Open `http://localhost/DIGITAL-FORENSIC-EVIDENCE-ANALYZER`
   - Use default credentials or create new accounts

## 📱 Usage

### **User Workflow**
1. **Registration/Login**: Create account or sign in to existing account
2. **Evidence Submission**: Upload files and provide case details
3. **Case Management**: Track investigation progress and status
4. **File Access**: Download and review submitted evidence

### **Administrator Workflow**
1. **Dashboard Access**: View system-wide analytics and statistics
2. **User Management**: Monitor user activity and evidence submissions
3. **System Analytics**: Generate reports and performance metrics
4. **Data Export**: Export investigation data for external analysis

## 📁 Project Structure

```
DIGITAL-FORENSIC-EVIDENCE-ANALYZER/
├── 📄 Core Application Files
│   ├── index.html              # Landing page with dual login options
│   ├── userlogin.php           # User authentication system
│   ├── adminlogin.php          # Administrator login portal
│   ├── usersignup.php          # User registration system
│   ├── evidenceManagement.php  # Evidence handling and management
│   └── adminveiw.php           # Administrative dashboard
├── 🗄️ Database
│   ├── database.sql            # Complete database schema and sample data
│   └── PROJECT_DATABASE.zip    # Compressed database backup
├── 🎨 Assets
│   ├── style.css               # Global CSS styling
│   ├── script.js               # JavaScript functionality
│   ├── Images.zip              # Background images and icons
│   └── uploads.zip             # File storage system
└── 📚 Documentation
    └── README.md               # Project documentation
```

## 🎓 Learning Outcomes

This project demonstrates comprehensive mastery of:

### **Database Concepts**
- ✅ **Normalization**: Third Normal Form (3NF) implementation
- ✅ **Relationships**: Foreign key constraints and referential integrity
- ✅ **Query Optimization**: Complex JOINs and aggregation functions
- ✅ **Security**: SQL injection prevention and authentication

### **Web Development Skills**
- ✅ **Full-Stack Development**: PHP backend with HTML/CSS/JS frontend
- ✅ **Responsive Design**: Mobile-first approach with modern UI/UX
- ✅ **Data Visualization**: Chart.js integration for analytics
- ✅ **File Management**: Secure upload and storage systems

### **Real-World Application**
- ✅ **Problem Solving**: Converting forensic requirements to database schema
- ✅ **Workflow Modeling**: Understanding investigation processes
- ✅ **Security Implementation**: Industry-standard security practices
- ✅ **Performance Optimization**: Database and application performance tuning

## 📸 Screenshots

### **Landing Page**
*Modern landing page with parallax background and dual login options*

### **User Dashboard**
*Evidence management interface with file upload and categorization*

### **Admin Analytics**
*Interactive charts showing evidence statistics and user activity*

## 🤝 Contributing

This is a course project, but contributions and suggestions are welcome:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is developed as part of a **Database Course Curriculum** and is intended for educational purposes.

## 👨‍💻 Author

**Student Name** - Database Course Project  
**Course**: Database Management Systems  
**Institution**: [Your University Name]  
**Year**: 2024

---

## 🏆 Project Highlights

- **Comprehensive Database Design**: Demonstrates advanced SQL and database concepts
- **Professional UI/UX**: Modern, responsive interface with forensic-themed design
- **Security Implementation**: Industry-standard security practices and authentication
- **Real-World Application**: Practical implementation of forensic investigation workflows
- **Performance Optimization**: Efficient database queries and application architecture

---

⭐ **Star this repository if you find it helpful for your database studies!**
