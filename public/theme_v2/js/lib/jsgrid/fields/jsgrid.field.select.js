!function(e,u,s){var i=e.NumberField,r="number";function t(e){if(this.items=[],this.selectedIndex=-1,this.valueField="",this.textField="",e.valueField&&e.items.length){var t=e.items[0][e.valueField];this.valueType=typeof t===r?r:"string"}this.sorter=this.valueType,i.call(this,e)}t.prototype=new i({align:"center",valueType:r,itemTemplate:function(i){var e,t=this.items,r=this.valueField,n=this.textField;e=r?u.grep(t,function(e,t){return e[r]===i})[0]||{}:t[i];var l=n?e[n]:e;return l===s||null===l?"":l},filterTemplate:function(){if(!this.filtering)return"";var t=this._grid,e=this.filterControl=this._createSelect();return this.autosearch&&e.on("change",function(e){t.search()}),e},insertTemplate:function(){return this.inserting?this.insertControl=this._createSelect():""},editTemplate:function(e){if(!this.editing)return this.itemTemplate.apply(this,arguments);var t=this.editControl=this._createSelect();return e!==s&&t.val(e),t},filterValue:function(){var e=this.filterControl.val();return this.valueType===r?parseInt(e||0,10):e},insertValue:function(){var e=this.insertControl.val();return this.valueType===r?parseInt(e||0,10):e},editValue:function(){var e=this.editControl.val();return this.valueType===r?parseInt(e||0,10):e},_createSelect:function(){var n=u("<select>"),l=this.valueField,s=this.textField,a=this.selectedIndex;return u.each(this.items,function(e,t){var i=l?t[l]:e,r=s?t[s]:t;u("<option>").attr("value",i).text(r).appendTo(n).prop("selected",a===e)}),n.prop("disabled",!!this.readOnly),n}}),e.fields.select=e.SelectField=t}(jsGrid,jQuery);