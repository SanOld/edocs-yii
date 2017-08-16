<?php
namespace app\models;
use yii;
use yii\db\ActiveRecord;

class Author extends ActiveRecord {

    public static function tableName()
    {
        return 'authors';
    }

    public static function primaryKey()
    { 
      return array("id");
    }

}