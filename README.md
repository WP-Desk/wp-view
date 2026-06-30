[![Tests](https://github.com/WP-Desk/wp-view/actions/workflows/tests.yml/badge.svg)](https://github.com/WP-Desk/wp-view/actions/workflows/tests.yml)
[![Latest Stable Version](https://poser.pugx.org/wpdesk/wp-view/v/stable)](https://packagist.org/packages/wpdesk/wp-view)
[![Total Downloads](https://poser.pugx.org/wpdesk/wp-view/downloads)](https://packagist.org/packages/wpdesk/wp-view)
[![License](https://poser.pugx.org/wpdesk/wp-view/license)](https://packagist.org/packages/wpdesk/wp-view)

WP View
=======

WP View is a lightweight PHP library for rendering PHP templates. It can be
used as a standalone renderer and also provides resolvers for WordPress theme
overrides and WooCommerce-style template loading.

## Requirements

- PHP 7.4 or later, including PHP 8.x.
- Composer.
- WordPress is required when using `WPThemeResolver` or `PluginViewBuilder`.
- WooCommerce is required when using `WooTemplateResolver`.

## Installation via Composer

Install the package with [Composer](https://getcomposer.org/):

```bash
composer require wpdesk/wp-view
```

Composer autoloads the library with the `WPDesk\View\` namespace.

## Basic usage

`SimplePhpRenderer` renders a PHP template resolved by a resolver. The renderer
adds the `.php` extension, so `template-name` resolves to `template-name.php`.

```php
<?php

$resolver = new \WPDesk\View\Resolver\DirResolver( __DIR__ . '/templates' );
$renderer = new \WPDesk\View\Renderer\SimplePhpRenderer( $resolver );

$html = $renderer->render( 'template-name', [ 'param1' => 'test' ] );
```

Inside `templates/template-name.php`, array keys passed to `render()` are
available as local variables:

```php
<?php echo htmlspecialchars( (string) $param1, ENT_QUOTES, 'UTF-8' ); ?>
```

## Multiple template directories

Use `ChainResolver` when templates can be loaded from more than one location.
Resolvers are checked in the order in which they are added, and the first
matching template is used.

```php
<?php

$resolver = new \WPDesk\View\Resolver\ChainResolver(
    new \WPDesk\View\Resolver\DirResolver( __DIR__ . '/templates/overrides' ),
    new \WPDesk\View\Resolver\DirResolver( __DIR__ . '/templates/default' )
);

$renderer = new \WPDesk\View\Renderer\SimplePhpRenderer( $resolver );

$html = $renderer->render( 'template-name', [ 'param1' => 'test' ] );
```

In this example, `templates/overrides/template-name.php` is used when it exists.
Otherwise, the renderer falls back to `templates/default/template-name.php`.

## WordPress plugin usage

`PluginViewBuilder` creates a default renderer for plugin templates. It looks
for theme overrides first and falls back to templates bundled with the plugin.

```php
<?php

$builder  = new \WPDesk\View\PluginViewBuilder( __DIR__, 'templates' );
$renderer = $builder->createSimpleRenderer();

$html = $renderer->render( 'template-name', [ 'param1' => 'test' ] );
```

For a plugin directory named `example-plugin`, the default lookup order is:

1. Child theme path: `example-plugin/template-name.php`.
2. Parent theme path: `example-plugin/template-name.php`.
3. Plugin path: `templates/template-name.php`.

You can also render directly through the builder:

```php
<?php

$builder = new \WPDesk\View\PluginViewBuilder( __DIR__, 'templates' );

$html = $builder->loadTemplate( 'template-name', '.', [ 'param1' => 'test' ] );
```

## WooCommerce templates

Use `WooTemplateResolver` when templates should follow WooCommerce's template
lookup behavior, including theme overrides handled by `wc_locate_template()`.

```php
<?php

$resolver = new \WPDesk\View\Resolver\WooTemplateResolver( __DIR__ . '/templates/' );
$renderer = new \WPDesk\View\Renderer\SimplePhpRenderer( $resolver );

$html = $renderer->render( 'emails/example', [ 'param1' => 'test' ] );
```

## Main components

- `WPDesk\View\Renderer\SimplePhpRenderer` renders PHP templates and returns output as a string.
- `WPDesk\View\Renderer\Renderer` defines the renderer interface.
- `WPDesk\View\Resolver\DirResolver` resolves templates from a directory.
- `WPDesk\View\Resolver\WPThemeResolver` resolves templates through WordPress `locate_template()`.
- `WPDesk\View\Resolver\WooTemplateResolver` resolves templates through WooCommerce `wc_locate_template()`.
- `WPDesk\View\Resolver\ChainResolver` tries multiple resolvers in order.
- `WPDesk\View\Resolver\NullResolver` is a resolver implementation that always fails.
- `WPDesk\View\Resolver\Exception\CanNotResolve` is thrown when a template cannot be resolved.
- `WPDesk\View\PluginViewBuilder` builds the default WordPress plugin renderer.

## Development

Install dependencies before running local checks:

```bash
composer install
```

Available Composer scripts:

```bash
composer phpcs
composer phpunit-unit
composer phpunit-unit-fast
composer phpunit-integration
composer phpunit-integration-fast
```

## License

This package is released under the MIT License.
