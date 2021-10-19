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

            $this->redirect('/mon-compte');
        }

        echo $this->twig->render('article/createArticle.html.twig', [
            'errors' => $form->getErrors()
        ]);
    }


    public function edit($params)
    {
        $this->checkLoggin();
        $request = Request::getInstance();

         $article = $this->articleManager->get(['id' => $params['id']]);

        $form = new ArticleForm();

        $form->handle($request);

        if ($request::isPost() && $form->isValid()) {
            $this->articleManager->insert([
                'title' => $request::get('title'),
                'chapo' => $request::get('chapo'),
                'content' => $request::get('content'),
            ]);

            $this->redirect('/mon-compte');
        }

        echo $this->twig->render('article/edit.html.twig', [
            'errors' => $form->getErrors(),
            'article' => $article
        ]);
    }

    public function article($id)
    {
        if (isset($id['id'])){
            $article = $this->articleManager->getArticle(['id' => $id['id']]);
            echo $this->twig->render('article/article.html.twig', [
                'article' => $article
        ]);
        }
    }

     public function delete($id)
    {
        if (isset($id['id'])){
            $article = $this->articleManager->get(['id' => $id['id']]);
            if ($this->getuser()->getId() == $article->getAuthor()) {
               $this->articleManager->delete($id['id']);
            }
        }

        $this->redirect('/mon-compte');
    }
}
?>
