<?php

namespace common\services;

/*
use common\models\Project;
use common\models\User;*/
use yii\base\Component;
//use yii\base\Event;



class EmailService extends Component
{
	public function send($viewHTML, $viewText, $data, $email) {
		
		\Yii::$app
			->mailer
			->compose(
					['html' => $viewHTML, 'text' => $viewText], $data
				)
				->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
				->setTo($email)
				->setSubject('Password reset for ' . \Yii::$app->name)
				->send();
	}

}