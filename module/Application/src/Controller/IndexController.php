<?php

namespace Application\Controller;

class IndexController extends \system\Template\AbstractController {

    public function indexAction() {

        $this->getRouter()->redirect("application", ["controller" => "user", "action" => "index", "param"=>[
            "id"=>3,
            "name"=>"Lop hoc lap trinh"
        ]]);

        return [];
    }

}
