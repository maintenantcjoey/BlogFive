<?php


namespace Blog\Form;


class CommentForm extends Form
{

    public function configure()
    {
        $this->fields = [
            'content' => [
                'required' => true
            ]
        ];
    }
}