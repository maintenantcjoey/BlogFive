<?php


namespace Blog\Controller;


use Blog\Form\CommentForm;
use Blog\Http\Request;
use Blog\Model\Manager\CommentManager;

class CommentController extends Controller
{

    private $commentManager;

    public function __construct()
    {
        parent::__construct();
        $this->commentManager = new CommentManager();
    }

    public function create($params)
    {
        $this->checkLoggin();
        $request = Request::getInstance();

        $form = new CommentForm();
        $form->handle($request);
        if ($request::isPost() && $form->isValid()) {

            $this->commentManager->insert([
                'content' => Request::get('content'),
                'post' => $params['id'],
                'author' => (int) $this->getUser()->getId(),
                'status' => ARTICLE_PENDING
            ]);
            $this->redirect(sprintf('/post/%s', $params['id']));
        }
        $this->redirect(sprintf('/post/%s', $params['id']));
    }

}