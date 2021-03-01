## Fakunle, Mobolaji Johnson
Email: abjmobolaji@gmail.com <br/>
Phone No: 07039486879

## Full stack Laravel Developer Assessment
Test Url: http://localhost:8000 (php artisan serve)

## Installation

<b>Requirements</b> <br/>
* MySQL/PHP (E.g WAMP/XAMPP)
* Composer
* Laravel
* Database
<br/>
<b>Configurations</b> <br/>
- After cloning repo, copy the content of .env.example to a new .env file in the same location.
- .env File Configuration - Update the database details (host, username, password, database name)
- Run command a "composer install" to install the dependencies.
- Run command b "php artisan key:generate" to generate app key
- Run command c "php artisan migrate" to connect and create tables
- Run command d "php artisan serve" to start development server
- Run command e "vendor\bin\phpunit" to start the test 
<br/><br/>
<b>Commands</b> <br/>
<b>a - Install Composer Dependencies</b> -- "composer install"<br/>
<b>b - Generate app key</b> -- "php artisan key:generate"<br/>
<b>c - Migrate Database</b> -- "php artisan migrate" <br/>
<b>d - Start Server</b> -- "php artisan serve" <br/>
<b>e - Run Tests</b> -- "vendor\bin\phpunit" <br/>

## Files
<b>View</b> <br/>
* resources/views/index.blade.php
* public/assets/style.css
* public/assets/script.js

<b>Controllers</b> <br/>
* app/Http/Controller/ApiController.php

<b>Database & Model</b> <br/>
* database/migrations/2021_02_26_180418_create_books_table.php
* app/Models/Books.php

<b>Routes</b> <br/>
* routes/api.php
* routes/web.php

<b>Test</b> <br/>
* tests/Feature/BookTest.php

## API Documentation
https://documenter.getpostman.com/view/13609645/TWDdiZL4



