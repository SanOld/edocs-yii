<?php
namespace app\models;
use yii;
use yii\db\ActiveRecord;

class Type extends ActiveRecord {

    public static function tableName()
    {
        return 'types';
    }

    public static function primaryKey()
    { 
      return array("id"); 
    }

}