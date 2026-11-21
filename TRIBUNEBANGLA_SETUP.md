# TribuneBangla deployment notes

This branch preserves the existing Laravel/Blade theme and reads the public news feed and active categories from the TribuneBangla Supabase project.

## Server environment

Configure the actual server .env privately. Do not commit database passwords, SMTP passwords, or admin passwords.

Required values:

- APP_URL=https://tribunebangla.com
- APP_TIMEZONE=Asia/Dhaka
- DB_CONNECTION=mysql and the hosting MySQL database credentials
- SUPABASE_URL=https://tdyrxdnqyuebtzhjuprh.supabase.co
- SUPABASE_PUBLISHABLE_KEY (public client key; the code has a fallback, but an environment override is preferred)
- SMTP mail settings if admin password-reset email is required

For first-time admin creation, set ADMIN_NAME, ADMIN_EMAIL, and a strong ADMIN_PASSWORD in the server environment. The seeder creates the account only if that email does not already exist; it does not overwrite an existing admin password.

## First deployment commands

Run from the Laravel project directory:

    composer install --no-dev --optimize-autoloader
    php artisan key:generate
    php artisan migrate --force
    php artisan db:seed --force
    php artisan storage:link
    php artisan optimize:clear
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

After confirming the site is healthy, remove ADMIN_PASSWORD from the server environment if it is no longer needed for initial setup.

## Data-source boundary

- Public homepage, category navigation, article pages, and the admin read-only “সাইটে প্রকাশিত সংবাদ” list read published rows from Supabase using the publishable key and public RLS policies.
- The legacy Laravel admin News CRUD and its category/settings forms still use the Laravel MySQL schema. They do not write to the Supabase news tables. Do not assume an edit in that legacy screen changes a public Supabase article.
- Only the public, published article body supplied by Supabase is displayed. Short source bodies are not expanded with invented text; the article page retains its source link.

## Safety

Keep the Supabase service-role key out of the browser and repository. The public Laravel feed uses only the publishable key. Production deployment is not performed by these repository commits.
