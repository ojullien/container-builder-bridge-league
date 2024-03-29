↖ _The autogenerated table of contents is here_

# Container Builder Bridge League

A concrete implementation of the [Container Builder Bridge](https://github.com/ojullien/container-builder-bridge) using [league/container](https://github.com/thephpleague/container)

[![Lint Code Base](https://github.com/ojullien/container-builder-bridge-league/actions/workflows/linter.yml/badge.svg)](https://github.com/ojullien/container-builder-bridge-league/actions/workflows/linter.yml)
[![Tests](https://github.com/ojullien/container-builder-bridge-league/actions/workflows/tests.yml/badge.svg)](https://github.com/ojullien/container-builder-bridge-league/actions/workflows/tests.yml)

## Requirements

This package requires:

- PHP: ^8.0
- ojullien/container-builder-bridge: ^1.1
- league/container: ^4.2

For specifics, please examine the manifest [composer.json](https://github.com/ojullien/container-builder-bridge-league/blob/master/composer.json) file.

You may check if your PHP and extension versions match the platform requirements using `composer diagnose` and `composer check-platform-reqs`. (This requires [Composer](https://getcomposer.org/) to be available as composer.)

## Installation

This package is installable and PSR-4 autoloadable via [Composer](https://getcomposer.org/) as ojullien/container-builder-bridge-league. For no dev, use `composer install --no-dev` and for dev, use `composer install`.

Alternatively, [download a release](https://github.com/ojullien/container-builder-bridge-league/releases), or clone this repository, then map the OJullien\ContainerBuilderBridge\League namespace to the package src/ directory.

## Documentation

We do not provide exhaustive documentation. Please read the code and the comments ;)

Using the default ContainerBuilderBridge\Builder:

```php
// As League\Container does not have a builder. 
// We instanciate and configure the PSR-11 container
$builder = new \League\Container\Container();

// Instanciates the implementation to use thru the bridge builder
$implementation = new \OJullien\ContainerBuilderBridge\League\Implementation($builder);

// Instanciates the bridge
$bridge = new \OJullien\ContainerBuilderBridge\Builder($implementation);

// Create definitions using sequences
$sequence = Sequence::getSequence();
$sequence = $sequence->withDefinition('database.host', 'localhost')
                     ->withDefinition('database.port', 5000)
                     ->withDefinition('report.recipients', ['bob@example.com','alice@example.com',])
                     ->withDefinition('factory',static function (ContainerInterface $container){...});

// Builds the PSR-11 container
$container = $bridge->getContainer($sequence);
```

Using the extended ContainerBuilderBridge\League\Builder:

```php
// As League\Container does not have a builder. 
// We instanciate and configure the PSR-11 container
$builder = new \League\Container\Container();

// Instanciates the implementation to use thru the bridge builder
$implementation = new \OJullien\ContainerBuilderBridge\League\Implementation($builder);

// Instanciates the bridge
$bridge = new \OJullien\ContainerBuilderBridge\League\Builder($implementation);

// Create shared definitions using sequences
$sequence = Sequence::getSequence();
$sequence = $sequence->withDefinition(SomeServiceProvider::class);

// Builds the PSR-11 container
$container = $bridge->addSharedDefinitions($sequence);

// Builds the PSR-11 container with service provider
$container = $bridge->addServiceProviders(new SomeServiceProvider());

```

## Test

To run the unit tests at the command line, issue `composer install` and then `./vendor/bin/phpunit` at the package root. (This requires [Composer](https://getcomposer.org/) to be available as composer.)

## Contributing

Thanks you for taking the time to contribute. Please fork the repository and make changes as you'd like.

If you have any ideas, just open an [issue](https://github.com/ojullien/container-builder-bridge-league/issues) and tell me what you think. Pull requests are also warmly welcome.

If you encounter any **bugs**, please open an [issue](https://github.com/ojullien/container-builder-bridge-league/issues).

Be sure to include a title and clear description,as much relevant information as possible, and a code sample or an executable test case demonstrating the expected behavior that is not occurring.

## License

**Container Builder Bridge League** is open-source and is licensed under the [MIT license](LICENSE).
