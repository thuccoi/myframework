<?php

namespace Application\Controller;

class UserController extends \system\Template\AbstractController {

    public function indexAction() {
        
        return [];
    }

    public function loginAction(){

        $this->setLayout('index/outside.tami');
        
        return [
            'thuc'=>'lam sao vay?'
        ];
    }
}
