<?php

namespace app\models\helpers;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\identities\Users;

/**
 * This is the model class for table "logs".
 *
 * @property int $id
 * @property string|null $table
 * @property string|null $activity
 * @property string|null $data_before
 * @property string|null $data_inserted
 * @property int|null $time
 * @property int|null $user_id
 * @property int|null $user_role
 *
 * @property Users $user
 */
class Logs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'logs';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'time'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data_before', 'data_inserted'], 'string'],
            [['time', 'user_id', 'user_role'], 'integer'],
            [['table', 'activity'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'table' => Yii::t('app', 'Table'),
            'activity' => Yii::t('app', 'Activity'),
            'data_before' => Yii::t('app', 'Data Before'),
            'data_inserted' => Yii::t('app', 'Data Inserted'),
            'time' => Yii::t('app', 'Time'),
            'user_id' => Yii::t('app', 'User ID'),
            'user_role' => Yii::t('app', 'User Role'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}