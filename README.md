# Support handlers out of monolog/monolog

![Packagist](https://img.shields.io/packagist/dt/sepiphy/logging.svg)
![Packagist Version](https://img.shields.io/packagist/v/sepiphy/logging.svg?label=version)
![GitHub](https://img.shields.io/github/license/sepiphy/logging.svg)

Currently supported:
- Chatwork

## Installation

Install `sepiphy/logging` package via composer.

    $ composer require sepiphy/logging

## Usage

Create a new file called "try-logging.php" with the code sample below:

```php
<?php

use Monolog\Logger;
use Sepiphy\Logging\ChatworkHandler;

require __DIR__ . '/vendor/autoload.php';

$apiKey = 'YOU_API_KEY';
$roomId = 12345678; // Your room id that you want to report to.

$handler = new ChatworkHandler($apiKey, $roomId);

$logger = new Logger('JUST_FOR_TEST');
$logger->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'));
$logger->pushHandler($handler);

$logger->info('Try monolog with chatwork handler');

try {
    throw new Exception('Something went wrong!');
} catch (Exception $exception) {
    $logger->error($exception, ['exception' => $exception]);
}

```

Verify result by running this command:

    $ php try-logging.php
