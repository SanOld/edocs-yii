<?php
namespace app\models;
use yii;
use yii\db\ActiveRecord;
use Dhtmlx\Connector\TreeGroupConnector;

//class Tree extends ActiveRecord {
//
//    public static function tableName()
//    {
//        $table = (isset($_REQUEST['table'])) ? $_REQUEST['table'] : 'types';
//        return $table;
//    }
//
//    public static function primaryKey()
//    {
//        return array("id");
//    }
//
//}

class Tree  {

    public  function __construct()
    {
      
        $tree = new TreeGroupConnector(Yii::$app->custom_db->con,'MySQL');
        $tree->enable_log("Log",true); //в корне
//        $tree->enable_log("Log",Yii::$app->basePath);

        $table = (isset($_REQUEST['table'])) ? $_REQUEST['table'] : 'types';

        $tree->render_sql(
            "SELECT t1.id,t1.parent, t1.name as leaf_name, t2.name as node_name, t2.id as parent
            FROM ".$table." as t1
            INNER JOIN ".$table." as t2 
            ON t1.parent = t2.id",
            "id","t1.id(leaf_name)","","t2.name");
    }
}