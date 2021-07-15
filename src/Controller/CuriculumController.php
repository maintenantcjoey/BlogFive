<?php

namespace Blog\Controller;

/**
 * FrontController
 */
class CuriculumController extends Controller
{
    public function curiculum()
    {
        echo $this->twig->render('user/cv.html.twig');
    }
}