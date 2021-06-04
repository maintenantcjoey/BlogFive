<?php

namespace Blog\Controller;


/**
 * FrontController
 */
class FrontController extends Controller
{
	
	public function home()
	{
		echo $this->twig->render('home.html.twig');
	}
}