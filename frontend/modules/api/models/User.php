<?php
namespace frontend\modules\api\models;

class User extends \common\models\User 
{
	public function fields() {
		return [
			'un' => 'username', 
			'e' => 'email',
			'FullId' => function($model) {
				return $model->id.' '.$model->email;
			}
		];
	}
}
