composer install
copy .env.example .env
php artisan key generate
php artisan migrate:fresh
php artisan db:seed
php artisan serve