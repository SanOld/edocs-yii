<?php
namespace app\models;
use yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\components\PermissionManager;
use yii\behaviors\TimestampBehavior;
//
//class User extends ActiveRecord implements IdentityInterface
//{
//  public $permissions;
//    public static function tableName()
//    {
//        return 'users';
//    }
//
//    /**
//     * Finds an identity by the given ID.
//     *
//     * @param string|int $id the ID to be looked for
//     * @return IdentityInterface|null the identity object that matches the given ID.
//     */
//    public static function findIdentity($id)
//    {
//        return static::findOne($id);
//    }
//
//    /**
//     * Finds an identity by the given token.
//     *
//     * @param string $token the token to be looked for
//     * @return IdentityInterface|null the identity object that matches the given token.
//     */
//    public static function findIdentityByAccessToken($token, $type = null)
//    {
//        return static::findOne(['access_token' => $token]);
//    }
//
//    public static function findByUsername($username)
//    {
//      return static::findOne(['username' => $username]);
//    }
//    /**
//     * @return int|string current user ID
//     */
//    public function getId()
//    {
//        return $this->id;
//    }
//    
//    public function getPermission()
//    {
//        return  Yii::$app->permissionManager;
//    }
//
//    /**
//     * @inheritdoc
//     */
//    public function getAuthKey()
//    {
//        return $this->authKey;
//    }
//
//    /**
//     * @inheritdoc
//     */
//    public function validateAuthKey($authKey)
//    {
//        return $this->authKey === $authKey;
//    }
//
//    /**
//     * Validates password
//     *
//     * @param string $password password to validate
//     * @return bool if password provided is valid for current user
//     */
//    public function validatePassword($password)
//    {
//        return $this->password === $password;
//    }
//    
//    public function afterLogin($event)
//    {
//             
////        $this->lastvisitDate = date('Y-m-d H:i:s');
////        $this->save(false);
//        return true;
//    }
//}



/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
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
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
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

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    public function afterLogin($event)
    {
             
//        $this->lastvisitDate = date('Y-m-d H:i:s');
//        $this->save(false);
        return true;
    }
}