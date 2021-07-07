<?php
/**
 * File Form.php.
 */

namespace Blog\Form;


use Blog\Http\Request;

abstract class Form
{
    protected $fields = [];

    private $errors = [];


    public function handle(Request $request)
    {
        $this->configure();
        if ($request::isPost()) {
            $this->validate($request);
        }

    }

    private function validate(Request $request)
    {
        if (empty($this->fields)) {
            return;
        }
        $posts = $request::posts();

        foreach ($this->fields as $key => $configs) {
            if (!in_array($key, array_keys($posts))) {
                $this->errors['missings'][] = $key;
            }

            if (isset($configs['required'], $posts[$key]) && $configs['required'] && empty(trim($posts[$key]))) {
                $this->errors['required'][$key] = true;
            }
        }

    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function isValid()
    {
        return count($this->errors) === 0;
    }

    abstract public function configure();

}