!function(s){"use strict";s.fn.LineProgressbar=function(i){i=s.extend({percentage:null,ShowProgressCount:!0,duration:1e3,fillBackgroundColor:"#3498db",backgroundColor:"#eef1f6",radius:"0px",height:"5px",width:"100%"},i);return this.each(function(r,o){s(o).html('<div class="progressbar"><div class="proggress"></div><div class="percentCount"></div></div>');var e=s(o).find(".proggress"),n=s(o).find(".progressbar");e.css({backgroundColor:i.fillBackgroundColor,height:i.height,borderRadius:i.radius}),n.css({width:i.width,backgroundColor:i.backgroundColor,borderRadius:i.radius}),e.animate({width:i.percentage+"%"},{step:function(r){i.ShowProgressCount&&s(o).find(".percentCount").text(Math.round(r)+"%")},duration:i.duration})})}}(jQuery);