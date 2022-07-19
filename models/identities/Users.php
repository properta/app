<?php

namespace app\models\identities;

use yii\behaviors\TimestampBehavior;
use Yii;
use app\models\mains\generals\Settings;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $full_name
 * @property string|null $auth_key
 * @property string|null $password_hash
 * @property string|null $register_token
 * @property string|null $password_reset_token
 * @property string|null $email
 * @property string|null $phone
 * @property int $status
 * @property string|null $role
 * @property string|null $image
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $deleted_at
 * @property int|null $deleted_by
 *
 * @property BpCategories[] $bpCategories
 * @property BpCategories[] $bpCategories0
 * @property BpCategories[] $bpCategories1
 * @property BpItems[] $bpItems
 * @property BpItems[] $bpItems0
 * @property BpItems[] $bpItems1
 * @property BpMasters[] $bpMasters
 * @property BpMasters[] $bpMasters0
 * @property BpMasters[] $bpMasters1
 * @property BuildingTypes[] $buildingTypes
 * @property BuildingTypes[] $buildingTypes0
 * @property BuildingTypes[] $buildingTypes1
 * @property BuildingTypes[] $buildingTypes2
 * @property Contractors[] $contractors
 * @property Contractors[] $contractors0
 * @property Contractors[] $contractors1
 * @property Logs[] $logs
 * @property MCurrencies[] $mCurrencies
 * @property MCurrencies[] $mCurrencies0
 * @property MCurrencies[] $mCurrencies1
 * @property MMaterials[] $mMaterials
 * @property MMaterials[] $mMaterials0
 * @property MMaterials[] $mMaterials1
 * @property MOccupations[] $mOccupations
 * @property MOccupations[] $mOccupations0
 * @property MOccupations[] $mOccupations1
 * @property MProficiencies[] $mProficiencies
 * @property MProficiencies[] $mProficiencies0
 * @property MUnitCodes[] $mUnitCodes
 * @property MUnitCodes[] $mUnitCodes0
 * @property MUnitCodes[] $mUnitCodes1
 * @property MWindDirections[] $mWindDirections
 * @property MWindDirections[] $mWindDirections0
 * @property MWindDirections[] $mWindDirections1
 * @property MWupaItems[] $mWupaItems
 * @property MWupaItems[] $mWupaItems0
 * @property MWupaItems[] $mWupaItems1
 * @property Markers[] $markers
 * @property Markers[] $markers0
 * @property Markers[] $markers1
 * @property Notifications[] $notifications
 * @property Notifications[] $notifications0
 * @property Notifications[] $notifications1
 * @property PlotDimensionTypes[] $plotDimensionTypes
 * @property PlotDimensionTypes[] $plotDimensionTypes0
 * @property PlotDimensionTypes[] $plotDimensionTypes1
 * @property PlotOfLands[] $plotOfLands
 * @property PlotOfLands[] $plotOfLands0
 * @property PlotOfLands[] $plotOfLands1
 * @property ProjectSettings[] $projectSettings
 * @property ProjectSettings[] $projectSettings0
 * @property ProjectSettings[] $projectSettings1
 * @property Projects[] $projects
 * @property Projects[] $projects0
 * @property Projects[] $projects1
 * @property Projects[] $projects2
 * @property Settings[] $settings
 * @property Settings[] $settings0
 * @property Settings[] $settings1
 * @property WupaCoefficients[] $wupaCoefficients
 * @property WupaCoefficients[] $wupaCoefficients0
 * @property WupaCoefficients[] $wupaCoefficients1
 * @property WupaMasters[] $wupaMasters
 * @property WupaMasters[] $wupaMasters0
 * @property WupaMasters[] $wupaMasters1
 */
class Users extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $new_password, $repeat_password, $old_password, $password;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = -1;

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'full_name'], 'required'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'image'], 'string', 'max' => 255],
            [['full_name'], 'string', 'max' => 128],
            ['created_by', 'default', 'value' => Yii::$app->user->id],
            [['updated_by'], 'default', 'value' => Yii::$app->user->id, 'on' => 'update'],
            [['deleted_by'], 'default', 'value' => Yii::$app->user->id, 'on' => 'delete'],
            ['deleted_at', 'default', 'value' => time(), 'on' => 'delete'],
            [['auth_key', 'role'], 'string', 'max' => 32],
            [['register_token'], 'string', 'max' => 225],
            [['email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'full_name' => Yii::t('app', 'Full Name'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'register_token' => Yii::t('app', 'Register Token'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'status' => Yii::t('app', 'Status'),
            'role' => Yii::t('app', 'Role'),
            'image' => Yii::t('app', 'Image'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'deleted_by' => Yii::t('app', 'Deleted By'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => hash('sha256', $token)]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */

    public function oldPassword($attribute, $params)
    {
        $_user     = self::findOne(Yii::$app->user->id);
        $_validate = Yii::$app->security->validatePassword($this->old_password, $_user->password_hash);
        if (!$_validate) {
            $this->addError($attribute, 'Old password is wrong.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Gets query for [[BpCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBpCategories()
    {
        return $this->hasMany(BpCategories::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[BpCategories0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBpCategories0()
    {
        return $this->hasMany(BpCategories::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[BpCategories1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBpCategories1()
    {
        return $this->hasMany(BpCategories::className(), ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[BpItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBpItems()
    {
        return $this->hasMany(BpItems::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[BpItems0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBpItems0()
    {
        return $this->hasMany(BpItems::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[BpItems1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBpItems1()
    {
        return $this->hasMany(BpItems::className(), ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[BpMasters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBpMasters()
    {
        return $this->hasMany(BpMasters::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[BpMasters0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBpMasters0()
    {
        return $this->hasMany(BpMasters::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[BpMasters1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBpMasters1()
    {
        return $this->hasMany(BpMasters::className(), ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[BuildingTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuildingTypes()
    {
        return $this->hasMany(BuildingTypes::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[BuildingTypes0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuildingTypes0()
    {
        return $this->hasMany(BuildingTypes::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[BuildingTypes1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuildingTypes1()
    {
        return $this->hasMany(BuildingTypes::className(), ['project_id' => 'id']);
    }

    /**
     * Gets query for [[BuildingTypes2]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuildingTypes2()
    {
        return $this->hasMany(BuildingTypes::className(), ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Contractors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractors()
    {
        return $this->hasMany(Contractors::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Contractors0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractors0()
    {
        return $this->hasMany(Contractors::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[Contractors1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractors1()
    {
        return $this->hasMany(Contractors::className(), ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Logs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLogs()
    {
        return $this->hasMany(Logs::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[MCurrencies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMCurrencies()
    {
        return $this->hasMany(MCurrencies::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[MCurrencies0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMCurrencies0()
    {
        return $this->hasMany(MCurrencies::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[MCurrencies1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMCurrencies1()
    {
        return $this->hasMany(MCurrencies::className(), ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[MMaterials]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMMaterials()
    {
        return $this->hasMany(MMaterials::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[MMaterials0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMMaterials0()
    {
        return $this->hasMany(MMaterials::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[MMaterials1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMMaterials1()
    {
        return $this->hasMany(MMaterials::className(), ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[MOccupations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMOccupations()
    {
        return $this->hasMany(MOccupations::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[MOccupations0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMOccupations0()
    {
        return $this->hasMany(MOccupations::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[MOccupations1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMOccupations1()
    {
        return $this->hasMany(MOccupations::className(), ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[MProficiencies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMProficiencies()
    {
        return $this->hasMany(MProficiencies::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[MProficiencies0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMProficiencies0()
    {
        return $this->hasMany(MProficiencies::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[MUnitCodes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMUnitCodes()
    {
        return $this->hasMany(MUnitCodes::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[MUnitCodes0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMUnitCodes0()
    {
        return $this->hasMany(MUnitCodes::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[MUnitCodes1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMUnitCodes1()
    {
        return $this->hasMany(MUnitCodes::className(), ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[MWindDirections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMWindDirections()
    {
        return $this->hasMany(MWindDirections::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[MWindDirections0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMWindDirections0()
    {
        return $this->hasMany(MWindDirections::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[MWindDirections1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMWindDirections1()
    {
        return $this->hasMany(MWindDirections::className(), ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[MWupaItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMWupaItems()
    {
        return $this->hasMany(MWupaItems::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[MWupaItems0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMWupaItems0()
    {
        return $this->hasMany(MWupaItems::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[MWupaItems1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMWupaItems1()
    {
        return $this->hasMany(MWupaItems::className(), ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Markers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMarkers()
    {
        return $this->hasMany(Markers::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Markers0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMarkers0()
    {
        return $this->hasMany(Markers::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[Markers1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMarkers1()
    {
        return $this->hasMany(Markers::className(), ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Notifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notifications::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Notifications0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications0()
    {
        return $this->hasMany(Notifications::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[Notifications1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications1()
    {
        return $this->hasMany(Notifications::className(), ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[PlotDimensionTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlotDimensionTypes()
    {
        return $this->hasMany(PlotDimensionTypes::className(), ['creatad_by' => 'id']);
    }

    /**
     * Gets query for [[PlotDimensionTypes0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlotDimensionTypes0()
    {
        return $this->hasMany(PlotDimensionTypes::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[PlotDimensionTypes1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlotDimensionTypes1()
    {
        return $this->hasMany(PlotDimensionTypes::className(), ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[PlotOfLands]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlotOfLands()
    {
        return $this->hasMany(PlotOfLands::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[PlotOfLands0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlotOfLands0()
    {
        return $this->hasMany(PlotOfLands::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[PlotOfLands1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlotOfLands1()
    {
        return $this->hasMany(PlotOfLands::className(), ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[ProjectSettings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectSettings()
    {
        return $this->hasMany(ProjectSettings::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[ProjectSettings0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectSettings0()
    {
        return $this->hasMany(ProjectSettings::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[ProjectSettings1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectSettings1()
    {
        return $this->hasMany(ProjectSettings::className(), ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Projects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Projects::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Projects0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjects0()
    {
        return $this->hasMany(Projects::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[Projects1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjects1()
    {
        return $this->hasMany(Projects::className(), ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[Projects2]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjects2()
    {
        return $this->hasMany(Projects::className(), ['pic_id' => 'id']);
    }

    /**
     * Gets query for [[Settings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSettings()
    {
        return $this->hasMany(Settings::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[Settings0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSettings0()
    {
        return $this->hasMany(Settings::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[Settings1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSettings1()
    {
        return $this->hasMany(Settings::className(), ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[WupaCoefficients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWupaCoefficients()
    {
        return $this->hasMany(WupaCoefficients::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[WupaCoefficients0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWupaCoefficients0()
    {
        return $this->hasMany(WupaCoefficients::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[WupaCoefficients1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWupaCoefficients1()
    {
        return $this->hasMany(WupaCoefficients::className(), ['updated_by' => 'id']);
    }

    /**
     * Gets query for [[WupaMasters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWupaMasters()
    {
        return $this->hasMany(WupaMasters::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[WupaMasters0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWupaMasters0()
    {
        return $this->hasMany(WupaMasters::className(), ['deleted_by' => 'id']);
    }

    /**
     * Gets query for [[WupaMasters1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWupaMasters1()
    {
        return $this->hasMany(WupaMasters::className(), ['updated_by' => 'id']);
    }
}