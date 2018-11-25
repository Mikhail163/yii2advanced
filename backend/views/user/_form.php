<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

/*
 *    
    <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>
    
     <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'avatar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'creator_id')->textInput() ?>

    <?= $form->field($model, 'updater_id')->textInput() ?>

 */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        /*'layout'      => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'label' => 'col-sm-2',
            ]
        ],*/
        'options' => ['enctype' => 'multipart/form-date']
    ]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

 
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(\common\models\User::STATUS_LABELS) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>
    
    <?= $form->field($model, 'avatar')->fileInput(['accept' => 'image/*'])
            ->label(Html::img($model->getThumbUploadUrl('avatar', \common\models\User::AVATAR_PREVIEW)))?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
