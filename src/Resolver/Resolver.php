<?php

namespace WPDesk\View\Resolver;

/**
 * Can resolve template name to a file
 */
interface Resolver {
	/**
	 * Resolve a template/pattern name to a resource the renderer can consume
	 *
	 * @param  string $name
	 * @param  null|Resolver $renderer
	 *
	 * @return mixed
	 */
	public function resolve($name, Resolver $renderer = null);
}
