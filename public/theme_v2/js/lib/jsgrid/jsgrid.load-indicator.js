!function(i,t,n){function s(i){this._init(i)}s.prototype={container:"body",message:"Loading...",shading:!0,zIndex:1e3,shaderClass:"jsgrid-load-shader",loadPanelClass:"jsgrid-load-panel",_init:function(i){t.extend(!0,this,i),this._initContainer(),this._initShader(),this._initLoadPanel()},_initContainer:function(){this._container=t(this.container)},_initShader:function(){this.shading&&(this._shader=t("<div>").addClass(this.shaderClass).hide().css({position:"absolute",top:0,right:0,bottom:0,left:0,zIndex:this.zIndex}).appendTo(this._container))},_initLoadPanel:function(){this._loadPanel=t("<div>").addClass(this.loadPanelClass).text(this.message).hide().css({position:"absolute",top:"50%",left:"50%",zIndex:this.zIndex}).appendTo(this._container)},show:function(){var i=this._loadPanel.show(),t=i.outerWidth(),n=i.outerHeight();i.css({marginTop:-n/2,marginLeft:-t/2}),this._shader.show()},hide:function(){this._loadPanel.hide(),this._shader.hide()}},i.LoadIndicator=s}(jsGrid,jQuery);