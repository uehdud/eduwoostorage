
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
