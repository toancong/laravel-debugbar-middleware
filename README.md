## Laravel Debugbar Middleware

A simple laravel middleware for toggle debugbar

## Installation

Require this package with composer.

```shell
composer require beanbean/laravel-debugbar-middleware
```

Since Laravel 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

## Usage

The Debugbar will be enabled when `APP_DEBUG` is `true` and be toggled use request param.

Enable by access key in config or .env
```
?debugbar_enable=<your access key>
```

Disable
```
?debugbar_disable
```
