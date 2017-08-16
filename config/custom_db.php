<?php
if(YII_LOCAL == 'dev'){
 return [
      'class' => 'app\components\Custom_db',
      'type' => 'MySQL',
      'host' => 'localhost',
      'user' => 'root',
      'password' => '',
      'db_name' => 'expert'
]; 
} else {
 return [
        'class' => 'app\components\Custom_db',
        'type' => 'MySQL',
        'host' => 'sheh00.mysql.ukraine.com.ua',
        'user' => 'sheh00_edocs',
        'password' => '2g7x2gt9',
        'db_name' => 'sheh00_edocs'
]; 
}

