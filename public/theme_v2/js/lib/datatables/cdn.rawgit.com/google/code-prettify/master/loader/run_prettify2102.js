!function(){function t(){d&&function(t){function n(e){"readystatechange"==e.type&&"complete"!=c.readyState||(("load"==e.type?i:c)[s](o+e.type,n,!1),!r&&(r=!0)&&t.call(i,e.type||e))}var e=c.addEventListener,r=!1,a=!0,l=e?"addEventListener":"attachEvent",s=e?"removeEventListener":"detachEvent",o=e?"":"on";if("complete"==c.readyState)t.call(i,"lazy");else{if(c.createEventObject&&u.doScroll){try{a=!i.frameElement}catch(e){}a&&function t(){try{u.doScroll("left")}catch(e){return void i.setTimeout(t,50)}n("poll")}()}c[l](o+"DOMContentLoaded",n,!1),c[l](o+"readystatechange",n,!1),i[l](o+"load",n,!1)}}(function(){var t=h.length;v(t?function(){for(var e=0;e<t;++e)!function(e){i.setTimeout(function(){i.exports[h[e]].apply(i,arguments)},0)}(e)}:void 0)})}for(var i=window,c=document,u=c.documentElement,r=c.head||c.getElementsByTagName("head")[0]||u,e="",n=(m=c.getElementsByTagName("script")).length;0<=--n;){var a=m[n],l=a.src.match(/^[^?#]*\/run_prettify\.js(\?[^#]*)?(?:#.*)?$/);if(l){e=l[1]||"",a.parentNode.removeChild(a);break}}var s,o,d=!0,p=[],f=[],h=[];for(e.replace(/[?&]([^&=]+)=([^&]+)/g,function(e,t,n){n=decodeURIComponent(n),"autorun"==(t=decodeURIComponent(t))?d=!/^[0fn]/i.test(n):"lang"==t?p.push(n):"skin"==t?f.push(n):"callback"==t&&h.push(n)}),n=0,e=p.length;n<e;++n)!function(){var e=c.createElement("script");e.onload=e.onerror=e.onreadystatechange=function(){!e||e.readyState&&!/loaded|complete/.test(e.readyState)||(e.onerror=e.onload=e.onreadystatechange=null,--g||i.setTimeout(t,0),e.parentNode&&e.parentNode.removeChild(e),e=null)},e.type="text/javascript",e.src="https://cdn.rawgit.com/google/code-prettify/master/loader/lang-"+encodeURIComponent(p[n])+".js",r.insertBefore(e,r.firstChild)}(p[n]);var g=p.length,m=[];for(n=0,e=f.length;n<e;++n)m.push("https://cdn.rawgit.com/google/code-prettify/master/loader/skins/"+encodeURIComponent(f[n])+".css");m.push("https://cdn.rawgit.com/google/code-prettify/master/loader/prettify.css"),o=(s=m).length,function e(t){if(t!==o){var n=c.createElement("link");n.rel="stylesheet",n.type="text/css",t+1<o&&(n.error=n.onerror=function(){e(t+1)}),n.href=s[t],r.appendChild(n)}}(0);var y,v=("undefined"!=typeof window&&(window.PR_SHOULD_USE_CONTINUATION=!0),function(){function x(e,t,n,r,a){n&&(r(e={h:e,l:1,j:null,m:null,a:n,c:null,i:t,g:null}),a.push.apply(a,e.g))}function S(e){for(var t=void 0,n=e.firstChild;n;n=n.nextSibling){var r=n.nodeType;t=1===r?t?e:n:3===r&&u.test(n.nodeValue)?e:t}return t===e?void 0:t}function l(i,y){var v,b={};!function(){for(var e=i.concat(y),t=[],n={},r=0,a=e.length;r<a;++r){var l=e[r],s=l[3];if(s)for(var o=s.length;0<=--o;)b[s.charAt(o)]=l;s=""+(l=l[1]),n.hasOwnProperty(s)||(t.push(l),n[s]=null)}t.push(/[\0-\uffff]/),v=function(e){function o(e){var t=e.charCodeAt(0);if(92!==t)return t;var n=e.charAt(1);return(t=s[n])?t:"0"<=n&&n<="7"?parseInt(e.substring(1),8):"u"===n||"x"===n?parseInt(e.substring(2),16):e.charCodeAt(1)}function i(e){return e<32?(e<16?"\\x0":"\\x")+e.toString(16):"\\"===(e=String.fromCharCode(e))||"-"===e||"]"===e||"^"===e?"\\"+e:e}function c(e){var t=e.substring(1,e.length-1).match(RegExp("\\\\u[0-9A-Fa-f]{4}|\\\\x[0-9A-Fa-f]{2}|\\\\[0-3][0-7]{0,2}|\\\\[0-7]{1,2}|\\\\[\\s\\S]|-|[^-\\\\]","g"));e=[];var n=["["];(r="^"===t[0])&&n.push("^");for(var r=r?1:0,a=t.length;r<a;++r){var l,s=t[r];/\\[bdsw]/i.test(s)?n.push(s):(s=o(s),r+2<a&&"-"===t[r+1]?(l=o(t[r+2]),r+=2):l=s,e.push([s,l]),l<65||122<s||(l<65||90<s||e.push([32|Math.max(65,s),32|Math.min(l,90)]),l<97||122<s||e.push([-33&Math.max(97,s),-33&Math.min(l,122)])))}for(e.sort(function(e,t){return e[0]-t[0]||t[1]-e[1]}),t=[],a=[],r=0;r<e.length;++r)(s=e[r])[0]<=a[1]+1?a[1]=Math.max(a[1],s[1]):t.push(a=s);for(r=0;r<t.length;++r)s=t[r],n.push(i(s[0])),s[1]>s[0]&&(s[1]+1>s[0]&&n.push("-"),n.push(i(s[1])));return n.push("]"),n.join("")}function t(e){for(var t=e.source.match(RegExp("(?:\\[(?:[^\\x5C\\x5D]|\\\\[\\s\\S])*\\]|\\\\u[A-Fa-f0-9]{4}|\\\\x[A-Fa-f0-9]{2}|\\\\[0-9]+|\\\\[^ux0-9]|\\(\\?[:!=]|[\\(\\)\\^]|[^\\x5B\\x5C\\(\\)\\^]+)","g")),n=t.length,r=[],a=0,l=0;a<n;++a){var s=t[a];"("===s?++l:"\\"===s.charAt(0)&&(s=+s.substring(1))&&(s<=l?r[s]=-1:t[a]=i(s))}for(a=1;a<r.length;++a)-1===r[a]&&(r[a]=++u);for(l=a=0;a<n;++a)"("===(s=t[a])?r[++l]||(t[a]="(?:"):"\\"===s.charAt(0)&&(s=+s.substring(1))&&s<=l&&(t[a]="\\"+r[s]);for(a=0;a<n;++a)"^"===t[a]&&"^"!==t[a+1]&&(t[a]="");if(e.ignoreCase&&d)for(a=0;a<n;++a)e=(s=t[a]).charAt(0),2<=s.length&&"["===e?t[a]=c(s):"\\"!==e&&(t[a]=s.replace(/[a-zA-Z]/g,function(e){return e=e.charCodeAt(0),"["+String.fromCharCode(-33&e,32|e)+"]"}));return t.join("")}for(var u=0,d=!1,n=!1,r=0,a=e.length;r<a;++r){var l=e[r];if(l.ignoreCase)n=!0;else if(/[a-z]/i.test(l.source.replace(/\\u[0-9a-f]{4}|\\x[0-9a-f]{2}|\\[^ux]/gi,""))){n=!(d=!0);break}}var s={b:8,t:9,n:10,v:11,f:12,r:13},p=[];for(r=0,a=e.length;r<a;++r){if((l=e[r]).global||l.multiline)throw Error(""+l);p.push("(?:"+t(l)+")")}return new RegExp(p.join("|"),n?"gi":"g")}(t)}();var w=y.length;return function e(t){for(var n=t.i,r=t.h,a=[n,"pln"],l=0,s=t.a.match(v)||[],o={},i=0,c=s.length;i<c;++i){var u,d=s[i],p=o[d],f=void 0;if("string"==typeof p)u=!1;else{var h=b[d.charAt(0)];if(h)f=d.match(h[1]),p=h[0];else{for(u=0;u<w;++u)if(h=y[u],f=d.match(h[1])){p=h[0];break}f||(p="pln")}!(u=5<=p.length&&"lang-"===p.substring(0,5))||f&&"string"==typeof f[1]||(u=!1,p="src"),u||(o[d]=p)}if(h=l,l+=d.length,u){u=f[1];var g=d.indexOf(u),m=g+u.length;f[2]&&(g=(m=d.length-f[2].length)-u.length),p=p.substring(5),x(r,n+h,d.substring(0,g),e,a),x(r,n+h+g,u,A(p,u),a),x(r,n+h+m,d.substring(m),e,a)}else a.push(n+h,p)}t.g=a}}function e(e){var t=[],n=[];e.tripleQuotedStrings?t.push(["str",/^(?:\'\'\'(?:[^\'\\]|\\[\s\S]|\'{1,2}(?=[^\']))*(?:\'\'\'|$)|\"\"\"(?:[^\"\\]|\\[\s\S]|\"{1,2}(?=[^\"]))*(?:\"\"\"|$)|\'(?:[^\\\']|\\[\s\S])*(?:\'|$)|\"(?:[^\\\"]|\\[\s\S])*(?:\"|$))/,null,"'\""]):e.multiLineStrings?t.push(["str",/^(?:\'(?:[^\\\']|\\[\s\S])*(?:\'|$)|\"(?:[^\\\"]|\\[\s\S])*(?:\"|$)|\`(?:[^\\\`]|\\[\s\S])*(?:\`|$))/,null,"'\"`"]):t.push(["str",/^(?:\'(?:[^\\\'\r\n]|\\.)*(?:\'|$)|\"(?:[^\\\"\r\n]|\\.)*(?:\"|$))/,null,"\"'"]),e.verbatimStrings&&n.push(["str",/^@\"(?:[^\"]|\"\")*(?:\"|$)/,null]);var r=e.hashComments;if(r&&(e.cStyleComments?(1<r?t.push(["com",/^#(?:##(?:[^#]|#(?!##))*(?:###|$)|.*)/,null,"#"]):t.push(["com",/^#(?:(?:define|e(?:l|nd)if|else|error|ifn?def|include|line|pragma|undef|warning)\b|[^\r\n]*)/,null,"#"]),n.push(["str",/^<(?:(?:(?:\.\.\/)*|\/?)(?:[\w-]+(?:\/[\w-]+)+)?[\w-]+\.h(?:h|pp|\+\+)?|[a-z]\w*)>/,null])):t.push(["com",/^#[^\r\n]*/,null,"#"])),e.cStyleComments&&(n.push(["com",/^\/\/[^\r\n]*/,null]),n.push(["com",/^\/\*[\s\S]*?(?:\*\/|$)/,null])),r=e.regexLiterals){var a=(r=1<r?"":"\n\r")?".":"[\\S\\s]";n.push(["lang-regex",RegExp("^(?:^^\\.?|[+-]|[!=]=?=?|\\#|%=?|&&?=?|\\(|\\*=?|[+\\-]=|->|\\/=?|::?|<<?=?|>>?>?=?|,|;|\\?|@|\\[|~|{|\\^\\^?=?|\\|\\|?=?|break|case|continue|delete|do|else|finally|instanceof|return|throw|try|typeof)\\s*(/(?=[^/*"+r+"])(?:[^/\\x5B\\x5C"+r+"]|\\x5C"+a+"|\\x5B(?:[^\\x5C\\x5D"+r+"]|\\x5C"+a+")*(?:\\x5D|$))+/)")])}return(r=e.types)&&n.push(["typ",r]),(r=(""+e.keywords).replace(/^ | $/g,"")).length&&n.push(["kwd",new RegExp("^(?:"+r.replace(/[\s,]+/g,"|")+")\\b"),null]),t.push(["pln",/^\s+/,null," \r\n\t "]),r="^.[^\\s\\w.$@'\"`/\\\\]*",e.regexLiterals&&(r+="(?!s*/)"),n.push(["lit",/^@[a-z_$][a-z_$@0-9]*/i,null],["typ",/^(?:[@_]?[A-Z]+[a-z][A-Za-z_$@0-9]*|\w+_t\b)/,null],["pln",/^[a-z_$][a-z_$@0-9]*/i,null],["lit",/^(?:0x[a-f0-9]+|(?:\d(?:_\d+)*\d*(?:\.\d*)?|\.\d\+)(?:e[+\-]?\d+)?)[a-z]*/i,null,"0123456789"],["pln",/^\\[\s\S]?/,null],["pun",new RegExp(r),null]),l(t,n)}function C(e,t,a){function l(e){var t=e.nodeType;if(1!=t||o.test(e.className)){if((3==t||4==t)&&a){var n=e.nodeValue,r=n.match(i);r&&(t=n.substring(0,r.index),e.nodeValue=t,(n=n.substring(r.index+r[0].length))&&e.parentNode.insertBefore(c.createTextNode(n),e.nextSibling),s(e),t||e.parentNode.removeChild(e))}}else if("br"===e.nodeName.toLowerCase())s(e),e.parentNode&&e.parentNode.removeChild(e);else for(e=e.firstChild;e;e=e.nextSibling)l(e)}function s(e){for(;!e.nextSibling;)if(!(e=e.parentNode))return;e=function e(t,n){var r=n?t.cloneNode(!1):t;if(a=t.parentNode){var a=e(a,1),l=t.nextSibling;a.appendChild(r);for(var s=l;s;s=l)l=s.nextSibling,a.appendChild(s)}return r}(e.nextSibling,0);for(var t;(t=e.parentNode)&&1===t.nodeType;)e=t;r.push(e)}for(var o=/(?:^|\s)nocode(?:\s|$)/,i=/\r\n?|\n/,c=e.ownerDocument,n=c.createElement("li");e.firstChild;)n.appendChild(e.firstChild);for(var r=[n],u=0;u<r.length;++u)l(r[u]);t===(0|t)&&r[0].setAttribute("value",t);var d=c.createElement("ol");d.className="linenums",t=Math.max(0,t-1|0)||0,u=0;for(var p=r.length;u<p;++u)(n=r[u]).className="L"+(u+t)%10,n.firstChild||n.appendChild(c.createTextNode(" ")),d.appendChild(n);e.appendChild(d)}function t(e,t){for(var n=t.length;0<=--n;){var r=t[n];p.hasOwnProperty(r)?P.console&&console.warn("cannot override language handler %s",r):p[r]=e}}function A(e,t){return e&&p.hasOwnProperty(e)||(e=/^\s*</.test(t)?"default-markup":"default-code"),p[e]}function N(e){var t,r,a,l,s,o,i,n=e.j;try{var c=(t=e.h,r=e.l,a=/(?:^|\s)nocode(?:\s|$)/,l=[],o=[],i=s=0,function e(t){var n=t.nodeType;if(1==n){if(!a.test(t.className)){for(n=t.firstChild;n;n=n.nextSibling)e(n);"br"!==(n=t.nodeName.toLowerCase())&&"li"!==n||(l[i]="\n",o[i<<1]=s++,o[i++<<1|1]=t)}}else 3!=n&&4!=n||(n=t.nodeValue).length&&(n=r?n.replace(/\r\n?/g,"\n"):n.replace(/[ \t\r\n]+/g," "),l[i]=n,o[i<<1]=s,s+=n.length,o[i++<<1|1]=t)}(t),g={a:l.join("").replace(/\n$/,""),c:o}).a;e.a=c,e.c=g.c,e.i=0,A(n,c)(e);var u,d,p=(p=/\bMSIE\s(\d+)/.exec(navigator.userAgent))&&+p[1]<=8,f=(n=/\n/g,e.a),h=f.length,g=0,m=e.c,y=m.length,v=(c=0,e.g),b=v.length,w=0;for(v[b]=h,d=u=0;d<b;)v[d]!==v[d+2]?(v[u++]=v[d++],v[u++]=v[d++]):d+=2;for(b=u,d=u=0;d<b;){for(var x=v[d],S=v[d+1],C=d+2;C+2<=b&&v[C+1]===S;)C+=2;v[u++]=x,v[u++]=S,d=C}v.length=u;var N=e.h;e="",N&&(e=N.style.display,N.style.display="none");try{for(;c<y;){var E,_=m[c+2]||h,T=v[w+2]||h,k=(C=Math.min(_,T),m[c+1]);if(1!==k.nodeType&&(E=f.substring(g,C))){p&&(E=E.replace(n,"\r")),k.nodeValue=E;var R=k.ownerDocument,L=R.createElement("span");L.className=v[w+1];var $=k.parentNode;$.replaceChild(L,k),L.appendChild(k),g<_&&(m[c+1]=k=R.createTextNode(f.substring(C,_)),$.insertBefore(k,L.nextSibling))}_<=(g=C)&&(c+=2),T<=g&&(w+=2)}}finally{N&&(N.style.display=e)}}catch(e){P.console&&console.log(e&&e.stack||e)}}var n,r,P="undefined"!=typeof window?window:{},a=[n=[[r=["break,continue,do,else,for,if,return,while"],"auto,case,char,const,default,double,enum,extern,float,goto,inline,int,long,register,restrict,short,signed,sizeof,static,struct,switch,typedef,union,unsigned,void,volatile"],"catch,class,delete,false,import,new,operator,private,protected,public,this,throw,true,try,typeof"],"abstract,assert,boolean,byte,extends,finally,final,implements,import,instanceof,interface,null,native,package,strictfp,super,synchronized,throws,transient"],s=[n,"abstract,add,alias,as,ascending,async,await,base,bool,by,byte,checked,decimal,delegate,descending,dynamic,event,finally,fixed,foreach,from,get,global,group,implicit,in,interface,internal,into,is,join,let,lock,null,object,out,override,orderby,params,partial,readonly,ref,remove,sbyte,sealed,select,set,stackalloc,string,select,uint,ulong,unchecked,unsafe,ushort,value,var,virtual,where,yield"],o=[r,"and,as,assert,class,def,del,elif,except,exec,finally,from,global,import,in,is,lambda,nonlocal,not,or,pass,print,raise,try,with,yield,False,True,None"],i=[r,"alias,and,begin,case,class,def,defined,elsif,end,ensure,false,in,module,next,nil,not,or,redo,rescue,retry,self,super,then,true,undef,unless,until,when,yield,BEGIN,END"],c=/^(DIR|FILE|array|vector|(de|priority_)?queue|(forward_)?list|stack|(const_)?(reverse_)?iterator|(unordered_)?(multi)?(set|map)|bitset|u?(int|float)\d*)\b/,u=/\S/,d=e({keywords:[f=[n,"alignas,alignof,align_union,asm,axiom,bool,concept,concept_map,const_cast,constexpr,decltype,delegate,dynamic_cast,explicit,export,friend,generic,late_check,mutable,namespace,noexcept,noreturn,nullptr,property,reinterpret_cast,static_assert,static_cast,template,typeid,typename,using,virtual,where"],s,a,n=[n,"abstract,async,await,constructor,debugger,enum,eval,export,function,get,implements,instanceof,interface,let,null,set,undefined,var,with,yield,Infinity,NaN"],"caller,delete,die,do,dump,elsif,eval,exit,foreach,for,goto,if,import,last,local,my,next,no,our,print,package,redo,require,sub,undef,unless,until,use,wantarray,while,BEGIN,END",o,i,r=[r,"case,done,elif,esac,eval,fi,function,in,local,set,then,until"]],hashComments:!0,cStyleComments:!0,multiLineStrings:!0,regexLiterals:!0}),p={};t(d,["default-code"]),t(l([],[["pln",/^[^<?]+/],["dec",/^<!\w[^>]*(?:>|$)/],["com",/^<\!--[\s\S]*?(?:-\->|$)/],["lang-",/^<\?([\s\S]+?)(?:\?>|$)/],["lang-",/^<%([\s\S]+?)(?:%>|$)/],["pun",/^(?:<[%?]|[%?]>)/],["lang-",/^<xmp\b[^>]*>([\s\S]+?)<\/xmp\b[^>]*>/i],["lang-js",/^<script\b[^>]*>([\s\S]*?)(<\/script\b[^>]*>)/i],["lang-css",/^<style\b[^>]*>([\s\S]*?)(<\/style\b[^>]*>)/i],["lang-in.tag",/^(<\/?[a-z][^<>]*>)/i]]),"default-markup htm html mxml xhtml xml xsl".split(" ")),t(l([["pln",/^[\s]+/,null," \t\r\n"],["atv",/^(?:\"[^\"]*\"?|\'[^\']*\'?)/,null,"\"'"]],[["tag",/^^<\/?[a-z](?:[\w.:-]*\w)?|\/?>$/i],["atn",/^(?!style[\s=]|on)[a-z](?:[\w:-]*\w)?/i],["lang-uq.val",/^=\s*([^>\'\"\s]*(?:[^>\'\"\s\/]|\/(?=\s)))/],["pun",/^[=<>\/]+/],["lang-js",/^on\w+\s*=\s*\"([^\"]+)\"/i],["lang-js",/^on\w+\s*=\s*\'([^\']+)\'/i],["lang-js",/^on\w+\s*=\s*([^\"\'>\s]+)/i],["lang-css",/^style\s*=\s*\"([^\"]+)\"/i],["lang-css",/^style\s*=\s*\'([^\']+)\'/i],["lang-css",/^style\s*=\s*([^\"\'>\s]+)/i]]),["in.tag"]),t(l([],[["atv",/^[\s\S]+/]]),["uq.val"]),t(e({keywords:f,hashComments:!0,cStyleComments:!0,types:c}),"c cc cpp cxx cyc m".split(" ")),t(e({keywords:"null,true,false"}),["json"]),t(e({keywords:s,hashComments:!0,cStyleComments:!0,verbatimStrings:!0,types:c}),["cs"]),t(e({keywords:a,cStyleComments:!0}),["java"]),t(e({keywords:r,hashComments:!0,multiLineStrings:!0}),["bash","bsh","csh","sh"]),t(e({keywords:o,hashComments:!0,multiLineStrings:!0,tripleQuotedStrings:!0}),["cv","py","python"]),t(e({keywords:"caller,delete,die,do,dump,elsif,eval,exit,foreach,for,goto,if,import,last,local,my,next,no,our,print,package,redo,require,sub,undef,unless,until,use,wantarray,while,BEGIN,END",hashComments:!0,multiLineStrings:!0,regexLiterals:2}),["perl","pl","pm"]),t(e({keywords:i,hashComments:!0,multiLineStrings:!0,regexLiterals:!0}),["rb","ruby"]),t(e({keywords:n,cStyleComments:!0,regexLiterals:!0}),["javascript","js","ts","typescript"]),t(e({keywords:"all,and,by,catch,class,else,extends,false,finally,for,if,in,is,isnt,loop,new,no,not,null,of,off,on,or,return,super,then,throw,true,try,unless,until,when,while,yes",hashComments:3,cStyleComments:!0,multilineStrings:!0,tripleQuotedStrings:!0,regexLiterals:!0}),["coffee"]),t(l([],[["str",/^[\s\S]+/]]),["regex"]);var f,h=P.PR={createSimpleLexer:l,registerLangHandler:t,sourceDecorator:e,PR_ATTRIB_NAME:"atn",PR_ATTRIB_VALUE:"atv",PR_COMMENT:"com",PR_DECLARATION:"dec",PR_KEYWORD:"kwd",PR_LITERAL:"lit",PR_NOCODE:"nocode",PR_PLAIN:"pln",PR_PUNCTUATION:"pun",PR_SOURCE:"src",PR_STRING:"str",PR_TAG:"tag",PR_TYPE:"typ",prettyPrintOne:function(e,t,n){n=n||!1,t=t||null;var r=document.createElement("div");return r.innerHTML="<pre>"+e+"</pre>",r=r.firstChild,n&&C(r,n,!0),N({j:t,m:n,h:r,l:1,a:null,i:null,c:null,g:null}),r.innerHTML},prettyPrint:y=function(c,e){for(var u=(t=e||document.body).ownerDocument||document,t=[t.getElementsByTagName("pre"),t.getElementsByTagName("code"),t.getElementsByTagName("xmp")],d=[],n=0;n<t.length;++n)for(var r=0,a=t[n].length;r<a;++r)d.push(t[n][r]);t=null;var p=Date;p.now||(p={now:function(){return+new Date}});var f=0,h=/\blang(?:uage)?-([\w.]+)(?!\S)/,g=/\bprettyprint\b/,m=/\bprettyprinted\b/,y=/pre|xmp/i,v=/^code$/i,b=/^(?:pre|code|xmp)$/i,w={};!function e(){for(var t=P.PR_SHOULD_USE_CONTINUATION?p.now()+250:1/0;f<d.length&&p.now()<t;f++){for(var n=d[f],r=w,a=n;(a=a.previousSibling)&&((o=(7===(l=a.nodeType)||8===l)&&a.nodeValue)?/^\??prettify\b/.test(o):3===l&&!/\S/.test(a.nodeValue));)if(o){r={},o.replace(/\b(\w+)=([\w:.%+-]+)/g,function(e,t,n){r[t]=n});break}if(a=n.className,(r!==w||g.test(a))&&!m.test(a)){for(l=!1,o=n.parentNode;o;o=o.parentNode)if(b.test(o.tagName)&&o.className&&g.test(o.className)){l=!0;break}if(!l){var l,s;if(n.className+=" prettyprinted",(l=r.lang)||(!(l=a.match(h))&&(s=S(n))&&v.test(s.tagName)&&(l=s.className.match(h)),l&&(l=l[1])),y.test(n.tagName))o=1;else{var o=n.currentStyle,i=u.defaultView;o=(o=o?o.whiteSpace:i&&i.getComputedStyle?i.getComputedStyle(n,null).getPropertyValue("white-space"):0)&&"pre"===o.substring(0,3)}(i="true"===(i=r.linenums)||+i)||(i=!!(i=a.match(/\blinenums\b(?::(\d+))?/))&&(!i[1]||!i[1].length||+i[1])),i&&C(n,i,o),N({j:l,h:n,m:i,l:o,a:null,i:null,c:null,g:null})}}}f<d.length?P.setTimeout(e,250):"function"==typeof c&&c()}()}};"function"==typeof(f=P.define)&&f.amd&&f("google-code-prettify",[],function(){return h})}(),y);g||i.setTimeout(t,0)}();