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
    ],
	'userService' => [
		'class' => \common\components\UserService::class,
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
];
