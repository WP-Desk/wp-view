<?php

namespace WPDesk\View\Tests\Resolver;

use WPDesk\View\Resolver\Exception\CanNotResolve;
use WPDesk\View\Resolver\WPThemeResolver;
use WPDesk\View\Tests\TestCase;

class TestWpThemeResolver extends TestCase
{
	public function setUp(): void
	{
		parent::setUp();

		\WP_Mock::userFunction('locate_template', [
			'return' => function ($template_names, $load = false, $require_once = true) {
				$located = '';
				foreach ((array)$template_names as $template_name) {
					if ( ! $template_name) {
						continue;
					}
					if (file_exists(STYLESHEETPATH . '/' . $template_name)) {
						$located = STYLESHEETPATH . '/' . $template_name;
						break;
					}
				}

				return $located;
			}
		]);
	}

	public function testCanFindInStyleSheetPath()
	{
		define('STYLESHEETPATH', self::getTemplatesPath());

		$resolver = new WPThemeResolver('theme-template');

		$this->assertEquals(
			self::getTemplatesPath() . '/theme-template/child-template.php',
			$resolver->resolve('child-template.php'),
			'Template should be found in stylesheetpath'
		);
	}

	public function testThrowExceptionWhenCannotFind()
	{
		$this->expectException(CanNotResolve::class);

		$resolver = new WPThemeResolver('whatever');
		$resolver->resolve('whatever2');
	}
}
