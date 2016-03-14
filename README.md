# InkSplat

Technical Test For Job Application

## Requirements

PHP 5.4+

## Install and Run

    git clone git@github.com:stevemarvell/InkSplat.git
    cd InkSplat
    composer install --no-dev

    php bin/splat.php

## Install, Test and Run

    git clone git@github.com:stevemarvell/InkSplat.git
    cd InkSplat
    composer install

    phpunit

    php bin/splat.php

## TODO

Check for particular exceptions thrown by external libraries.

Add additional unit tests based on confidence in data, though general exceptions are caught just in case.

Consider getopt