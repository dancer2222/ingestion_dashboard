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

And also you need to add the Brightcove credentials to `.env` file.
```dotenv
BRIGHTCOVE_ACCOUNT_ID=
BRIGHTCOVE_CLIENT_ID=
BRIGHTCOVE_CLIENT_SECRET= 
```

Also you need to add Google credentials to `.env` file
```dotenv
GOOGLE_API_CLIENT_ID=
GOOGLE_API_CLIENT_SECRET=
GOOGLE_API_REDIRECT_URI="http://localhost:8877/auth/google/callback
```

Now you can access to web interface. Check it in your browser: 
- dashboard: `http://127.0.0.1:[NGINX_PORT]`. Login with your credentials
- phpmyadmin: `http://127.0.0.1:[PMA_PORT]`. Login using the values you set in `docker/.env` file.
