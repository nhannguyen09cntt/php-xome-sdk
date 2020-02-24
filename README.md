# Xome SDK

Xome SDK for PHP (xome.vn)

## Installation

With Composer:

```
composer require nhannguyen09cntt/php-xome-sdk
```

Or manually add it to your composer.json:

```
{
  "require": {
    "php": "^7.2",
    "nhannguyen09cntt/php-xome-sdk": "^1.0"
  }
}
```

## Usage
Env
```
#.env

Xome_API_KEY=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
Xome_API_USER=admin
```

Source code:
```
<?php
namespace xxxx;
use Xome\Xome;
...
$Xome = new Xome();
$response = $Xome->get('/c/11.json', ['page' => 1]);
$body = $response->getDecodedBody();
$topics = $body['topic_list']['topics'];
...
```
