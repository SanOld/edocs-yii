<?php


//хеш файлов, меняется при внесении изменений
$dir1 = "js/";
//
$files_array = dirlist($dir1);
$hash = md5(implode(':',$files_array));

// возвращает массив всех файлов директории вкл файлы пддиректорий
function dirlist($dir){ 
  
  $files = [];
  
  if (@is_dir($dir)) {
    $opendir = opendir($dir);
      while ( ($filename = readdir($opendir)) !== false )
      {
        if($filename != '.' && $filename != '..'){
          $isDir = @is_dir($dir . $filename . "/");
          if ($isDir == false)
          {
              $fileHash = filemtime(strtolower($dir . $filename));
              $files[] = $fileHash;
          } else {
             $files = array_merge($files, dirlist($dir . $filename . "/"));
          }
        }
      }
      closedir($opendir);
  }
   return $files;
}
// возвращает массив всех файлов директории
function filelist($dir){
  $files=[];
  
  $opendir = opendir($dir);

  while ($filename = readdir($opendir))
  {

      $isDir = @is_dir($dir . $filename . '/');
      if ($isDir == false)
      {
          $fileHash = filemtime(strtolower($dir . $filename));
          $files[] = $fileHash;
      } 
  }

  closedir($opendir);

  return $files;
}
?>
<title>EDOCS</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=1280">
<meta name="description" content="">
<meta name="author" content="">
<base href="/">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link href="css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<link href="dhtmlxSuite_v50_std/skins/web/dhtmlx.css" rel="stylesheet">
<script src="dhtmlxSuite_v50_std/codebase/ext/swfobject.js"></script>
<!--<link href="css/skins/terrace/dhtmlx.css" rel="stylesheet">-->

<!--<link href="css/font-awesome.css" rel="stylesheet">-->
<link href="css/helper.css?<?php echo $hash;?>" rel="stylesheet">
<link href="css/style.css?<?php echo $hash;?>" rel="stylesheet">

<script src="js/lib/jquery-latest.js"></script>
<script src="js/lib/jquery-ui-latest.js"></script>
<script src="js/lib/bootstrap.min.js"></script>

<script src="dhtmlxSuite_v50_std/codebase/dhtmlx.js"></script>
<script src="js/lib/dhtmlxPartsPro/dhtmlxInsertDeleteColumn.js"></script>


<script src="js/include.js?<?php echo $hash;?>"></script>
<script src="js/edocs.js?<?php echo $hash;?>"></script>
<script src="js/init.js?<?php echo $hash;?>"></script>
<script> 
  var HASH = "<?php echo $hash;?>";
  var config = JSON.parse('<?php echo json_encode(Yii::$app->params['config_js']);?>');
  var USER = JSON.parse('<?php echo json_encode(array(
        'role'=>Yii::$app->permissionManager->getRole()
      , 'permissions' => Yii::$app->permissionManager->getPermissions())); ?>');
</script>


