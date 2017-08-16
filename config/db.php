<?php
if(YII_LOCAL == 'dev'){
  return [
     'class' => 'yii\db\Connection',
     'dsn' => 'mysql:host=localhost;dbname=expert',
     'username' => 'root',
     'password' => '',
     'charset' => 'utf8'
]; 
} else {
  return [
     'class' => 'yii\db\Connection',
     'dsn' => 'mysql:host=sheh00.mysql.ukraine.com.ua;dbname=sheh00_edocs',
     'username' => 'sheh00_edocs',
     'password' => '2g7x2gt9',
     'charset' => 'utf8'
]; 
}

