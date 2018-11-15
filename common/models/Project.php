<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property int $project_id
 * @property string $title
 * @property string $description
 * @property int $creator_by
 * @property int $updater_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $creatorBy
 * @property User $updaterBy
 * @property ProjectUser[] $projectUsers
 */
class Project extends \yii\db\ActiveRecord
{
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
            [['creator_by', 'updater_by', 'created_at', 'updated_at'], 'integer'],
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
     * {@inheritdoc}
     * @return \common\models\query\ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProjectQuery(get_called_class());
    }
}