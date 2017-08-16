toolbarMain.attachEvent("onClick", function(id){
  switch (id) {
    case 'button_upload':
      uploadFormShow(layout);
      break;
    case 'button_upload_folder':
      uploadFormShow(layout, true);
      break; 
    case 'button_search':
      searchFormShow();
      break;    
  }
});
toolbarMain.attachEvent("onStateChange", function(id, state){
  //обновление состояния кнопок тулбара
  toolbarMain.forEachItem(function(itemId){
    var state = toolbarMain.getItemState(id);
    if(itemId != id && state){
      toolbarMain.setItemState(itemId,!state);
    }
  });
  //действия в зависимости от выбора фильтра
  switch (id) {
    case 'button_type':
      documentTree.clearAll();
      documentTree.loadStruct("./index.php/tree/data?table=types");
      active_filter.mode = 'type_id';
      layout.cells("a").setText("Типы документов");
      break;
    case 'button_author':
      documentTree.clearAll();
      documentTree.loadStruct("./index.php/tree/data?table=authors");
      active_filter.mode = 'author_id';
      layout.cells("a").setText("Издатели");
      break;
    case 'button_topic':
      documentTree.clearAll();
      documentTree.loadStruct("./index.php/tree/data?table=topics");
      active_filter.mode = 'topic_id';
      layout.cells("a").setText("Темы");
      break;
  }
});
toolbarC.attachEvent("onClick", function(id){
      switch (id) {
        case 'button_editor':
          edocs.message("функционал не реализован");
          break;
        case 'button_undo':
          loadGridFromHistory(-1);
          break;
        case 'button_redo':
          loadGridFromHistory(1);
          break;
      }
    })
documentsGrid.attachEvent("onRowSelect", function(id,ind){
  var id = documentsGrid.getSelectedId();
  var docName = documentsGrid.cells(documentsGrid.getSelectedId(),documentsGrid.getColIndexById('file')).getValue();
//  var docType = documentsGrid.cells(documentsGrid.getSelectedId(),documentsGrid.getColIndexById('type_id')).getValue();
  
  if (gridDeleteMode) {
      
      var type = documentsGrid.cells(documentsGrid.getSelectedId(),documentsGrid.getColIndexById('type_name'));
      if(type.getValue() == 'Корзина'){
        documentsGrid.deleteRow(documentsGrid.getSelectedId());
      } else {

        type.setValue("Корзина");
        
        dataProc.setUpdated(documentsGrid.getSelectedId(),true);
        documentsGrid.setRowHidden(documentsGrid.getSelectedId(),true);

      }

      gridDeleteMode = !gridDeleteMode;    
  } else if(config['env'] != 'dev') {
    
      var oIframe = document.getElementsByTagName('iframe')[0];
      var path;

      edocs.message(docName);
      if('document_show' in USER['permissions']){
        if (docName.search(/\.html/i) != -1){  
          oIframe.src = config['docsPath'] + docName;
        } else {
          oIframe.src = "http://docs.google.com/viewer?url=" + config['docsPath'] + docName + "&embedded=true";
      //    oIframe.src = "https://docs.google.com/viewerng/viewer?url=http://innakhx4.bget.ru/" + docName + "&embedded=true";  
        }
      } else {
        edocs.message("Недостаточно прав для просмотра документа!");
      }

  }

 
}); 
documentsGrid.attachEvent("onCellChanged", function(rId,cInd,nValue){

});
documentTree.attachEvent("onSelect", function(id, mode){
  if(mode){
    documentsGrid.clearAll();
    doBeforeGridUpdate();
    active_filter.text = documentTree.getItemText(id);
    documentsGrid.load("/index.php/grid/data?connector=true&dhx_filter[" + active_filter.mode + "]=" + id, doAfterGridUpdate);
  }
});  
documentTree.attachEvent("onXLE", function(){
  // after loading ended and data rendered (before user's callback)
  // your code here
  if( ! ('cart' in USER['permissions']) ){
    documentTree.deleteItem("Корзина__{group_param}");
  }
});

dataProc.attachEvent("onAfterUpdate", function(id, action, tid, response){

  switch (action) {
    case 'updated':
      window.console.log('updated');
      window.console.log(response);
      break;
    case 'inserted':
      window.console.log('inserted');
      window.console.log(response);
      break;  
    case 'deleted':
      window.console.log('deleted');
      window.console.log(response);
      break;
    case 'invalid':
      window.console.log('invalid');
      window.console.log(response);
      break;
    case 'error':
      window.console.log('error');
      window.console.log(response);
      break;  
  return true;
  }
});

editForm.attachEvent("onButtonClick", function(id){ 
  switch (id) {
    case 'submit':
      var dhxCalendar = editForm.getCalendar('date');
      editForm.save();  
      documentsGrid.setRowHidden(documentsGrid.getSelectedRowId(), needHide); //скрываю строку при изменении атрибута отличного от выбранного в TreeView
      needHide = false;
      break;
    case 'submit_close':
      var dhxCalendar = editForm.getCalendar('date');
      editForm.save();  
      editForm.hide();
      documentsGrid.setRowHidden(documentsGrid.getSelectedRowId(), needHide); //скрываю строку при изменении атрибута отличного от выбранного в TreeView
      needHide = false;
      break;      
    case 'close':
      editWindow.window('editWindow').hide();  
      break;
  }//attaches a handler function to the "onButtonClick" event
                                                    //sends the values of the updated row to the server
});
editForm.attachEvent("onBeforeChange", function (name, old_value, new_value){

  switch (name) {
    case 'type_name':
      if(active_filter.mode == 'type_id'){
          needHide = (active_filter.text != new_value);
      }
      break;
    case 'author_name':
      if(active_filter.mode == 'author_id'){
          needHide = (active_filter.text != new_value);
      }
      break;
    case 'topic_name':
      if(active_filter.mode == 'topic_id'){
          needHide = (active_filter.text != new_value);
      }
      break;
  }
return true;
});

function searchFormEvent(){
 searchForm.attachEvent("onButtonClick", function(id){
  switch (id) {
    case 'submit':
      searchFormSend();
      break;
    case 'submit_close':
      searchFormSend();
      searchWindow.window('searchWindow').close();
      break;      
    case 'close':
      searchWindow.window('searchWindow').close();  
      break;
  }//attaches a handler function to the "onButtonClick" event
                                                    //sends the values of the updated row to the server
}); 
}


