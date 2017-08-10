# Ingestion Dashboard Api

Ingestion dashboard is a dashboard to monitor the ingestion processes. For instance: which batch is still processing, what are the movies that are still not yet encoded by Brightcove, what is the latest feed processed for a given provider, show the list of failed items for a given batch...

## Run project

Make sure you've already installed the version `1.15.0` of `docker-compose` or higher.

To install `docker-compose`:
```
$ curl -L https://github.com/docker/compose/releases/download/1.15.0/docker-compose-`uname -s`-`uname -m` > /usr/local/bin/docker-compose
$ chmod +x /usr/local/bin/docker-compose
```

Clone the project:
```
$ git clone https://github.com/[username]/ingestion_dashboard_api 
$ cd ingestion_dashboard_api
$ composer install
```

Make `.env` file in the `docker` folder and set the correct values:
```
$ cd docker
$ cp .env.example .env
```

If `.env` file doesn't exist in the **root directory** of the project you should run `$ cp .env.example .env`.
Set the correct values to database connection.
```dotenv
DB_CONNECTION=mysql
DB_HOST=mysql // The host have to be `mysql` if you use project on your local.
DB_PORT=3306
DB_DATABASE=playster_content  
DB_USERNAME=root // value you set in `docker/.env` file
DB_PASSWORD=123 // value you set in `docker/.env` file
```

And also you need to add the Brightcove credentials to `.env` file.
```dotenv
BRIGHTCOVE_ACCOUNT_ID=
BRIGHTCOVE_CLIENT_ID=
BRIGHTCOVE_CLIENT_SECRET= 
```

Make sure that the directories within `storage` and `bootstrap/cache` are writable by web server or Laravel will not run.
Run these commands from root directory if it isn't:
```
$ sudo chmod -R 775 bootstrap/cache
$ sudo chmod -R 775 storage
$ sudo chown -R $USER:www-data bootstrap/cache
$ sudo chown -R $USER:www-data storage
```

You should use the `php artisan key:generate` command to generate key to use Laravel's encrypter. 

Running the containers and migrations:
```
$ docker-compose up -d web
$ docker-compose exec php bash
// Before next step make sure that the database exists if you use project on your local.
// If the database doesn't exist you should create it with the name you set in `.env` file in the **root directory** of the project.
$ php artisan migrate // Run inside the container
```

Create a new user:
```
$ cd docker
$ docker-compose exec php bash
// Run inside the container
$ php artisan make:user
// Then you will be asked to enter the username, email and password.
```

Now you can access to web interface. Check it in your browser: 
- dashboard: `http://127.0.0.1:[NGINX_PORT]`. Login with your credentials
- phpmyadmin: `http://127.0.0.1:[PMA_PORT]`. Login using the values you set in `docker/.env` file.
