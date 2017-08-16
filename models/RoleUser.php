<?php
namespace app\models;
use yii;
use yii\db\ActiveRecord;

class RoleUser extends ActiveRecord {

    public static function tableName()
    {
        return 'role_user';
    }

    public static function primaryKey()
    { 
      return array("id"); 
    }

}
