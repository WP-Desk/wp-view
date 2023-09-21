<?php

namespace WPDesk\View\Tests;

use WPDesk\View\Resolver\ChainResolver;
use WPDesk\View\Resolver\DirResolver;
use WPDesk\View\Resolver\Exception\CanNotResolve;
use WPDesk\View\Resolver\NullResolver;

class TestSimplePhpRenderer extends \PHPUnit\Framework\TestCase
{
    const TEXT_IN_TEMPLATE = 'outputText';

    const TEMPLATE_NAME = 'some_template';

    const TEMPLATE_DIR = '/templates';

    public function testThrowsExceptionWhenCannotFindTemplate()
    {
      $this->expectException(CanNotResolve::class);

      $renderer = new \WPDesk\View\Renderer\SimplePhpRenderer(new DirResolver(''));
      $renderer->render('anything');
    }

    public function testRenderWithDirResolver()
    {
        $renderer = new \WPDesk\View\Renderer\SimplePhpRenderer(new DirResolver(__DIR__ . self::TEMPLATE_DIR));
        $this->assertEquals(self::TEXT_IN_TEMPLATE, $renderer->render(self::TEMPLATE_NAME));
    }

    public function testCanRenderNestedTemplates(): void
    {
        $renderer = new \WPDesk\View\Renderer\SimplePhpRenderer(new DirResolver(__DIR__ . '/../Fixtures'));
        $this->assertStringContainsString('This is a content of nested template: Hello World!', $renderer->render('root-template'));
    }
}