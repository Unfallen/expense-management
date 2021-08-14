
# Expense Manager

## Tech Specification

- Laravel 8
- Vue 2 + VueRouter + vue-progressbar + sweetalert2 + laravel-vue-pagination
- Laravel Passport
- Admin LTE 3 + Bootstrap 4 + Font Awesome 5

## Install with Docker

- `docker-compose up -d --build`
- `docker exec -it expense-app bash`
- `composer install`
- `cp .env.example .env`
- `php artisan key:generate`
- `php artisan migrate:fresh --seed`
- `php artisan passport:install`
- Application: http://localhost:8000/
- username: admin@admin.com
- password: 123456


## Unit Test

#### run PHPUnit

```bash
docker exec -it expense-app bash

# run PHPUnit all test cases
vendor/bin/phpunit
# or Feature test only
vendor/bin/phpunit --testsuite Feature
```

## License

[MIT license](https://opensource.org/licenses/MIT).
