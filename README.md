# Bill Split
Split the bill among friends.

## Running the App
1. ### Using php artisan serve

```
composer install
php artisan serve
```

Access the application via http://127.0.0.1:8081

2. ### Using Docker

```
docker build -t bill-split .
docker run -p 8181:8181 --name app bill-split
```

You can mount the volume for the development purposes using

```
docker run -p 8181:8181 -v $(pwd):/app --name app bill-split
```

3. Run Test cases

```
./vendor/bin/phpunit
```