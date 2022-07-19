<?php

namespace app\models\mains\generals;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\identities\Users;

/**
 * This is the model class for table "contractors".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $title
 * @property string|null $desc
 * @property string|null $address
 * @property string|null $telp
 * @property string|null $fax
 * @property string|null $tax_number
 * @property string|null $logo
 * @property int|null $pic_str
 * @property string|null $pic_phone_number
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
 */
class Contractors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contractors';
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
            [['code', 'title', 'tax_number', 'address', 'telp'], 'required'],
            [['desc', 'address'], 'string'],
            [['pic_str', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['code'], 'string', 'max' => 15],
            [['title', 'logo'], 'string', 'max' => 255],
            [['telp', 'fax'], 'string', 'max' => 20],
            [['tax_number'], 'string', 'max' => 25],
            [['pic_phone_number'], 'string', 'max' => 16],
            ['created_by', 'default', 'value' => Yii::$app->user->id],
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
            'address' => Yii::t('app', 'Address'),
            'telp' => Yii::t('app', 'Telp'),
            'fax' => Yii::t('app', 'Fax'),
            'tax_number' => Yii::t('app', 'Tax Number'),
            'logo' => Yii::t('app', 'Logo'),
            'pic_str' => Yii::t('app', 'Pic Str'),
            'pic_phone_number' => Yii::t('app', 'Pic Phone Number'),
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
     * Gets query for [[Projects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Projects::className(), ['contractor_id' => 'id']);
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

    public function GetAvailableCreateContractor()
    {
        $setting = Settings::find()
            ->where(['name' => 'max_contractors'])
            ->andWhere(['status' => 1])
            ->andWhere(['deleted_at' => NULL])
            ->one();
        $max = $setting->value ? Yii::$app->encryptor->decodeUrl($setting->value) : 0;

        $contractors = $this->find()
            ->andWhere(['status' => 1])
            ->andWhere(['deleted_at' => NULL])
            ->count('id');

        return $contractors < $max ? true : false;
    }
}
