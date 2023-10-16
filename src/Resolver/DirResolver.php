<?php

namespace WPDesk\View\Resolver;


use WPDesk\View\Renderer\Renderer;
use WPDesk\View\Resolver\Exception\CanNotResolve;

/**
 * Class should resolve name by serching in provided dir.
 *
 * @package WPDesk\View\Resolver
 */
class DirResolver implements Resolver
{

    /** @var string */
    private $dir;


    /**
     * Base path for templates ie. subdir
     *
     * @param string $dir
     */
    public function __construct($dir)
    {
		if ( empty( $dir ) ) {
			trigger_error( "DirResolver requires templates' base path.", E_USER_DEPRECATED );
		}

        $this->dir = $dir;
    }

    /**
     * Resolve name to full path
     *
     * @param string $name
     * @param Renderer|null $renderer
     *
     * @return string
     */
    public function resolve($name, Renderer $renderer = null)
    {
        $dir = rtrim($this->dir, '/');

		if ( empty( $dir ) || $dir === '/' ) {
			throw new CanNotResolve("Denying to search in system's root path.");
		}

        $fullName = $dir . '/' . $name;
        if (file_exists($fullName)) {
            return $fullName;
        }

        throw new CanNotResolve("Cannot resolve {$name}");
    }

}
