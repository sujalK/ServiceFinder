# Service Finder

Service Finder is a PHP and MySQL web application for finding nearby services and businesses. Visitors can search by service name, tags, and location. Registered business owners can publish and manage service listings, while administrators can manage users, listings, categories, and reviews.

The website is also branded as **FindNearMe** in parts of the user interface.

## Main features

- Search for verified services by name, tags, and location
- View service details, images, contact information, maps, and certificates
- Register as a regular user or business owner
- Verify new accounts by email
- Log in and manage sessions
- Add and manage business listings
- Upload multiple images for a service
- Add reviews and votes
- Approve or reject reviews
- Send and respond to service notifications
- Manage users, categories, and service approval from the user panel
- Send messages from the contact page
- Edit content with TinyMCE

## Technology used

- PHP
- MySQL / MariaDB
- Apache (XAMPP is suitable for local development)
- HTML, CSS, and JavaScript
- PHPMailer for SMTP email
- TinyMCE for rich-text editing
- Leaflet for maps
- Fancybox for image galleries

PHPMailer is included in the `mailer/` directory, so Composer is not required for the current project.

## Local setup with XAMPP

1. Place the project inside the XAMPP web directory:

   ```text
   /Applications/XAMPP/xamppfiles/htdocs/service_finder
   ```

2. Start Apache and MySQL from XAMPP.

3. Create a MySQL database named:

   ```text
   business_finder
   ```

4. Import the project's database schema and data.

   This repository currently does not contain a `.sql` dump. You will need an existing copy of the database or must create the required tables manually.

5. Check the local database settings in `helpers/credentials.php`. The current XAMPP defaults are:

   ```php
   define("DB_SERVER", "localhost");
   define("DB_NAME", "business_finder");
   define("DB_USER", "root");
   define("DB_PASS", "");
   ```

6. Open the application:

   ```text
   http://localhost/service_finder/
   ```

## Local secrets and API keys

Real credentials must never be committed to Git.

Copy the example configuration:

```bash
cp helpers/env.local.example.php helpers/env.local.php
```

Then open `helpers/env.local.php` and replace the placeholders:

```php
putenv('SMTP_USERNAME=you@example.com');
putenv('SMTP_PASSWORD=your-secret');
putenv('TINYMCE_API_KEY=your-tinymce-key');
```

`helpers/credentials.php` loads this local file automatically. The actual `helpers/env.local.php` file is ignored by Git, while `helpers/env.local.example.php` is safe to commit as a template.

The SMTP configuration currently uses PrivateEmail with SSL on port 465.

## Database tables

Based on the application queries, the project expects tables including:

- `users`
- `services`
- `service_category`
- `vote_and_reviews`
- `notification`
- `login_logs`
- `inactive_service_log`
- `re_active_service_log`

The exact columns and indexes must match the PHP code. In particular, service search uses MySQL full-text search, so suitable full-text indexes may be required.

## Important folders

```text
classes/       PHP classes for users, services, email, sessions, and uploads
css/           Website styles
helpers/       Bootstrap, database, utility, and local environment configuration
images/        Static images
js/            Frontend JavaScript
mailer/        Bundled PHPMailer library
uploads/       User-uploaded service images and documents
user_panel/    Business-owner and administrator pages
utilities/     Logout and chat-related utilities
```

## Git workflow

Development work should normally be done on `dev`:

```bash
git switch dev
```

After testing, merge it into `master`:

```bash
git switch master
git merge dev
```

Keep `master` as the stable branch and avoid committing local secrets, uploaded private documents, or machine-specific configuration.

## Security notes

- Change any credential that has previously been exposed.
- Never add real values to `helpers/env.local.example.php`.
- Do not use the default MySQL `root` account with an empty password in production.
- Restrict the TinyMCE key to approved domains.
- Use HTTPS in production and enable secure session cookies.
- Treat uploaded citizenship documents and other user files as private data.

## Current limitations

- No database SQL dump is included.
- There is no automated test suite.
- Some configuration and URLs are specific to the original deployment.
- Production deployment requires stronger database, upload, session, and server security settings.
