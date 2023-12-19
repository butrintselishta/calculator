
# CALCULATOR APP    


## Getting Started
These instuctions below will get you a copy of the project up and running on your local machine for development and testing purposes.

### Requirements
Before setting up the project, ensure that your machine meets the following mandatory requirements:
```bash
- Git
- PHP Version 8.1
- Composer
- MySQL
```

Apart from the mandatory requirements, there are optional tools and packages that can significantly improve your development experience and are optional but still suggested to have:

### Optional Enhancements

###### [LARAVEL VALET](https://laravel.com/docs/8.x/valet)

## Application Setup
To set up the project on your **local machine**, follow these steps:

1. Clone the repository from Github:
```bash
git clone git@github.com:butrintselishta/calculator.git
```
<br/>

2. Navigate to the Project Folder, so in your terminal where you cloned the repository execude this command:
```bash
cd calculator
```
<br/>

3. Checkout to master branch by executing this command in your terminal:
```bash
git checkout master
```

<br/>

4. Install application's dependencies by writing this in your terminal:
```bash
composer install
```

<br/>

4. Install npm dependencies by writing this in your terminal:
```bash
npm install
```

<br/>

5. Copy `.env.example` to `.env` by executing this command in your terminal:
```bash
cp .env.example .env
```
And then create the database in your database manger (MySQL).
##### NOTE about ***.env***
> This file contains all the configuration settings for your application. While it comes preloaded with default configurations, you may need to modify or append certain values to match your specific environment. For instance, **DB_DATABASE** relies on your MySQL database name choice, so ensure alignment accordingly.

<br/>

7. Run database migrations
##### Migrations IMPORTANT NOTE 1:
> Before running your migrations, ensure that you have the correct configuration for your database by checking and adjusting the following variables: `DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD`.

If everything looks alright, you run the Database migrations by writing this in your terminal:
```bash
php artisan migrate
```

<br/>
8. Start the Development Server:

Initiate your development server by running the following command in your terminal:
```bash
php artisan serve
```
This command sets up the server and provides a convenient way to access your application for testing and development.
