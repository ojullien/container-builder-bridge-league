# Container Builder Bridge League

![PHP Composer](https://github.com/oseille/container-builder-bridge-league/workflows/PHP%20Composer/badge.svg?branch=master)

A concrete implementation of the [Container Builder Bridge](https://github.com/oseille/container-builder-bridge) using [league/container](https://github.com/thephpleague/container)

## Table of Contents

- [Requirements](#requirements) | [Installation](#installation) | [Documentation](#documentation) | [Test](#test) | [Contributing](#contributing) | [License](#license)

## Requirements

- PHP: ^7.4
- oseille/container-builder-bridge: ^1.0

## Installation

This package requires PHP 7.4. For specifics, please examine the package [composer.json](https://github.com/oseille/container-builder-bridge-league/blob/master/composer.json) file.

You may check if your PHP and extension versions match the platform requirements using `composer diagnose` and `composer check-platform-reqs`. (This requires [Composer](https://getcomposer.org/) to be available as composer.)

This package is installable and PSR-4 autoloadable via [Composer](https://getcomposer.org/) as oseille/container-builder-bridge-league. For no dev, use `composer install --no-dev` and for dev, use `composer install`.

Alternatively, [download a release](https://github.com/oseille/container-builder-bridge-league/releases), or clone this repository, then map the Oseille\ContainerBuilderBridge\League namespace to the package src/ directory.

## Documentation

We do not provide exhaustive documentation. Please read the code and the comments ;)

```php
// Instanciate and configure the PSR-11 container
$container_builder = new \League\Container\Container();

// Instanciate the implementor to use thru the bridge builder
$bridge_builder = new \Oseille\ContainerBuilderBridge\League\Implementor($container_builder);

// Add the definitions to the builder
$bridge_builder->addDefinitions($definitions);

// Build the container
$container = $bridge_builder->build();
```

## Test

To run the unit tests at the command line, issue `composer install` and then `./vendor/bin/phpunit` at the package root. (This requires [Composer](https://getcomposer.org/) to be available as composer.)

## Contributing

Thanks you for taking the time to contribute. Please fork the repository and make changes as you'd like.

If you have any ideas, just open an [issue](https://github.com/oseille/container-builder-bridge-league/issues) and tell me what you think. Pull requests are also warmly welcome.

If you encounter any **bugs**, please open an [issue](https://github.com/oseille/container-builder-bridge-league/issues).

Be sure to include a title and clear description,as much relevant information as possible, and a code sample or an executable test case demonstrating the expected behavior that is not occurring.

## License

**Container Builder Bridge League** is open-source and is licensed under the [MIT license](LICENSE).
