<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use Dhtmlx\Connector\ComboConnector;
use app\models\Status;

class StatusController extends Controller {


    public function actionData()
    {
      $connector = new ComboConnector(null, "PHPYii");
      
//      if(isset($_REQUEST['mode'])){
        switch ( $_REQUEST['mode'] ) {
         case 'name':
           $id = "name";
            break;
         default:
           $id = "id";
            break; 
        }
//      }
        $connector->configure(new Status(), $id,"name");
        $connector->render();
    }

}
