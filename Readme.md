# SamplerLibrary

## Basic set up

### Instructions
The SamplerLibrary uses AngularJS, PHP, Laravel and Postgres.
So to set up the system it's necessary to install these three resources.

#### Database 
Inside the library-api:
- In the file .env, configure the database with your local information.
- Create the database with the name library in Postgres.
```
CREATE DATABASE library;
```
- Run the follwing command to create the tables:
```
php artisan migrate
```
- Run the following command to populate the tables Users and Books:
php artisan db:seed --class=UsersTableSeeder
php artisan db:seed --class=BooksTableSeeder

#### OAUTH
- Run the following command to configure the oauth passport.
```
php artisan passport:install
```
Inside the library-api:
- In the end of the file .env, include the values genrated by the command, for example:
```
CLIENT_1=p5VLkQdwEzLkK2RoYBgcvzwupSHjwMmYuqq4akcE
CLIENT_2=59V2OHSbTSpAtrZgnfzKh0FxQnG2a6tXLXzdgwhY
```

Inside the library-admin:
- In the file library-admin/src/app/public/login/login.component.ts, change 
client_id and client_secret data field to the ones generated above, for example:
```
const data = {
    username: formData.email,
    password: formData.password,
    grant_type: 'password',
    client_id: 2,
    client_secret: '59V2OHSbTSpAtrZgnfzKh0FxQnG2a6tXLXzdgwhY',
    scope: '*'
};
```

#### Turning local servers
After installing them, you can put server on using the following commands:
PHP:
```
php artisan serve
``` 
AngularJS: 
```
ng serve
```
Now you can access the interface:
http://localhost:4200/

Or you can use the api endpoints through:
http://127.0.0.1:8000

The main routes are:
- http://localhost:8000/book
- http://localhost:8000/book/change
- http://localhost:8000/book/create
- http://localhost:8000/user
- http://localhost:8000/register

#### Login
- Choose one user available in the table Users (default password secret); or
- Register your own user through the register endpoint or interface.

#### Unit tests
Run the tests written in file library-api/tests/Feature/UserActionLogTest.php, through the command:
```
vendor/bin/phpunit
```