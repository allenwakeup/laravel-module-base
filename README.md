# Laravel Modules Base

## Introduction

The Laravel Modules Base overwrite routes, resources, or others files.

With help of package [allenwakeup/laravel-modules](https://github.com/allenwakeup/laravel-modules),
    there is an opportunity that makes laravel in modules.
    
## Installation

To install through Composer, by run the following command:

```shell script
composer require goodcatch/laravel-module-base
```

### migration

```shell script
php artisan goodcatch:table

php artisan migrate

php artisan goodcatch:cache
```

### seed

```shell script
php artisan goodcatch:seed base
```

### publish files

just following commands.

```shell script
php artisan vendor:publish --tag=goodcatch-modules-base --force
```

**note:** make project clean and then publish files.


### node

build front-end

```shell script
yarn run prod
```

or


```shell script
yarn run dev
```

### others

* add menu, role menu mapping, permission, role permission mapping

checkout [permission seeder](https://github.com/allenwakeup/laravel-module-base/blob/master/database/seeds/PermissionTableSeeder.php)