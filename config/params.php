<?php
if(YII_LOCAL == 'dev'){
    $docsPath = "http://edocs-yii/web/docs/";
 } else {
    $docsPath = "http://edocs.sheh.space/web/docs/";
  }
  

return [
    'adminEmail' => 'admin@example.com'
    ,'supportEmail' => 'support@example.com'
    ,'user.passwordResetTokenExpire' => 3600
    ,'config_js' => [
                     'env' => YII_LOCAL
                    ,'docsPath' => $docsPath
                   ]
  , 
];
