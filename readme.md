# Ingestion Dashboard Api

Ingestion dashboard is a dashboard to monitor the ingestion processes. For instance: which batch is still processing, what are the movies that are still not yet encoded by Brightcove, what is the latest feed processed for a given provider, show the list of failed items for a given batch...

## Run project

Make sure you've already installed the version `1.15.0` of `docker-compose` or higher.

To install `docker-compose`:
```bash
$ curl -L https://github.com/docker/compose/releases/download/1.15.0/docker-compose-`uname -s`-`uname -m` > /usr/local/bin/docker-compose
$ chmod +x /usr/local/bin/docker-compose
```

Clone the project:
```bash
$ git clone https://github.com/[username]/ingestion_dashboard_api 
$ cd ingestion_dashboard_api
$ composer install --ignore-platform-reqs
```

Make `.env` file in the `docker` folder and set the correct values:
```bash
$ cd docker
$ cp .env.example .env
```

If `.env` file doesn't exist in the **root directory** of the project you should run `$ cp .env.example .env`.
Set the correct values to database connection.
```dotenv
DB_CONNECTION=mysql_prod
```

For prod connection
```dotenv
DB_PROD_HOST= Prod host
DB_PROD_PORT=3306
DB_PROD_DATABASE=playster_content
DB_PROD_USERNAME= Your username on prod
DB_PROD_PASSWORD= Your password on prod
```

For qa connection
```dotenv
DB_QA_HOST= QA host
DB_QA_PORT=3306
DB_QA_DATABASE=playster_content
DB_QA_USERNAME= Your username on qa
DB_QA_PASSWORD= Your password on qa
```

For local connection
```dotenv
DB_LOCAL_HOST=br_mysql
DB_LOCAL_PORT=3306
DB_LOCAL_DATABASE=playster_content  
DB_LOCAL_USERNAME=root // value you set in `docker/.env` file
DB_LOCAL_PASSWORD=123 // value you set in `docker/.env` file
```

And also you need to add the Brightcove credentials to `.env` file.
```dotenv
BRIGHTCOVE_ACCOUNT_ID=
BRIGHTCOVE_CLIENT_ID=
BRIGHTCOVE_CLIENT_SECRET= 
```

Make sure that the directories within `storage` and `bootstrap/cache` are writable by web server or Laravel will not run.
Run these commands from root directory if it isn't:
```bash
$ sudo chmod -R 775 bootstrap/cache
$ sudo chmod -R 775 storage
$ sudo chown -R $USER:www-data bootstrap/cache
$ sudo chown -R $USER:www-data storage
```

You should use the `php artisan key:generate` command to generate key to use Laravel's encrypter. 

Running the containers and migrations:
```bash
$ docker-compose up -d br_web
$ docker-compose exec br_php bash
// Before next step make sure that the database exists if you use project on your local.
// If the database doesn't exist you should create it with the name you set in `.env` file in the **root directory** of the project.
$ php artisan migrate --database mysql_local // Run inside the container
```

Create a new user:
```bash
$ cd docker
$ docker-compose exec br_php bash
// Run inside the container
$ php artisan make:user // Create a new user to access to dashboard
// Then you will be asked to enter the username, email and password.
```

Now you can access to web interface. Check it in your browser: 
- dashboard: `http://127.0.0.1:[NGINX_PORT]`. Login with your credentials
- phpmyadmin: `http://127.0.0.1:[PMA_PORT]`. Login using the values you set in `docker/.env` file.
