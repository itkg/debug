Itkg Debug library
==================

[![Build Status](https://travis-ci.org/itkg/debug.svg?branch=master)](https://travis-ci.org/itkg/debug)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/itkg/debug/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/itkg/debug/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/itkg/debug/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/itkg/debug/?branch=master)


Debug library with custom debug bar

## Installation

### Installation by Composer

If you use composer, add itkg/debug as a dependency to the composer.json of your application

```json
    "require": {
        ...
        "itkg/debug": "dev-master"
        ...
    },

```

To install assets in your web directory with composer, you can add this lines :

```json
    "extra": {
        "itkg_debug_asset_dir": "path/to/your/web/directory"
    },
    "scripts": {
        "post-update-cmd":  "Itkg\\Debug\\Composer\\Installer::copyAssets",
        "post-install-cmd": "Itkg\\Debug\\Composer\\Installer::copyAssets"
    }
```

## Usage

For documentation & default data collector, read [php-debugBar documentation](https://github.com/maximebf/php-debugbar).

To activate debug bar :
```php
    ... // include autoload, etc
    $container = new Itkg\Core\ServiceContainer();
    $container->register(new Itkg\Debug\ServiceProvider());

    $debugBarRenderer = $container['debug']['renderer'];

    // include scripts header
    echo $debugBarRenderer->renderHead();

    // include debug bar
    echo $debugBarRenderer->render();

```