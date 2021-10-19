<?php

namespace Blog\Controller;

use Blog\Model\User;
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
		$loader = new FilesystemLoader(__DIR__ . '/../../views');
		$this->twig = new Environment($loader, [
    		'cache' => __DIR__ . '/../../var/cache',
            'debug' => true
		]);

		if ($user = $this->getUser()) {
		    $this->twig->addGlobal('user', $user);
        }
	}

    public function redirect($url)
    {
        header('Location: ' . $url, true, 302);
        exit();
	}

    public function flash($message)
    {
        $_SESSION['flash'] = $message;
	}

    public function checkLoggin()
    {
        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            $this->redirect('/connexion');
        }
	}

    /**
     * @return User|null
     */
    public function getUser()
    {
        return isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
	}
}