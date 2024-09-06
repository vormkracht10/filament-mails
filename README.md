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

The package is built on top of [Laravel Mails](https://github.com/vormkracht10/laravel-mails).

![Filament Mails](./docs/list.png)

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

Then add the plugin to your `PanelProvider`

```php
use Vormkracht10\FilamentMails\FilamentMailsPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugin(FilamentMailsPlugin::make());
}
```

### Features and screenshots

#### List with all sent emails and statistics

The package provides a clear overview of all emails, including statistics and the ability to filter the data.

![Filament Mails](https://github.com/vormkracht10/filament-mails/blob/main/docs/mails-list.png)

#### Resending emails

You can resend emails to the same or another recipient(s). This is useful when your email has bounced and you want to resend it.

![Filament Mails](https://github.com/vormkracht10/filament-mails/blob/main/docs/mail-resend.png)

#### Information

You can view all relevant information about the email, such as the subject, the body, the attachments, the from address, the to address(es), the cc address(es), the bcc address(es), the reply to address, metadata and much more.

![Filament Mails](https://github.com/vormkracht10/filament-mails/blob/main/docs/mail-sender-information.png)

![Filament Mails](https://github.com/vormkracht10/filament-mails/blob/main/docs/mail-statistics.png)

![Filament Mails](https://github.com/vormkracht10/filament-mails/blob/main/docs/mail-events.png)

![Filament Mails](https://github.com/vormkracht10/filament-mails/blob/main/docs/mail-attachments.png)

#### Preview email

The package provides a preview of the email. This is useful to quickly check if the email is correct.

![Filament Mails](https://github.com/vormkracht10/filament-mails/blob/main/docs/mail-preview.png)

We also provide the raw HTML and plain text of the email.

![Filament Mails](https://github.com/vormkracht10/filament-mails/blob/main/docs/mail-raw-html.png)

#### Events

The package also logs all events that are fired when an email is sent. This is useful to track the email sending process.

![Filament Mails](https://github.com/vormkracht10/filament-mails/blob/main/docs/events-list.png)

![Filament Mails](https://github.com/vormkracht10/filament-mails/blob/main/docs/event-details.png)

## Usage

..

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
