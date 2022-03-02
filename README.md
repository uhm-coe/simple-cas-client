# Simple CAS Client

This example PHP page, `index.php`, requires authentication from the CAS server defined in `config.php` before rendering any output.

## Installation

1. Clone this repo to a location that is web accessible, on a web server with PHP enabled.

1. Copy `config.sample.php` to `config.php` and set the appropriate values for your CAS server.

1. Visit the page in a browser, authenticate via CAS, and you will see **Welcome, &lt;username>** on the page. If not, check your web server error logs for details.

## Notes

1. phpCAS has been added via `composer require apereo/phpcas` and included via the composer autoloader.

	[https://packagist.org/packages/jasig/phpcas](https://packagist.org/packages/jasig/phpcas)

1. More phpCAS examples are available from Apereo here:

	[https://github.com/apereo/phpCAS/tree/master/docs/examples](https://github.com/apereo/phpCAS/tree/master/docs/examples)

1. CA certificate bundle copied from WordPress core:

	[https://github.com/WordPress/WordPress/blob/master/wp-includes/certificates/ca-bundle.crt](https://github.com/WordPress/WordPress/blob/master/wp-includes/certificates/ca-bundle.crt)
