<?php

namespace common\models;

use common\rbac\models\Role;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property integer $phone
 * @property integer $phone_short
 * @property string $email
 * @property string $balance
 * @property string $password_hash
 * @property integer $status
 * @property integer $country_id
 * @property string $auth_key
 * @property string $secret_key
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property string $statusName
 * @property string $countryName
 * @property array $statusList
 * @property array $roleList
 * @property array $countriesList
 * @property array $currencyList
 * @property NoticeService[] $noticeServices
 * @property NoticeUsers[] $noticeUsers
 *
 * @property AuthAssignment $authAssignment
 * @property AuthSocial $auths
 * @property Role $role
 * @property PlaceCountry $country
 * @property UserProfile $userProfile
 * @property PlaceCountry $modelPlaceCountryByIso2
 *
 *
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 10;

    /**
     * @var \common\rbac\models\Role
     */
    public $item_name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'phone_short', 'email', 'password_hash', 'status', 'country_id', 'auth_key'], 'required', 'on' => 'default'],
            [['balance'], 'number'],
            [['phone', 'phone_short', 'status', 'country_id', 'created_at', 'updated_at'], 'integer'],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 64],
            [['password_hash', 'secret_key'], 'string', 'max' => 255],
            [['phone'], 'unique'],
            [['email'], 'unique'],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => PlaceCountry::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['password_hash', 'status', 'auth_key'], 'required', 'on' => 'social'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'phone' => \Yii::t('app', 'Phone'),
            'phone_short' => \Yii::t('app', 'Phone'),
            'email' => \Yii::t('app', 'Email'),
            'balance' => \Yii::t('app', 'Balance'),
            'password_hash' => \Yii::t('app', 'Password Hash'),
            'status' => \Yii::t('app', 'Status'),
            'country_id' => \Yii::t('app', 'Country'),
            'auth_key' => \Yii::t('app', 'Auth Key'),
            'secret_key' => \Yii::t('app', 'Secret Key'),
            'created_at' => \Yii::t('app', 'Created At'),
            'updated_at' => \Yii::t('app', 'Updated At'),
            'item_name' => \Yii::t('app', 'Role'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignment()
    {
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuths()
    {
        return $this->hasOne(AuthSocial::className(), ['user_id' => 'id']);
    }

    public function getNoticeServices()
    {
        return $this->hasMany(NoticeService::className(), ['user_id' => 'id']);
    }

    public function getNoticeUsers()
    {
        return $this->hasMany(NoticeUsers::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(PlaceCountry::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    public function getModelPlaceCountryByIso2($countryIso)
    {
        return PlaceCountry::findOne(['iso2' => $countryIso]);
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /* Поиск */

    /** Находит пользователя по имени и возвращает объект найденного пользователя.
     *  Вызываеться из модели LoginForm.
     *
     * @param $phone
     * @return null|static
     */
    public static function findByphone($phone)
    {
        $phone = str_replace([' ', '-', '+'], '', $phone);

        $user = static::findOne([
            'phone' => $phone
        ]);

        if($user) {
            return $user;
        }

        if(substr($phone, 0, 1) == '8' && strlen($phone) == 11) {
            $phone = substr_replace($phone, '7', 0, 1);
            $user = static::findOne([
                'phone' => $phone
            ]);
        }
        return $user;
    }

    /* Находит пользователя по емайл */
    public static function findByEmail($email)
    {
        return static::findOne([
            'email' => $email
        ]);
    }

    public static function findBySecretKey($key)
    {
        if (!static::isSecretKeyExpire($key))
        {
            return null;
        }
        return static::findOne([
            'secret_key' => $key,
        ]);
    }

    /* Хелперы */
    public function generateSecretKey()
    {
        $this->secret_key = \Yii::$app->security->generateRandomString().'_'.time();
    }

    public function removeSecretKey()
    {
        $this->secret_key = null;
    }

    public static function isSecretKeyExpire($key)
    {
        if (empty($key))
        {
            return false;
        }
        $expire = \Yii::$app->params['secretKeyExpire'];
        $parts = explode('_', $key);
        $timestamp = (int) end($parts);

        return $timestamp + $expire >= time();
    }

    /**
     * Генерирует хеш из введенного пароля и присваивает (при записи) полученное значение полю password_hash таблицы user для
     * нового пользователя.
     * Вызываеться из модели RegForm.
     * @param $password
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function setPassword($password)
    {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Генерирует случайную строку из 32 шестнадцатеричных символов и присваивает (при записи) полученное значение полю auth_key
     * таблицы user для нового пользователя.
     * Вызываеться из модели RegForm.
     */
    public function generateAuthKey(){
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    /**
     * Сравнивает полученный пароль с паролем в поле password_hash, для текущего пользователя, в таблице user.
     * Вызываеться из модели LoginForm.
     * @param $password
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /* Аутентификация пользователей */
    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id,
            'status' => self::STATUS_ACTIVE
        ]);
    }

    public static function findIdentityByAccessToken($token, $type = NULL)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function updateUser()
    {
        $user = User::findOne(\Yii::$app->user->id);
        $phone = $this->phone;
        $user->phone = $phone;
        if($user->save()):
            return $user;
        else:
            return false;
        endif;
    }

    /* Хелперы */

    /**
     * Returns the user status in nice format.
     *
     * @param  null|integer $status Status integer value if sent to method.
     * @return string               Nicely formatted status.
     */
    public function getStatusName($status = null)
    {
        $status = (empty($status)) ? $this->status : $status ;

        if ($status === self::STATUS_DELETED)
        {
            return \Yii::t('app', "Ban");
        }
        elseif ($status === self::STATUS_NOT_ACTIVE)
        {
            return \Yii::t('app', "Not activated");
        }
        else
        {
            return \Yii::t('app', "Activated");
        }
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getStatusList()
    {
        $statusArray = [
            self::STATUS_ACTIVE     => \Yii::t('app', "Activated"),
            self::STATUS_NOT_ACTIVE => \Yii::t('app', "Not activated"),
            self::STATUS_DELETED    => \Yii::t('app', "Ban")
        ];
        return $statusArray;
    }

    public function getCountriesList()
    {
        $modelPlaceCountry = PlaceCountry::find()
        ->asArray()
        ->all();
        $countriesArray = ArrayHelper::map($modelPlaceCountry,
            'id',
            function($modelPlaceCountry) {
                return \Yii::t('countries', $modelPlaceCountry['short_name']).' +'.str_replace(['\\'], '', $modelPlaceCountry['calling_code']);
            }
        );

        return $countriesArray;
    }

    public function getCurrencyList()
    {
        $modelPlaceCountry = PlaceCountry::find()
            ->asArray()
            ->all();
        $currencyArray = ArrayHelper::map($modelPlaceCountry,
            'id', 'currency'
        );

        return $currencyArray;
    }

    public function getCountryName()
    {
        return \Yii::t('countries', $this->country->short_name);
    }

    /**
     * Связь с Role моделью.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        // User has_one Role via Role.user_id -> id
        return $this->hasOne(Role::className(), ['user_id' => 'id']);
    }

    public static function getRolesList()
    {
        $roles = [];

        foreach (AuthItem::getRoles() as $item_name)
        {
            /* @var $item_name AuthItem */
            $roles[$item_name->name] = $item_name->name;
        }

        return $roles;
    }

    /**
     * Возвращает название роли ( item_name )
     *
     * @return string
     */
    public function getRoleName()
    {
        return $this->role->item_name;
    }
}
