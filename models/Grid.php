<?php



namespace app\models;
use yii;

include (Yii::$app->basePath.'/app_server/grid_connector.php');
include (Yii::$app->basePath.'/app_server/db_pdo.php');
include ('grid_filters.php');

class Grid {
    private $connect;
    public $grid_connector;
    
    public  function __construct()
    {

      $host = Yii::$app->custom_db->host;
      $user = Yii::$app->custom_db->user;
      $password = Yii::$app->custom_db->password;
      $db_name = Yii::$app->custom_db->db_name;
      
      $this->connect = new Yii::$app->custom_db('PDO',$host,$user,$password,$db_name);

      $grid_connector = new \GridConnector($this->connect->con, "PDO");

      $grid_connector->enable_log("Log",true);

      $grid_connector->event->attach("beforeProcessing",'handleBeforeProcessing');
      $grid_connector->event->attach("beforeRender","dateRange_filter");
      $grid_connector->event->attach("beforeFilter",'custom_filter');

    //===список полей грида
    function getTaskColumns() {
      $columns = array (
                        'file'
                        ,'topic_name'
                        ,'status_name'
                        ,'author_name'
                        ,'type_name'
                        ,'name'
                        ,'date'
                        ,'num'
                      );
      return implode ( ',', $columns );
    }


    //===Преобразование фильтра при выборе группового элемента в дереве
    if(isset($_GET['dhx_filter'])){
    //   $res = new PDO ( "mysql:dbname=" . DB_DATABASE . ";host=" . DB_HOST, DB_USER, DB_PASSWORD );

      foreach ( $_GET['dhx_filter'] as $key => $value ) {
        switch ( $key ) {
          case 'type_id':
            $table = 'types';
            break;
          case 'topic_id':
            $table = 'topics';
            break;
          case 'author_id':
            $table = 'authors';
            break;
        }

        if (preg_match ("/group_param/", $_GET['dhx_filter'][$key])) {
          $name_example = explode('__',$_GET['dhx_filter'][$key]);
    //      unset($_GET['dhx_filter']['type_id']);

          $sql_example = "
                        SELECT 
                          id,
                          name
                        FROM " . $table . "
                        WHERE parent in (SELECT id FROM " . $table . " WHERE name ='".$name_example[0]."' )
                        ";


          $new_res = Yii::$app->db->createCommand($sql_example)
                ->queryAll();

           foreach ($new_res as $row) {
               $filter_example[] = $row['id'];
           } 

    //      foreach ($res->query($sql_example) as $row) {
    //           $filter_example[] = $row['id'];
    //       }    
          $value = implode(",",$filter_example);
          $_GET['dhx_filter'][$key] = "(" . $value . ")";

          $_GET['group'] = array();
          $_GET['group'][$key]['filter'] = $key;
          $_GET['group'][$key]['operation'] = 'IN';
          $_GET['group'][$key]['table'] = $table;

        }


      }
    }
    //===Преобразование фильтра при выборе группового элемента в дереве




    //===блок для формы поиска




    $filter2 = new \OptionsConnector($this->connect);
    $filter2->render_table("statuses","id","name");
    $grid_connector->set_options("status_id",$filter2);

    $filter3 = new \OptionsConnector($this->connect);
    $filter3->render_table("authors","id","name");
    $grid_connector->set_options("author_id",$filter3);

    $filter4 = new \OptionsConnector($this->connect);
    $filter4->render_table("topics","id","name(value)");
    $grid_connector->set_options("topic_id",$filter4);


    $sql = "
      SELECT 
       docs.id
      ,file
      ,topics.name as topic_name
      ,statuses.name as status_name 
      ,authors.name as author_name
      ,types.name as type_name
      ,docs.name
      ,date
      ,num
      FROM docs
      LEFT JOIN statuses ON docs.status_id = statuses.id
      LEFT JOIN types ON docs.type_id = types.id
      LEFT JOIN authors  ON docs.author_id = authors.id
      LEFT JOIN topics  ON docs.topic_id = topics.id
      ";

    //используется для первоначального отображения грида
    if(isset($_GET['limit'])){
      $grid_connector->set_limit($_GET['limit']);
      $grid_connector->sort('date','DESC');
      $grid_connector->render_sql($sql, 'id', getTaskColumns());
    }
    //используется для первоначального отображения грида

    $ids = array('default');
    if (isset($_REQUEST['ids'])){
      if (preg_match ("/,/", $_REQUEST['ids'])) {
          $ids = explode(",",$_REQUEST['ids']);
      } else {
          $ids[0] = $_REQUEST['ids'];
      }  
    }

    foreach ( $ids as $value ) {
      $act= $value."_!nativeeditor_status";
      
      if(isset($_REQUEST[$act])){
        switch ( $_REQUEST[$act] ) {
          case 'updated':
            $_POST = $_REQUEST;
            $grid_connector->render_table('docs', 'id', getTaskColumns());
            break;
          case 'deleted':
            $grid_connector->render_table('docs', 'id', getTaskColumns());
            break;
          default:
            $grid_connector->render_sql($sql, 'id', getTaskColumns());
            break;
        }
      } else {
        $grid_connector->render_sql($sql, 'id', getTaskColumns());
      }
    }



    }

}

