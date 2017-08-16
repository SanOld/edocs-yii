var uploadWindow //объявлена глобально для keyEvents
function uploadFormShow(layout, isFolder){
var isFolder =  isFolder ? isFolder : false;
var uploadForm
var w1;
//window properties
var width = 500;
var height = 500;
var left = ($(window).width() - width)/2;
var right = ($(window).height() - height)/2;
var typeFile = ['DOC','DOCX','XLS','XLSX','PDF','RTF','HTML'];

var formData = [
      {type: "fieldset", label: "Загрузчик", list:[
        {type: "upload"
          , name: "myFiles"
          , inputWidth: width - 100
          , inputHeight: 300
          , url: "./index.php/upload/index"
          , swfPath: "uploader.swf"
          , swfUrl: "./index.php/site/upload"
        }  
      ]}
    ];

uploadWindow = new dhtmlXWindows();
//			uploadWindow.attachViewportTo("winVP");
w1 = uploadWindow.createWindow('uploadWindow', left, right, width, height);
uploadWindow.window('uploadWindow').setModal(true);
uploadWindow.attachViewportTo("bd");
uploadWindow.window('uploadWindow').keepInViewport(true);
w1.setText("Загрузка файлов");

uploadForm = w1.attachForm(formData);
if(uploadForm && isFolder){
  $('input[type=file]').attr('webkitdirectory', true);
}

uploadForm.attachEvent("onBeforeFileAdd",function(realName){
  var result = false;
  var name = realName.toUpperCase();
  
  typeFile.forEach(function(item, i, typeFile) {
    if(name.indexOf(item) != -1){
      result = true;
      return result;
    }
  });
    
  if(!result){edocs.message("Недопустимый формат файла: " + realName);}

  return result;
});


uploadForm.attachEvent("onUploadFile",function(realName, serverName){
  edocs.message("Загрузка файла: " + realName);
});
uploadForm.attachEvent("onUploadComplete",function(count){
  edocs.message("Загрузка завершена" + "\n" + count + "файл(ов) загружено" );
});
uploadForm.attachEvent("onUploadCancel",function(realName){
  edocs.message("Загрузка отменена!");
});
uploadForm.attachEvent("onUploadFail",function(realName){
  edocs.message("При загрузке произошла ошибка!");
});


}
