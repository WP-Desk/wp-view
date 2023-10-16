<?php

namespace WPDesk\View\Tests\Resolver;

use WPDesk\View\Renderer\SimplePhpRenderer;
use WPDesk\View\Resolver\ChainResolver;
use WPDesk\View\Resolver\DirResolver;
use WPDesk\View\Resolver\Exception\CanNotResolve;
use WPDesk\View\Resolver\NullResolver;
use WPDesk\View\Tests\TestCase;

class TestSimplePhpRenderer extends TestCase
{
    public function testThrowsExceptionWhenCannotFindTemplate()
    {
      $this->expectException(CanNotResolve::class);

      $renderer = new SimplePhpRenderer(new DirResolver('whatever'));
      $renderer->render('anything');
    }

    /**
     * @dataProvider templatesWithContent
     */
    public function testRenderingTemplates(string $template, string $content, array $parameters): void {
      $renderer = new SimplePhpRenderer( new DirResolver(self::getTemplatesPath()));
      $this->assertStringContainsString($content, $renderer->render($template, $parameters));
    }

    /**
     * @dataProvider templatesWithContent
     */
    public function testOutputtingTemplates(string $template, string $content, array $parameters): void {
      $this->expectOutputString($content);
      $renderer = new SimplePhpRenderer(new DirResolver(self::getTemplatesPath()));
      $renderer->output_render($template, $parameters);
    }

    public function templatesWithContent(): iterable {
      yield 'simple template' => [
        'template' => 'simple',
        'content' => 'outputText',
        'parameters' => []
      ];

      yield 'nested template' => [
        'template' => 'root-template',
        'content' => "This is a content of nested template: Hello World!\n",
        'parameters' => []
      ];

      yield 'access parameters with $param variable' => [
        'template' => 'with-parameter',
        'content' => 'passed parameter: custom_parameter',
        'parameters' => [
          'custom_parameter' => 'custom_parameter'
        ]
      ];

      yield 'access parameters directly through variable' => [
        'template' => 'with-variable',
        'content' => 'passed variable: custom_variable',
        'parameters' => [
          'custom_variable' => 'custom_variable'
        ]
      ];
    }
}
