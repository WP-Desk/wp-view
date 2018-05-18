<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Can render templates
 */
interface WPDesk_View {
	/**
	 * @param string $template
	 * @param string $template_path
	 * @param array $template_params
	 *
	 * @return string
	 */
	public function load_template( $template, $template_path, $template_params );
}
