<?php

namespace WPDesk\View\Tests\Resolver;

use WPDesk\View\Resolver\DirResolver;
use WPDesk\View\Resolver\Exception\CanNotResolve;
use WPDesk\View\Tests\TestCase;

class TestDirResolver extends TestCase {

	public function testCanFindInDirPath(): void {
		$resolver = new DirResolver(self::getTemplatesPath());

		$this->assertEquals(
			self::getTemplatesPath() . '/some_template.php',
			$resolver->resolve('some_template.php'),
			'Template should be found in dir'
		);
	}

	public function testThrowExceptionWhenCannotFind(): void {
		$this->expectException(CanNotResolve::class);

		$resolver = new DirResolver('whatever');
		$resolver->resolve('whatever2');
	}

	public function testResolvingFromCurrentPath(): void {
		$this->expectException(CanNotResolve::class);
		$this->expectExceptionMessage('Denying to search in system\'s root path.');

		$resolver = new DirResolver(null);
		$resolver->resolve('whatever2');
	}
}
