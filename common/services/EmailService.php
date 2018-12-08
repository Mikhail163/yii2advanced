<?php

namespace common\services;

/*
use common\models\Project;
use common\models\User;*/
use yii\base\Component;
//use yii\base\Event;



class EmailService extends Component
{
	public function send($viewHTML, $viewText, $data, $email, $subject) {
		
		\Yii::$app
			->mailer
			->compose(
					['html' => $viewHTML, 'text' => $viewText], $data
				)
				->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
				->setTo($email)
				->setSubject($subject)
				->send();
	}

}