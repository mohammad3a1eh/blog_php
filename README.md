# Blog PHP

A simple and clean blog application built with **PHP** and **Bootstrap**, allowing you to create, manage, and publish blog posts with support for comments and moderation.

## Features
- Create, edit, publish, and unpublish blog posts
- Add, accept, and manage comments on posts
- Pagination for listing posts and comments
- Upload and manage user profile image
- Simple and responsive UI using Bootstrap

## Requirements
- PHP 7.x or newer
- MySQL or compatible database
- Web server (e.g. Apache with mod_rewrite enabled)
- **Bootstrap** (integrated via `css/` and `js/` folders)

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/mohammad3a1eh/blog_php.git
   cd blog_php
   ```
2. Import the provided SQL schema (if available) into your MySQL database.
3. Update database credentials in `lib/config.php` (or wherever your DB config is).
4. Ensure `upload_profile.php` is writable by the server (for image uploads).
5. Run the application by accessing `index.php` in your browser.
6. Use moderation features to publish posts and comments as needed.

## Usage
- Navigate to the homepage (`index.php`) to see published blog posts.
- To create a post: `new_post.php`
- To edit or delete: use the respective PHP files (`edit_post.php`, `drop.php`)
- Moderate posts via moderation list (`accept_post_list.php`), accept with `accept_post.php`
- Manage comments similarly
- Upload a profile image with `upload_profile.php`
- The site is styled using Bootstrap for a responsive layout.

## License
This project is licensed under the **GNU GPL‑3.0 License**. See the [LICENSE](LICENSE) file for details.
