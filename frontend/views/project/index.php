<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

        	[
        		'attribute' => 'title',
        		'value'     => 
        		function (\common\models\Project $model) {
        			return HTML::a($model->title, ['view', 'id' => $model->project_id]);
        		},
        		'format' => 'html',
    		],
       		
    		[
    			'attribute' => \common\models\Project::RELATION_PROJECT_USERS.'.role',
    			'value'     => function (\common\models\Project $model) {
    				return join(',', Yii::$app->projectService->getRoles($model, Yii::$app->user->identity));
        		},
        		'format' => 'html',
        	],
        	
        	[
        		'attribute' => 'active',
        		'filter' => \common\models\Project::STATUS_LABELS,
        		'value' => function (\common\models\Project $model) {
        			return \common\models\Project::STATUS_LABELS[$model->active];
        		}
        	],
        	
            //'project_id',
            //'title',
            'description:ntext',
            [
            	'attribute' => 'creator_by',
            	'value' => function (\common\models\Project $model) {

            		return Html::a($model->creatorBy->username,
            			['user/view', 'id' => $model->creatorBy->id]);
        		},
        		'format' => 'html',
        	],
        	[
        		'attribute' => 'updater_by',
        		'value' => function (\common\models\Project $model) {
        			
        			return Html::a($model->updaterBy->username,
        					['user/view', 'id' => $model->updaterBy->id]);
        		},
        		'format' => 'html',
        	],
            //'updater_by',
            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
