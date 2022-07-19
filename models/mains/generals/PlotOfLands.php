<?php

namespace app\models\mains\generals;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\identities\Users;

/**
 * This is the model class for table "plot_of_lands".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $title
 * @property string|null $desc
 * @property int|null $dimension_id
 * @property string|null $building_permit_number
 * @property string|null $images
 * @property float|null $excess_str
 * @property int|null $excess_desc_id
 * @property string|null $excess_desc_str
 * @property int|null $marker_area_id
 * @property string|null $marker_area_str
 * @property int|null $wind_direction_id
 * @property string|null $wind_direction_str
 * @property int|null $excess_unit_code_id
 * @property string|null $excess_unit_code_str
 * @property float|null $latitude
 * @property float|null $longitude
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $deleted_at
 * @property int|null $deleted_by
 *
 * @property Users $createdBy
 * @property Users $deletedBy
 * @property Settings $excessDesc
 * @property MUnitCodes $excessUnitCode
 * @property Markers $markerArea
 * @property Users $updatedBy
 * @property MWindDirections $windDirection
 */
class PlotOfLands extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plot_of_lands';
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
            [['desc', 'images'], 'string'],
            [['dimension_id', 'excess_desc_id', 'marker_area_id', 'wind_direction_id', 'excess_unit_code_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['excess_str', 'latitude', 'longitude'], 'number'],
            [['code'], 'string', 'max' => 15],
            [['title'], 'string', 'max' => 255],
            [['building_permit_number', 'excess_desc_str', 'marker_area_str', 'wind_direction_str', 'excess_unit_code_str'], 'string', 'max' => 100],
            ['created_by', 'default', 'value'=>Yii::$app->user->id],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['deleted_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['excess_desc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Settings::className(), 'targetAttribute' => ['excess_desc_id' => 'id']],
            [['excess_unit_code_id'], 'exist', 'skipOnError' => true, 'targetClass' => MUnitCodes::className(), 'targetAttribute' => ['excess_unit_code_id' => 'id']],
            [['wind_direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => MWindDirections::className(), 'targetAttribute' => ['wind_direction_id' => 'id']],
            [['marker_area_id'], 'exist', 'skipOnError' => true, 'targetClass' => Markers::className(), 'targetAttribute' => ['marker_area_id' => 'id']],
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
            'dimension_id' => Yii::t('app', 'Dimension ID'),
            'building_permit_number' => Yii::t('app', 'Building Permit Number'),
            'images' => Yii::t('app', 'Images'),
            'excess_str' => Yii::t('app', 'Excess Str'),
            'excess_desc_id' => Yii::t('app', 'Excess Desc ID'),
            'excess_desc_str' => Yii::t('app', 'Excess Desc Str'),
            'marker_area_id' => Yii::t('app', 'Marker Area ID'),
            'marker_area_str' => Yii::t('app', 'Marker Area Str'),
            'wind_direction_id' => Yii::t('app', 'Wind Direction ID'),
            'wind_direction_str' => Yii::t('app', 'Wind Direction Str'),
            'excess_unit_code_id' => Yii::t('app', 'Excess Unit Code ID'),
            'excess_unit_code_str' => Yii::t('app', 'Excess Unit Code Str'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
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
     * Gets query for [[ExcessDesc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExcessDesc()
    {
        return $this->hasOne(Settings::className(), ['id' => 'excess_desc_id']);
    }

    /**
     * Gets query for [[ExcessUnitCode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExcessUnitCode()
    {
        return $this->hasOne(MUnitCodes::className(), ['id' => 'excess_unit_code_id']);
    }

    /**
     * Gets query for [[MarkerArea]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMarkerArea()
    {
        return $this->hasOne(Markers::className(), ['id' => 'marker_area_id']);
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
     * Gets query for [[WindDirection]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWindDirection()
    {
        return $this->hasOne(MWindDirections::className(), ['id' => 'wind_direction_id']);
    }
}