//ind	number	index of the column
//header	string	header content of column (optional, blank by default)
//type	string	the type of the column (optional, 'ed' by default)
//width	number	the width of the column (optional, '100' by default)
//sort	string	the sort type of the column (optional, 'na' by default)
//align	string	the align of the column (optional, 'left' by default)
//valign	string	vertical align of column (optional)
//reserved	any	not used for now
//columnColor	string	background color of the column (optional)
dhtmlXGridObject.prototype.insertColumn = function(ind, header, type, width, sort, align, valign, reserved, columnColor) {
    ind = parseInt(ind);
    if (ind > this._cCount) {
        ind = this._cCount
    }
    if (!this._cMod) {
        this._cMod = this._cCount
    }
    this._processAllArrays(this._cCount, ind - 1, [(header || "&nbsp;"), (width || 100), (type || "ed"), (align || "left"), (valign || ""), (sort || "na"), (columnColor || ""), "", this._cMod, (width || 100)]);
    this._processAllRows("_addColInRow", ind);
    if (typeof (header) == "object") {
        for (var l = 1; l < this.hdr.rows.length; l++) {
            if (header[l - 1] == "#rspan") {
                var w = l - 1;
                var v = false;
                var s = null ;
                while (!v) {
                    var s = this.hdr.rows[w];
                    for (var g = 0; g < s.cells.length; g++) {
                        if (s.cells[g]._cellIndex == ind) {
                            v = g;
                            break
                        }
                    }
                    w--
                }
                this.hdr.rows[w + 1].cells[g].rowSpan = (this.hdr.rows[w].cells[g].rowSpan || 1) + 1
            } else {
                this.setHeaderCol(ind, (header[l - 1] || "&nbsp;"), l)
            }
        }
    } else {
        this.setHeaderCol(ind, (header || "&nbsp;"))
    }
    this.hdr.rows[0].cells[ind];
    this._cCount++;
    this._cMod++;
    this._master_row = null ;
    this.setSizes()
}
;
dhtmlXGridObject.prototype.deleteColumn = function(ind) {
    ind = parseInt(ind);
    if (this._cCount == 0) {
        return
    }
    if (!this._cMod) {
        this._cMod = this._cCount
    }
    if (ind >= this._cCount) {
        return
    }
    this._processAllArrays(ind, this._cCount - 1, [null , null , null , null , null , null , null , null , null , null , null ]);
    this._processAllRows("_deleteColInRow", ind);
    this._cCount--;
    this._master_row = null ;
    this.setSizes()
};

dhtmlXGridObject.prototype._processAllArrays = function(r, a, o) {
    var h = ["hdrLabels", "initCellWidth", "cellType", "cellAlign", "cellVAlign", "fldSort", "columnColor", "_hrrar", "_c_order"];
    if (this.cellWidthPX.length) {
        h.push("cellWidthPX")
    }
    if (this.cellWidthPC.length) {
        h.push("cellWidthPC")
    }
    if (this._col_combos) {
        h.push("_col_combos")
    }
    if (this._mCols) {
        h[h.length] = "_mCols"
    }
    if (this.columnIds) {
        h[h.length] = "columnIds"
    }
    if (this._maskArr) {
        h.push("_maskArr")
    }
    if (this._drsclmW) {
        h.push("_drsclmW")
    }
    if (this._RaSeCol) {
        h.push("_RaSeCol")
    }
    if (this._hm_config) {
        h.push("_hm_config")
    }
    if (this._drsclmn) {
        h.push("_drsclmn")
    }
    if (this.clists) {
        h.push("clists")
    }
    if (this._validators && this._validators.data) {
        h.push(this._validators.data)
    }
    h.push("combos");
    if (this._customSorts) {
        h.push("_customSorts")
    }
    if (this._aggregators) {
        h.push("_aggregators")
    }
    var n = (r <= a);
    if (!this._c_order) {
        this._c_order = new Array();
        var e = this._cCount;
        for (var m = 0; m < e; m++) {
            this._c_order[m] = m
        }
    }
    for (var m = 0; m < h.length; m++) {
        var s = this[h[m]] || h[m];
        if (s) {
            if (n) {
                var c = s[r];
                for (var g = r; g < a; g++) {
                    s[g] = s[g + 1]
                }
                s[a] = c
            } else {
                var c = s[r];
                for (var g = r; g > (a + 1); g--) {
                    s[g] = s[g - 1]
                }
                s[a + 1] = c
            }
            if (o) {
                s[a + (n ? 0 : 1)] = o[m]
            }
        }
    }
};
dhtmlXGridObject.prototype._processAllRows = function(h, a, c) {
    this[h](this.obj.rows[0], a, c, 0);
    var g = this.hdr.rows.length;
    for (var e = 0; e < g; e++) {
        this[h](this.hdr.rows[e], a, c, e)
    }
    if (this.ftr) {
        var g = this.ftr.firstChild.rows.length;
        for (var e = 0; e < g; e++) {
            this[h](this.ftr.firstChild.rows[e], a, c, e)
        }
    }
    this.forEachRow(function(l) {
        if (this.rowsAr[l] && this.rowsAr[l].tagName == "TR") {
            this[h](this.rowsAr[l], a, c, -1)
        }
    })
};
dhtmlXGridObject.prototype._addColInRow = function(n, l, a, g) {
    var h = l;
    if (n._childIndexes) {
        if (n._childIndexes[l - 1] == n._childIndexes[l] || !n.childNodes[n._childIndexes[l - 1]]) {
            for (var e = n._childIndexes.length; e >= l; e--) {
                n._childIndexes[e] = e ? (n._childIndexes[e - 1] + 1) : 0
            }
            n._childIndexes[l]--
        } else {
            for (var e = n._childIndexes.length; e >= l; e--) {
                n._childIndexes[e] = e ? (n._childIndexes[e - 1] + 1) : 0
            }
        }
        var h = n._childIndexes[l]
    }
    var o = n.childNodes[h];
    var m = document.createElement((g) ? "TD" : "TH");
    if (g) {
        m._attrs = {}
    } else {
        m.style.width = (parseInt(this.cellWidthPX[l]) || "100") + "px"
    }
    if (o) {
        n.insertBefore(m, o)
    } else {
        n.appendChild(m)
    }
    if (this.dragAndDropOff && n.idd) {
        this.dragger.addDraggableItem(n.childNodes[h], this)
    }
    for (var e = h + 1; e < n.childNodes.length; e++) {
        n.childNodes[e]._cellIndex = n.childNodes[e]._cellIndexS = n.childNodes[e]._cellIndex + 1
    }
    if (n.childNodes[h]) {
        n.childNodes[h]._cellIndex = n.childNodes[h]._cellIndexS = l
    }
    if (n.idd || typeof (n.idd) != "undefined") {
        this.cells3(n, l).setValue("");
        m.align = this.cellAlign[l];
        m.style.verticalAlign = this.cellVAlign[l];
        m.bgColor = this.columnColor[l]
    } else {
        if (m.tagName == "TD") {
            if (!n.idd && this.forceDivInHeader) {
                m.innerHTML = "<div class='hdrcell'>&nbsp;</div>"
            } else {
                m.innerHTML = "&nbsp;"
            }
        }
    }
}
dhtmlXGridObject.prototype._deleteColInRow = function(n, m) {
    var e = m;
    if (n._childIndexes) {
        m = n._childIndexes[m]
    }
    var o = n.childNodes[m];
    if (!o) {
        return
    }
    if (o.colSpan && o.colSpan > 1 && o.parentNode.idd) {
        var h = o.colSpan - 1;
        var a = this.cells4(o).getValue();
        this.setColspan(o.parentNode.idd, o._cellIndex, 1);
        if (h > 1) {
            var l = o._cellIndex * 1;
            this.setColspan(o.parentNode.idd, l + 1, h);
            this.cells(o.parentNode.idd, o._cellIndex * 1 + 1).setValue(a);
            n._childIndexes.splice(l, 1);
            for (var g = l; g < n._childIndexes.length; g++) {
                n._childIndexes[g] -= 1
            }
        }
    } else {
        if (n._childIndexes) {
            n._childIndexes.splice(e, 1);
            for (var g = e; g < n._childIndexes.length; g++) {
                n._childIndexes[g]--
            }
        }
    }
    if (o) {
        n.removeChild(o)
    }
    for (var g = m; g < n.childNodes.length; g++) {
        n.childNodes[g]._cellIndex = n.childNodes[g]._cellIndexS = n.childNodes[g]._cellIndex - 1
    }
}