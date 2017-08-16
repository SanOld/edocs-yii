<?php
namespace app\models;
use yii;
use yii\db\ActiveRecord;

class Status extends ActiveRecord {

    public static function tableName()
    {
        return 'statuses';
    }

    public static function primaryKey()
    { 
      return array("id");
    }

}


