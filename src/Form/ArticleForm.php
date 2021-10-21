<?php
/**
 * File ArticleForm.php.
 */

namespace Blog\Form;


class ArticleForm extends Form
{

    public function configure()
    {
       return [
            'title' => [
                'required' => true
            ],
            'chapo' => [
                'required' => true
            ],
            'content' => [
                'required' => true
            ]
        ];

    }

}