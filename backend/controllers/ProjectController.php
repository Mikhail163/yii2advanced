<?php

namespace backend\controllers;

use Yii;
use common\models\Project;
use common\models\User;
use common\models\search\ProjectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        	'access' => [
        		'class' => AccessControl::className(),
        		//'only' => ['logout', 'signup'],
        		'rules' => [
        			[
        				'allow' => true,
        				'roles' => ['@'],
        			],
        		],
        	],
        ];
    }

    /**
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Project model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Project();


        $model->creator_by = Yii::$app->userService->getId();
        //$model->updater_by = Yii::$app->userService->getId();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->project_id]);
        }

        
        print_r($model->errors);
        //exit();
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    private function loadModel(Project $model)
    {
    	$data = Yii::$app->request->post($model->formName());
    	$projectUsers = $data[Project::RELATION_PROJECT_USERS] ?? null;
    	
    	
    	
    	if ($projectUsers !== null) {
    		$model->projectUsers = $projectUsers === '' ? [] : $projectUsers;
    	}
    	
    	return $model->load(Yii::$app->request->post());
    }

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $projectUsers = $model->getUsersData();
        
        //$model->updater_by = Yii::$app->userService->getId();	
        
        //print_r($model);exit();
        
        //print_r($projectUsers);
        
        if ($this->loadModel($model) && $model->save()) {
            
        	
        	if ($diffRoles = array_diff_assoc($model->getUsersData(), $projectUsers)){
        		
        		
        		//print_r($diffRoles); exit();
        		
        		foreach($diffRoles as $userId => $diffRole) {
        			Yii::$app->projectService->assignRole(
        					$model,
        					User::findOne($userId),
        					$diffRole);
        		}
        		
        	}
        	
        	//return $this->redirect(['view', 'id' => $model->project_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
