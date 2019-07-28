# Bill Split
Split the bill among friends.

## Running the App
1. ### Using php artisan serve

```
composer install
cp .env.example .env
php artisan serve

# Access the application via http://127.0.0.1:8080
```


2. ###  (WIP) Using Docker

```
docker build -t bill-split .
docker run -p 8181:8181 --name app bill-split
```

You can mount the volume for the development purposes using

```
docker run -p 8181:8181 -v $(pwd):/app --name app bill-split
```

## Run Test cases

```
./vendor/bin/phpunit
```

# Suggested Enhancements

> Integrate Database to provide more features.

Adding DB to the system can enable the User registration and data persistency. Then Users can upload multiple documents daily and get the summary anytime.
Also then the System can handle groups of friends and more flexibility of calculating the data.

> Improve the Security

System security can be improve by following given actions.

- Prevent Cross-site request forgery
- Adding Captcha to restrict unnecessary uploads
- User Registration process

> User Experience

Every user doesn't know how to upload or paste JSON data to the system. UX perspective it's vital for enable User Friendly Interface to enter the data to the system.

- Provide fields to enter each piece of data
- Add validations
- Temporary savings (session)
- Converting the site to SPA using frontend frameworks like React, Vue to enhance the user experience.
- Add sharing, printind, exporting, notifiying (emails) features to remind the bill amounts to each user in the group.
- Develop Mobile application

