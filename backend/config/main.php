<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
	'layout' => 'admin-lte/main',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            	[
            		'class' => 'yii\log\FileTarget',
            		'logFile' => '@runtime/logs/auts.log',
            		'levels' => ['info'],
            		'categories' => ['auth'],
            		'logVars' => [],
            		'maxFileSize' => 1024 * 100,
            		'maxLogFiles' => 5,
            	],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    	'userService' => [
    		'on '.\common\components\UserService::EVENT_CREATE => function (
    			\common\components\CreateEvent $model)
    		{
    			echo $model->user->username;
    		},
    		'on '.\common\components\UserService::EVENT_LOGIN => function (
    			\common\components\CreateEvent $model)
    		{
    			return Yii::info("{$model->user->username} login", 'auth');
    		},
    	],
        /*
        'view' => [
          'theme' => [
            'pathMap' => [
            '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
          ],
         ],
        ],*/
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
