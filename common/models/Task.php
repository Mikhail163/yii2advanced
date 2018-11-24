<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\Project;

/**
 * This is the model class for table "task".
 *
 * @property int $task_id
 * @property string $title
 * @property string $description
 * @property int $estimation
 * @property int $project_id
 * @property int $executor_id
 * @property int $started_at
 * @property int $completed_at
 * @property int $creator_by
 * @property int $updater_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Project $project
 * @property User $creatorBy
 * @property User $updaterBy
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'estimation', 'project_id', 'creator_by'], 'required'],
            [['estimation', 'project_id', 'executor_id', 'started_at', 'completed_at', 'creator_by', 'updater_by', 'created_at', 'updated_at'], 'integer'],
            [['title', 'description'], 'string', 'max' => 255],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'project_id']],
            [['creator_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_by' => 'id']],
            [['updater_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'Task ID',
            'title' => 'Title',
            'description' => 'Description',
            'estimation' => 'Estimation',
            'project_id' => 'Project ID',
            'executor_id' => 'Executor ID',
            'started_at' => 'Started At',
            'completed_at' => 'Completed At',
            'creator_by' => 'Creator By',
            'updater_by' => 'Updater By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['project_id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatorBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'creator_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdaterBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'updater_by']);
    }
    

    /**
     * {@inheritdoc}
     * @return \common\models\query\TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\TaskQuery(get_called_class());
    }
}
