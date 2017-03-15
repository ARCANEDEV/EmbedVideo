# 1. Installation

## Table of contents

  1. [Installation and Setup](1-Installation-and-Setup.md)
  2. [Configuration](2-Configuration.md)
  3. [Usage](3-Usage.md)

## Requirements

```
- PHP >= 5.6
```

## Version Compatibility

| EmbedVideo                          | Laravel                                                                                                             |
|:------------------------------------|:--------------------------------------------------------------------------------------------------------------------|
| ![EmbedVideo v1.x][embed_video_1_x] | ![Laravel v5.0][laravel_5_0] ![Laravel v5.1][laravel_5_1] ![Laravel v5.2][laravel_5_2] ![Laravel v5.3][laravel_5_3] |
| ![EmbedVideo v2.x][embed_video_2_x] | ![Laravel v5.4][laravel_5_4]                                                                                        |

> **Note :** This is a framework-agnostic package, so you can use any version of this package in your PHP project.

[laravel_5_0]:    https://img.shields.io/badge/v5.0-supported-brightgreen.svg?style=flat-square "Laravel v5.0"
[laravel_5_1]:    https://img.shields.io/badge/v5.1-supported-brightgreen.svg?style=flat-square "Laravel v5.1"
[laravel_5_2]:    https://img.shields.io/badge/v5.2-supported-brightgreen.svg?style=flat-square "Laravel v5.2"
[laravel_5_3]:    https://img.shields.io/badge/v5.3-supported-brightgreen.svg?style=flat-square "Laravel v5.3"
[laravel_5_4]:    https://img.shields.io/badge/v5.4-supported-brightgreen.svg?style=flat-square "Laravel v5.4"

[embed_video_1_x]: https://img.shields.io/badge/version-1.*-blue.svg?style=flat-square "EmbedVideo v1.*"
[embed_video_2_x]: https://img.shields.io/badge/version-2.*-blue.svg?style=flat-square "EmbedVideo v2.*"

## Composer

You can install this package via [Composer](http://getcomposer.org/) by running this command `composer require arcanedev/embed-video`.

## Laravel

### Setup

Once the package is installed, you can register the service provider in `config/app.php` in the `providers` array:

```php
'providers' => [
    ...
    Arcanedev\EmbedVideo\EmbedVideoServiceProvider::class,
],
```

And the facade in the `aliases` array:

```php
'aliases' => [
    ...
    'Embed' => Arcanedev\EmbedVideo\Facades\Embed::class,
],
```
