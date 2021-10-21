<?php
/**
 * File SecurityController.php.php.
 */

namespace Blog\Controller;


use Blog\Form\ArticleForm;
use Blog\Http\Request;
use Blog\Model\Manager\ArticleManager;
use Blog\Model\Manager\CommentManager;
use Blog\Model\Manager\UserManager;

class ArticleController extends Controller
{
    /**
     * @var ArticleManager
     */
    private $articleManager;

    /**
     * @var CommentManager
     */
    private $commentManager;
    /**
     * @var UserManager
     */
    private $userManager;

    public function __construct()
    {
        $this->articleManager  = new ArticleManager();
        $this->commentManager  = new CommentManager();
        $this->userManager  = new UserManager();
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
                'image' => $this->upload($_FILES),
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

        $article = $this->articleManager->getPostById($params['id']);

        $form = new ArticleForm();

        $form->handle($request);

        if ($request::isPost() && $form->isValid()) {
            $this->articleManager->update([
                'title' => $request::get('title'),
                'chapo' => $request::get('chapo'),
                'content' => $request::get('content'),
                'image' => $this->upload($_FILES),
            ], $article->getId());

            $this->redirect(sprintf('/post/%s', $article->getId()));
        }

        echo $this->twig->render('article/edit.html.twig', [
            'errors' => $form->getErrors(),
            'article' => $article
        ]);
    }

    public function article($id)
    {
        if (isset($id['id'])){

            $article = $this->articleManager->getPostById($id['id']);

            echo $this->twig->render('article/article.html.twig', [
                'article' => $article,
                'author' => $this->userManager->getUserById($article->getAuthor()),
                'comments' => $this->commentManager->getCommentsBy($id['id'], COMMENT_VALIDATE)
        ]);
        }
    }

     public function delete($id)
    {
        if (isset($id['id'])){
            $article = $this->articleManager->getPostById($id['id']);
            if ($this->getuser()->getId() == $article->getAuthor()) {
               $this->articleManager->delete($id['id']);
            }
        }

        $this->redirect('/mon-compte');
    }

    public function upload($files)
    {
        try {

            // Undefined | Multiple Files | $_FILES Corruption Attack
            // If this request falls under any of them, treat it invalid.
            if (
                !isset($files['picture']['error']) ||
                is_array($files['picture']['error'])
            ) {
                throw new \RuntimeException('Paramètre invalide');
            }

            // Check $_FILES['upfile']['error'] value.
            switch ($files['picture']['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new \RuntimeException('Fichier non trouvé');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new \RuntimeException('La taille de l\image ne correspond pas');
                default:
                    throw new \RuntimeException('Erreur inconnue');
            }

            // Verification de la taille
            if ($files['picture']['size'] > 1000000) {
                throw new \RuntimeException('La taille du fichier n\est pas pris en charge');
            }

            // Verification du format
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            if (false === $ext = array_search(
                    $finfo->file($files['picture']['tmp_name']),
                    [
                        'jpg' => 'image/jpeg',
                        'png' => 'image/png',
                        'gif' => 'image/gif',
                    ],
                    true
                )) {
                throw new \RuntimeException('Format invalide');
            }


            // Move dans le dossier defini
            $pictureName = sha1_file($files['picture']['tmp_name']);

            if (!move_uploaded_file(
                $files['picture']['tmp_name'],
                sprintf(
                    __DIR__.'/../../public/uploads/%s.%s',
                    $pictureName,
                    $ext
                )
            )) {
                throw new \RuntimeException('Failed to move uploaded file.');
            }

            return $pictureName . "." . $ext;
        } catch (\RuntimeException $e) {
            echo $e->getMessage();
        }
    }
}
?>
