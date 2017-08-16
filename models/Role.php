<?php
namespace app\models;
use yii;
use yii\db\ActiveRecord;

class Role extends ActiveRecord {

    public static function tableName()
    {
        return 'roles';
    }

    public static function primaryKey()
    { 
      return array("id"); 
    }

}
