<?php

namespace app\models\mains\generals;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\identities\Users;

/**
 * This is the model class for table "m_unit_codes".
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
 * @property BpItems[] $bpItems
 * @property BuildingTypes[] $buildingTypes
 * @property Users $createdBy
 * @property Users $deletedBy
 * @property MMaterials[] $mMaterials
 * @property MOccupations[] $mOccupations
 * @property MProficiencies[] $mProficiencies
 * @property MWupaItems[] $mWupaItems
 * @property PlotDimensionTypes[] $plotDimensionTypes
 * @property PlotOfLands[] $plotOfLands
 * @property Users $updatedBy
 * @property WupaCoefficients[] $wupaCoefficients
 */
class MUnitCodes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'm_unit_codes';
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
            [['code', 'title'], 'required'],
            ['code', 'unique'],
            [['desc'], 'string'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['code'], 'string', 'max' => 15],
            [['title'], 'string', 'max' => 255],
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
     * Gets query for [[BpItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBpItems()
    {
        return $this->hasMany(BpItems::className(), ['volume_unit_code_id' => 'id']);
    }

    /**
     * Gets query for [[BuildingTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuildingTypes()
    {
        return $this->hasMany(BuildingTypes::className(), ['area_unit_code_id' => 'id']);
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
     * Gets query for [[MMaterials]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMMaterials()
    {
        return $this->hasMany(MMaterials::className(), ['default_unit_code_id' => 'id']);
    }

    /**
     * Gets query for [[MOccupations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMOccupations()
    {
        return $this->hasMany(MOccupations::className(), ['default_unit_code_id' => 'id']);
    }

    /**
     * Gets query for [[MProficiencies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMProficiencies()
    {
        return $this->hasMany(MProficiencies::className(), ['default_unit_code_id' => 'id']);
    }

    /**
     * Gets query for [[MWupaItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMWupaItems()
    {
        return $this->hasMany(MWupaItems::className(), ['default_unit_code_id' => 'id']);
    }

    /**
     * Gets query for [[PlotDimensionTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlotDimensionTypes()
    {
        return $this->hasMany(PlotDimensionTypes::className(), ['dimension_unit_code_id' => 'id']);
    }

    /**
     * Gets query for [[PlotOfLands]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlotOfLands()
    {
        return $this->hasMany(PlotOfLands::className(), ['excess_unit_code_id' => 'id']);
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
        return $this->hasMany(WupaCoefficients::className(), ['unit_code_id' => 'id']);
    }
}