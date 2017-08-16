<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use Dhtmlx\Connector\GridConnector;
use app\models\Grid;

class GridController extends Controller {

    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionData()
    {
//        $connector = new GridConnector(null, "PHPYii");
//        
//        $connector->configure(new Grid(), "event_id", "start_date, end_date, event_name");
//        $connector->render();

        return new Grid();
    }

}
