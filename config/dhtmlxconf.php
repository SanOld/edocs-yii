<?php
//define('ENV', 'dev'); //prod or dev
//define('SECRET_KEY', '240bcd8f829ea1cc9a6e094eb3bd1bc1'); 


//define('BASE_PATH', dirname(__DIR__) . "/");
//define('UPLOAD_PATH', BASE_PATH . "docs/");


if ( YII_ENV != 'dev' ) {
return [
        db_host => 'sheh00.mysql.ukraine.com.ua',
        db_user =>'sheh00_edocs',
        db_password => '2g7x2gt9',
        db_database =>'sheh00_edocs'
        ];

} else {
  return[
        db_host => 'localhost',
        db_user => 'root',
        db_password => '',
        db_database => 'expert'
        ];

}