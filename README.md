# Taste atlas

Taste atlas is a demo (test) application built in Laravel 10, for the portfolio purposes.

Taste atlas offers a single endpoint with the abilitiy to view the dishes along with their ingridients.
It takes several parameters in url query, and returns result according to params.

The params are:
-   **per_page**    (optional)  => e.g. per_page=1
-   **page**        (optional)  => e.g. page=1
-   **category**    (optional)  => e.g. category=1
-   **tags**        (optional)  => e.g. tags=1 || tags=1,2
-   **with**        (optional)  => e.g. with=ingredients,tags,category
-   **lang**        (required)  => e.g. lang=hr (hr,en,de,fr)
-   **diff_time**   (optional)  => e.g. diff_time={timestamp}

Here is the example of query string:
`.../meals?per_page=5&tags=2&lang=hr&with=ingredients,category,tags&diff_time=1493902343&page=2`

## Tech stack:

-   [Laravel 10](https://laravel.com/docs/10.x)
-   PHP 8.1
-   MySQL
-   Docker

## Running instructions

Here is the [link](https://github.com/dev-domagojsamardzic/taste-atlas) to the public git repo.

1. Clone the project into local repository. In my case, name of the repository is `taste-atlas`

`git clone git@github.com:dev-domagojsamardzic/taste-atlas.git taste-atlas`

`cd taste-atlas`

2. Run this command to build initial application's dependencies. See more [here](https://laravel.com/docs/10.x/sail#installing-composer-dependencies-for-existing-projects)

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

3. Set up .env file. For initial setup, it is enough to copy .env.example:

`cp .env.example .env`

4. Run container (you can run it in detached mode, by setting `-d` flag at the end of command)

`sail up -d`

5. Run migrations and seeders

`sail artisan migrate --seed`

You are good to go!



