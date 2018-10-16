<?php

namespace system\Template;

class System {

    public static function run($init) {
        if ($init) {
            if (isset($init["view_file"])) {

                //init parameters
                if (isset($init['parameters']) && $init['parameters']) {
                    foreach ($init['parameters'] as $key => $val) {
                        $$key = $val;
                    }
                }

                if (!file_exists($init["view_file"])) {
                    echo "View file: {$init["view_file"]} not exists";
                    exit;
                }

                require_once $init["view_file"];
            } else {
                echo "Not exists view file";
                exit;
            }
        } else {
            echo "system not initialize";
            exit;
        }
    }

    public static function init() {
        
        //get config of system
        $sysconfig = \system\Template\Container::getSysConfig();

        $code = new \system\Helper\Code();

        $request_uri = $_SERVER['REQUEST_URI'];


        //get path and params ..
        $path = "/";
        $arrrequest = explode('?', $request_uri);

        if (isset($arrrequest[0])) {
            $path = $arrrequest[0];
        }

        //add data to $_GET from url
        if (isset($arrrequest[1])) {
            \system\Helper\HTML::addQuery($code, $arrrequest[1]);
        }



        $router = \system\Helper\HTML::getPathUri($code, $path, $sysconfig);

        $module = $router->getModule();

        $controller = $router->getController();

        $action = $router->getAction();


        $config = self::getModuleConfig($module, $controller);

        if ($config) {
            if (isset($config['controller'])) {

                if (!isset($config['factory'])) {
                    echo "Not found factory in module config";
                    exit;
                }

                $factory = $config['factory'];

                $objfactory = new $factory;


                //init controller
                $obj = $objfactory($config['controller'], $router, $code, $sysconfig, []);

                //echo method exists
                if (!method_exists($obj, $action . "Action")) {
                    echo "Method " . $action . "Action(){...} not exists in {$config['controller']}";
                    exit;
                }


                //get parameters 
                $parameters = $obj->{$action . "Action"}();


                return [
                    "parameters" => $parameters,
                    "view_file" => $config['view_dir'] . $controller . '/' . $action . '.tami'
                ];
            } else {
                echo "Not found controller config";
                exit;
            }
        } else {
            echo "Not get module config";
            exit;
        }
    }

    public static function getModuleConfig($module, $controller) {
        //load config of module
        foreach (TAMI_MODULE as $val) {
            $classname = $val . '\\Module';

            $obj = new $classname();

            //get module config
            $config = $obj->getConfig();

            if (isset($config['router'])) {

                //accept module config
                if (isset($config['router'][$module])) {

                    //get factory
                    if (!isset($config['controller']) || !$config['controller']) {
                        echo "Not found config controller in module config: {$val}";
                        exit;
                    }

                    if (!isset($config['controller']['factories'])) {
                        echo "Not found config factories in module config: {$val}";
                        exit;
                    }

                    //accept controller
                    if (isset($config['router'][$module][$controller])) {

                        if (!isset($config['controller']['factories'][$config['router'][$module][$controller]])) {
                            echo "{$config['router'][$module][$controller]} has not factory";
                            exit;
                        }

                        //factory of controller
                        $factory = $config['controller']['factories'][$config['router'][$module][$controller]];

                        return [
                            "controller" => $config['router'][$module][$controller],
                            "factory" => $factory,
                            "view_dir" => DIR_ROOT . '/module/' . $val . '/view/'
                        ];
                    } else {
                        echo 'Controller Not found';
                        exit;
                    }
                } else {
                    echo 'Module not found';
                    exit;
                }
            } else {
                echo "Module not config router";
                exit;
            }
        }
    }

}
