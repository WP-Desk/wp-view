<?php

namespace WPDesk\View\Renderer;

use WPDesk\View\Resolver\Resolver;

/**
 * Can render templates
 */
interface Renderer {
	/**
	 * Set the resolver used to map a template name to a resource the renderer may consume.
	 *
	 * @param  Resolver $resolver
	 *
	 * @return Resolver
	 */
	public function set_resolver( Resolver $resolver );

	/**
	 * @param string $template
	 * @param array $params
	 *
	 * @return string
	 */
	public function render( $template, $params );
}
