<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
	'language' => 'ru',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    	'userService' => [
    		'class' => \common\services\UserService::class,
    	],
    	'projectService' => [
    		'class' => \common\services\ProjectService::class,
    		'on '.common\services\ProjectService::EVENT_ASSIGN_ROLE => 
    			function (\common\services\AssignRoleEvent $event) {
    				\yii\helpers\VarDumper::dump($event->dump(), 5, true);
    			}
    	],
    ],
	
];
