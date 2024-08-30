# Filament Mails

[![Latest Version on Packagist](https://img.shields.io/packagist/v/vormkracht10/filament-mails.svg?style=flat-square)](https://packagist.org/packages/vormkracht10/filament-mails)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/vormkracht10/filament-mails/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/vormkracht10/filament-mails/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/vormkracht10/filament-mails/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/vormkracht10/filament-mails/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/vormkracht10/filament-mails.svg?style=flat-square)](https://packagist.org/packages/vormkracht10/filament-mails)

Filament Mails can collect everything you might want to track about the mails that has been sent by your Filament app. Common use cases are provided in this package:

-   Log all sent emails with only specific attributes
-   View all sent emails in the browser using the viewer
-   Collect feedback about the delivery from email providers using webhooks
-   Relate sent emails to Eloquent models
-   Get automatically notified when email bounces
-   Prune logging of emails periodically
-   Resend logged email to another recipient

## Why this package

Email as a protocol is very error prone. Succesfull email delivery is not guaranteed in any way, so it is best to monitor your email sending realtime. Using external services like Postmark, Mailgun or Resend email gets better by offering things like logging and delivery feedback, but it still needs your attention and can fail silently but horendously. Therefore we created Laravel Mails that fills in all the gaps.

## Installation

You can install the package via composer:

```bash
composer require vormkracht10/filament-mails
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="mails-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="mails-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-mails-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$filamentMails = new Vormkracht10\FilamentMails();
echo $filamentMails->echoPhrase('Hello, Vormkracht10!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Baspa](https://github.com/vormkracht10)
-   [Mark van Eijk](https://github.com/markvaneijk)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
