function showDocs(oLink) {
  var oBlock = oLink.getElementsByTagName('div')[0];
  var oIframe = oLink.getElementsByTagName('iframe')[0];
  var oIframeUrl = oLink.getAttribute('url-show');
  if(oBlock.style.height == 0+'px') {
      oBlock.style.height = 980+'px';
      if(oIframe.src != oIframeUrl) {oIframe.src = oIframeUrl};
  } else {
      oBlock.style.height = 0+'px';
  }
}

function searchFormSend(){
  searchForm.send("./index.php/grid/data?connector=true", "get", function(loader, response){
  documentsGrid.clearAll();
  doBeforeGridUpdate();
  documentsGrid.parse(response);
  var num = documentsGrid.getRowsNum();
  if(num){
    dhtmlx.message("Знайдено: " + documentsGrid.getRowsNum() + " документів")
  } else {
    dhtmlx.message("За вашим запитом нічого не знайдено!")
  }

  doAfterGridUpdate();
});
}

function doAfterGridUpdate(){
  saveGridToHistory();

  if(('ac_show' in USER['permissions']) && !ac_is_show){
    gridAttachAdminColumns();
    ac_is_show = !ac_is_show;
  }
  return true;
}

function doBeforeGridUpdate(){

    if(('ac_show' in USER['permissions']) && ac_is_show){
      gridDetachAdminColumns();
      ac_is_show = !ac_is_show;
    }
}

function saveGridToHistory(){
  
  if(!isFilterMode){
    grid_history.push(documentsGrid.serialize());
    index_history = grid_history.length - 1;
  }
  if(grid_history.length > max_history_index){
    grid_history.shift();
  }
}
function loadGridFromHistory(key){
  if(typeof(index_history) == 'undefined'){
    index_history = grid_history.length - 1;
  }
  index_history = index_history + key;
  if (index_history > max_history_index || index_history > grid_history.length - 1) index_history = grid_history.length - 1;
  if (index_history < 0) index_history = 0;
  
  if(index_history in grid_history){
    isFilterMode = 1;

    documentsGrid.clearAll();
    doBeforeGridUpdate();
    documentsGrid.parse(grid_history[index_history]);
    doAfterGridUpdate();

    isFilterMode = 0;
    
  }
}   
    
function gridAttachAdminColumns(){
  var columnsNumber = documentsGrid.getColumnsNum();
  documentsGrid.insertColumn(0,'Вибір','myCheck',50,'na','center','top',null);
  var columnsNumber = documentsGrid.getColumnsNum();
  documentsGrid.insertColumn(columnsNumber,'','myEdit',50,'na','center','top',null);
  var columnsNumber = documentsGrid.getColumnsNum();
  documentsGrid.insertColumn(columnsNumber,'','myDelete',50,'na','center','top',null);
}
function gridDetachAdminColumns(){
  documentsGrid.deleteColumn(documentsGrid.getColumnsNum()-1);
  documentsGrid.deleteColumn(documentsGrid.getColumnsNum()-1);
//  documentsGrid.deleteColumn(columnsNumber-3);
  documentsGrid.deleteColumn(0);
}
