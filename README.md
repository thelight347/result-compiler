# Ato Salvation Result Compiler System

## Description
A Laravel-based web application for managing academic results in primary and secondary schools.

## Features
- Automated result computation
- Teacher and Admin dashboards
- Cloud backup with Google Drive
- Role-based access control
- Printable result sheets

## Installation

### Prerequisites
- PHP 8.1 or higher
- Laravel 11
- MySQL 8.0
- Composer
- Node.js and npm

### Steps
1. Clone the repository:
```
   git clone https://github.com/YOUR_USERNAME/Ato-Salvation-Result-Compiler.git
   cd Ato-Salvation-Result-Compiler
```

2. Install dependencies:
```
   composer install
   npm install
```

3. Set up environment:
```
   cp .env.example .env
   php artisan key:generate
```

4. Create database:
```
   php artisan migrate
   php artisan db:seed
```

5. Run server:
```
   php artisan serve
```

6. Access at: http://localhost:8000

## Default Login Credentials
- **Headmaster**: headmaster@school.com / password123
- **Teacher**: teacher@school.com / password123

## Project Structure
- `/app` - Application logic (Models, Controllers)
- `/resources` - Views and assets
- `/routes` - API and web routes
- `/database` - Migrations and seeders

## Author
Ato Salvation

## License
MIT License

## Support
For issues or questions, contact your instructor.
```

---

### **PHASE 4: UPLOAD PROJECT TO GITHUB**

#### **Step 8: Open Terminal/Command Prompt**
Navigate to your project folder:
```
cd path/to/Ato-Salvation-Result-Compiler
```

#### **Step 9: Initialize Git Repository**
```
git init
```

#### **Step 10: Add Files to Git**
```
git add .
```

#### **Step 11: Create Initial Commit**
```
git commit -m "Initial commit: Ato Salvation Result Compiler System"
```

#### **Step 12: Add Remote Repository**
Go to your GitHub repository and copy the HTTPS URL (looks like: `https://github.com/YOUR_USERNAME/Ato-Salvation-Result-Compiler.git`)

Then run:
```
git remote add origin https://github.com/YOUR_USERNAME/Ato-Salvation-Result-Compiler.git
git branch -M main
git push -u origin main
```

When prompted, enter your GitHub username and password (or Personal Access Token).

---

### **PHASE 5: ADD YOUR LECTURER AS COLLABORATOR**

#### **Step 13: Invite Lecturer to Repository**
1. Go to your repository on GitHub
2. Click **Settings** (in the repository menu)
3. Click **Collaborators** (left sidebar)
4. Click **Add people**
5. Enter your lecturer's GitHub username or email
6. Click **Add [username] to this repository**
7. Choose permission level: **Maintain** or **Push**

#### **Step 14: Send Invitation Link**
Your lecturer will receive an invitation. They need to:
1. Accept the invitation
2. Go to the repository URL

---

### **PHASE 6: YOUR LECTURER DOWNLOADS & RUNS THE PROJECT**

#### **How Your Lecturer Can Access:**

**Option A: Download as ZIP**
1. Click **Code** (green button)
2. Click **Download ZIP**
3. Extract and run locally

**Option B: Clone Repository**
Your lecturer runs:
```
git clone https://github.com/YOUR_USERNAME/Ato-Salvation-Result-Compiler.git
cd Ato-Salvation-Result-Compiler
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

---

## 📋 **QUICK REFERENCE CHECKLIST**

- ✓ Install Git on your computer
- ✓ Create GitHub account
- ✓ Create new repository on GitHub
- ✓ Prepare project folder with good structure
- ✓ Create `.gitignore` file
- ✓ Create detailed `README.md`
- ✓ Run `git init` in your project folder
- ✓ Run `git add .`
- ✓ Run `git commit -m "message"`
- ✓ Run `git remote add origin [your-repo-url]`
- ✓ Run `git push -u origin main`
- ✓ Add lecturer as collaborator in GitHub Settings
- ✓ Send repository URL to lecturer

---

## 🔑 **IMPORTANT NOTES:**

1. **Personal Access Token**: If asked, create a token instead of using password:
   - GitHub Settings → Developer settings → Personal access tokens
   - Generate new token with "repo" permission
   - Use token as password when pushing

2. **Keep .env Secret**: Never commit `.env` file (use `.gitignore`)

3. **Future Updates**: To push updates later:
```
   git add .
   git commit -m "Update message"
   git push