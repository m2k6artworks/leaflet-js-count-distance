# Geodistance

[![Build Status](https://travis-ci.org/0x13a/geodistance-php.svg?branch=master)](https://travis-ci.org/0x13a/geodistance-php)
[![Latest Stable Version](https://poser.pugx.org/0x13a/geodistance-php/v/stable)](https://packagist.org/packages/0x13a/geodistance-php)
[![Total Downloads](https://poser.pugx.org/0x13a/geodistance-php/downloads)](https://packagist.org/packages/0x13a/geodistance-php)
[![License](https://poser.pugx.org/0x13a/geodistance-php/license)](https://packagist.org/packages/0x13a/geodistance-php)
[![composer.lock](https://poser.pugx.org/0x13a/geodistance-php/composerlock)](https://packagist.org/packages/0x13a/geodistance-php)

simple & minimal geodistance php library to calculate geo distance between two points (latitude, longitude) using [Harvesine formula](https://www.wikiwand.com/en/Haversine_formula)

## Installation

``` bash
composer require 0x13a/geodistance-php
```

## Usage

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use function Geodistance\centimeters;
use function Geodistance\feet;
use function Geodistance\kilometers;
use function Geodistance\miles;
use function Geodistance\meters;
use function Geodistance\yards;
use Geodistance\Location;

$new_york          = new Location(40.7128, 74.0059);
$los_angeles       = new Location(34.0522, 118.2437);
$decimal_precision = 3;

echo kilometers($new_york, $los_angeles); // 3936
echo miles($new_york, $los_angeles, $decimal_precision); // 2445.564
echo yards($new_york, $los_angeles); // 4304181
echo feet($new_york, $los_angeles); // 12912543
echo centimeters($new_york, $los_angeles); // 393575500
echo meters($new_york, $los_angeles); // 3935755

```

## License

Geodistance PHP is licensed under the MIT license. See [License File](LICENSE) for more information.
