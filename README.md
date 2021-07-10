# Stock Exchange Test

### The tech stack using
PHP 7.2

MySQL 5.6


### Installation 
using Composer for dependency / package manger.
using "vlucas/phpdotenv" for environment variables handling
```
{
    "require": {
        "vlucas/phpdotenv": "^2.4"
    },
    "autoload": {
        "psr-4": {
            "Src\\": "src/"
        }
    }
}
```
install our dependencies
``composer install``

copy `.env.example` to `.env`

### Configure a Database for Your PHP REST API
```
mysql -uroot -p
CREATE DATABASE trade CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'stock_user'@'localhost' identified by 'stock_password';
GRANT ALL on trade.* to 'stock_user'@'localhost';
quit
```

To execute the job use this endpoint `http://127.0.0.1:8000/trade-test`