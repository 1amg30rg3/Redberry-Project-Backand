<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Introduction
<p>Laravel Sanctum provides a featherweight authentication system for SPAs (single page applications), mobile applications, and simple, token based APIs. Sanctum allows each user of your application to generate multiple API tokens for their account. These tokens may be granted abilities / scopes which specify which actions the tokens are allowed to perform.</p>


## About App

<ul>
    <li>Laravel Version 9</li>
    <li>Authorization system with Laravel Sanctum</li>
    <li>Database For Countires and Coutry Statistics - Covid Data</li>
    <li>Laravel Scheduler for getting data every hour.</li>
</ul>


<ul>
    <li></li>
    <li>Authorization system with Laravel Sanctum</li>
    <li>Database For Countires and Coutry Statistics - Covid Data</li>
    <li>Laravel Scheduler for getting data every hour.</li>
</ul>



## Getting Started
### Step 1: setup database in .env file

```` 
DB_DATABASE=dbname
DB_USERNAME=root
DB_PASSWORD= password
````

## Step 2:Install Project Dependencies.

```` 
composer update
composer install
```` 

## Step 4:Run your database migrations.

```` 
php artisan migrate
```` 

## Step 3: Generate app key .

```` 
php artisan key:generate
```` 

## Step 3: Start app.

```` 
php artisan serve
```` 
