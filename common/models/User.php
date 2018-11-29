<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $name
 * @property string $avatar
 * @property int $creator_id
 * @property int $updater_id
 * @property string $password write-only password
 * 
 * @mixin UploadImageBehavior
 *
 * @property Project[] $projects
 * @property Project[] $projects0
 * @property ProjectUser[] $projectUsers
 * @property Task[] $tasks
 * @property Task[] $tasks0
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    private $password;
	const STATUS_DELETED = 0;
	const STATUS_ACTIVE = 10;
	const STATUSES = [
			self::STATUS_DELETED, self::STATUS_ACTIVE
	];
	const STATUS_LABELS= [
			self::STATUS_DELETED => 'Удален', self::STATUS_ACTIVE => 'Активен'
	]; 
	
	// Размеры каринок
	const AVATAR_ICO = 'ico';
	const AVATAR_PREVIEW = 'preview';
	
	
	const SCENARIO_INSERT = 'insert';
	const SCENARIO_UPDATE = 'update';
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => \mohorev\file\UploadImageBehavior::class,
                'attribute' => 'avatar',
                'scenarios' => [self::SCENARIO_UPDATE],
                //'placeholder' => '@app/modules/user/assets/images/userpic.jpg',
                'path' => '@frontend/web/upload/user/{id}',
                'url' => Yii::$app->params['hosts.front'] . 
                         Yii::getAlias('@web/upload/user/{id}'),
                'thumbs' => [
                    self::AVATAR_ICO => ['width' => 30, 'quality' => 90],
                    self::AVATAR_PREVIEW => ['width' => 400, 'height' => 400],
                
                ],
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
    	
    	 return [
    	    [['email','username'], 'required'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
    	    [['username', 'email', 'auth_key', 'password'], 'safe'],
    	    ['avatar', 'image', 'extensions' => 'jpg, jpeg, gif, png', 'on' => [self::SCENARIO_UPDATE]],
        ];
    	 
    	/*
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at', 'creator_id', 'updater_id'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'name', 'avatar'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];*/
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'name' => 'Name',
            'avatar' => 'Avatar',
            'creator_id' => 'Creator ID',
            'updater_id' => 'Updater ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsCreatorBy()
    {
        return $this->hasMany(Project::className(), ['creator_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsUpdaterBy()
    {
        return $this->hasMany(Project::className(), ['updater_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectUsers()
    {
        return $this->hasMany(ProjectUser::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasksCreatorBy()
    {
        return $this->hasMany(Task::className(), ['creator_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasksUpdaterBy()
    {
        return $this->hasMany(Task::className(), ['updater_by' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\UserQuery(get_called_class());
    }
    
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
    	return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    	throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
    	return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
    	if (!static::isPasswordResetTokenValid($token)) {
    		return null;
    	}
    	return static::findOne([
    			'password_reset_token' => $token,
    			'status' => self::STATUS_ACTIVE,
    	]);
    }
    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
    	if (empty($token)) {
    		return false;
    	}
    	$timestamp = (int) substr($token, strrpos($token, '_') + 1);
    	$expire = Yii::$app->params['user.passwordResetTokenExpire'];
    	return $timestamp + $expire >= time();
    }
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
    	return $this->getPrimaryKey();
    }
    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
    	return $this->auth_key;
    }
    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
    	return $this->getAuthKey() === $authKey;
    }
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
    	return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        if ($password) {
    	   $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        }
        
        $this->password = $password;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
    	$this->auth_key = Yii::$app->security->generateRandomString();
    }
    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
    	$this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
    	$this->password_reset_token = null;
    }
}
