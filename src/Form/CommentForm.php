<?php


namespace Blog\Form;


class CommentForm extends Form
{

    public function configure()
    {
        return [
            'content' => [
                'required' => true
            ]
        ];
    }
}