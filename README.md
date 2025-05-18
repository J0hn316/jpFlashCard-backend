# JP Flashcard Backend

A Laravel 12 API backend for managing Japanese vocabulary flashcards and quiz results, with Sanctum‐powered token authentication.

## Requirements

-   PHP ≥ 8.4
-   Composer
-   MySQL (or compatible)
-   Python 3 (for optional cleaning script)

## Installation

```bash
# 1. Clone the repo
git clone https://github.com/your-org/jpflashcard-backend.git
cd jpflashcard-backend

# 2. Install PHP dependencies
composer install

# 3. Copy .env and generate an app key
cp .env.example .env
php artisan key:generate

```
