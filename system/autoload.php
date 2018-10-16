<?php

//require config global
require_once dirname(__DIR__) . '/config/php/global.php';

if(!defined("TAMI_MODULE")){
    define("TAMI_MODULE", require_once DIR_ROOT.'/config/php/module.config.php');
}

//require autload of vender
require_once DIR_ROOT . '/vendor/autoload.php';
