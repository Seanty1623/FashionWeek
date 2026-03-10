# Fashion Week LOS - Laravel Edition

A Laravel conversion of the Fashion Week LOS Clothes Selector & Voting System for Lyceum of Subic Bay.

## Features

- **Clothes Selector**: Select outfit items from Tops, Bottoms, Shoes, and Accessories
- **Photo Upload**: Submit fashion photos with student name, year level, and description
- **Gallery**: View all submissions with like functionality
- **Leaderboard**: See rankings by likes with winner spotlight
- **Outfit Builder**: Save outfit combinations from the clothes selector to the gallery

## Requirements

- PHP 8.2+
- Composer
- SQLite (default) or MySQL/PostgreSQL
- Node.js & NPM (optional, for asset building)

## Installation

1. **Install dependencies** (already done if you cloned):
   ```bash
   composer install
   ```

2. **Configure environment**:
   - Copy `.env.example` to `.env` if not already done
   - Generate app key: `php artisan key:generate`
   - Database is configured for SQLite by default (database/database.sqlite)

3. **Run migrations**:
   ```bash
   php artisan migrate
   ```

4. **Create storage link** (for uploaded images):
   ```bash
   php artisan storage:link
   ```

5. **Start the development server**:
   ```bash
   php artisan serve
   ```

6. Visit `http://localhost:8000` in your browser.

## Project Structure

```
app/
├── Http/Controllers/
│   └── PhotoController.php    # Handles photos, uploads, likes
├── Models/
│   ├── Photo.php
│   └── PhotoLike.php

database/migrations/
└── 2024_12_01_000000_create_photos_table.php

resources/views/fashion/
├── layout.blade.php
├── index.blade.php
└── partials/
    ├── navbar.blade.php
    ├── footer.blade.php
    ├── gallery.blade.php
    └── leaderboard.blade.php

public/
├── css/fashion.css
└── js/fashion.js
```

## Voting System

Likes are tracked per session. Each browser session can like a photo once. The session ID is stored to prevent duplicate likes from the same visitor.

## File Uploads

- Max file size: 5MB
- Allowed formats: JPG, PNG, GIF
- Images are stored in `storage/app/public/photos/`
- Access via `/storage/photos/filename.jpg` (after `php artisan storage:link`)

## License

MIT
