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
    	'emailService' => [
    		'class' => \common\services\EmailService::class,
    	],
    	'projectService' => [
    		'class' => \common\services\ProjectService::class,
    		'on '.common\services\ProjectService::EVENT_ASSIGN_ROLE => 
    			function (\common\services\AssignRoleEvent $event) {
    				
    				$data = [
    						'project' => $event->project, 
    						'user' => $event->user, 
    						'role' => \common\models\ProjectUser::ROLE_LABELS[($event->role)],
    					];
    				
    				Yii::$app->emailService->send(
    						'assign-role-html',
    						'assign-role-text',
    						$data,
    						$event->user->email,
    						'You role changed'
    					);
    				
    				/*
    				Yii::info(
    					\yii\helpers\VarDumper::dump($event->dump(), 5, true), '_'
    				);
    				*/
    			}
    	],
    ],
	
];
