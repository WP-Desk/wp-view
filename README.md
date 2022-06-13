[![pipeline status](https://gitlab.com/wpdesk/wp-view/badges/master/pipeline.svg)](https://gitlab.com/wpdesk/wp-view/pipelines)
[![coverage report](https://gitlab.com/wpdesk/wp-view/badges/master/coverage.svg?job=unit+test+lastest+coverage)](https://gitlab.com/wpdesk/wp-view/commits/master)
[![Latest Stable Version](https://poser.pugx.org/wpdesk/wp-view/v/stable)](https://packagist.org/packages/wpdesk/wp-view)
[![Total Downloads](https://poser.pugx.org/wpdesk/wp-view/downloads)](https://packagist.org/packages/wpdesk/wp-view)
[![License](https://poser.pugx.org/wpdesk/wp-view/license)](https://packagist.org/packages/wpdesk/wp-view)

WP View
=======

wp-view is a simple to render templates.

## Requirements

PHP 7.0 or later.

## Installation via Composer

In order to install the bindings via [Composer](http://getcomposer.org/) run the following command:

```bash
composer require wpdesk/wp-view
```

## Example usage

```php
<?php

$resolver = new \WPDesk\View\Resolver\ChainResolver();
$resolver->appendResolver( new \WPDesk\View\Resolver\WPThemeResolver( 'example-plugin' ) );
$resolver->appendResolver( new \WPDesk\View\Resolver\DirResolver( trailingslashit( __DIR__ ) . 'templates' ) );
$renderer = new \WPDesk\View\Renderer\SimplePhpRenderer( $resolver );

$renderer->render( 'template-name', ['param1' => 'test'] );
```
