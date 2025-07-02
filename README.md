<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com/)**
-   **[Tighten Co.](https://tighten.co)**
-   **[WebReinvent](https://webreinvent.com/)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
-   **[Cyber-Duck](https://cyber-duck.co.uk)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Jump24](https://jump24.co.uk)**
-   **[Redberry](https://redberry.international/laravel/)**
-   **[Active Logic](https://activelogic.com)**
-   **[byte5](https://byte5.de)**
-   **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Video Eduwoo File Manager

A Laravel + Livewire based file and folder manager application supporting upload, secure share links for video streaming, and access protection.

## Features

-   File upload (supports chunk upload for large files)
-   Folder & file management (rename, delete, move)
-   Share link for video/file with referer protection (can only be embedded from allowed domains)
-   Inline video streaming (not easily downloadable by IDM)
-   Pagination, search, and storage statistics
-   Modern UI with Bootstrap

## Installation

1. **Clone the repository**

    ```bash
    git clone https://github.com/username/video-eduwoo.git
    cd video-eduwoo
    ```

2. **Install dependencies**

    ```bash
    composer install
    npm install && npm run dev
    ```

3. **Copy .env and generate key**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Configure your database in `.env` and run migrations**

    ```bash
    php artisan migrate
    ```

5. **Run the server**
    ```bash
    php artisan serve
    ```

## Important Configuration

-   **Share Link Protection:**  
    Only specific domains can access video/files via share link.  
    Set allowed domains in `ShareLinkController` and CSP in your HTML embed.

-   **Storage:**  
    Files are uploaded to `storage/app/public/uploads`.  
    Run `php artisan storage:link` to make files publicly accessible.

-   **Chunk Upload:**  
    Supports large file uploads via chunking (see `UploadChunkController`).

## Folder Structure

-   `app/Http/Controllers` - Main controllers (ShareLink, UploadChunk)
-   `app/Livewire/Dashboard` - Livewire components for the dashboard file manager
-   `app/Models` - Eloquent models (File, Folder, ShareLink)
-   `resources/views/livewire/dashboard` - Main Blade views
-   `routes/web.php` - Application routes

## Security

-   Share links are only accessible from allowed referer/domains.
-   Videos are streamed inline, not easily downloadable directly.
-   Validation and protection on every file/folder action.

## Contribution

Pull requests and issues are welcome!  
Please ensure your code is tested before submitting a PR.

## License

MIT License

---

**By [Your Name/Team]**
