# 🚀 Laravel Blog Backend — REST API

A robust, production-ready REST API for a blog application built with Laravel 12, MySQL, Sanctum authentication, and Cloudinary for image uploads.

---

## ✨ Features

- 🔐 **Authentication** — Register, Login, Logout with Laravel Sanctum (API tokens)
- 👑 **Admin Panel** — Role-based authorization (admin/user)
- 📝 **Posts** — Full CRUD operations with slug-based URLs
- 🏷️ **Categories** — Manage categories with post counts
- 💬 **Comments** — Users can comment on posts
- 🖼️ **Image Upload** — Cloudinary integration for secure image storage
- 📊 **Pagination** — Built-in pagination for posts and admin lists
- 🔍 **Search & Filter** — Search posts by title, filter by category
- ✅ **Validation** — Request validation with custom error messages
- 📦 **API Resources** — Data transformation for consistent JSON responses
- 🧪 **Factories & Seeders** — Generate fake data for testing
- 🛡️ **CORS** — Configured for frontend integration

---

## 🛠️ Tech Stack

| Technology | Purpose |
|------------|---------|
| Laravel 12 | Backend framework |
| MySQL | Database |
| Laravel Sanctum | API authentication |
| Cloudinary | Image upload & storage |
| Postman/Thunder Client | API testing |

---

## 📦 Installation

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM (for Vite)
- Cloudinary account (for image upload)

### Steps

```bash
# Clone the repository
git clone https://github.com/YOUR_USERNAME/blog-backend.git

# Navigate to project directory
cd blog-backend

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env
DB_DATABASE=blog_db
DB_USERNAME=root
DB_PASSWORD=

# Run migrations
php artisan migrate

# Seed database (categories + admin user)
php artisan db:seed

# Start development server
php artisan serve
