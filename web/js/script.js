eXcell_myCheck.prototype = new eXcell;// nests all other methods from the base class
eXcell_myDate.prototype = new eXcell;// nests all other methods from the base class
eXcell_myDelete.prototype = new eXcell;// nests all other methods from the base class
eXcell_myEdit.prototype = new eXcell;// nests all other methods from the base class
function eXcell_myCheck(cell){ // the eXcell name is defined here
  var _this = this;
  var value = 0;
  if (cell){            // the default pattern, just copy it
      this.cell = cell;
      this.grid = this.cell.parentNode.grid;
      var row_id=this.cell.parentNode.idd;
  }

  this.edit = function(){alert(1)} //read-only cell doesn't have edit method
  // the cell is read-only, so it's always in the disabled state
  this.isDisabled = function(){ return true; }
  this.setValue=function(val){
//        this.setCValue("<input type='button' value='"+val+"'>",val);

      this.setCValue('<input class="rowcheck" type="checkbox">',val);

  }
  this.getValue=function(){
      return this.cell.firstChild.checked; // get button label
  }
  this.cell.onclick=function(e){
    if(_this.getValue()){
      checkObject[row_id] = 1;
    } else {
      if(row_id in checkObject){
//          arr.splice(arr[row_id],1);
        delete checkObject[row_id];
      }
    }
  }


}
function eXcell_myDate(cell){ // the eXcell name is defined here
  if (cell){            // the default pattern, just copy it
      this.cell = cell;
      this.grid = this.cell.parentNode.grid;
  }
  this.edit = function(){} //read-only cell doesn't have edit method
  // the cell is read-only, so it's always in the disabled state
  this.isDisabled = function(){ return true; }
  this.setValue=function(val){
      // actual data processing may be placed here, for now we just set value as it is
//        window.dhx.str2date(val, "%d-%m-%Y");
      var val = (typeof val  == 'string') ? val : window.dhx.date2str(val, "%d-%m-%Y");
//
//        val = window.dhx.date2str(date, "%d-%m-%Y");
      this.setCValue(val);

  }
}
function eXcell_myDelete(cell){ // the eXcell name is defined here
  if (cell){                // the default pattern, just copy it
      this.cell = cell;
      this.grid = this.cell.parentNode.grid;
      this.cell.onclick = function(e){
//          (e||event).cancelBubble=true;
         gridDeleteMode = !gridDeleteMode;
      }
  }
  this.edit = function(){}  //read-only cell doesn't have edit method
  // the cell is read-only, so it's always in the disabled state
  this.isDisabled = function(){ return true; }
  this.setValue=function(val){
//        this.setCValue("<input type='button' value='"+val+"'>",val);
      this.setCValue('<button type="button" class="btn btn-default btn-sm"  ><span class="fa fa-close"></span></button>',val);
  }
}
function eXcell_myEdit(cell){ // the eXcell name is defined here
  if (cell){                // the default pattern, just copy it
      this.cell = cell;
      this.grid = this.cell.parentNode.grid;
      this.cell.onclick = function(e){
//          (e||event).cancelBubble=true;
          gridEditMode = true;
          editFormShow();
      }
  }
  this.edit = function(){}  //read-only cell doesn't have edit method
  // the cell is read-only, so it's always in the disabled state
  this.isDisabled = function(){ return true; }
  this.setValue=function(val){
//        this.setCValue("<input type='button' value='"+val+"'>",val);
      this.setCValue('<button type="button" class="btn btn-default btn-sm"  ><span class="fa fa-pencil"></span></button>',val);
  }
}

function removeRow(){
    var selId = documentsGrid.getSelectedId();       //gets the Id of the selected row
    alert('will remove: ' + selId)
    documentsGrid.deleteRow(selId);            //deletes the row with the specified id
}





//  layout = new dhtmlXLayoutObject(document.body,"3L");                       //initializes dhtmlxLayout
  layout = new dhtmlXLayoutObject("layoutObj","3L");
  layout.setSkin("dhx_web");
  layout.cells("a").setText("Типы документов");                                     //sets the text in the header of the 'grid' column
  layout.cells("a").setWidth(250);
  layout.cells("b").setText("Список документов");
  layout.cells("b").setHeight(300);
  layout.cells("c").setText("Документ");
  layout.cells("c").attachHTMLString('<iframe id="viewer" src="" height="100%" width="100%"></iframe>');

  menu = layout.attachMenu();                                                //initializes dhtmlxMenu
//  menu.setIconsPath("icons/");                                               //sets the path to custom icons
  menu.loadFromHTML("mainMenu", false);                                             //loads items from the "data/menu.xml" file to the menu
  toolbarMain = layout.attachToolbar();                                          //initializes dhtmlxToolbar
  toolbarMain.setIconset("awesome");
  toolbarMain.setIconSize(48);
//  toolbarMain.loadStruct("../data/toolbarMain.xml", true);                                       //loads items from the "data/toolbar.xml" file to the toolbar
  toolbarMain.addButtonTwoState('button_type', 1, 'Вид',"fa fa-th-list",false);
  toolbarMain.setItemToolTip('button_type',"Фильтр документов по типам");
  toolbarMain.addButtonTwoState('button_author', 2, 'Видавник',"fa fa-edit",false);
  toolbarMain.setItemToolTip('button_author',"Фильтр документов по издателю");
  toolbarMain.addButtonTwoState('button_topic', 3, 'Тема',"fa fa-text-height",false);
  toolbarMain.setItemToolTip('button_topic',"Фильтр документов по темам");
  toolbarMain.addButton     ('button_search', 6, 'Пошук',"fa fa-search",false);
  toolbarMain.setItemToolTip('button_search',"Завантаження файлів масово з папки");

  documentTree = layout.cells("a").attachTreeView({
//              parent:         "treeviewObj",  // id/object, container for treeview
    skin:           "dhx_terrace",  // string, optional, treeview's skin
    iconset:        "font_awesome", // string, optional, sets the font-awesome icons
    multiselect:    true,           // boolean, optional, enables multiselect
    checkboxes:     false,           // boolean, optional, enables checkboxes
    dnd:            false,           // boolean, optional, enables drag-and-drop
    context_menu:   true           // boolean, optional, enables context menu
//              items:[],
//              onload:         function(){}    // callable, optional, callback for load
});
  documentTree.loadStruct("./index.php/tree/data");

//  toolbarA = layout.cells("a").attachToolbar()
//  toolbarA.setIconset("awesome");
//  toolbarA.loadStruct("../data/toolbarA.xml", true);

  documentsGrid = layout.cells("b").attachGrid();                             //initializes dhtmlxGrid
  documentsGrid.setImagePath("../imgs/dhxgrid_material/");
  documentsGrid.setHeader("file,Тема,Статус,Видавник, Вид, Назва документу,Дата,N",null,
                          [  "text-align:center;"
                            ,"text-align:center;"
                            ,"text-align:center;"
                            ,"text-align:center;"
                            ,"text-align:center;"
                            ,"text-align:center;"
                            ,"text-align:center;"
                            ,"text-align:center;"
                          ]);                            //sets the header labels
  documentsGrid.setColumnIds("file,topic_name,status_name,author_name,type_name,name,date,num");                            //sets the column ids
  documentsGrid.setInitWidths("0,0,100,150,150,*,100,100");                                 //sets the initial widths of columns
  documentsGrid.setColAlign("left,left,left,left,left,left,center,left");                                //sets the horizontal alignment

  documentsGrid.setColTypes("ro,ro,ro,ro,ro,ro,myDate,ro");                                      //sets the types of columns
  documentsGrid.setColSorting("str,str,str,str,str,str,str");                                 //sets the sorting types of columns
  documentsGrid.attachHeader(",,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter,#text_filter");       //sets the filters for columns
  documentsGrid.setColumnHidden(0,1); //hides the 1st column
  documentsGrid.setColumnHidden(1,1); //hides the 1st column
//  documentsGrid.enableMultiselect(true);
  documentsGrid.enableAutoWidth(true);
	documentsGrid.enableAutoHeight(true);
//  documentsGrid.setSerializationLevel(true,true,true,true,false,true);
  documentsGrid.setSerializationLevel(true,true);
  documentsGrid.init();

  toolbarC = layout.cells("b").attachToolbar()
  toolbarC.setIconset("awesome");
  toolbarC.addButton('button_undo', 5, 'Назад',"fa fa-undo",false);
  toolbarC.addButton('button_redo', 5, 'Вперед',"fa fa-repeat",false);

  var dataProc = new dataProcessor("./index.php/grid/data");
//  dataProc.enableDebug(true);
  dataProc.setTransactionMode("GET", true);
  dataProc.init(documentsGrid);


  if('ac_show' in USER['permissions']){
    toolbarMain.addButton     ('button_upload', 4, 'Завантажити файли...',"fa fa-upload",false);
    toolbarMain.setItemToolTip('button_upload',"Завантаження файлів");
    toolbarMain.addButton     ('button_upload_folder', 5, 'Завантажити з папки...',"fa fa-cloud-upload",false);
    toolbarMain.setItemToolTip('button_upload_folder',"Завантаження файлів масово з папки");

    toolbarC.addButton('button_editor', 5, 'Редактор',"fa fa-pencil",false);
    toolbarC.setItemToolTip('button_editor',"Редактор документів");
  }

  editFormCreate(); //created edit form
  documentsGrid.load("./index.php/grid/data?connector=true&limit=" + bootstrap_count, doAfterGridUpdate);

//  searchFormCreate();



