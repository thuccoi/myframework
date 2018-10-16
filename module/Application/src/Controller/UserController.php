<?php

namespace Application\Controller;

class UserController extends \system\Template\AbstractController {

    public function indexAction() {
        
        return [
            'thuc' => 'anwesomme dasdasd',
            'dat' => 'Toi la dat'
        ];
    }

    public function listAction() {
        return [
            'users' => [1, 2, 3, 4, 4]
        ];
    }

    public function registerAction() {
        return [
        ];
    }

}
