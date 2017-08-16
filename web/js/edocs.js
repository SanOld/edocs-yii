var edocs = {
 message: function (arg){
var obj = arg || {};
    switch (typeof arg) {

      case 'string':
        obj['text'] = arg;
        break;   
//      case 'num':
//        obj['expire'] = arg;
//        break;
      
      default: 
        obj['type'] = ('type' in obj) ? obj.type : "msg_area"; // 'customCss' - css class
        obj['expire'] = ('expire' in obj) ? obj.expire : 3000;
        break;
        
    }

   function func() {
    return dhtmlx.message(obj);
  }
//    window.console.log(arguments);
//    window.console.log([].slice.call(arguments));
////var arr = [].slice.call(arguments);

    return func.apply(this,[]);
 }
};


