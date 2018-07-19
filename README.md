## Lumen REST Object Fetch Middleware

> **IMPORTANT:** This package is a work in progress, it it not stable by any means.   
> Use responsibly! Or don't use at all and wait for v1.0.

#### The purpose of this project

It was created to avoid repetitive 404 (and other) checks when hitting CRUD endpoints of API.

#### Is it any good?

[Yes](https://news.ycombinator.com/item?id=3067434)

(well, it will be in stable version... I hope...)

## Installation

1. Install the package with [Composer](https://getcomposer.org/):  
 
```bash
composer require wronx/lumen-rest-object-fetch-middleware
```

2. Enable it in `bootstrap/app.php`:

```php
$app->routeMiddleware([
// ...
                          'object' => WRonX\RestObjectFetch\RestObjectFetchMiddleware::class,
                      ]);
```

## Usage

1. In `routes/web.php` assign it to route which requires `id` parameter, giving it model's class name:

```php
$router->group([
                   'prefix'     => '/something/{id:[0-9]+}',
                   'middleware' => 'object:Something', // <--- HERE
               ],
    function() use ($router) {
        $router->get('', [
            'as'   => 'show_something',
            'uses' => 'SomethingController@show',
        ]);
        
        $router->patch('', [
            'as'   => 'edit_something',
            'uses' => 'SomethingController@update',
        ]);
        
        $router->delete('', [
            'as'   => 'delete_something',
            'uses' => 'SomethingController@destroy',
        ]);
    });
```

2. In Controller methods that are covered by this middleware you don't have to check if object exists and you don't have to fetch it again from DB:

```php
    public function show(Request $request) {
        $something = $request->attributes->get('fetchedObject');
        
        return new JsonResponse($something);
    }
``` 

## Contributing

If you want to contribute, **please wait**. Until stable version arrives I want to shape this package in my specific way. Later on, pull requests will be welcome. 

## License:

> Copyright © 2016 github.com/WRonX    
> This work is free. You can redistribute it and/or modify it under the terms of the Do What The Fuck You Want To Public License, Version 2, as published by Sam Hocevar. See http://www.wtfpl.net/ for more details
