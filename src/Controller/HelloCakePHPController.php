<?php

namespace App\Controller;

use App\Controller\AppController;

class HelloCakePHPController extends AppController
{
    public function hello()
    {
        if ($this->request->is('post')) {
            $name = $this->request->data('name');
            if (strlen($name) != 0) {
                $this->set('display_name', $name);
            }
        }
    }
}
