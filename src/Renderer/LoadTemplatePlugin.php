<?php

namespace WPDesk\View\Renderer;

use WPDesk\View\Resolver\Resolver;

/**
 * Can render templates
 */
class LoadTemplatePlugin implements Renderer {
	private $plugin;

	public function __construct($plugin) {
		$this->plugin = $plugin;
	}

	public function set_resolver( Resolver $resolver ) {

	}

	public function render( $template, $params ) {
		return $this->plugin->load_template($template, '', $params);
	}
}
