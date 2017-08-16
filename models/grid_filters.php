<?php
 function custom_filter  ($filter_by){
 
  if(isset($_GET['search'])){
    if (!sizeof($filter_by->rules)) {
      $filter_by->add("docs.name","%".$_GET['name']."%","LIKE");
      $filter_by->add("topic_id",     $_GET['topic_id'],"LIKE");
      $filter_by->add("status_id",    $_GET['status_id'],"LIKE");
      $filter_by->add("author_id",    $_GET['author_id'],"LIKE");
      $filter_by->add("type_id",      $_GET['type_id'],"LIKE");
      $filter_by->add("num",          $_GET['num'],"LIKE");
      $filter_by->add("date",         $_GET['date'],"LIKE");     
    }
  }
  
  if(isset($_GET['group'])){
    foreach ( $_GET['group'] as $key => $value ) {
      if (!sizeof($filter_by->rules)){
//        $filter_by->claear();
        $filter_by->add($_GET['group'][$key]['filter'],$value,"LIKE");
      } 
        
      $index = $filter_by->index($_GET['group'][$key]['filter']);
      if ($index!==false){  //a client-side input for the filter}
        $filter_by->rules[$index]["operation"]=$_GET['group'][$key]['operation'];
      }      
    }

  }
} 


 function handleBeforeProcessing($action){

//    $res = new PDO ( "mysql:dbname=" . DB_DATABASE . ";host=" . DB_HOST, DB_USER, DB_PASSWORD );
//    $connector = new Connector($res, "PDO");
    //$temp->configure("some_table");

      $fieldArray = array( 'status_name'=> array('table'=>'statuses','field'=>'status_id')
                          ,'author_name'=> array('table'=>'authors','field'=>'author_id')
                          ,'type_name'=>   array('table'=>'types','field'=>'type_id')
                          ,'topic_name'=>   array('table'=>'topics','field'=>'topic_id')
      );
      foreach ( $fieldArray as $key => $value ) {

        $data = Yii::$app->db->createCommand("SELECT id FROM ".$value['table']." WHERE name='".$action->get_value($key)."'")
                ->queryOne();
        
//        $result = $connector->sql->query("SELECT id FROM ".$value['table']." WHERE name='".$action->get_value($key)."'");
//        $data = $connector->sql->get_next($result);

        $action->add_field($value['field'],$data['id']);
        $action->set_value($value['field'],$data['id']);
        $action->remove_field($key,$action->get_value($key));
      }

    //  $action->success(); //завершение процесс коннектора
    }

 function dateRange_filter($data){
    if(isset($_GET['dateStart']) && $_GET['dateStart'] != ''){
      if ($data->get_value("date") < $_GET['dateStart']){$data->skip();}
    }
    if(isset($_GET['dateStart']) && $_GET['dateEnd'] != ''){
      if ($data->get_value("date") > $_GET['dateEnd']){$data->skip();}
    }  
           //not include into output
  }