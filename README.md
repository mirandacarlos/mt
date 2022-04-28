# Requirements
- Linux or WSL [(laravel on windows)](https://laravel.com/docs/9.x/#getting-started-on-windows "laravel on windows")
- Docker

# Installation
- Open a terminal in the project folder and execute the following command to install the project dependencies (vendor folder):
`docker run --rm -v $(pwd):/opt -w /opt laravelsail/php81-composer:latest bash -c "composer install"`
- From the terminal execute the following command to start the project stack:
`./vendor/bin/sail up -d`
- Once started execute the following command to create the database and the initial data:
`./vendor/bin/sail artisan migrate:fresh --path=database/migrations/mt --seed`

# Usage
The API is available at: [localhost/products](http://localhost/products "localhost/products")
The following query string parameters are available:
- **category**: get products of the given category (boots, sandals, sneakers).
- **priceLessThan**: filter get products with price less or equal.
- **page**: Indicates the page to retrieve (5 results per page).
You can use single or multiple params chained with "&". For example:
http://localhost/products?category=boots&priceLessThan=99000
To run **tests** execute the following command from a terminal in the project folder:
`./vendor/bin/sail artisan test`