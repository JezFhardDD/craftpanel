<div align="center">

# ⛏️ CRAFTPANEL

**A Minecraft-inspired server & community management platform**

Built with Laravel, Inertia.js, and Vue 3

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Vue](https://img.shields.io/badge/Vue-3-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white)
![Inertia.js](https://img.shields.io/badge/Inertia.js-2.0-9553E9?style=for-the-badge&logo=inertia&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-Database-003B57?style=for-the-badge&logo=sqlite&logoColor=white)

</div>

---

## 📖 About

**CRAFTPANEL** is a full-stack web application that simulates a Minecraft server management dashboard. It lets **Players** join worlds, complete quests, and climb leaderboards, while **World Owners** create and manage their own worlds, and **Admins** oversee the whole community.

> [!NOTE]
> This project was built as a **school/academic exercise** to practice and learn full-stack web development — specifically the **Laravel + Inertia.js + Vue 3** stack. The main goals were to get hands-on experience with the framework's conventions, MVC architecture, authentication scaffolding, Eloquent relationships, and building a role-based SPA-like application. It is **not** a production-ready product — think of it as a structured playground for learning software engineering fundamentals (routing, controllers, models, migrations, middleware, policies, and component-driven frontend design).

---

## ✨ Features

- 🔐 **Authentication** — registration, login, email verification, password reset (Laravel Breeze-based)
- 🧑‍🤝‍🧑 **Role-based access** — `Player`, `World Owner`, and `Admin` roles with dedicated dashboards and middleware guards
- 🌍 **World management** — create, edit, join, leave, and delete worlds with configurable player limits, status, and backgrounds
- 🗺️ **Quest system** — world owners create quests; players acquire, track progress, and complete them
- 🏆 **Leaderboards** — global player rankings by level, XP, and kills
- 👥 **Player profiles & stats** — level, XP, PvP/PvE kills, achievements, friends
- 🛡️ **Authorization policies** — Laravel policies/gates controlling who can manage which world
- ⚡ **SPA-like experience** — powered by Inertia.js, no separate REST API needed

---

## 🏗️ Tech Stack & Architecture

| Layer | Technology |
|---|---|
| Backend | Laravel 12 (PHP 8.2+) |
| Frontend | Vue 3 (Composition API, `<script setup>`) |
| Bridge | Inertia.js (server-driven SPA, no separate API layer) |
| Styling | Tailwind CSS |
| Database | SQLite (dev) — swappable via Laravel's DB config |
| Auth | Laravel Breeze scaffolding |
| Build tool | Vite |

The app follows a fairly standard **Laravel MVC** structure, with Inertia used to render Vue "pages" instead of Blade views for the authenticated app:

```
app/
 ├── Http/
 │    ├── Controllers/       # Route logic (Dashboard, World, Profile, Auth, etc.)
 │    └── Middleware/        # Role-based route protection
 ├── Models/                 # Eloquent models (User, World, Quest, Player, ...)
 └── Policies/                # Authorization rules (WorldPolicy, etc.)

database/
 ├── migrations/             # Schema definitions
 └── factories/ & seeders/   # Test/demo data

resources/
 ├── js/Pages/                # Vue pages rendered via Inertia
 ├── js/Components/            # Reusable Vue components
 └── js/Layouts/               # Shared page layouts

routes/
 ├── web.php                  # Application routes
 └── auth.php                 # Auth-related routes
```

---

## 🚀 Getting Started

```bash
# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Copy env file & generate app key
cp .env.example .env
php artisan key:generate

# Set up the database (SQLite by default)
touch database/database.sqlite
php artisan migrate --seed

# Run the app (server + queue + vite, all in one)
composer run dev
```

Then visit `http://localhost:8000` 🎉

---

## 🎓 Learning Objectives

This project was used as a hands-on way to practice:

- Laravel's routing, controllers, and request validation
- Eloquent relationships (`hasOne`, `belongsToMany`, pivot tables, policies)
- Middleware-based role authorization
- Inertia.js as a bridge between Laravel and Vue (no traditional REST API)
- Component-based frontend architecture with Vue 3
- Database migrations and schema evolution over time
- General software engineering practices in a full-stack context

---

## 👥 Team

Jezreel Villanueva: Fullstack Developer
Ace York Buban: UI/UX Designer

---

## 📄 License

This project is for educational purposes and is open for learning reference.
