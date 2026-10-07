# The Money Circle — Backend API & Coach Back Office

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Live Production](https://img.shields.io/badge/Live-moneycircle.microsilsystem.co.ke-success)](https://moneycircle.microsilsystem.co.ke)
[![License](https://img.shields.io/badge/License-Proprietary-red)](#)

The central server engine, RESTful API, Coach administration portal, and distribution hub for **The Money Circle** financial coaching platform in Kenya.

---

## 🏛️ System Architecture

### 1. RESTful Mobile API (`/api/*`)
* **Sanctum Authentication**: Secure bearer token issuance, registration, verification codes, and profile management.
* **Dashboard Aggregations**: Net cashflow, total monthly expenditure, total income, and remaining category budgets.
* **Income & Transactions Engine**: Flexible transaction storage supporting income streams and categorized expenses with resilient float serialization.
* **Recurring Bills Management**: Full CRUD (`/api/recurring-bills`) supporting monthly utility tracking, due date reminders, and payment logging.
* **Budget Categories & Reset Utilities**: Endpoints for category spending reset (`/categories/{id}/reset-spending`) and total expense reset (`/transactions/reset-expenses`).
* **Wealth Tracking**: Endpoints for Debts, Emergency Funds (MMF), Savings Goals, and Investments.
* **In-App Auto-Update Handshake**: `/api/app/version` delivers the latest version numbers, build counters, forced-update flags, and release notes to active client apps.

### 2. Coach Back Office (`/coach-dashboard`)
* **Member Overview & Analytics**: Inspect active member net cashflow, monthly expenditure vs budget, and debt loads.
* **Financial Drill-Downs**: Drill into individual member categories, recent expense lists, recurring utility commitments, and income breakdowns.
* **Direct Advice & Nudges**: Leave contextual coaching notes and feedback directly on a member’s reflection or budget category.

### 3. Community Operations Suite (`/coach/*`)
* **Announcements**: Broadcast pinned alerts with custom action links to the mobile and web app.
* **Live Sessions**: Schedule coaching calls and webinars.
* **Resource Library**: Upload and manage financial templates, guides, and worksheets.
* **Q&A Desk**: Review and answer financial questions submitted by circle members.
* **Wins Wall**: Moderate financial milestones and celebrate debt-free achievements.

### 4. Public Web Portal & App Distribution
* **Responsive Landing Page**: Built in Blade with Tailwind CSS (`resources/views/welcome.blade.php`).
* **Direct Android Distribution**: Serves [`/downloads/TheMoneyCircle.apk`](file:///d:/Projects/TheMoneyCircle/public/downloads/TheMoneyCircle.apk) directly from the server.
* **Progressive Web App (PWA) Host**: Serves the compiled Flutter Web App inside [`/app/`](file:///d:/Projects/TheMoneyCircle/public/app/) with `.htaccess` SPA fallback routing, giving iPhone users a full-screen app without App Store installation.

---

## 🚀 Local Development Setup

### Prerequisites
* PHP 8.2 or newer
* Composer 2.x
* MySQL or SQLite

### 1. Installation
```bash
git clone https://github.com/stevescilar/TheMoneyCircle.git
cd TheMoneyCircle
composer install
```

### 2. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```
Configure your database settings in `.env`:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=moneycircle_db
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Run Database Migrations
```bash
php artisan migrate
```

### 4. Start Local Server
```bash
php artisan serve
```
Access the application at `http://localhost:8000`.

---

## 🌐 Find It Here

The live production application is hosted at **`https://moneycircle.microsilsystem.co.ke/`** 
---


## 👨‍💻 Developer & Support

```text
Developed by: Muambi.Dev @ Microsil System
Call / WhatsApp: 0793800603
Email: solutions@microsilsystem.co.ke
Web: https://microsilsystem.co.ke
```
