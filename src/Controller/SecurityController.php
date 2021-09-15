<?php
/**
 * File SecurityController.php.php.
 */

namespace Blog\Controller;


use Blog\Form\UserForm;
use Blog\Http\Request;
use Blog\Model\Manager\UserManager;

class SecurityController extends Controller
{
    /**
     * @var UserManager
     */
    private $userManager;

    public function __construct()
    {
        $this->userManager  = new UserManager();
        parent::__construct();
    }

    public function create()
    {
        $request = Request::getInstance();

        $form = new UserForm();

        $form->handle($request);

        if ($request::isPost() && $form->isValid()) {
            $this->userManager->insert([
                'firstname' => $request::get('firstname'),
                'lastname' => $request::get('lastname'),
                'email' => strtolower($request::get('email')),
                'role' => USER_PENDING,
                'password' => $this->userManager->encode($request::get('password'))
            ]);

            $this->redirect('/connexion');
        }

        echo $this->twig->render('user/create.html.twig', [
            'errors' => $form->getErrors()
        ]);
    }

    public function login()
    {
        $request = Request::getInstance();

        if ($request::isPost()) {
            $user = $this->userManager->get([
                'email' => $request::get('email')
            ]);
            if (!$user || ($user && !$this->userManager->verify($request::get('password'), $user->getPassword()))) {
                $this->flash("User n'existe pas ou mot de passe incorect");
            } else {
                $_SESSION['user'] = serialize($user);
                if($this->getUser()->isAdmin()) {
                    $this->redirect('/admin');
                }
                $this->redirect('/mon-compte');
            }
        }

        echo $this->twig->render('user/login.html.twig');
    }

    public function logout() {
        session_destroy();
        $this->redirect('/connexion');
    }

}