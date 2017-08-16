var docsPath;
var docsUploaded; 
var layout,
    menu,
    toolbarMain,
    documentTree,
    toolbarA,
    documentsGrid,
    toolbarC,
    toolbarD;
var active_filter = {mode:'type_id', text:''};
var needHide = false; //флаг для удаления записи из таблицы при изменении параметра отличного от фильтра
var gridDeleteMode = false;
var ac_is_show = false;
var checkObject = {}; //j,]trn чекнутых строк

var editWindow; //объявлена глобально для keyEvents
var editWindowElement;
var editForm;

var searchWindow 
var searchWindowElement;
var searchForm

var bootstrap_count = 100; //кол-во записей при перывоначальной загрузке грида

var grid_history = []; // массив для реализации undo redo
var index_history; //текущий индекс истории
var max_history_index = 10; //хранимое количество переходов
var isFilterMode = 0 //флаг режима undo redo

$(document).ready(function() {

  edocs.message("Режим: " + config['env']);

  include("/js/utils.js?"+HASH); 
  include("/js/uploadForm.js?"+HASH); //форма загрузки файлов
  include("/js/editForm.js?"+HASH); //форма редактирования файлов
  include("/js/searchForm.js?"+HASH); //форма поиска документов
  include("/js/keyEvent.js?"+HASH); // события нажатия клавиатуры
  include("/js/script.js?"+HASH); 
  include("/js/events.js?"+HASH); 
  
})
