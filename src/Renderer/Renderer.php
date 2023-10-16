<?php

namespace WPDesk\View\Renderer;

use WPDesk\View\Resolver\Resolver;

/**
 * Can render templates
 */
interface Renderer
{
    /**
     * Set the resolver used to map a template name to a resource the renderer may consume.
     *
     * @param  Resolver $resolver
	 *
	 * @deprecated Setting resolver doesn't concern renderer. Pass it with setter method, or by constructor, but it shouldn't be included in interface declaration.
     */
    public function set_resolver(Resolver $resolver);

    /**
     * @param string $template
     * @param array $params
     *
     * @return string
     */
    public function render($template, array $params = null);

    /**
     * @param string $template
     * @param array $params
     */
    public function output_render($template, array $params = null);
}
