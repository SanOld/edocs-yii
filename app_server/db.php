<?php
include('../app/config.php');

/* TABLES */
define('TBL_DOCS', 'docs'); 
define('TBL_AUTHORS', 'authors'); 
define('TBL_LINKS', 'formats'); 
define('TBL_PAYMENT', 'topics'); 
define('TBL_PAYMENT', 'types'); 
 

// Mysql
$dbtype = "PDO";

$res = new PDO ( "mysql:dbname=" . DB_DATABASE . ";host=" . DB_HOST, DB_USER, DB_PASSWORD );

//mysql_select_db(DB_DATABASE);
