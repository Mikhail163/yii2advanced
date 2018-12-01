<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        	'on '.\yii\web\User::EVENT_AFTER_LOGIN => function(\yii\web\UserEvent $e) {
        		return Yii::info('login user='.$e->identity->username, 'auth');
        	}
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'modules' => [
        'chat' => [
            'class' => 'common\modules\chat\Module',
        ],
    	'api' => [
    		'class' => 'frontend\modules\api\Module',
    	],
    ],
		
		
    'params' => $params,
];
