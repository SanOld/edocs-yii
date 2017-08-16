<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use Dhtmlx\Connector\ComboConnector;
use app\models\Author;

class AuthorController extends Controller {


    public function actionData()
    {
        $connector = new ComboConnector(null, "PHPYii");
        switch ( $_REQUEST['mode'] ) {
          case 'name':
            $id = "name";
            break;
          default:
            $id = "id";
            break; 
        }
        $connector->configure(new Author(), $id,"name");
        $connector->render();
    }

}
