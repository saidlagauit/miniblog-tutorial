# Mini Blog Tutorial - CRUD

Mini Blog is a comprehensive blogging platform built with PHP and MySQL. It features a public-facing blog with a modern, responsive design and a powerful admin panel for managing content, users, and settings.

## Features

### Public Interface

- **Modern Design**: Clean and responsive UI built with Bootstrap and custom CSS.
- **Blog Posts**: Read articles with support for rich content.
- **Comments**: Interactive comment system for user engagement.
- **Contact Form**: Integrated contact page for user inquiries.
- **About Page**: dedicated section for author biography and skills.

### Admin Panel (Owner Area)

- **Dashboard**: Overview of site statistics (articles, comments, visits).
- **Article Management**: Create, read, update, and delete (CRUD) blog posts.
- **Category & Tag Management**: Organize content effectively.
- **Comment Moderation**: Approve or delete user comments.
- **User Management**: Manage admin and author accounts.
- **Responsive Sidebar**: Easy navigation on both desktop and mobile devices.
- **Security**:
  - Secure session management.
  - Input sanitization using `FILTER_SANITIZE_SPECIAL_CHARS`.
  - Protection against SQL injection and XSS.

## Tech Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL / MariaDB
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Server**: Apache (via XAMPP/WAMP/MAMP)

## Installation

1. **Clone the Repository**

    ```bash
    git clone https://github.com/saidlagauit/miniblog-tutorial.git
    cd miniblog-tutorial
    ```

2. **Database Setup**
    - Create a new MySQL database named `mini_blog`.
    - Import the `db/miniblog.sql` file into your database.
      - _Note: The SQL file contains the table structure. You may need to create an initial admin user manually or insert sample data if preferred._

3. **Configuration**
    - Verify database credentials in `owner/connect.php` (default: localhost, root, no password).

4. **Run the Project**
    - Place the project folder in your server's root directory (e.g., `htdocs` for XAMPP).
    - Access the public site: `http://localhost/miniblog-tutorial/`
    - Access the admin panel: `http://localhost/miniblog-tutorial/owner/`

## Default Login Credentials

**Admin Panel URL**: `http://localhost/miniblog-tutorial/owner/index.php`

- **Username**: `lagauit`
- **Password**: `123`

## Recent Updates

- **Slug Support**: Articles and comments now use SEO-friendly slugs instead of IDs.
- **UI Improvements**: Enhanced styling for the homepage, about, and contact pages.
- **Admin Sidebar**: New responsive sidebar for better dashboard navigation.
- **Code Cleanup**: Removed deprecated filters and improved error handling.
