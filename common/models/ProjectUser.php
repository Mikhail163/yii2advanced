<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project_user".
 *
 * @property int $project_user_id
 * @property int $project_id
 * @property int $user_id
 * @property int $role
 *
 * @property Project $project
 * @property User $user
 */
class ProjectUser extends \yii\db\ActiveRecord
{
	const ROLE_DEVELOPER = 0;
	const ROLE_MANAGER = 1;
	const ROLE_TESTER = 2;
	
	const ROLE_LABELS= [
			self::ROLE_DEVELOPER => 'Developer',
			self::ROLE_MANAGER => 'Manager',
			self::ROLE_TESTER => 'Tester',
	];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'user_id', 'role'], 'required'],
            [['project_id', 'user_id', 'role'], 'integer'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'project_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'project_user_id' => 'Project User ID',
            'project_id' => 'Project ID',
            'user_id' => 'User ID',
            'role' => 'Role',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ProjectUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProjectUserQuery(get_called_class());
    }
}
