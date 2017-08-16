<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\Tree;

class TreeController extends Controller {

    public function actionData()
    {
      return new Tree();
      
//      $tree = new TreeGroupConnector(null, "PHPYii");
//      $tree->enable_log("Log",true);
//      $tree->configure(new Tree(), "id", "name,parent", "", "parent");
//      $tree->render();;

    }
}