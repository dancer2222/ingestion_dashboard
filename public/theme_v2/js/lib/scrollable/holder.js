!function(i){if(i.document){var e,d,t,n,r,a=i.document;a.querySelectorAll||(a.querySelectorAll=function(e){var t,n=a.createElement("style"),r=[];for(a.documentElement.firstChild.appendChild(n),a._qsa=[],n.styleSheet.cssText=e+"{x-qsa:expression(document._qsa && document._qsa.push(this))}",i.scrollBy(0,0),n.parentNode.removeChild(n);a._qsa.length;)(t=a._qsa.shift()).style.removeAttribute("x-qsa"),r.push(t);return a._qsa=null,r}),a.querySelector||(a.querySelector=function(e){var t=a.querySelectorAll(e);return t.length?t[0]:null}),a.getElementsByClassName||(a.getElementsByClassName=function(e){return e=String(e).replace(/^|\s+/g,"."),a.querySelectorAll(e)}),Object.keys||(Object.keys=function(e){if(e!==Object(e))throw TypeError("Object.keys called on non-object");var t,n=[];for(t in e)Object.prototype.hasOwnProperty.call(e,t)&&n.push(t);return n}),Array.prototype.forEach||(Array.prototype.forEach=function(e){if(null==this)throw TypeError();var t=Object(this),n=t.length>>>0;if("function"!=typeof e)throw TypeError();var r,i=arguments[1];for(r=0;r<n;r++)r in t&&e.call(i,t[r],r,t)}),d="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",(e=i).atob=e.atob||function(e){var t=0,n=[],r=0,i=0;if((e=(e=String(e)).replace(/\s/g,"")).length%4==0&&(e=e.replace(/=+$/,"")),e.length%4==1)throw Error("InvalidCharacterError");if(/[^+/0-9A-Za-z]/.test(e))throw Error("InvalidCharacterError");for(;t<e.length;)r=r<<6|d.indexOf(e.charAt(t)),24===(i+=6)&&(n.push(String.fromCharCode(r>>16&255)),n.push(String.fromCharCode(r>>8&255)),n.push(String.fromCharCode(255&r)),r=i=0),t+=1;return 12===i?(r>>=4,n.push(String.fromCharCode(255&r))):18===i&&(r>>=2,n.push(String.fromCharCode(r>>8&255)),n.push(String.fromCharCode(255&r))),n.join("")},e.btoa=e.btoa||function(e){e=String(e);var t,n,r,i,a,o,s,l=0,h=[];if(/[^\x00-\xFF]/.test(e))throw Error("InvalidCharacterError");for(;l<e.length;)i=(t=e.charCodeAt(l++))>>2,a=(3&t)<<4|(n=e.charCodeAt(l++))>>4,o=(15&n)<<2|(r=e.charCodeAt(l++))>>6,s=63&r,l===e.length+2?s=o=64:l===e.length+1&&(s=64),h.push(d.charAt(i),d.charAt(a),d.charAt(o),d.charAt(s));return h.join("")},Object.prototype.hasOwnProperty||(Object.prototype.hasOwnProperty=function(e){var t=this.__proto__||this.constructor.prototype;return e in this&&(!(e in t)||t[e]!==this[e])}),function(){if("performance"in i==!1&&(i.performance={}),Date.now=Date.now||function(){return(new Date).getTime()},"now"in i.performance==!1){var e=Date.now();performance.timing&&performance.timing.navigationStart&&(e=performance.timing.navigationStart),i.performance.now=function(){return Date.now()-e}}}(),i.requestAnimationFrame||(i.webkitRequestAnimationFrame&&i.webkitCancelAnimationFrame?((r=i).requestAnimationFrame=function(e){return webkitRequestAnimationFrame(function(){e(r.performance.now())})},r.cancelAnimationFrame=r.webkitCancelAnimationFrame):i.mozRequestAnimationFrame&&i.mozCancelAnimationFrame?((n=i).requestAnimationFrame=function(e){return mozRequestAnimationFrame(function(){e(n.performance.now())})},n.cancelAnimationFrame=n.mozCancelAnimationFrame):((t=i).requestAnimationFrame=function(e){return t.setTimeout(e,1e3/60)},t.cancelAnimationFrame=t.clearTimeout))}}(this),function(e,t){"object"==typeof exports&&"object"==typeof module?module.exports=t():"function"==typeof define&&define.amd?define([],t):"object"==typeof exports?exports.Holder=t():e.Holder=t()}(this,function(){return function(n){var r={};function i(e){if(r[e])return r[e].exports;var t=r[e]={exports:{},id:e,loaded:!1};return n[e].call(t.exports,t,t.exports,i),t.loaded=!0,t.exports}return i.m=n,i.c=r,i.p="",i(0)}([function(e,t,n){e.exports=n(1)},function(s,e,T){(function(h){var e=T(2),u=T(3),L=T(6),g=T(7),m=T(8),v=T(9),I=T(10),t=T(11),d=T(12),c=T(15),y=g.extend,w=g.dimensionCheck,b=t.svg_ns,r={version:t.version,addTheme:function(e,t){return null!=e&&null!=t&&(R.settings.themes[e]=t),delete R.vars.cache.themeKeys,this},addImage:function(r,e){return v.getNodeArray(e).forEach(function(e){var t=v.newEl("img"),n={};n[R.setup.dataAttr]=r,v.setAttr(t,n),e.appendChild(t)}),this},setResizeUpdate:function(e,t){e.holderData&&(e.holderData.resizeUpdate=!!t,e.holderData.resizeUpdate&&S(e))},run:function(e){e=e||{};var d={},c=y(R.settings,e);R.vars.preempted=!0,R.vars.dataAttr=c.dataAttr||R.setup.dataAttr,d.renderer=c.renderer?c.renderer:R.setup.renderer,-1===R.setup.renderers.join(",").indexOf(d.renderer)&&(d.renderer=R.setup.supportsSVG?"svg":R.setup.supportsCanvas?"canvas":"html");var t=v.getNodeArray(c.images),n=v.getNodeArray(c.bgnodes),r=v.getNodeArray(c.stylenodes),i=v.getNodeArray(c.objects);return d.stylesheets=[],d.svgXMLStylesheet=!0,d.noFontFallback=!!c.noFontFallback,d.noBackgroundSize=!!c.noBackgroundSize,r.forEach(function(e){if(e.attributes.rel&&e.attributes.href&&"stylesheet"==e.attributes.rel.value){var t=e.attributes.href.value,n=v.newEl("a");n.href=t;var r=n.protocol+"//"+n.host+n.pathname+n.search;d.stylesheets.push(r)}}),n.forEach(function(e){if(h.getComputedStyle){var t=h.getComputedStyle(e,null).getPropertyValue("background-image"),n=e.getAttribute("data-background-src")||t,r=null,i=c.domain+"/",a=n.indexOf(i);if(0===a)r=n;else if(1===a&&"?"===n[0])r=n.slice(1);else{var o=n.substr(a).match(/([^\"]*)"?\)/);if(null!==o)r=o[1];else if(0===n.indexOf("url("))throw"Holder: unable to parse background URL: "+n}if(r){var s=l(r,c);s&&p({mode:"background",el:e,flags:s,engineSettings:d})}}}),i.forEach(function(e){var t={};try{t.data=e.getAttribute("data"),t.dataSrc=e.getAttribute(R.vars.dataAttr)}catch(e){}var n=null!=t.data&&0===t.data.indexOf(c.domain),r=null!=t.dataSrc&&0===t.dataSrc.indexOf(c.domain);n?f(c,d,t.data,e):r&&f(c,d,t.dataSrc,e)}),t.forEach(function(e){var t={};try{t.src=e.getAttribute("src"),t.dataSrc=e.getAttribute(R.vars.dataAttr),t.rendered=e.getAttribute("data-holder-rendered")}catch(e){}var n,r,i,a,o,s=null!=t.src,l=null!=t.dataSrc&&0===t.dataSrc.indexOf(c.domain),h=null!=t.rendered&&"true"==t.rendered;s?0===t.src.indexOf(c.domain)?f(c,d,t.src,e):l&&(h?f(c,d,t.dataSrc,e):(n=t.src,r=c,i=d,a=t.dataSrc,o=e,g.imageExists(n,function(e){e||f(r,i,a,o)}))):l&&f(c,d,t.dataSrc,e)}),this}},R={settings:{domain:"holder.js",images:"img",objects:"object",bgnodes:"body .holderjs",stylenodes:"head link.holderjs",themes:{gray:{bg:"#EEEEEE",fg:"#AAAAAA"},social:{bg:"#3a5a97",fg:"#FFFFFF"},industrial:{bg:"#434A52",fg:"#C2F200"},sky:{bg:"#0D8FDB",fg:"#FFFFFF"},vine:{bg:"#39DBAC",fg:"#1E292C"},lava:{bg:"#F8591A",fg:"#1C2846"}}},defaults:{size:10,units:"pt",scale:1/16}};function f(e,t,n,r){var i=l(n.substr(n.lastIndexOf(e.domain)),e);i&&p({mode:null,el:r,flags:i,engineSettings:t})}function l(e,t){var n={theme:y(R.settings.themes.gray,null),stylesheets:t.stylesheets,instanceOptions:t},r=e.indexOf("?"),i=[e];-1!==r&&(i=[e.slice(0,r),e.slice(r+1)]);var a=i[0].split("/");n.holderURL=e;var o=a[1],s=o.match(/([\d]+p?)x([\d]+p?)/);if(!s)return!1;if(n.fluid=-1!==o.indexOf("p"),n.dimensions={width:s[1].replace("p","%"),height:s[2].replace("p","%")},2===i.length){var l=u.parse(i[1]);if(g.truthy(l.ratio)){n.fluid=!0;var h=parseFloat(n.dimensions.width.replace("%","")),d=parseFloat(n.dimensions.height.replace("%",""));d=Math.floor(d/h*100),h=100,n.dimensions.width=h+"%",n.dimensions.height=d+"%"}if(n.auto=g.truthy(l.auto),l.bg&&(n.theme.bg=g.parseColor(l.bg)),l.fg&&(n.theme.fg=g.parseColor(l.fg)),l.bg&&!l.fg&&(n.autoFg=!0),l.theme&&n.instanceOptions.themes.hasOwnProperty(l.theme)&&(n.theme=y(n.instanceOptions.themes[l.theme],null)),l.text&&(n.text=l.text),l.textmode&&(n.textmode=l.textmode),l.size&&(n.size=l.size),l.font&&(n.font=l.font),l.align&&(n.align=l.align),l.lineWrap&&(n.lineWrap=l.lineWrap),n.nowrap=g.truthy(l.nowrap),n.outline=g.truthy(l.outline),g.truthy(l.random)){R.vars.cache.themeKeys=R.vars.cache.themeKeys||Object.keys(n.instanceOptions.themes);var c=R.vars.cache.themeKeys[0|Math.random()*R.vars.cache.themeKeys.length];n.theme=y(n.instanceOptions.themes[c],null)}}return n}function p(e){var t=e.mode,n=e.el,r=e.flags,i=e.engineSettings,a=r.dimensions,o=r.theme,s=a.width+"x"+a.height;t=null==t?r.fluid?"fluid":"image":t;if(null!=r.text&&(o.text=r.text,"object"===n.nodeName.toLowerCase())){for(var l=o.text.split("\\n"),h=0;h<l.length;h++)l[h]=g.encodeHtmlEntity(l[h]);o.text=l.join("\\n")}if(o.text){var d=o.text.match(/holder_([a-z]+)/g);null!==d&&d.forEach(function(e){"holder_dimensions"===e&&(o.text=o.text.replace(e,s))})}var c=r.holderURL,u=y(i,null);if(r.font&&(o.font=r.font,!u.noFontFallback&&"img"===n.nodeName.toLowerCase()&&R.setup.supportsCanvas&&"svg"===u.renderer&&(u=y(u,{renderer:"canvas"}))),r.font&&"canvas"==u.renderer&&(u.reRender=!0),"background"==t)null==n.getAttribute("data-background-src")&&v.setAttr(n,{"data-background-src":c});else{var f={};f[R.vars.dataAttr]=c,v.setAttr(n,f)}r.theme=o,n.holderData={flags:r,engineSettings:u},"image"!=t&&"fluid"!=t||v.setAttr(n,{alt:o.text?o.text+" ["+s+"]":s});var p={mode:t,el:n,holderSettings:{dimensions:a,theme:o,flags:r},engineSettings:u};"image"==t?(r.auto||(n.style.width=a.width+"px",n.style.height=a.height+"px"),"html"==u.renderer?n.style.backgroundColor=o.bg:(x(p),"exact"==r.textmode&&(n.holderData.resizeUpdate=!0,R.vars.resizableImages.push(n),S(n)))):"background"==t&&"html"!=u.renderer?x(p):"fluid"==t&&(n.holderData.resizeUpdate=!0,"%"==a.height.slice(-1)?n.style.height=a.height:null!=r.auto&&r.auto||(n.style.height=a.height+"px"),"%"==a.width.slice(-1)?n.style.width=a.width:null!=r.auto&&r.auto||(n.style.width=a.width+"px"),"inline"!=n.style.display&&""!==n.style.display&&"none"!=n.style.display||(n.style.display="block"),function(e){if(e.holderData){var t=w(e);if(t){var n=e.holderData.flags,r={fluidHeight:"%"==n.dimensions.height.slice(-1),fluidWidth:"%"==n.dimensions.width.slice(-1),mode:null,initialDimensions:t};r.fluidWidth&&!r.fluidHeight?(r.mode="width",r.ratio=r.initialDimensions.width/parseFloat(n.dimensions.height)):!r.fluidWidth&&r.fluidHeight&&(r.mode="height",r.ratio=parseFloat(n.dimensions.width)/r.initialDimensions.height),e.holderData.fluidConfig=r}else A(e)}}(n),"html"==u.renderer?n.style.backgroundColor=o.bg:(R.vars.resizableImages.push(n),S(n)))}function x(t){var e,n=t.mode,r=t.el,i=t.holderSettings,a=t.engineSettings;switch(a.renderer){case"svg":if(!R.setup.supportsSVG)return;break;case"canvas":if(!R.setup.supportsCanvas)return;break;default:return}var o={width:i.dimensions.width,height:i.dimensions.height,theme:i.theme,flags:i.flags},s=function(e){var t=R.defaults.size;parseFloat(e.theme.size)?t=e.theme.size:parseFloat(e.flags.size)&&(t=e.flags.size);switch(e.font={family:e.theme.font?e.theme.font:"Arial, Helvetica, Open Sans, sans-serif",size:(n=e.width,r=e.height,i=t,a=R.defaults.scale,o=parseInt(n,10),s=parseInt(r,10),l=Math.max(o,s),h=Math.min(o,s),d=.8*Math.min(h,l*a),Math.round(Math.max(i,d))),units:e.theme.units?e.theme.units:R.defaults.units,weight:e.theme.fontweight?e.theme.fontweight:"bold"},e.text=e.theme.text||Math.floor(e.width)+"x"+Math.floor(e.height),e.noWrap=e.theme.nowrap||e.flags.nowrap,e.align=e.theme.align||e.flags.align||"center",e.flags.textmode){case"literal":e.text=e.flags.dimensions.width+"x"+e.flags.dimensions.height;break;case"exact":if(!e.flags.exactDimensions)break;e.text=Math.floor(e.flags.exactDimensions.width)+"x"+Math.floor(e.flags.exactDimensions.height)}var n,r,i,a,o,s,l,h,d;var c=e.flags.lineWrap||R.setup.lineWrapRatio,u=e.width*c,f=u,p=new L({width:e.width,height:e.height}),g=p.Shape,m=new g.Rect("holderBg",{fill:e.theme.bg});if(m.resize(e.width,e.height),p.root.add(m),e.flags.outline){var v=new I(m.properties.fill);v=v.lighten(v.lighterThan("7f7f7f")?-.1:.1),m.properties.outline={fill:v.toHex(!0),width:2}}var y=e.theme.fg;if(e.flags.autoFg){var w=new I(m.properties.fill),b=new I("fff"),x=new I("000",{alpha:.285714});y=w.blendAlpha(w.lighterThan("7f7f7f")?x:b).toHex(!0)}var S=new g.Group("holderTextGroup",{text:e.text,align:e.align,font:e.font,fill:y});S.moveTo(null,null,1),p.root.add(S);var A=S.textPositionData=B(p);if(!A)throw"Holder: staging fallback not supported yet.";S.properties.leading=A.boundingBox.height;var C=null,E=null;function k(e,t,n,r){t.width=n,t.height=r,e.width=Math.max(e.width,t.width),e.height+=t.height}if(1<A.lineCount){var T,j=0,F=0,O=0;E=new g.Group("line"+O),"left"!==e.align&&"right"!==e.align||(f=e.width*(1-2*(1-c)));for(var z=0;z<A.words.length;z++){var D=A.words[z];C=new g.Text(D.text);var M="\\n"==D.text;!e.noWrap&&(j+D.width>=f||!0===M)&&(k(S,E,j,S.properties.leading),S.add(E),j=0,F+=S.properties.leading,O+=1,(E=new g.Group("line"+O)).y=F),!0!==M&&(C.moveTo(j,0),j+=A.spaceWidth+D.width,E.add(C))}if(k(S,E,j,S.properties.leading),S.add(E),"left"===e.align)S.moveTo(e.width-u,null,null);else if("right"===e.align){for(T in S.children)(E=S.children[T]).moveTo(e.width-E.width,null,null);S.moveTo(0-(e.width-u),null,null)}else{for(T in S.children)(E=S.children[T]).moveTo((S.width-E.width)/2,null,null);S.moveTo((e.width-S.width)/2,null,null)}S.moveTo(null,(e.height-S.height)/2,null),(e.height-S.height)/2<0&&S.moveTo(null,0,null)}else C=new g.Text(e.text),(E=new g.Group("line0")).add(C),S.add(E),"left"===e.align?S.moveTo(e.width-u,null,null):"right"===e.align?S.moveTo(0-(e.width-u),null,null):S.moveTo((e.width-A.boundingBox.width)/2,null,null),S.moveTo(null,(e.height-A.boundingBox.height)/2,null);return p}(o);function l(){var e=null;switch(a.renderer){case"canvas":e=c(s,t);break;case"svg":e=d(s,t);break;default:throw"Holder: invalid renderer: "+a.renderer}return e}if(null==(e=l()))throw"Holder: couldn't render placeholder";"background"==n?(r.style.backgroundImage="url("+e+")",a.noBackgroundSize||(r.style.backgroundSize=o.width+"px "+o.height+"px")):("img"===r.nodeName.toLowerCase()?v.setAttr(r,{src:e}):"object"===r.nodeName.toLowerCase()&&v.setAttr(r,{data:e,type:"image/svg+xml"}),a.reRender&&h.setTimeout(function(){var e=l();if(null==e)throw"Holder: couldn't render placeholder";"img"===r.nodeName.toLowerCase()?v.setAttr(r,{src:e}):"object"===r.nodeName.toLowerCase()&&v.setAttr(r,{data:e,type:"image/svg+xml"})},150)),v.setAttr(r,{"data-holder-rendered":!0})}function S(e){for(var t,n=0,r=(t=null==e||null==e.nodeType?R.vars.resizableImages:[e]).length;n<r;n++){var i=t[n];if(i.holderData){var a=i.holderData.flags,o=w(i);if(o){if(!i.holderData.resizeUpdate)continue;if(a.fluid&&a.auto){var s=i.holderData.fluidConfig;switch(s.mode){case"width":o.height=o.width/s.ratio;break;case"height":o.width=o.height*s.ratio}}var l={mode:"image",holderSettings:{dimensions:o,theme:a.theme,flags:a},el:i,engineSettings:i.holderData.engineSettings};"exact"==a.textmode&&(a.exactDimensions=o,l.holderSettings.dimensions=a.dimensions),x(l)}else A(i)}}}function i(){var t,n=[];Object.keys(R.vars.invisibleImages).forEach(function(e){t=R.vars.invisibleImages[e],w(t)&&"img"==t.nodeName.toLowerCase()&&(n.push(t),delete R.vars.invisibleImages[e])}),n.length&&r.run({images:n}),setTimeout(function(){h.requestAnimationFrame(i)},10)}function A(e){e.holderData.invisibleId||(R.vars.invisibleId+=1,(R.vars.invisibleImages["i"+R.vars.invisibleId]=e).holderData.invisibleId=R.vars.invisibleId)}var C,E,k,n,B=(k=E=C=null,function(e){var t,n=e.root;if(R.setup.supportsSVG){var r=!1;null!=C&&C.parentNode===document.body||(r=!0),(C=m.initSVG(C,n.properties.width,n.properties.height)).style.display="block",r&&(E=v.newEl("text",b),t=null,k=document.createTextNode(t),v.setAttr(E,{x:0}),E.appendChild(k),C.appendChild(E),document.body.appendChild(C),C.style.visibility="hidden",C.style.position="absolute",C.style.top="-100%",C.style.left="-100%");var i=n.children.holderTextGroup.properties;v.setAttr(E,{y:i.font.size,style:g.cssProps({"font-weight":i.font.weight,"font-size":i.font.size+i.font.units,"font-family":i.font.family})}),k.nodeValue=i.text;var a=E.getBBox(),o=Math.ceil(a.width/n.properties.width),s=i.text.split(" "),l=i.text.match(/\\n/g);o+=null==l?0:l.length,k.nodeValue=i.text.replace(/[ ]+/g,"");var h=E.getComputedTextLength(),d=a.width-h,c=Math.round(d/Math.max(1,s.length-1)),u=[];if(1<o){k.nodeValue="";for(var f=0;f<s.length;f++)if(0!==s[f].length){k.nodeValue=g.decodeHtmlEntity(s[f]);var p=E.getBBox();u.push({text:s[f],width:p.width})}}return C.style.display="none",{spaceWidth:c,lineCount:o,boundingBox:a,words:u}}return!1});function a(){!function(e){R.vars.debounceTimer||e.call(this),R.vars.debounceTimer&&h.clearTimeout(R.vars.debounceTimer),R.vars.debounceTimer=h.setTimeout(function(){R.vars.debounceTimer=null,e.call(this)},R.setup.debounce)}(function(){S(null)})}for(var o in R.flags)R.flags.hasOwnProperty(o)&&(R.flags[o].match=function(e){return e.match(this.regex)});R.setup={renderer:"html",debounce:100,ratio:1,supportsCanvas:!1,supportsSVG:!1,lineWrapRatio:.9,dataAttr:"data-src",renderers:["html","canvas","svg"]},R.vars={preempted:!1,resizableImages:[],invisibleImages:{},invisibleId:0,visibilityCheckStarted:!1,debounceTimer:null,cache:{}},(n=v.newEl("canvas")).getContext&&-1!=n.toDataURL("image/png").indexOf("data:image/png")&&(R.setup.renderer="canvas",R.setup.supportsCanvas=!0),document.createElementNS&&document.createElementNS(b,"svg").createSVGRect&&(R.setup.renderer="svg",R.setup.supportsSVG=!0),R.vars.visibilityCheckStarted||(h.requestAnimationFrame(i),R.vars.visibilityCheckStarted=!0),e&&e(function(){R.vars.preempted||r.run(),h.addEventListener?(h.addEventListener("resize",a,!1),h.addEventListener("orientationchange",a,!1)):h.attachEvent("onresize",a),"object"==typeof h.Turbolinks&&h.document.addEventListener("page:change",function(){r.run()})}),s.exports=r}).call(e,function(){return this}())},function(e,t){e.exports="undefined"!=typeof window&&function(e){null==document.readyState&&document.addEventListener&&(document.addEventListener("DOMContentLoaded",function e(){document.removeEventListener("DOMContentLoaded",e,!1),document.readyState="complete"},!1),document.readyState="loading");var t=e.document,n=t.documentElement,r="load",i=!1,a="on"+r,o="complete",s="readyState",l="attachEvent",h="detachEvent",d="addEventListener",c="DOMContentLoaded",u="onreadystatechange",f="removeEventListener",p=d in t,g=i,m=i,v=[];function y(e){if(!m){if(!t.body)return x(y);for(m=!0;e=v.shift();)x(e)}}function w(e){(p||e.type===r||t[s]===o)&&(b(),y())}function b(){p?(t[f](c,w,i),e[f](r,w,i)):(t[h](u,w),e[h](a,w))}function x(e,t){setTimeout(e,0<=+t?t:1)}if(t[s]===o)x(y);else if(p)t[d](c,w,i),e[d](r,w,i);else{t[l](u,w),e[l](a,w);try{g=null==e.frameElement&&n}catch(e){}g&&g.doScroll&&function t(){if(!m){try{g.doScroll("left")}catch(e){return x(t,50)}b(),y()}}()}function S(e){m?x(e):v.push(e)}return S.version="1.4.0",S.isReady=function(){return m},S}(window)},function(e,t,n){var a=encodeURIComponent,h=decodeURIComponent,d=n(4),o=n(5),c=/(\w+)\[(\d+)\]/,u=/\w+\.\w+/;t.parse=function(e){if("string"!=typeof e)return{};if(""===(e=d(e)))return{};"?"===e.charAt(0)&&(e=e.slice(1));for(var t={},n=e.split("&"),r=0;r<n.length;r++){var i,a,o,s=n[r].split("="),l=h(s[0]);if(i=c.exec(l))t[i[1]]=t[i[1]]||[],t[i[1]][i[2]]=h(s[1]);else if(i=u.test(l)){for(i=l.split("."),a=t;i.length;)if((o=i.shift()).length){if(a[o]){if(a[o]&&"object"!=typeof a[o])break}else a[o]={};i.length||(a[o]=h(s[1])),a=a[o]}}else t[s[0]]=null==s[1]?"":h(s[1])}return t},t.stringify=function(e){if(!e)return"";var t=[];for(var n in e){var r=e[n];if("array"!=o(r))t.push(a(n)+"="+a(e[n]));else for(var i=0;i<r.length;++i)t.push(a(n+"["+i+"]")+"="+a(r[i]))}return t.join("&")}},function(e,t){(t=e.exports=function(e){return e.replace(/^\s*|\s*$/g,"")}).left=function(e){return e.replace(/^\s*/,"")},t.right=function(e){return e.replace(/\s*$/,"")}},function(e,t){var n=Object.prototype.toString;e.exports=function(e){switch(n.call(e)){case"[object Date]":return"date";case"[object RegExp]":return"regexp";case"[object Arguments]":return"arguments";case"[object Array]":return"array";case"[object Error]":return"error"}return null===e?"null":void 0===e?"undefined":e!=e?"nan":e&&1===e.nodeType?"element":null!=(t=e)&&(t._isBuffer||t.constructor&&"function"==typeof t.constructor.isBuffer&&t.constructor.isBuffer(t))?"buffer":typeof(e=e.valueOf?e.valueOf():Object.prototype.valueOf.apply(e));var t}},function(e,t){e.exports=function(e){var t=1;var n=function(e){t++,this.parent=null,this.children={},this.id=t,this.name="n"+t,void 0!==e&&(this.name=e),this.x=this.y=this.z=0,this.width=this.height=0};n.prototype.resize=function(e,t){null!=e&&(this.width=e),null!=t&&(this.height=t)},n.prototype.moveTo=function(e,t,n){this.x=null!=e?e:this.x,this.y=null!=t?t:this.y,this.z=null!=n?n:this.z},n.prototype.add=function(e){var t=e.name;if(void 0!==this.children[t])throw"SceneGraph: child already exists: "+t;(this.children[t]=e).parent=this};var r=function(){n.call(this,"root"),this.properties=e};r.prototype=new n;var i=function(e,t){if(n.call(this,e),this.properties={fill:"#000000"},void 0!==t)!function(e,t){for(var n in t)e[n]=t[n]}(this.properties,t);else if(void 0!==e&&"string"!=typeof e)throw"SceneGraph: invalid node name"};i.prototype=new n;var a=function(){i.apply(this,arguments),this.type="group"};a.prototype=new i;var o=function(){i.apply(this,arguments),this.type="rect"};o.prototype=new i;var s=function(e){i.call(this),this.type="text",this.properties.text=e};s.prototype=new i;var l=new r;return this.Shape={Rect:o,Text:s,Group:a},this.root=l,this}},function(e,t){(function(i){t.extend=function(e,t){var n={};for(var r in e)e.hasOwnProperty(r)&&(n[r]=e[r]);if(null!=t)for(var i in t)t.hasOwnProperty(i)&&(n[i]=t[i]);return n},t.cssProps=function(e){var t=[];for(var n in e)e.hasOwnProperty(n)&&t.push(n+":"+e[n]);return t.join(";")},t.encodeHtmlEntity=function(e){for(var t=[],n=0,r=e.length-1;0<=r;r--)128<(n=e.charCodeAt(r))?t.unshift(["&#",n,";"].join("")):t.unshift(e[r]);return t.join("")},t.imageExists=function(e,t){var n=new Image;n.onerror=function(){t.call(this,!1)},n.onload=function(){t.call(this,!0)},n.src=e},t.decodeHtmlEntity=function(e){return e.replace(/&#(\d+);/g,function(e,t){return String.fromCharCode(t)})},t.dimensionCheck=function(e){var t={height:e.clientHeight,width:e.clientWidth};return!(!t.height||!t.width)&&t},t.truthy=function(e){return"string"==typeof e?"true"===e||"yes"===e||"1"===e||"on"===e||"✓"===e:!!e},t.parseColor=function(e){var t,n=e.match(/(^(?:#?)[0-9a-f]{6}$)|(^(?:#?)[0-9a-f]{3}$)/i);return null!==n?"#"!==(t=n[1]||n[2])[0]?"#"+t:t:null!==(n=e.match(/^rgb\((\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*\)$/))?t="rgb("+n.slice(1).join(",")+")":null!==(n=e.match(/^rgba\((\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(0\.\d{1,}|1)\)$/))?t="rgba("+n.slice(1).join(",")+")":null},t.canvasRatio=function(){var e=1,t=1;if(i.document){var n=i.document.createElement("canvas");if(n.getContext){var r=n.getContext("2d");e=i.devicePixelRatio||1,t=r.webkitBackingStorePixelRatio||r.mozBackingStorePixelRatio||r.msBackingStorePixelRatio||r.oBackingStorePixelRatio||r.backingStorePixelRatio||1}}return e/t}}).call(t,function(){return this}())},function(e,t,n){(function(h){var d=n(9),s="http://www.w3.org/2000/svg";t.initSVG=function(e,t,n){var r,i,a=!1;e&&e.querySelector?null===(i=e.querySelector("style"))&&(a=!0):(e=d.newEl("svg",s),a=!0),a&&(r=d.newEl("defs",s),i=d.newEl("style",s),d.setAttr(i,{type:"text/css"}),r.appendChild(i),e.appendChild(r)),e.webkitMatchesSelector&&e.setAttribute("xmlns",s);for(var o=0;o<e.childNodes.length;o++)8===e.childNodes[o].nodeType&&e.removeChild(e.childNodes[o]);for(;i.childNodes.length;)i.removeChild(i.childNodes[0]);return d.setAttr(e,{width:t,height:n,viewBox:"0 0 "+t+" "+n,preserveAspectRatio:"none"}),e},t.svgStringToDataURI=function(e,t){return t?"data:image/svg+xml;charset=UTF-8;base64,"+btoa(h.unescape(encodeURIComponent(e))):"data:image/svg+xml;charset=UTF-8,"+encodeURIComponent(e)},t.serializeSVG=function(e,t){if(h.XMLSerializer){var n=new XMLSerializer,r="",i=t.stylesheets;if(t.svgXMLStylesheet){for(var a=d.createXML(),o=i.length-1;0<=o;o--){var s=a.createProcessingInstruction("xml-stylesheet",'href="'+i[o]+'" rel="stylesheet"');a.insertBefore(s,a.firstChild)}a.removeChild(a.documentElement),r=n.serializeToString(a)}var l=n.serializeToString(e);return r+(l=l.replace(/\&amp;(\#[0-9]{2,}\;)/g,"&$1"))}}}).call(t,function(){return this}())},function(e,t){(function(n){t.newEl=function(e,t){if(n.document)return null==t?n.document.createElement(e):n.document.createElementNS(t,e)},t.setAttr=function(e,t){for(var n in t)e.setAttribute(n,t[n])},t.createXML=function(){if(n.DOMParser)return(new DOMParser).parseFromString("<xml />","application/xml")},t.getNodeArray=function(e){var t=null;return"string"==typeof e?t=document.querySelectorAll(e):n.NodeList&&e instanceof n.NodeList?t=e:n.Node&&e instanceof n.Node?t=[e]:n.HTMLCollection&&e instanceof n.HTMLCollection?t=e:e instanceof Array?t=e:null===e&&(t=[]),t=Array.prototype.slice.call(t)}}).call(t,function(){return this}())},function(e,t){var o=function(e,t){"string"==typeof e&&("#"===(this.original=e).charAt(0)&&(e=e.slice(1)),/[^a-f0-9]+/i.test(e)||(3===e.length&&(e=e.replace(/./g,"$&$&")),6===e.length&&(this.alpha=1,t&&t.alpha&&(this.alpha=t.alpha),this.set(parseInt(e,16)))))};o.rgb2hex=function(e,t,n){return[e,t,n].map(function(e){var t=(0|e).toString(16);return e<16&&(t="0"+t),t}).join("")},o.hsl2rgb=function(e,t,n){var r=e/60,i=(1-Math.abs(2*n-1))*t,a=i*(1-Math.abs(parseInt(r)%2-1)),o=n-i/2,s=0,l=0,h=0;return 0<=r&&r<1?(s=i,l=a):1<=r&&r<2?(s=a,l=i):2<=r&&r<3?(l=i,h=a):3<=r&&r<4?(l=a,h=i):4<=r&&r<5?(s=a,h=i):5<=r&&r<6&&(s=i,h=a),s+=o,l+=o,h+=o,[s=parseInt(255*s),l=parseInt(255*l),h=parseInt(255*h)]},o.prototype.set=function(e){this.raw=e;var t=(16711680&this.raw)>>16,n=(65280&this.raw)>>8,r=255&this.raw,i=.2126*t+.7152*n+.0722*r,a=-.09991*t-.33609*n+.436*r,o=.615*t-.55861*n-.05639*r;return this.rgb={r:t,g:n,b:r},this.yuv={y:i,u:a,v:o},this},o.prototype.lighten=function(e){var t=255*(Math.min(1,Math.max(0,Math.abs(e)))*(e<0?-1:1))|0,n=Math.min(255,Math.max(0,this.rgb.r+t)),r=Math.min(255,Math.max(0,this.rgb.g+t)),i=Math.min(255,Math.max(0,this.rgb.b+t)),a=o.rgb2hex(n,r,i);return new o(a)},o.prototype.toHex=function(e){return(e?"#":"")+this.raw.toString(16)},o.prototype.lighterThan=function(e){return e instanceof o||(e=new o(e)),this.yuv.y>e.yuv.y},o.prototype.blendAlpha=function(e){e instanceof o||(e=new o(e));var t=e,n=t.alpha*t.rgb.r+(1-t.alpha)*this.rgb.r,r=t.alpha*t.rgb.g+(1-t.alpha)*this.rgb.g,i=t.alpha*t.rgb.b+(1-t.alpha)*this.rgb.b;return new o(o.rgb2hex(n,r,i))},e.exports=o},function(e,t){e.exports={version:"2.9.4",svg_ns:"http://www.w3.org/2000/svg"}},function(e,t,n){var C=n(13),E=n(8),r=n(11),k=n(7),T=r.svg_ns,j=function(e){var t=e.tag,n=e.content||"";return delete e.tag,delete e.content,[t,n,e]};e.exports=function(e,t){var n,r=t.engineSettings.stylesheets.map(function(e){return'<?xml-stylesheet rel="stylesheet" href="'+e+'"?>'}).join("\n"),i="holder_"+Number(new Date).toString(16),a=e.root,o=a.children.holderTextGroup,s="#"+i+" text { "+(n=o.properties,k.cssProps({fill:n.fill,"font-weight":n.font.weight,"font-family":n.font.family+", monospace","font-size":n.font.size+n.font.units}))+" } ";o.y+=.8*o.textPositionData.boundingBox.height;var l=[];Object.keys(o.children).forEach(function(e){var a=o.children[e];Object.keys(a.children).forEach(function(e){var t=a.children[e],n=o.x+a.x+t.x,r=o.y+a.y+t.y,i=j({tag:"text",content:t.properties.text,x:n,y:r});l.push(i)})});var h,d,c,u,f=j({tag:"g",content:l}),p=null;if(a.children.holderBg.properties.outline){var g=a.children.holderBg.properties.outline;p=j({tag:"path",d:(h=a.children.holderBg.width,d=a.children.holderBg.height,c=g.width,u=c/2,["M",u,u,"H",h-u,"V",d-u,"H",u,"V",0,"M",0,u,"L",h,d-u,"M",0,d-u,"L",h,u].join(" ")),"stroke-width":g.width,stroke:g.fill,fill:"none"})}var m,v=(m=a.children.holderBg,j({tag:"rect",width:m.width,height:m.height,fill:m.properties.fill})),y=[];y.push(v),g&&y.push(p),y.push(f);var w=j({tag:"g",id:i,content:y}),b=j({tag:"style",content:s,type:"text/css"}),x=j({tag:"defs",content:b}),S=j({tag:"svg",content:[x,w],width:a.properties.width,height:a.properties.height,xmlns:T,viewBox:[0,0,a.properties.width,a.properties.height].join(" "),preserveAspectRatio:"none"}),A=C(S);return A=r+A[0],E.svgStringToDataURI(A,"background"===t.mode)}},function(e,t,n){n(14);e.exports=function e(t,n,r){"use strict";var i,a,o,s,l,h,d,c,u,f,p,g,m=1,v=!0;function y(e,t){if(null!==t&&!1!==t&&void 0!==t)return"string"!=typeof t&&"object"!=typeof t?String(t):t}if(r=r||{},"string"==typeof t[0])t[0]=(l=t[0],h=l.match(/^[\w-]+/),d={tag:h?h[0]:"div",attr:{},children:[]},c=l.match(/#([\w-]+)/),u=l.match(/\$([\w-]+)/),f=l.match(/\.[\w-]+/g),c&&(d.attr.id=c[1],r[c[1]]=d),u&&(r[u[1]]=d),f&&(d.attr.class=f.join(" ").replace(/\./g,"")),l.match(/&$/g)&&(v=!1),d);else{if(!Array.isArray(t[0]))throw new Error("First element of array must be a string, or an array and not "+JSON.stringify(t[0]));m=0}for(;m<t.length;m++){if(!1===t[m]||null===t[m]){t[0]=!1;break}if(void 0!==t[m]&&!0!==t[m])if("string"==typeof t[m])v&&(t[m]=(p=t[m],String(p).replace(/&/g,"&amp;").replace(/"/g,"&quot;").replace(/'/g,"&apos;").replace(/</g,"&lt;").replace(/>/g,"&gt;"))),t[0].children.push(t[m]);else if("number"==typeof t[m])t[0].children.push(t[m]);else if(Array.isArray(t[m])){if(Array.isArray(t[m][0])){if(t[m].reverse().forEach(function(e){t.splice(m+1,0,e)}),0!==m)continue;m++}e(t[m],n,r),t[m][0]&&t[0].children.push(t[m][0])}else if("function"==typeof t[m])o=t[m];else{if("object"!=typeof t[m])throw new TypeError('"'+t[m]+'" is not allowed as a value.');for(a in t[m])t[m].hasOwnProperty(a)&&null!==t[m][a]&&!1!==t[m][a]&&("style"===a&&"object"==typeof t[m][a]?t[0].attr[a]=JSON.stringify(t[m][a],y).slice(2,-2).replace(/","/g,";").replace(/":"/g,":").replace(/\\"/g,"'"):t[0].attr[a]=t[m][a])}}if(!1!==t[0]){for(s in i="<"+t[0].tag,t[0].attr)t[0].attr.hasOwnProperty(s)&&(i+=" "+s+'="'+((g=t[0].attr[s])||0===g?String(g).replace(/&/g,"&amp;").replace(/"/g,"&quot;"):"")+'"');i+=">",t[0].children.forEach(function(e){i+=e}),i+="</"+t[0].tag+">",t[0]=i}return r[0]=t[0],o&&o(t[0]),r}},function(e,t){"use strict";var s=/["'&<>]/;e.exports=function(e){var t,n=""+e,r=s.exec(n);if(!r)return n;var i="",a=0,o=0;for(a=r.index;a<n.length;a++){switch(n.charCodeAt(a)){case 34:t="&quot;";break;case 38:t="&amp;";break;case 39:t="&#39;";break;case 60:t="&lt;";break;case 62:t="&gt;";break;default:continue}o!==a&&(i+=n.substring(o,a)),o=a+1,i+=t}return o!==a?i+n.substring(o,a):i}},function(e,t,n){var f,p,r=n(9),g=n(7);e.exports=(f=r.newEl("canvas"),p=null,function(e){null==p&&(p=f.getContext("2d"));var t=g.canvasRatio(),n=e.root;f.width=t*n.properties.width,f.height=t*n.properties.height,p.textBaseline="middle";var r=n.children.holderBg,i=t*r.width,a=t*r.height;p.fillStyle=r.properties.fill,p.fillRect(0,0,i,a),r.properties.outline&&(p.strokeStyle=r.properties.outline.fill,p.lineWidth=r.properties.outline.width,p.moveTo(1,1),p.lineTo(i-1,1),p.lineTo(i-1,a-1),p.lineTo(1,a-1),p.lineTo(1,1),p.moveTo(0,1),p.lineTo(i,a-1),p.moveTo(0,a-1),p.lineTo(i,1),p.stroke());var o=n.children.holderTextGroup;for(var s in p.font=o.properties.font.weight+" "+t*o.properties.font.size+o.properties.font.units+" "+o.properties.font.family+", monospace",p.fillStyle=o.properties.fill,o.children){var l=o.children[s];for(var h in l.children){var d=l.children[h],c=t*(o.x+l.x+d.x),u=t*(o.y+l.y+d.y+o.properties.leading/2);p.fillText(d.properties.text,c,u)}}return f.toDataURL("image/png")})}])}),function(e,t){typeof Meteor!=="undefined"&&typeof Package!=="undefined"&&(Holder=e.Holder)}(this);