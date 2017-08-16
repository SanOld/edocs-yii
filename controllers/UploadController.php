<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\app_server\Uploader;

class UploadController extends Controller {

    public function actions()
    {
      $this->enableCsrfValidation = false;
    }
    
    public function actionIndex()
    {
      return new Uploader();
    }

}