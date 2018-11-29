<?php 

namespace common\components;

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
	const EVENT_LOGIN = 'login';
	const EVENT_CREATE = 'create';
	
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
	
	public function login(User $model, $remember) {
		if ($result = \Yii::$app->user->login($model, $remember)) {
			$event = new CreateEvent();
			$event->user = $model;
			$this->trigger(self::EVENT_LOGIN, $event);
		}
		
		return $result;
	}
}