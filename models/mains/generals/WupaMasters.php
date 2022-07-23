<?php

namespace app\models\mains\generals;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\identities\Users;

/**
 * This is the model class for table "wupa_masters".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $title
 * @property string|null $desc
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
 * @property Users $updatedBy
 * @property WupaCoefficients[] $wupaCoefficients
 */
class WupaMasters extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wupa_masters';
    }



    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    //fungsi delete
    public function delete()
    {
        $this->scenario = 'delete';
        if ($this->save()) :
            return true;
        endif;
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'desc'], 'required'],
            [['desc'], 'string'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['code'], 'string', 'max' => 15],
            [['title'], 'string', 'max' => 255],
            // tambah bagian ini
            ['created_by', 'default', 'value' => Yii::$app->user->id],
            ['updated_by', 'default', 'value' => Yii::$app->user->id, 'when' => function ($model) {
                return !$model->isNewRecord;
            }],
            ['deleted_at', 'default', 'value' => time(), 'on' => 'delete'],
            ['deleted_by', 'default', 'value' => Yii::$app->user->id, 'on' => 'delete'],
            [['desc'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

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
            'code' => Yii::t('app', 'Code'),
            'title' => Yii::t('app', 'Title'),
            'desc' => Yii::t('app', 'Desc'),
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
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['id' => 'updated_by']);
    }

    /**
     * Gets query for [[WupaCoefficients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWupaCoefficients()
    {
        return $this->hasMany(WupaCoefficients::className(), ['wupa_master_id' => 'id']);
    }
}