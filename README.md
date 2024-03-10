# Assignment 2 Solution

## Setup

Ensure you create the database schema with the `database/schema.sql` file. The credentials for the database can be added within the Repository.php file.

## Install dependencies

```
npm i
```

```
composer install
```

## Running the application

You can run the application using the built-in PHP web server.

For example:

```
php -S localhost:7777 -t public/
```

### Compile and hot-reload CSS assets

```
npx tailwindcss -i views/css/input.css -o ./public/dist/output.css --watch
```
