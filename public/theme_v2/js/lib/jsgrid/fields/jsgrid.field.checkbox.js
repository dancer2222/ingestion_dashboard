!function(e,i,t){var r=e.Field;function n(e){r.call(this,e)}n.prototype=new r({sorter:"number",align:"center",autosearch:!0,itemTemplate:function(e){return this._createCheckbox().prop({checked:e,disabled:!0})},filterTemplate:function(){if(!this.filtering)return"";var e=this._grid,t=this.filterControl=this._createCheckbox();return t.prop({readOnly:!0,indeterminate:!0}),t.on("click",function(){var e=i(this);e.prop("readOnly")?e.prop({checked:!1,readOnly:!1}):e.prop("checked")||e.prop({readOnly:!0,indeterminate:!0})}),this.autosearch&&t.on("click",function(){e.search()}),t},insertTemplate:function(){return this.inserting?this.insertControl=this._createCheckbox():""},editTemplate:function(e){if(!this.editing)return this.itemTemplate.apply(this,arguments);var t=this.editControl=this._createCheckbox();return t.prop("checked",e),t},filterValue:function(){return this.filterControl.get(0).indeterminate?void 0:this.filterControl.is(":checked")},insertValue:function(){return this.insertControl.is(":checked")},editValue:function(){return this.editControl.is(":checked")},_createCheckbox:function(){return i("<input>").attr("type","checkbox")}}),e.fields.checkbox=e.CheckboxField=n}(jsGrid,jQuery);