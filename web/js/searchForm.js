
function searchFormCreate(){

//window properties
var width = 675;
var height = 550;
var left = ($(window).width() - width)/2;
var right = ($(window).height() - height)/2;

searchWindow = new dhtmlXWindows(); 
//			searchWindow.attachViewportTo("winVP");
searchWindowElement = searchWindow.createWindow('searchWindow', left, right, width, height);
searchWindow.window('searchWindow').button('close').hide();
//searchWindow.window('searchWindow').setModal(true);
searchWindow.attachViewportTo("bd");
searchWindow.window('searchWindow').keepInViewport(true);
searchWindowElement.setText("Поиск документов");

var formData = [
  {type:"hidden",name:"search",label:"",value:"1"}
 ,{type:"input",name:"name",label:"Назва",value:"", rows: 3}
 ,{type:"settings", labelWidth: "100", inputWidth: "450"}
 ,{type: "combo", label: "Тема", name: "topic_id", connector: "./index.php/topic/data?mode=id", filtering:"true"}
 , {type: "combo", label: "Статус", name: "status_id", connector: "./index.php/status/data?mode=id", filtering:"true"}
 ,{type: "combo", label: "Видавник", name: "author_id", connector: "./index.php/author/data?mode=id", filtering:"true"}
 ,{type: "combo", label: "Вид", name: "type_id", connector: "./index.php/type/data?mode=id", filtering:"true"}
 ,{type:"input",name:"num",label:"Номер",value:""} 
 
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
 ,{type: "fieldset", offsetLeft: 100, offsetTop: -50,  name: "mydata", label: "Період", width:"450", list:[
 ,{
      type: "calendar", 
      name: "dateStart", 
      label: "Початок",
      labelWidth: "100",
      enableTime: true, 
      enableTodayButton: true,
      calendarPosition: "bottom",
      dateFormat: "%d-%m-%Y",
      inputWidth: "200"
  }
//  ,{type: "newcolumn", offset:5}
 ,{
      type: "calendar", 
      name: "dateEnd", 
      label: "Закінчення",
      labelWidth: "100",
      enableTime: true, 
      enableTodayButton: true,
      calendarPosition: "bottom",
      dateFormat: "%d-%m-%Y",
      inputWidth: "200"
  }
]}


 ,{type: "block", blockOffset: 0, offsetTop: 20, list: [
    ,{type: "button", name: "submit", value: "Знайти", width: 70}
    ,{type: "newcolumn", offset:5}
    ,{type: "button", name: "submit_close", value: "Знайти і Закрити", width: 130}
    ,{type: "newcolumn", offset:5}
    ,{type: "button", name: "close", value: "Закрити", width: 70}
  ]} 
];


searchForm = searchWindowElement.attachForm();
searchForm = searchWindowElement.attachForm(formData);
searchForm.setItemFocus("name");
//searchWindow.window('searchWindow').hide();
searchFormEvent();
}

function searchFormShow(){
    searchFormCreate();
    searchWindow.window('searchWindow').show();
}