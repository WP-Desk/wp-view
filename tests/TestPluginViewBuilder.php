<?php

namespace WPDesk\View\Tests;

use WPDesk\View\PluginViewBuilder;

class TestPluginViewBuilder extends \PHPUnit\Framework\TestCase {
	public function setUp(): void {
		\WP_Mock::setUp();

		\WP_Mock::userFunction('trailingslashit', [
			'return' => function ($string) {
				return rtrim($string, '/\\') . '/';
			}
		]);
	}

	public function tearDown(): void
	{
		\WP_Mock::tearDown();
	}

	public function testCanRenderUsingDir() {
		$builder  = new PluginViewBuilder( __DIR__ . '/Fixtures', 'template' );
		$renderer = $builder->createSimpleRenderer();

		$val     = 'val to render';
		$args    = [ 'singleArg' => $val ];
		$content = $renderer->render( 'file', $args );
		$this->assertRegExp( '/template content/', $content, 'Content from Fixtures/template/file.php should be renderer' );
		$this->assertRegExp( "/{$val}/", $content, 'Content from Fixtures/template/file.php should contain $val' );

		$contentUsingOtherMethod = $builder->loadTemplate( 'file', '.', $args );
		$this->assertEquals( $content, $contentUsingOtherMethod,
			'Content should be the same no matter the method of render' );
	}
}