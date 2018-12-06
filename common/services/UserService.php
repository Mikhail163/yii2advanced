<?php 

namespace common\services;

use common\models\User;
use yii\base\Component;
use yii\base\Event;

class CreateEvent extends  Event
{
	/** @var User */
	public $user;
}

class UserService extends Component
{
	const EVENT_LOGIN = 'userServiceLogin';
	const EVENT_CREATE = 'userServiceCreate';
	
	public function create(User $model)
	{
		$model->generateAuthKey();
		if ($result = $model->save()) {
			$event = new CreateEvent();
			$event->user = $model;
			$this->trigger(self::EVENT_CREATE, $event);
		}
		
		return $result;
	}
	
	public function login(User $model, $remember) 
	{
		if ($result = \Yii::$app->user->login($model, $remember)) {
			$event = new CreateEvent();
			$event->user = $model;
			$this->trigger(self::EVENT_LOGIN, $event);
		}
		
		return $result;
	}
	
	public function getUsername()
	{
		return \Yii::$app->user->identity->username;
	}
	
	public function getName()
	{
		return \Yii::$app->user->identity->name;
	}
	
	public function getId() 
	{
		return \Yii::$app->user->id;
	}
}