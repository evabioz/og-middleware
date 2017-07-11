# og-middleware
Laravel middleware for allow open graph bot visit it

## Requirements

- PHP 5.5.9+
- Laravel 5+

## Installation

First, pull in the package through Composer.

```shell
composer require evabioz/og-middleware
```

And then include the service provider within `app/config/app.php`.

```php
'providers' => [
    Evabioz\OGMiddleware\OGMiddlewareServiceProvider::class,
];
```

### Publish the package config file

```shell
$ php artisan vendor:publish --provider="Evabioz\OGMiddleware\OGMiddlewareServiceProvider"
```

## Configuration

You can use named route, or asterix syntax (without start and end markers).

```php
// within app/config/og-middleware.php

'route_endpoint_list' => [

    // 'foo/bar' => OpenGraphEndpoint::class

],
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.