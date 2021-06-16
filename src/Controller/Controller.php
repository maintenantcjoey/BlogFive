<?php

namespace Blog\Controller;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

/**
 * Controller
 */
class Controller
{
	protected $twig;

	public function __construct()
	{
		$loader = new FilesystemLoader(__DIR__ . '/../Views');
		$this->twig = new Environment($loader, [
    		'cache' => __DIR__ . '/../var/cache',
		]);
	}
}