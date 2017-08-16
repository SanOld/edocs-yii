
gantt._calc_grid_width = function () {
	var columns = this.getGridColumns();
	var cols_width = 0;
	var unknown = [];
	var width = [];

	for (var i = 0; i < columns.length; i++) {
		var v = parseInt(columns[i].width, 10);
    //дополнил 26.11.2016
    if(columns[i].hide){
      v = 0;
      columns[i].old_width = columns[i].width;
      columns[i].width = 0;
    } else {
      columns[i].old_width = ('old_width' in columns[i]) ? columns[i].old_width : columns[i].width;
      columns[i].width = columns[i].old_width != 0 ? columns[i].old_width : "auto";
    }
    //дополнил 26.11.2016
		if (window.isNaN(v)) {
			v = 50;
			unknown.push(i);
		}
		width[i] = v;
		cols_width += v;
	}
  
  

	if (this.config.autofit || unknown.length) {
		var diff = this._get_grid_width() - cols_width;
		// TODO: logic may be improved for proportional changing of width
		var step = diff / (unknown.length > 0 ? unknown.length : (width.length > 0 ? width.length : 1));
		if (unknown.length > 0) {
			// there are several columns with undefined width
			var delta = diff / (unknown.length ? unknown.length : 1);
			for (var i = 0; i < unknown.length; i++) {
				var index = unknown[i];
				width[index] += delta;
			}
		} else {
			// delta must be added for all columns
			var delta = diff / (width.length ? width.length : 1);
			for (var i = 0; i < width.length; i++)
				width[i] += delta;
		}

		for (var i = 0; i < width.length; i++) {
			columns[i].width = width[i];
		}
	}else{
		this.config.grid_width = cols_width;
	}
};


gantt.copy_object_columns = function(obj, copy){
		for(var i=0; i<gantt.config.columns.length; i++){
			var ct = gantt.config.columns[i].template;
			if (ct) {
				var val = ct(obj);
				if (val instanceof Date)
					val = gantt.templates.date_grid(val, obj);
				copy["_"+i] = val;
			}
		}
		return copy;
	}
