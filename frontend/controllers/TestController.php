<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class TestController extends Controller
{
 
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return 'hello world';
    }

}
