<?php
/**
 * File UserForm.php.
 */

namespace Blog\Form;


class UserForm extends Form
{

    public function configure()
    {
        $this->fields = [
            'firstname' => [
                'required' => true
            ],
            'lastname' => [
                'required' => true
            ],
            'email' => [
                'required' => true
            ],
            'password' => [
                'required' => true
            ]
        ];

    }

}