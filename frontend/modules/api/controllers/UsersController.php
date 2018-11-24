<?php

namespace frontend\modules\api\controllers;

use yii\rest\ActiveController;


/**
 * Default controller for the `api` module
 */
class UsersController extends ActiveController
{
	public $modelClass = \frontend\modules\api\models\User::class;
	/*
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
		return $behaviors;
	}
	*/
    /**
     * Renders the index view for the module
     * @return string
     */
	/*
    public function actionIndex()
    {
        return $this->render('index');
    }
    */
}
