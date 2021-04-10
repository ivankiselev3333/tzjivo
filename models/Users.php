<?php

namespace app\models;

use yii\base\NotSupportedException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 *
 * @property UsersIntegrationsJivositeApi[] $usersIntegrationsJivositeApis
 */
class Users extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
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
     * @param string $email
     * @return static|null
     */
    public static function findByUserEmail($email)
    {
        return static::findOne(['email' => $email]);
    }


    /**
     * Gets query for [[Id0]].
     *
     * @return ActiveQuery
     *
     * public function getId0()
     * {
     * return $this->hasOne(UsersIntegrationsJivositeApi::className(), ['user_id' => 'id']);
     * }
     */

    public static function findByUserId($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
        ];
    }

    /**
     * Gets query for [[UsersIntegrationsJivositeApis]].
     *
     * @return ActiveQuery
     */
    public function getUsersIntegrationsJivositeApis()
    {
        return $this->hasMany(UsersIntegrationsJivositeApi::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            // TimestampBehavior::className(),
        ];
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {

        return $true;
    }


}
