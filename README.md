# Pokemon Card Tracker

### Setup
 - Copy .env.example -> .env
 - update db creds
 - run `composer install`
 - run `npm install`
 - run `php artisan migrate`
 - run `php artisan app:create-user`

### Running the project
Assuming you have either setup a vhost, docker setup or just plan to run it through `php artisan serve` you should be largely good to go...

### Checks

#### Check 1. PHP Linter
- <code>vendor/bin/phplint ./ --exclude=vendor</code>

#### Check 2. PHP Code Style Checker - PSR12
https://www.php-fig.org/psr/psr-12/
- <code>vendor/bin/phpcs ./app</code>

If the CS Checker comes back with errors that it can automaticlly fix, run
- <code>vendor/bin/phpcbf ./app</code>

and it should fix them.
