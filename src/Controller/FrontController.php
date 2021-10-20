<?php

namespace Blog\Controller;


use Blog\Http\Request;
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

    public function contact()
    {
        $transport = (new \Swift_SmtpTransport(SMTP, 587, 'tls'))
            ->setUsername(USER_EMAIL)
            ->setPassword(PASSWORD_PASSWORD)
        ;

        $mailer = new \Swift_Mailer($transport);

        $message = (new \Swift_Message('New contact'))
            ->setFrom(Request::get('email'))
            ->setTo(USER_EMAIL)
            ->setBody(Request::get('message'))
        ;
        $mailer->send($message);
        $this->redirect('/');
    }
}