<p align="center"><a href="https://kuoz.herokuapp.com" target="_blank"><img src="public/images/logo.png"></a></p>

<p align="center"><span style="font-size:4em;" >Kuoz</span><p>

# <span style="color:orchid">Overview</span>

This app is an exercise to experiment how Laravel Backend can communicate with Vue Frontend.

Vue makes axios calls to Laravel APIs that implement CRUD operations on a SQL Data Base (a PostgreSQL DB in this case).

<img src="public/images/preview.png">

# <span style="color:orchid">How to install it locally</span>

### Download sources

From this page, click on the "Code" green button and select **Download ZIP**.\
Unzip the downloaded file and from your command line move into the created directory where files
has been placed.

### Set Data Base parameters

Copy the **".env.example"** in a file named **".env"**

```
cp .env.example .env
```

Edit the .env file and insert the following information:

> DB_DATABASE=your_db_name <br>
> DB_USERNAME=your_username <br>
> DB_PASSWORD=your_password

NOTE: you should have been created a postgres DB before.

### Get Node Dependencies and compile

Run the following command to install all needed dependencies:

```
npm install
```

then compile:

```
npm run dev
```

### Get Composer dependencies

```
composer update
```

### Generate a Laravel key

```
php artisan key:generate
```

# <span style="color:orchid">Run application</span>

```
php artisan serve
```

You should see indications about the localhost name where the application is running,
something like the following:<br>

> Starting Laravel development server: http://127.0.0.1:8000 > [Wed Jan 20 10:26:12 2021] PHP 7.4.3 Development Server (http://127.0.0.1:8000) started

Open the indicated local address in your browser.

# <span style="color:orchid">License</span>

Kuoz is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
