<?php

namespace app\models\mains\generals;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\identities\Users;

/**
 * This is the model class for table "plot_dimension_types".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $title
 * @property string|null $desc
 * @property int|null $project_id
 * @property float|null $length
 * @property float|null $width
 * @property int|null $dimension_unit_code_id
 * @property string|null $dimension_unit_code_id_str
 * @property int|null $plot_type_id
 * @property string|null $plot_type_str
 * @property int|null $total
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $deleted_at
 * @property int|null $deleted_by
 *
 * @property Users $creatadBy
 * @property Users $deletedBy
 * @property MUnitCodes $dimensionUnitCode
 * @property Settings $plotType
 * @property Projects $project
 * @property Users $updatedBy
 */
class PlotDimensionTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plot_dimension_types';
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
            [['desc'], 'string'],
            [['project_id', 'dimension_unit_code_id', 'plot_type_id', 'total', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['length', 'width'], 'number'],
            [['code'], 'string', 'max' => 15],
            [['title'], 'string', 'max' => 255],
            [['dimension_unit_code_id_str', 'plot_type_str'], 'string', 'max' => 100],
            ['created_by', 'default', 'value'=>Yii::$app->user->id],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['deleted_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['dimension_unit_code_id'], 'exist', 'skipOnError' => true, 'targetClass' => MUnitCodes::className(), 'targetAttribute' => ['dimension_unit_code_id' => 'id']],
            [['plot_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Settings::className(), 'targetAttribute' => ['plot_type_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Projects::className(), 'targetAttribute' => ['project_id' => 'id']],
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
            'project_id' => Yii::t('app', 'Project ID'),
            'length' => Yii::t('app', 'Length'),
            'width' => Yii::t('app', 'Width'),
            'dimension_unit_code_id' => Yii::t('app', 'Dimension Unit Code ID'),
            'dimension_unit_code_id_str' => Yii::t('app', 'Dimension Unit Code Id Str'),
            'plot_type_id' => Yii::t('app', 'Plot Type ID'),
            'plot_type_str' => Yii::t('app', 'Plot Type Str'),
            'total' => Yii::t('app', 'Total'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Creatad By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'deleted_by' => Yii::t('app', 'Deleted By'),
        ];
    }

    /**
     * Gets query for [[CreatadBy]].
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
     * Gets query for [[DimensionUnitCode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDimensionUnitCode()
    {
        return $this->hasOne(MUnitCodes::className(), ['id' => 'dimension_unit_code_id']);
    }

    /**
     * Gets query for [[PlotType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlotType()
    {
        return $this->hasOne(Settings::className(), ['id' => 'plot_type_id']);
    }

    /**
     * Gets query for [[Project]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Projects::className(), ['id' => 'project_id']);
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