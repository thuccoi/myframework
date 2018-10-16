<?php

namespace Application\Controller;

class UserController extends \system\Template\AbstractController {

    public function indexAction() {

        return [];
    }

    public function loginAction() {
        
        //set no layout
        $this->setLayout('TAMI_NOLAYOUT');

        return [
            'thuc' => 'lam sao vay?'
        ];
    }

}
