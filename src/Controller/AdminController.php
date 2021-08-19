<?php

namespace Blog\Controller;


use Blog\Model\Manager\ArticleManager;
/**
 * Admin Controller
 */
class AdminController extends Controller
{
	
	 /**
     * @var ArticleManager
     */
    private $articleManager;


	public function __construct()
	{
		$this->articleManager = new ArticleManager();
		parent::__construct();
	}

	public function home() {

		$posts = $this->articleManager->get(['status' => ARTICLE_PENDING], false);


		echo $this->twig->render('admin/home.html.twig', ['posts' => $posts]);
	}

	public function activatePost($id)
	{
		$post = $this->articleManager->get(['id' => $id['id']]);
		if (!$post) {	
			  $this->redirect('/admin');
		}
		$this->articleManager->activate($post);
		$this->redirect('/admin');
	}
}