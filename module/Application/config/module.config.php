<?php

namespace Application;

return [
    'router' => [
        'application' => [
            'user' => Controller\UserController::class,
            'index' => Controller\IndexController::class
        ]
    ],
    'controller' => [
        'factories' => [
            Controller\UserController::class => \system\Template\Factory::class,
            Controller\IndexController::class => \system\Template\Factory::class
        ]
    ],
    'view_manager' => [
        'layout' => dirname(__DIR__) . '/view/layout/layout.tami'
    ]
];
