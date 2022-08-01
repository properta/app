<?php

namespace app\models\mains\generals;

use Yii;
use app\models\identities\Users;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "wupa_coefficients".
 *
 * @property int $id
 * @property string|null $code
 * @property int|null $item_id
 * @property int|null $sub_item_group_id
 * @property int|null $sub_item_id
 * @property string|null $sub_item_str
 * @property string|null $sub_item_table
 * @property float|null $coefficient
 * @property int|null $unit_code_id
 * @property int|null $unit_code_str
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
 * @property MWupaItems $item
 * @property Settings $subItemGroup
 * @property MUnitCodes $unitCode
 * @property Users $updatedBy
 */
class WupaCoefficients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wupa_coefficients';
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
            [['item_id', 'sub_item_group_id', 'sub_item_id', 'unit_code_id', 'unit_code_str', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['coefficient'], 'number'],
            [['code'], 'string', 'max' => 15],
            [['sub_item_str', 'sub_item_table'], 'string', 'max' => 255],

            // tambah bagian ini
            ['created_by', 'default', 'value' => Yii::$app->user->id],
            ['updated_by', 'default', 'value' => Yii::$app->user->id, 'when' => function ($model) {
                return !$model->isNewRecord;
            }],
            ['deleted_at', 'default', 'value' => time(), 'on' => 'delete'],
            ['deleted_by', 'default', 'value' => Yii::$app->user->id, 'on' => 'delete'],

            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['deleted_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => MWupaItems::className(), 'targetAttribute' => ['item_id' => 'id']],
            [['sub_item_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Settings::className(), 'targetAttribute' => ['sub_item_group_id' => 'id']],
            [['unit_code_id'], 'exist', 'skipOnError' => true, 'targetClass' => MUnitCodes::className(), 'targetAttribute' => ['unit_code_id' => 'id']],
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
            'item_id' => Yii::t('app', 'Item ID'),
            'sub_item_group_id' => Yii::t('app', 'Sub Item Group ID'),
            'sub_item_id' => Yii::t('app', 'Sub Item ID'),
            'sub_item_str' => Yii::t('app', 'Sub Item Str'),
            'sub_item_table' => Yii::t('app', 'Sub Item Table'),
            'coefficient' => Yii::t('app', 'Coefficient'),
            'unit_code_id' => Yii::t('app', 'Unit Code ID'),
            'unit_code_str' => Yii::t('app', 'Unit Code Str'),
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
     * Gets query for [[Item]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(WupaItems::className(), ['id' => 'item_id']);
    }

    /**
     * Gets query for [[SubItemGroup]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubItemGroup()
    {
        return $this->hasOne(Settings::className(), ['id' => 'sub_item_group_id']);
    }

    /**
     * Gets query for [[UnitCode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnitCode()
    {
        return $this->hasOne(MUnitCodes::className(), ['id' => 'unit_code_id']);
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