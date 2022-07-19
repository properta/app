<?php

namespace app\models\mains\generals;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\identities\Users;

/**
 * This is the model class for table "wupa_coefficients".
 *
 * @property int $id
 * @property string|null $code
 * @property int|null $wupa_master_id
 * @property int|null $parent_item_id
 * @property int|null $category_item_id
 * @property int|null $item_id
 * @property int|null $unit_code_id
 * @property string $unit_code_str
 * @property float|null $coefficient
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $deleted_at
 * @property int|null $deleted_by
 *
 * @property MWupaItems $categoryItem
 * @property Users $createdBy
 * @property Users $deletedBy
 * @property MWupaItems $parentItem
 * @property MUnitCodes $unitCode
 * @property Users $updatedBy
 * @property WupaMasters $wupaMaster
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wupa_master_id', 'parent_item_id', 'category_item_id', 'item_id', 'unit_code_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['unit_code_str'], 'required'],
            [['coefficient'], 'number'],
            [['code'], 'string', 'max' => 15],
            [['unit_code_str'], 'string', 'max' => 100],
            ['created_by', 'default', 'value'=>Yii::$app->user->id],
            [['category_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => MWupaItems::className(), 'targetAttribute' => ['category_item_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['deleted_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['deleted_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['parent_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => MWupaItems::className(), 'targetAttribute' => ['parent_item_id' => 'id']],
            [['unit_code_id'], 'exist', 'skipOnError' => true, 'targetClass' => MUnitCodes::className(), 'targetAttribute' => ['unit_code_id' => 'id']],
            [['wupa_master_id'], 'exist', 'skipOnError' => true, 'targetClass' => WupaMasters::className(), 'targetAttribute' => ['wupa_master_id' => 'id']],
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
            'wupa_master_id' => Yii::t('app', 'Wupa Master ID'),
            'parent_item_id' => Yii::t('app', 'Parent Item ID'),
            'category_item_id' => Yii::t('app', 'Category Item ID'),
            'item_id' => Yii::t('app', 'Item ID'),
            'unit_code_id' => Yii::t('app', 'Unit Code ID'),
            'unit_code_str' => Yii::t('app', 'Unit Code Str'),
            'coefficient' => Yii::t('app', 'Coefficient'),
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
     * Gets query for [[CategoryItem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryItem()
    {
        return $this->hasOne(MWupaItems::className(), ['id' => 'category_item_id']);
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
     * Gets query for [[ParentItem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParentItem()
    {
        return $this->hasOne(MWupaItems::className(), ['id' => 'parent_item_id']);
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

    /**
     * Gets query for [[WupaMaster]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWupaMaster()
    {
        return $this->hasOne(WupaMasters::className(), ['id' => 'wupa_master_id']);
    }
}