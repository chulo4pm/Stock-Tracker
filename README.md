# Stock Tracker – Warehouse Inventory System

A web-based inventory and point-of-sale system for a furniture warehouse, built with **PHP** and **MySQL**. Managers and staff log in with role-based access to manage stock, process sales and review history.

> Final project(October 2025)


## Features

- Role-based login (manager / staff) with hashed passwords
- Dashboard for managers; inventory view for staff
- Inventory by category: tables, chairs, cabinets, beds
- Add, edit and view items, with image upload
- Shopping cart and checkout that deducts stock
- Restocking with restock history
- Sales / transaction history
- Staff list management

## Tech stack

PHP 8 · MySQL / MariaDB (`mysqli`, prepared statements) · HTML · CSS · XAMPP for local development

## Screenshots

_Add screenshots here, e.g. `docs/login.png`, `docs/dashboard.png`, `docs/inventory.png`._

## Getting started (local)

1. Install [XAMPP](https://www.apachefriends.org/) and start **Apache** and **MySQL**.
2. Copy this folder into `C:\xampp\htdocs\` (any folder name works, e.g. `stock_tracker_warehouse`).
3. Open phpMyAdmin and import `database.sql`.
4. Copy `config.example.php` to `config.php` and set your DB host, user, password and port.
5. Visit `http://localhost/<folder-name>/login.php`.

Or without XAMPP's Apache: run `php -S localhost:3000` in the project folder and open `http://localhost:3000/login.php`.

### Demo accounts

| Role    | Email                | Password |
|---------|----------------------|----------|
| Manager | manager@local.test   | 1234     |
| Staff   | staff@local.test     | 1234     |

Change these before deploying anywhere public.

## Deployment

GitHub Pages cannot run PHP. Use a PHP + MySQL host (e.g. InfinityFree, a shared host, or a VPS):

1. Upload the project files.
2. Create a database and import `database.sql`.
3. Create `config.php` from `config.example.php` with the host's DB credentials (or set `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`, `DB_PORT` environment variables).
4. Make sure `assets/uploads/` is writable.

## Project structure

```
auth/      login, register, logout
pages/     dashboard, inventory, cart, restock, transactions, staff list
assets/    css, images, backend handlers (assets/backends), uploads
includes/  shared UI (sidebar)
```
