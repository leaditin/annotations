# Leaditin\Annotations

A simple API for reading any kind of annotations from PHP Class

[![Build Status][ico-build]][link-build]
[![Code Quality][ico-code-quality]][link-code-quality]
[![Code Coverage][ico-code-coverage]][link-code-coverage]
[![Latest Version][ico-version]][link-packagist]
[![PDS Skeleton][ico-pds]][link-pds]

## Installation

The preferred method of installation is via [Composer](http://getcomposer.org/). Run the following command to install the latest version of a package and add it to your project's `composer.json`:

```bash
composer require leaditin/annotations
```

## Usage

Instantiate your preferred storage to read doc block data of any Class in your project.

```php
$collector = new \Leaditin\Annotations\Collector\MemoryCollector(
    new \Leaditin\Annotations\Reader\ReflectionReader()
);
$reflection = $collector->read(\Leaditin\Annotations\Reflection::class);

foreach ($reflection->getClassAnnotations() as $annotation) {
    printf('@%s %s%s',
        $annotation->getName(),
        $annotation->getArgument(0),
        PHP_EOL
    );
}

```

## Credits

- [All Contributors][link-contributors]

## License

Released under MIT License - see the [License File](LICENSE) for details.


[ico-version]: https://img.shields.io/packagist/v/leaditin/annotations.svg
[ico-build]: https://travis-ci.org/leaditin/annotations.svg?branch=master
[ico-code-coverage]: https://img.shields.io/scrutinizer/coverage/g/leaditin/annotations.svg
[ico-code-quality]: https://img.shields.io/scrutinizer/g/leaditin/annotations.svg
[ico-pds]: https://img.shields.io/badge/pds-skeleton-blue.svg

[link-packagist]: https://packagist.org/packages/leaditin/annotations
[link-build]: https://travis-ci.org/leaditin/annotations
[link-code-coverage]: https://scrutinizer-ci.com/g/leaditin/annotations/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/leaditin/annotations
[link-pds]: https://github.com/php-pds/skeleton
[link-contributors]: ../../contributors
