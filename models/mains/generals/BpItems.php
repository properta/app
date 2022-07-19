<?php

namespace app\models\mains\generals;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\identities\Users;

/**
 * This is the model class for table "bp_items".
 *
 * @property int $id
 * @property string|null $code
 * @property int|null $bp_master_id
 * @property int|null $occupation_category_id
 * @property int|null $occupation_item_id
 * @property float|null $volume
 * @property int|null $volume_unit_code_id
 * @property string|null $volume_unit_code_str
 * @property int|null $price_in_unit
 * @property int|null $price_currency_id
 * @property string|null $remark
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $deleted_at
 * @property int|null $deleted_by
 *
 * @property BpMasters $bpMaster
 * @property Users $createdBy
 * @property Users $deletedBy
 * @property MOccupations $occupationCategory
 * @property MOccupations $occupationItem
 * @property MCurrencies $priceCurrency
 * @property Users $updatedBy
 * @property MUnitCodes $volumeUnitCode
 */
class BpItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bp_items';
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
            [['bp_master_id', 'occupation_category_id', 'occupation_item_id', 'volume_unit_code_id', 'price_in_unit', 'price_currency_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['volume'], 'number'],
            [['remark'], 'string'],
            [['code'], 'string', 'max' => 15],
            [['volume_unit_code_str'], 'string', 'max' => 100],
            ['created_by', 'default', 'value'=>Yii::$app->user->id],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['deleted_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['bp_master_id'], 'exist', 'skipOnError' => true, 'targetClass' => BpMasters::className(), 'targetAttribute' => ['bp_master_id' => 'id']],
            [['occupation_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => MOccupations::className(), 'targetAttribute' => ['occupation_category_id' => 'id']],
            [['occupation_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => MOccupations::className(), 'targetAttribute' => ['occupation_item_id' => 'id']],
            [['price_currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => MCurrencies::className(), 'targetAttribute' => ['price_currency_id' => 'id']],
            [['volume_unit_code_id'], 'exist', 'skipOnError' => true, 'targetClass' => MUnitCodes::className(), 'targetAttribute' => ['volume_unit_code_id' => 'id']],
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
            'bp_master_id' => Yii::t('app', 'Bp Master ID'),
            'occupation_category_id' => Yii::t('app', 'Occupation Category ID'),
            'occupation_item_id' => Yii::t('app', 'Occupation Item ID'),
            'volume' => Yii::t('app', 'Volume'),
            'volume_unit_code_id' => Yii::t('app', 'Volume Unit Code ID'),
            'volume_unit_code_str' => Yii::t('app', 'Volume Unit Code Str'),
            'price_in_unit' => Yii::t('app', 'Price In Unit'),
            'price_currency_id' => Yii::t('app', 'Price Currency ID'),
            'remark' => Yii::t('app', 'Remark'),
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
     * Gets query for [[BpMaster]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBpMaster()
    {
        return $this->hasOne(BpMasters::className(), ['id' => 'bp_master_id']);
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
     * Gets query for [[OccupationCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOccupationCategory()
    {
        return $this->hasOne(MOccupations::className(), ['id' => 'occupation_category_id']);
    }

    /**
     * Gets query for [[OccupationItem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOccupationItem()
    {
        return $this->hasOne(MOccupations::className(), ['id' => 'occupation_item_id']);
    }

    /**
     * Gets query for [[PriceCurrency]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPriceCurrency()
    {
        return $this->hasOne(MCurrencies::className(), ['id' => 'price_currency_id']);
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
     * Gets query for [[VolumeUnitCode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVolumeUnitCode()
    {
        return $this->hasOne(MUnitCodes::className(), ['id' => 'volume_unit_code_id']);
    }
}