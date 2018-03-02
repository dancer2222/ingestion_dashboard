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
$ cd ingestion_dashboard_api/docker
$ docker-compose up -d
```

Make `.env` file in the `docker` folder and set the correct values:
```bash
$ cd docker
$ cp .env.example .env
```

If `.env` file doesn't exist in the **root directory** of the project you should run `$ cp .env.example .env`.
Set the correct values to database connection.
```dotenv
DB_CONNECTION=dweb
```

Put right values:
```dotenv
DB_LOCAL_INGESTION_HOST=dmysql
DB_LOCAL_INGESTION_PORT=3306
DB_LOCAL_INGESTION_DATABASE=playster_ingestion
DB_LOCAL_INGESTION_USERNAME=root
DB_LOCAL_INGESTION_PASSWORD=123

DB_LOCAL_CONTENT_HOST=
DB_LOCAL_CONTENT_PORT=3306
DB_LOCAL_CONTENT_DATABASE=playster_content
DB_LOCAL_CONTENT_USERNAME=
DB_LOCAL_CONTENT_PASSWORD=

BRIGHTCOVE_ACCOUNT_ID=
BRIGHTCOVE_CLIENT_ID=
BRIGHTCOVE_CLIENT_SECRET=

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_REGION=

RABBITMQ_HOST=
RABBITMQ_PORT=5672
RABBITMQ_VHOST=/
RABBITMQ_LOGIN=
RABBITMQ_PASSWORD=
RABBITMQ_QUEUE=ingestion-tools

GOOGLE_API_CLIENT_ID=
GOOGLE_API_CLIENT_SECRET=
GOOGLE_API_REDIRECT_URI="http://localhost:7771/social/callback/google"
```

Install dependencies
```bash
composer install --ignore-platform-reqs
```

Go to `http://127.0.0.1:7772`, login and create `playster_ingestion` database.

Make admin if it wasn't created before:
```bash
cd docker
docker-compose exec dweb bash
php artisan migrate --database=mysql_local_ingestion
php artisan make:admin
```

If everything is ok, we continue.
Run seeds:
```bash
cd docker
docker-compose exec dweb bash
php artisan db:seed --class=DatabaseSeeder --database=mysql_local_ingestion
```

Generate key:
```bash
php artisan key:generate
```

Now you can access to web interface. Check it in your browser: 
- dashboard: `http://127.0.0.1:7771`. Login with your credentials
- phpmyadmin: `http://127.0.0.1:7772`. Login using the values you set in `docker/.env` file.
