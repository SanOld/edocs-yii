<?php

/* db constants */

define('DB_HOST', 'sheh00.mysql.ukraine.com.ua');
define('DB_USER', 'sheh00_edocs'); //innakhx4_gantt
define('DB_PASSWORD', '2g7x2gt9'); //gantt_1

define('DB_DATABASE', 'sheh00_edocs'); //innakhx4_gantt

/* TABLES */
define('TBL_GANTT', 'user_smeta'); //innakhx4_gantt
define('TBL_RESOURCE', 'resources2'); //innakhx4_gantt
define('TBL_LINKS', 'gantt_links'); //innakhx4_gantt
define('TBL_PAYMENT', 'plan_payment'); //innakhx4_gantt

// Mysql
$dbtype = "MySQL";

$res = new PDO ( "mysql:dbname=" . DB_DATABASE . ";host=" . DB_HOST, DB_USER, DB_PASSWORD );
//mysql_select_db(DB_DATABASE);
