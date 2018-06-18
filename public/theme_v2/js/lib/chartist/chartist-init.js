!function(e){"use strict";new Chartist.Line(".ct-chart",{labels:["1","2","3","4","5","6","7","8","9","10","11","12"],series:[[16,9,7,8,5,4,6,2,3,3,4,6],[4,5,3,7,3,5,5,3,4,4,5,5],[5,3,4,5,6,3,3,4,5,6,3,4],[3,4,5,6,7,6,4,5,6,7,6,3]]},{low:0});var t={labels:["facebook","twitter","youtube","google plus"],series:[{value:20,className:"bg-facebook"},{value:10,className:"bg-twitter"},{value:30,className:"bg-youtube"},{value:40,className:"bg-google-plus"}]},a={labelInterpolationFnc:function(e){return e[0]}},i=[["screen and (min-width: 640px)",{chartPadding:30,labelOffset:100,labelDirection:"explode",labelInterpolationFnc:function(e){return e}}],["screen and (min-width: 1024px)",{labelOffset:80,chartPadding:20}]];new Chartist.Pie(".ct-pie-chart",t,a,i),new Chartist.Line(".ct-svg-chart",{labels:["Mon","Tue","Wed","Thu","Fri","Sat"],series:[[1,5,2,5,4,3],[2,3,4,8,1,2],[5,4,3,2,1,.5]]},{low:0,showArea:!0,showPoint:!1,fullWidth:!0}).on("draw",function(e){"line"!==e.type&&"area"!==e.type||e.element.animate({d:{begin:2e3*e.index,dur:2e3,from:e.path.clone().scale(1,0).translate(0,e.chartRect.height()).stringify(),to:e.path.clone().stringify(),easing:Chartist.Svg.Easing.easeOutQuint}})});t={labels:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],series:[[5,4,3,7,5,10,3,4,8,10,6,8],[3,2,9,5,4,6,4,6,7,8,7,4],[4,6,3,9,6,5,2,8,3,,5,4]]},a={seriesBarDistance:10},i=[["screen and (max-width: 640px)",{seriesBarDistance:5,axisX:{labelInterpolationFnc:function(e){return e[0]}}}]];new Chartist.Bar(".ct-bar-chart",t,a,i)}(jQuery),new Chartist.Line(".ct-sm-line-chart",{labels:["Monday","Tuesday","Wednesday","Thursday","Friday"],series:[[12,9,7,8,5],[2,1,3.5,7,3],[1,3,4,5,6]]},{fullWidth:!0,plugins:[Chartist.plugins.tooltip()],chartPadding:{right:40}}),new Chartist.Line(".ct-area-ln-chart",{labels:[1,2,3,4,5,6,7,8],series:[[5,9,7,8,5,3,5,4]]},{low:0,plugins:[Chartist.plugins.tooltip()],showArea:!0}),new Chartist.Line("#ct-polar-chart",{labels:[1,2,3,4,5,6,7,8],series:[[1,2,3,1,-2,0,1,0],[-2,-1,-2,-1,-2.5,-1,-2,-1],[0,0,0,1,2,2.5,2,1],[2.5,2,1,.5,1,.5,-1,-2.5]]},{high:3,low:-3,chartPadding:{left:-20,top:10},showArea:!0,showLine:!1,showPoint:!0,fullWidth:!0,plugins:[Chartist.plugins.tooltip()],axisX:{showLabel:!0,showGrid:!0},axisY:{showLabel:!1,showGrid:!0}});var chart=new Chartist.Line(".ct-animation-chart",{labels:["1","2","3","4","5","6","7","8","9","10","11","12"],series:[[12,9,7,8,5,4,6,2,3,3,4,6],[4,5,3,7,3,5,5,3,4,4,5,5],[5,3,4,5,6,3,3,4,5,6,3,4]]},{low:0}),seq=0,delays=80,durations=500;chart.on("created",function(){seq=0}),chart.on("draw",function(e){if(seq++,"line"===e.type)e.element.animate({opacity:{begin:seq*delays+1e3,dur:durations,from:0,to:1}});else if("label"===e.type&&"x"===e.axis)e.element.animate({y:{begin:seq*delays,dur:durations,from:e.y+100,to:e.y,easing:"easeOutQuart"}});else if("label"===e.type&&"y"===e.axis)e.element.animate({x:{begin:seq*delays,dur:durations,from:e.x-100,to:e.x,easing:"easeOutQuart"}});else if("point"===e.type)e.element.animate({x1:{begin:seq*delays,dur:durations,from:e.x-10,to:e.x,easing:"easeOutQuart"},x2:{begin:seq*delays,dur:durations,from:e.x-10,to:e.x,easing:"easeOutQuart"},opacity:{begin:seq*delays,dur:durations,from:0,to:1,easing:"easeOutQuart"}});else if("grid"===e.type){var t={begin:seq*delays,dur:durations,from:e[e.axis.units.pos+"1"]-30,to:e[e.axis.units.pos+"1"],easing:"easeOutQuart"},a={begin:seq*delays,dur:durations,from:e[e.axis.units.pos+"2"]-100,to:e[e.axis.units.pos+"2"],easing:"easeOutQuart"},i={};i[e.axis.units.pos+"1"]=t,i[e.axis.units.pos+"2"]=a,i.opacity={begin:seq*delays,dur:durations,from:0,to:1,easing:"easeOutQuart"},e.element.animate(i)}}),chart.on("created",function(){window.__exampleAnimateTimeout&&(clearTimeout(window.__exampleAnimateTimeout),window.__exampleAnimateTimeout=null),window.__exampleAnimateTimeout=setTimeout(chart.update.bind(chart),12e3)}),(chart=new Chartist.Line(".ct-svg-chart",{labels:["Mon","Tue","Wed","Thu","Fri","Sat"],series:[[1,5,2,5,4,3],[2,3,4,8,1,2],[5,4,3,2,1,.5]]},{low:0,showArea:!0,showPoint:!1,fullWidth:!0})).on("draw",function(e){"line"!==e.type&&"area"!==e.type||e.element.animate({d:{begin:2e3*e.index,dur:2e3,from:e.path.clone().scale(1,0).translate(0,e.chartRect.height()).stringify(),to:e.path.clone().stringify(),easing:Chartist.Svg.Easing.easeOutQuint}})});var data={labels:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],series:[[5,4,3,7,5,10,3,4,8,10,6,8],[3,2,9,5,4,6,4,6,7,8,7,4]]},options={seriesBarDistance:10},responsiveOptions=[["screen and (max-width: 640px)",{seriesBarDistance:5,axisX:{labelInterpolationFnc:function(e){return e[0]}}}]];new Chartist.Bar(".ct-bar-chart",data,options,responsiveOptions),new Chartist.Pie(".ct-gauge-chart",{series:[20,10,30,40]},{donut:!0,donutWidth:60,startAngle:270,total:200,low:0,showLabel:!1}),(chart=new Chartist.Pie(".ct-donute-chart",{series:[10,20,50,20,5,50,15],labels:[1,2,3,4,5,6,7]},{donut:!0,showLabel:!1})).on("draw",function(e){if("slice"===e.type){var t=e.element._node.getTotalLength();e.element.attr({"stroke-dasharray":t+"px "+t+"px"});var a={"stroke-dashoffset":{id:"anim"+e.index,dur:1e3,from:-t+"px",to:"0px",easing:Chartist.Svg.Easing.easeOutQuint,fill:"freeze"}};0!==e.index&&(a["stroke-dashoffset"].begin="anim"+(e.index-1)+".end"),e.element.attr({"stroke-dashoffset":-t+"px"}),e.element.animate(a,!1)}}),chart.on("created",function(){window.__anim21278907124&&(clearTimeout(window.__anim21278907124),window.__anim21278907124=null),window.__anim21278907124=setTimeout(chart.update.bind(chart),1e4)});