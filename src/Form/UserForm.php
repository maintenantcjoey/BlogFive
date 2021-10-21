<?php
/**
 * File UserForm.php.
 */

namespace Blog\Form;


class UserForm extends Form
{

    public function configure()
    {
        return [
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