<?php

namespace app\models\mains\generals;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\identities\Users;

/**
 * This is the model class for table "projects".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $title
 * @property string|null $desc
 * @property string|null $building_permit_number
 * @property string|null $area_code
 * @property int|null $region_id
 * @property string|null $region_str
 * @property int|null $pic_id
 * @property string|null $pic_str
 * @property string|null $pic_phone_number
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $deleted_at
 * @property int|null $deleted_by
 *
 * @property BpCategories[] $bpCategories
 * @property Users $createdBy
 * @property Users $deletedBy
 * @property Markers[] $markers
 * @property Users $pic
 * @property PlotDimensionTypes[] $plotDimensionTypes
 * @property ProjectSettings[] $projectSettings
 * @property Users $updatedBy
 */
class Projects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'projects';
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
            [['title', 'building_permit_number', 'contractor_id', 'area_code'], 'required'],
            [['desc'], 'string'],
            [['region_id', 'pic_id', 'contractor_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['code', 'area_code'], 'string', 'max' => 15],
            [['title', 'region_str', 'pic_str'], 'string', 'max' => 255],
            [['building_permit_number'], 'string', 'max' => 100],
            [['pic_phone_number'], 'string', 'max' => 16],

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
            [['pic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['pic_id' => 'id']],
            [['contractor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contractors::className(), 'targetAttribute' => ['contractor_id' => 'id']],
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
            'building_permit_number' => Yii::t('app', 'Building Permit Number'),
            'area_code' => Yii::t('app', 'Area Code'),
            'region_id' => Yii::t('app', 'Region ID'),
            'region_str' => Yii::t('app', 'Region Str'),
            'pic_id' => Yii::t('app', 'Pic ID'),
            'pic_str' => Yii::t('app', 'Pic Str'),
            'pic_phone_number' => Yii::t('app', 'Pic Phone Number'),
            'contractor_id' => Yii::t('app', 'Contractor ID'),
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
     * Gets query for [[BpCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBpCategories()
    {
        return $this->hasMany(BpCategories::className(), ['project_id' => 'id']);
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
     * Gets query for [[Markers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMarkers()
    {
        return $this->hasMany(Markers::className(), ['project_id' => 'id']);
    }

    /**
     * Gets query for [[Pic]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPic()
    {
        return $this->hasOne(Users::className(), ['id' => 'pic_id']);
    }

    /**
     * Gets query for [[Contractor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractor()
    {
        return $this->hasOne(Contractors::className(), ['id' => 'contractor_id']);
    }

    /**
     * Gets query for [[PlotDimensionTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlotDimensionTypes()
    {
        return $this->hasMany(PlotDimensionTypes::className(), ['project_id' => 'id']);
    }

    /**
     * Gets query for [[ProjectSettings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectSettings()
    {
        return $this->hasMany(ProjectSettings::className(), ['project_id' => 'id']);
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