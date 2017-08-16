
function editFormCreate(){

var editWindowElement;
//window properties
var width = 675;
var height = 360;
var left = ($(window).width() - width)/2;
var right = ($(window).height() - height)/2;

editWindow = new dhtmlXWindows();
//			editWindow.attachViewportTo("winVP");
editWindowElement = editWindow.createWindow('editWindow', left, right, width, height);
editWindow.window('editWindow').button('close').hide();
//editWindow.window('editWindow').setModal(true);
editWindow.attachViewportTo("bd");
editWindow.window('editWindow').keepInViewport(true);
editWindowElement.setText("Редактор записи");

var formData = [
  {type:"input",name:"name",label:"Назва",value:"", rows: 3}
 ,{type:"settings", labelWidth: "100", inputWidth: "450"}
 ,{type: "combo", label: "Тема", name: "topic_name", connector: "./index.php/topic/data?mode=name", filtering:"true"}
 , {type: "combo", label: "Статус", name: "status_name", connector: "./index.php/status/data?mode=name", filtering:"true"}
 ,{type: "combo", label: "Видавник", name: "author_name", connector: "./index.php/author/data?mode=name", filtering:"true"}
 ,{type: "combo", label: "Вид", name: "type_name", connector: "./index.php/type/data?mode=name", filtering:"true"}

 
 ,{
      type: "calendar", 
      name: "date", 
      label: "Дата",
      enableTime: true, 
      enableTodayButton: true,
      calendarPosition: "bottom",
      dateFormat: "%d-%m-%Y",
      inputWidth: "450"
  }
 ,{type:"input",name:"num",label:"Номер",value:""} 

 ,{type: "block", blockOffset: 0, offsetTop: 20, list: [
    ,{type: "button", name: "submit", value: "Сохранить", width: 70}
    ,{type: "newcolumn", offset:5}
    ,{type: "button", name: "submit_close", value: "Сохранить и Закрыть", width: 130}
    ,{type: "newcolumn", offset:5}
    ,{type: "button", name: "close", value: "Закрыть", width: 70}
  ]} 
];


editForm = editWindowElement.attachForm();
editForm = editWindowElement.attachForm(formData);
editForm.bind(documentsGrid);
editWindow.window('editWindow').hide();
}

function editFormShow (){

  editWindow.window('editWindow').show();
  documentsGrid.selectRowById(documentsGrid.getSelectedRowId());

}