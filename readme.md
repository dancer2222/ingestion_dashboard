# Ingestion Dashboard Api

Ingestion dashboard is a dashboard to monitor the ingestion processes. For instance: which batch is still processing, what are the movies that are still not yet encoded by Brightcove, what is the latest feed processed for a given provider, show the list of failed items for a given batch...

## Run project

```
$ cd to/project
$ composer install
```

Make `.env` file in the `docker` folder and set the correct values:
```
$ cd docker
$ cp .env.example .env
```

If `.env` file it isn't existed in the root directory of the project you should run `$ cp .env.example .env`.
Set the correct values to database connection.
```dotenv
DB_CONNECTION=mysql
DB_HOST=mysql // The host have to be `mysql` if you use project on your local.
DB_PORT=3306
DB_DATABASE=playster_content  
DB_USERNAME=homestead // value you set in `docker/.env` file
DB_PASSWORD=secret // value you set in `docker/.env` file
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
$ sudo chown -R $USER:www-data bootstap/cache
$ sudo chown -R $USER:www-data storage
```

You should use the `php artisan key:generate` command to generate key to use Laravel's encrypter. 

Before next steps make sure that the database is exist if you use project on your local.
Run containers and migrations:
```
$ docker-compose up -d web
$ docker-compose exec php bash
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
- phpmyadmin: `http://127.0.0.1:[PMA_PORT]`
