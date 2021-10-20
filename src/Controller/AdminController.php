<?php

namespace Blog\Controller;


use Blog\Model\Manager\ArticleManager;
use Blog\Model\Manager\CommentManager;

/**
 * Admin Controller
 */
class AdminController extends Controller
{
	
	 /**
     * @var ArticleManager
     */
    private $articleManager;
    /**
     * @var CommentManager
     */
    private $commentManager;


    public function __construct()
	{
		$this->articleManager = new ArticleManager();
		$this->commentManager = new CommentManager();
		parent::__construct();
	}

	public function home() {

		$posts = $this->articleManager->getPosts(ARTICLE_PENDING);
		$comments = $this->commentManager->getComments(COMMENT_PENDING);


		echo $this->twig->render('admin/home.html.twig', ['posts' => $posts, 'comments' => $comments]);
	}

	public function activatePost($id)
	{
		$post = $this->articleManager->getPostById($id['id']);
		if (!$post) {	
			  $this->redirect('/admin');
		}
		$this->articleManager->activate($post);
		$this->redirect('/admin');
	}

    public function activateComment($id)
    {
        $comment = $this->commentManager->getCommentById($id['id']);
        if (!$comment) {
            $this->redirect('/admin');
        }
        $this->commentManager->activate($comment);
        $this->redirect('/admin');
	}
}