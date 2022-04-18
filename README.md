# laravel-migrate-recreate

[![Latest Test](https://github.com/huangdijia/laravel-migrate-recreate/workflows/tests/badge.svg)](https://github.com/huangdijia/laravel-migrate-recreate/actions)
[![Latest Stable Version](https://poser.pugx.org/huangdijia/laravel-migrate-recreate/version.png)](https://packagist.org/packages/huangdijia/laravel-migrate-recreate)
[![Total Downloads](https://poser.pugx.org/huangdijia/laravel-migrate-recreate/d/total.png)](https://packagist.org/packages/huangdijia/laravel-migrate-recreate)

## Install

~~~bash
composer require huangdijia/laravel-migrate-recreate
~~~

## Usage

### Single

~~~php
php artisan migrate:recreate users
~~~

Output:

~~~bash
Recreate beginning
Clean up users migrate records
Renaming users to users_bak_at_180913
Migrating
Migrating: 2018_08_02_123610_create_users_table
Migrated:  2018_08_02_123610_create_users_table
Analyzing users and users_bak_at_180913 table structure
Restoring data from users_bak_at_180913
Remove users_bak_at_180913
Migrate completed
~~~

### Multi

~~~php
php artisan migrate:recreate users another_tables
~~~

### All

~~~php
php artisan migrate:recreate-all
~~~