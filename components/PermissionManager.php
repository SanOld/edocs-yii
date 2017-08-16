<?php

namespace app\components;
use yii;
use yii\base\Object;


class PermissionManager extends Object
{
  public $user_id = false;
  public $permissions;
  private $role = false;
  


  public function __construct( $permissions = null, $config = [])
  {
    $this->permissions = $permissions;
    
    if( ! Yii::$app->user->isGuest ){
      $this->user_id = Yii::$app->user->identity->getId();
      
      $command = (new \yii\db\Query()) 
      -> select('roles.name')
      ->from('users')
      ->join('LEFT JOIN', 'role_user', 'role_user.user_id = users.id')
      -> join('LEFT JOIN', 'roles', 'role_user.role_id = roles.id')
      -> where(' users.id = :id ', array(":id" => $this->user_id));
//       ->createCommand();
//      print_r($command->sql);
//      die();
      $this->role = $command->scalar();
    } else {
      $this->role = 'default';
    }
    parent::__construct($config);
  }

  public function init()
  {
    parent::init();
    // ... инициализация происходит после того, как была применена конфигурация.
  }
  
  public function can($permission){
    if(isset($this->permissions[$this->role][$permission])){
      return true;
    }
    return false;
  }
  
  public function getPermissions(){
      return $this->permissions[$this->role];
  }
  
  public function getRole(){
    return $this->role;
  }

}
