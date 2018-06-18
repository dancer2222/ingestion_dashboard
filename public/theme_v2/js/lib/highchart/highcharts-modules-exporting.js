!function(t){"object"==typeof module&&module.exports?module.exports=t:t(Highcharts)}(function(t){var a,e,x,n,f,o,p,y,l,b,d,g,v,w,i,h,r;e=(a=t).defaultOptions,x=a.doc,n=a.Chart,f=a.addEvent,o=a.removeEvent,p=a.fireEvent,y=a.createElement,l=a.discardElement,b=a.css,d=a.merge,g=a.pick,v=a.each,w=a.extend,i=a.isTouchDevice,h=a.win,r=a.Renderer.prototype.symbols,w(e.lang,{printChart:"Print chart",downloadPNG:"Download PNG image",downloadJPEG:"Download JPEG image",downloadPDF:"Download PDF document",downloadSVG:"Download SVG vector image",contextButtonTitle:"Chart context menu"}),e.navigation={buttonOptions:{theme:{},symbolSize:14,symbolX:12.5,symbolY:10.5,align:"right",buttonSpacing:3,height:22,verticalAlign:"top",width:24}},d(!0,e.navigation,{menuStyle:{border:"1px solid #999999",background:"#ffffff",padding:"5px 0"},menuItemStyle:{padding:"0.5em 1em",background:"none",color:"#333333",fontSize:i?"14px":"11px",transition:"background 250ms, color 250ms"},menuItemHoverStyle:{background:"#335cad",color:"#ffffff"},buttonOptions:{symbolFill:"#666666",symbolStroke:"#666666",symbolStrokeWidth:3,theme:{fill:"#ffffff",stroke:"none",padding:5}}}),e.exporting={type:"image/png",url:"https://export.highcharts.com/",printMaxWidth:780,scale:2,buttons:{contextButton:{className:"highcharts-contextbutton",menuClassName:"highcharts-contextmenu",symbol:"menu",_titleKey:"contextButtonTitle",menuItems:[{textKey:"printChart",onclick:function(){this.print()}},{separator:!0},{textKey:"downloadPNG",onclick:function(){this.exportChart()}},{textKey:"downloadJPEG",onclick:function(){this.exportChart({type:"image/jpeg"})}},{textKey:"downloadPDF",onclick:function(){this.exportChart({type:"application/pdf"})}},{textKey:"downloadSVG",onclick:function(){this.exportChart({type:"image/svg+xml"})}}]}}},a.post=function(t,e,n){var o;for(o in t=y("form",d({method:"post",action:t,enctype:"multipart/form-data"},n),{display:"none"},x.body),e)y("input",{type:"hidden",name:o,value:e[o]},null,t);t.submit(),l(t)},w(n.prototype,{sanitizeSVG:function(t,e){if(e&&e.exporting&&e.exporting.allowHTML){var n=t.match(/<\/svg>(.*?$)/);n&&(n='<foreignObject x="0" y="0" width="'+e.chart.width+'" height="'+e.chart.height+'"><body xmlns="http://www.w3.org/1999/xhtml">'+n[1]+"</body></foreignObject>",t=t.replace("</svg>",n+"</svg>"))}return(t=t.replace(/zIndex="[^"]+"/g,"").replace(/isShadow="[^"]+"/g,"").replace(/symbolName="[^"]+"/g,"").replace(/jQuery[0-9]+="[^"]+"/g,"").replace(/url\(("|&quot;)(\S+)("|&quot;)\)/g,"url($2)").replace(/url\([^#]+#/g,"url(#").replace(/<svg /,'<svg xmlns:xlink="http://www.w3.org/1999/xlink" ').replace(/ (NS[0-9]+\:)?href=/g," xlink:href=").replace(/\n/," ").replace(/<\/svg>.*?$/,"</svg>").replace(/(fill|stroke)="rgba\(([ 0-9]+,[ 0-9]+,[ 0-9]+),([ 0-9\.]+)\)"/g,'$1="rgb($2)" $1-opacity="$3"').replace(/&nbsp;/g," ").replace(/&shy;/g,"­")).replace(/<IMG /g,"<image ").replace(/<(\/?)TITLE>/g,"<$1title>").replace(/height=([^" ]+)/g,'height="$1"').replace(/width=([^" ]+)/g,'width="$1"').replace(/hc-svg-href="([^"]+)">/g,'xlink:href="$1"/>').replace(/ id=([^" >]+)/g,' id="$1"').replace(/class=([^" >]+)/g,'class="$1"').replace(/ transform /g," ").replace(/:(path|rect)/g,"$1").replace(/style="([^"]+)"/g,function(t){return t.toLowerCase()})},getChartHTML:function(){return this.container.innerHTML},getSVG:function(n){var i,t,e,o,r,s=d(this.options,n);return x.createElementNS||(x.createElementNS=function(t,e){return x.createElement(e)}),t=y("div",null,{position:"absolute",top:"-9999em",width:this.chartWidth+"px",height:this.chartHeight+"px"},x.body),e=this.renderTo.style.width,r=this.renderTo.style.height,e=s.exporting.sourceWidth||s.chart.width||/px$/.test(e)&&parseInt(e,10)||600,r=s.exporting.sourceHeight||s.chart.height||/px$/.test(r)&&parseInt(r,10)||400,w(s.chart,{animation:!1,renderTo:t,forExport:!0,renderer:"SVGRenderer",width:e,height:r}),s.exporting.enabled=!1,delete s.data,s.series=[],v(this.series,function(t){(o=d(t.userOptions,{animation:!1,enableMouseTracking:!1,showCheckbox:!1,visible:t.visible})).isInternal||s.series.push(o)}),v(this.axes,function(t){t.userOptions.internalKey=a.uniqueKey()}),i=new a.Chart(s,this.callback),n&&v(["xAxis","yAxis","series"],function(t){var e={};n[t]&&(e[t]=n[t],i.update(e))}),v(this.axes,function(e){var t=a.find(i.axes,function(t){return t.options.internalKey===e.userOptions.internalKey}),n=(o=e.getExtremes()).userMin,o=o.userMax;!t||void 0===n&&void 0===o||t.setExtremes(n,o,!0,!1)}),e=i.getChartHTML(),e=this.sanitizeSVG(e,s),s=null,i.destroy(),l(t),e},getSVGForExport:function(t,e){var n=this.options.exporting;return this.getSVG(d({chart:{borderRadius:0}},n.chartOptions,e,{exporting:{sourceWidth:t&&t.sourceWidth||n.sourceWidth,sourceHeight:t&&t.sourceHeight||n.sourceHeight}}))},exportChart:function(t,e){e=this.getSVGForExport(t,e),t=d(this.options.exporting,t),a.post(t.url,{filename:t.filename||"chart",type:t.type,width:t.width||0,scale:t.scale,svg:e},t.formAttributes)},print:function(){var t,e,n=this,o=n.container,i=[],r=o.parentNode,s=x.body,a=s.childNodes,l=n.options.exporting.printMaxWidth;n.isPrinting||(n.isPrinting=!0,n.pointer.reset(null,0),p(n,"beforePrint"),(e=l&&n.chartWidth>l)&&(t=[n.options.chart.width,void 0,!1],n.setSize(l,void 0,!1)),v(a,function(t,e){1===t.nodeType&&(i[e]=t.style.display,t.style.display="none")}),s.appendChild(o),h.focus(),h.print(),setTimeout(function(){r.appendChild(o),v(a,function(t,e){1===t.nodeType&&(t.style.display=i[e])}),n.isPrinting=!1,e&&n.setSize.apply(n,t),p(n,"afterPrint")},1e3))},contextMenu:function(e,t,n,o,i,r,s){var a,l,p=this,h=p.options.navigation,c=p.chartWidth,u=p.chartHeight,d="cache-"+e,g=p[d],m=Math.max(i,r);g||(p[d]=g=y("div",{className:e},{position:"absolute",zIndex:1e3,padding:m+"px"},p.container),a=y("div",{className:"highcharts-menu"},null,g),b(a,w({MozBoxShadow:"3px 3px 10px #888",WebkitBoxShadow:"3px 3px 10px #888",boxShadow:"3px 3px 10px #888"},h.menuStyle)),l=function(){b(g,{display:"none"}),s&&s.setState(0),p.openMenu=!1},f(g,"mouseleave",function(){g.hideTimer=setTimeout(l,500)}),f(g,"mouseenter",function(){clearTimeout(g.hideTimer)}),d=f(x,"mouseup",function(t){p.pointer.inClass(t.target,e)||l()}),f(p,"destroy",d),v(t,function(e){var t;e&&(e.separator?t=y("hr",null,null,a):((t=y("div",{className:"highcharts-menu-item",onclick:function(t){t&&t.stopPropagation(),l(),e.onclick&&e.onclick.apply(p,arguments)},innerHTML:e.text||p.options.lang[e.textKey]},null,a)).onmouseover=function(){b(this,h.menuItemHoverStyle)},t.onmouseout=function(){b(this,h.menuItemStyle)},b(t,w({cursor:"pointer"},h.menuItemStyle))),p.exportDivElements.push(t))}),p.exportDivElements.push(a,g),p.exportMenuWidth=g.offsetWidth,p.exportMenuHeight=g.offsetHeight),t={display:"block"},n+p.exportMenuWidth>c?t.right=c-n-i-m+"px":t.left=n-m+"px",o+r+p.exportMenuHeight>u&&"top"!==s.alignOptions.verticalAlign?t.bottom=u-o-m+"px":t.top=o+r-m+"px",b(g,t),p.openMenu=!0},addButton:function(t){var e,n,o=this,i=o.renderer,r=d(o.options.navigation.buttonOptions,t),s=r.onclick,a=r.menuItems,l=r.symbolSize||12;if(o.btnCount||(o.btnCount=0),o.exportDivElements||(o.exportDivElements=[],o.exportSVGElements=[]),!1!==r.enabled){var p,h=r.theme,c=(u=h.states)&&u.hover,u=u&&u.select;delete h.states,s?p=function(t){t.stopPropagation(),s.call(o,t)}:a&&(p=function(){o.contextMenu(n.menuClassName,a,n.translateX,n.translateY,n.width,n.height,n),n.setState(2)}),r.text&&r.symbol?h.paddingLeft=g(h.paddingLeft,25):r.text||w(h,{width:r.width,height:r.height,padding:0}),(n=i.button(r.text,0,0,p,h,c,u).addClass(t.className).attr({"stroke-linecap":"round",title:o.options.lang[r._titleKey],zIndex:3})).menuClassName=t.menuClassName||"highcharts-menu-"+o.btnCount++,r.symbol&&(e=i.symbol(r.symbol,r.symbolX-l/2,r.symbolY-l/2,l,l).addClass("highcharts-button-symbol").attr({zIndex:1}).add(n)).attr({stroke:r.symbolStroke,fill:r.symbolFill,"stroke-width":r.symbolStrokeWidth||1}),n.add().align(w(r,{width:n.width,x:g(r.x,o.buttonOffset)}),!0,"spacingBox"),o.buttonOffset+=(n.width+r.buttonSpacing)*("right"===r.align?-1:1),o.exportSVGElements.push(n,e)}},destroyExport:function(t){var n=t?t.target:this;t=n.exportSVGElements;var e=n.exportDivElements;t&&(v(t,function(t,e){t&&(t.onclick=t.ontouchstart=null,n.exportSVGElements[e]=t.destroy())}),t.length=0),e&&(v(e,function(t,e){clearTimeout(t.hideTimer),o(t,"mouseleave"),n.exportDivElements[e]=t.onmouseout=t.onmouseover=t.ontouchstart=t.onclick=null,l(t)}),e.length=0)}}),r.menu=function(t,e,n,o){return["M",t,e+2.5,"L",t+n,e+2.5,"M",t,e+o/2+.5,"L",t+n,e+o/2+.5,"M",t,e+o-1.5,"L",t+n,e+o-1.5]},n.prototype.renderExporting=function(){var t,e=this.options.exporting,n=e.buttons,o=this.isDirtyExporting||!this.exportSVGElements;if(this.buttonOffset=0,this.isDirtyExporting&&this.destroyExport(),o&&!1!==e.enabled){for(t in n)this.addButton(n[t]);this.isDirtyExporting=!1}f(this,"destroy",this.destroyExport)},n.prototype.callbacks.push(function(o){o.renderExporting(),f(o,"redraw",o.renderExporting),v(["exporting","navigation"],function(n){o[n]={update:function(t,e){o.isDirtyExporting=!0,d(!0,o.options[n],t),g(e,!0)&&o.redraw()}}})})});