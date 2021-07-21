<?php

namespace Blog\Controller;


use Blog\Form\ArticleForm;
use Blog\Http\Request;
use Blog\Model\Manager\ArticleManager;

class PostController extends Controller
{

    private $articleManager;

    public function article()
    {
        if (isset($_GET['id'])){
            $this->articleManager = new ArticleManager();
            $article = $this->articleManager->getArticle($_GET['id']);
            echo $this->twig->render('../views/article/article.html.twig', [
            'posts' => $posts,
        ]);
        }
    }

}


?>