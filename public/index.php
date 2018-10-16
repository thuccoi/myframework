<?php

//require system autoload
require_once dirname(__DIR__) . '/system/autoload.php';

//init application
$init = \system\Template\System::init();

//run application
\system\Template\System::run($init);