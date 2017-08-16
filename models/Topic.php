<?php
namespace app\models;
use yii;
use yii\db\ActiveRecord;

class Topic extends ActiveRecord {

    public static function tableName()
    {
        return 'topics';
    }

    public static function primaryKey()
    { 
      return array("id");
    }

}
