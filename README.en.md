# 🔍 Lost & Found System - University of Tabuk

A simple PHP + MySQL web application for managing lost and found items on campus, with an admin dashboard.

**Developed by:** Ali Mohammed — Department of Information Technology, College of Computers and Information Technology, University of Tabuk.

## ✨ Features

- Public homepage listing approved lost/found items
- Admin dashboard protected by login
- Add, edit, and delete items, each with an uploaded image
- Change item status (pending / approved / claimed)
- Quick stats overview in the dashboard

## 🏗️ Project Structure

```
├── index.php              # Public homepage
├── config.example.php     # Database connection template
├── includes/
│   ├── header.php
│   └── footer.php
├── admin/
│   ├── login.php
│   ├── logout.php
│   ├── dashboard.php
│   ├── add_item.php
│   ├── edit_item.php
│   └── manage_items.php
├── uploads/                # Uploaded item images (empty in the repo)
└── database/
    └── lost_found_project.sql
```

## 🚀 Running Locally

1. Install XAMPP or any local PHP + MySQL environment.
2. Import the database from `database/lost_found_project.sql` (create a database named `lost_found_project` first).
3. Copy `config.example.php` to `config.php` and update the connection details for your environment.
4. Place the project folder inside `htdocs` (or the equivalent path) and open it in your browser.

### ⚠️ Important: activating the default admin account

The default password stored in the SQL file is a plain-text string (`admin`), while the login page uses `password_verify()`, which requires a hashed password. **Login will not work** until you run the `change_pass.php` script once after importing the database, to generate a proper hashed password for the `admin` account.

## 🔒 Security notes before deploying publicly

- **`change_pass.php`**: this script resets the admin password back to `admin` for anyone who opens the URL directly, with no authentication at all. It's only useful for initial setup — it's excluded via `.gitignore`, and should be deleted from the server entirely after first use (or protected behind an additional check) before any public deployment.
- **`config.php`**: contains your database connection details, so it's excluded from version control. Use `config.example.php` as a template instead.
- There's no CSRF protection on the forms (add/edit/delete) — acceptable for a student project, but worth noting if actually deployed.
- Queries use `real_escape_string` and `intval` appropriately to prevent SQL injection in most places.

## 📄 License

Student project — open for use and modification.
