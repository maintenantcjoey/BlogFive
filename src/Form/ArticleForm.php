<?php
/**
 * File ArticleForm.php.
 */

namespace Blog\Form;


class ArticleForm extends Form
{

    public function configure()
    {
        $this->fields = [
            'title' => [
                'required' => true
            ],
            'chapo' => [
                'required' => true
            ],
            'content' => [
                'required' => true
            ],
            'author' => [
                'required' => true
            ],
            'image' => [
                'required' => true
            ]
            ,
            'date' => [
                'required' => true
            ]
        ];

    }

}