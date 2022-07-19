<?php

namespace app\models\helpers;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\identities\Users;

/**
 * This is the model class for table "notifications".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $roles
 * @property string|null $schools
 * @property string|null $year_of_graduates
 * @property string|null $title
 * @property string|null $sort_desc
 * @property string|null $desc
 * @property string|null $content
 * @property string|null $read_more_uri
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $deleted_at
 * @property int|null $deleted_by
 *
 * @property Users $createdBy
 * @property Users $deletedBy
 * @property NotificationReads[] $notificationReads
 * @property Users $updatedBy
 */
class Notifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notifications';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['roles', 'schools', 'year_of_graduates', 'sort_desc', 'desc', 'content'], 'string'],
            [['title', 'read_more_uri'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['deleted_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'roles' => Yii::t('app', 'Roles'),
            'schools' => Yii::t('app', 'Schools'),
            'year_of_graduates' => Yii::t('app', 'Year Of Graduates'),
            'title' => Yii::t('app', 'Title'),
            'sort_desc' => Yii::t('app', 'Sort Desc'),
            'desc' => Yii::t('app', 'Desc'),
            'content' => Yii::t('app', 'Content'),
            'read_more_uri' => Yii::t('app', 'Read More Uri'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'deleted_by' => Yii::t('app', 'Deleted By'),
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['id' => 'created_by']);
    }

    /**
     * Gets query for [[DeletedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy()
    {
        return $this->hasOne(Users::className(), ['id' => 'deleted_by']);
    }

    /**
     * Gets query for [[NotificationReads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotificationReads()
    {
        return $this->hasMany(NotificationReads::className(), ['notification_id' => 'id']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['id' => 'updated_by']);
    }
}