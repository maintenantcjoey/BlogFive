<?php
/**
 * File AccountController.php.
 */

namespace Blog\Controller;


use Blog\Model\Manager\ArticleManager;

class AccountController extends Controller
{
    /**
     * @var ArticleManager
     */
    private $articleManager;

    public function __construct()
    {
        $this->articleManager  = new ArticleManager();
        parent::__construct();
    }

    public function account()
    {
        $this->checkLoggin();

        echo $this->twig->render('account/account.html.twig', [
            'posts' => $this->articleManager->get([
                'author' => $this->getUser()->getId()
            ], false)
        ]);
    }

}