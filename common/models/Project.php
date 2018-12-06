<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;

/**
 * This is the model class for table "project".
 *
 * @property int $project_id
 * @property string $title
 * @property string $description
 * @property int $active
 * @property int $creator_by
 * @property int $updater_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $creatorBy
 * @property User $updaterBy
 * @property ProjectUser[] $projectUsers
 * @property Task[] $tasks
 */
class Project extends \yii\db\ActiveRecord
{
	/*
	 * $updated_by - какаето волшебная переменная
	 *               без нее yii2 ругается при совершении update
	 *               нужна только для того, чтоб не было ошибок
	 *               настоящая переменная назыается $updater_by
	 */
	public $updated_by = 0;
	const RELATION_PROJECT_USERS = 'projectUsers';
	const STATUS_DEACTIVE = 0;
	const STATUS_ACTIVE = 1;
	
	const STATUSES = [
			self::STATUS_DEACTIVE, self::STATUS_ACTIVE
	];
	const STATUS_LABELS= [
			self::STATUS_DEACTIVE => 'Не активен', self::STATUS_ACTIVE => 'Активен'
	]; 
	
	
	public function behaviors()
	{
		return [
				TimestampBehavior::class,
				[
						'class' => BlameableBehavior::className(),
						'createdByAttribute' => 'creator_by',
						'updatedByAttribute' => 'updater_by',
				],
				'saveRelations' => [
					'class' => SaveRelationsBehavior::class,
					'relations' => [
						self::RELATION_PROJECT_USERS,
					],
				]
			];
	}
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'creator_by'], 'required'],
            [['description'], 'string'],
            [['active', 'creator_by', 'updater_by', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
            'project_id' => 'Project ID',
            'title' => 'Title',
            'description' => 'Description',
            'active' => 'Active',
            'creator_by' => 'Creator By',
            'updater_by' => 'Updater By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatorBy()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdaterBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updater_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectUsers()
    {
        return $this->hasMany(ProjectUser::className(), ['project_id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['project_id' => 'project_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProjectQuery(get_called_class());
    }
    
    
    public function getUsersData()
    {
    	return 
    		$this->getProjectUsers()
    			->select('role') 
    			->indexBy('user_id') 
    			->column();
    }
}
