<?php
/**
 * File SecurityController.php.php.
 */

namespace Blog\Controller;


use Blog\Form\ArticleForm;
use Blog\Http\Request;
use Blog\Model\Manager\ArticleManager;

class ArticleController extends Controller
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

    public function create()
    {
        $this->checkLoggin();
        $request = Request::getInstance();

        $form = new ArticleForm();

        $form->handle($request);

        if ($request::isPost() && $form->isValid()) {
            $this->articleManager->insert([
                'title' => $request::get('title'),
                'chapo' => $request::get('chapo'),
                'content' => $request::get('content'),
                'author' => $this->getUser()->getId(),
                'image' => 'image.png',
                'date' => date('Y-m-d'),
                'status' => ARTICLE_PENDING
            ]);

            $this->redirect('/posts');
        }

        echo $this->twig->render('article/createArticle.html.twig', [
            'errors' => $form->getErrors()
        ]);
    }

    public function article($id)
    {
        if (isset($id['id'])){
            $this->articleManager = new ArticleManager();
            $article = $this->articleManager->getArticle(['id' => $id['id']]);
            // var_dump($article);
            // die;
            echo $this->twig->render('article/article.html.twig', [
            'article' => $article
        ]);
        }
    }
}
?>
