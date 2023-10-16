<?php

namespace WPDesk\View\Tests;

abstract class TestCase extends \PHPUnit\Framework\TestCase {

	public function setUp(): void {
		\WP_Mock::setUp();

        \WP_Mock::userFunction('trailingslashit', [
            'return' => function ($string) {
                return rtrim($string, '/\\') . '/';
            }
        ]);

        \WP_Mock::userFunction('untrailingslashit', [
            'return' => function ($string) {
                return rtrim($string, '/\\');
            }
        ]);
	}

	public function tearDown(): void {
		\WP_Mock::tearDown();
	}


	public static function getTemplatesPath(): string {
		return __DIR__ . '/Fixtures';
	}
}
