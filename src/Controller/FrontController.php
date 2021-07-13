<?php

namespace Blog\Controller;


use Blog\Model\Manager\ArticleManager;

/**
 * FrontController
 */
class FrontController extends Controller
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

    public function home()
    {
        $posts = $this->articleManager->getArticles();
        echo $this->twig->render('home.html.twig', [
            'posts' => $posts,
        ]);
    }
}