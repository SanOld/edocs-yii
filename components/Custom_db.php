<?php

namespace app\components;
use yii;
use yii\base\Object;


class Custom_db extends Object
{
  public $host;
  public $user;
  public $password;
  public $db_name;
  public $type;
  
  public $con;

  public function __construct($type = null, $host = null, $user = null, $password = null, $db_name = null, $config = [])
  {
//        print_r(1111);
//    die();
    $this->type = $type;
    $this->host = $host;
    $this->user = $user;
    $this->password = $password;
    $this->db_name = $db_name;
    

    parent::__construct($config);
    
    if($type == 'PDO'){
//      $this->con = new \PDO ( "mysql:dbname=" . $this->db_name . ";host=" . $this->host, $this->user, $this->password );

      $this->con = new \PDO ( "mysql:dbname=" . $this->db_name . ";host=".$this->host, $this->user, $this->password );

    } else {
      $this->con = mysql_connect($this->host,$this->user,$this->password);
      mysql_query("SET NAMES UTF8");
      mysql_select_db($this->db_name); // db connection
    }

  }

  public function init()
  {
    parent::init();

    // ... инициализация происходит после того, как была применена конфигурация.
  }

}