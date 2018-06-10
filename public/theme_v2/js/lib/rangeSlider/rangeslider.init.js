$(function(){"use strict";$("#range_01").ionRangeSlider(),$("#range_02").ionRangeSlider({min:100,max:1e3,from:550}),$("#range_03").ionRangeSlider({type:"double",grid:!0,min:0,max:1e3,from:200,to:800,prefix:"$"}),$("#range_04").ionRangeSlider({type:"double",grid:!0,min:-1e3,max:1e3,from:-500,to:500}),$("#range_05").ionRangeSlider({type:"double",grid:!0,min:-1e3,max:1e3,from:-500,to:500,step:250}),$("#range_06").ionRangeSlider({type:"double",grid:!0,min:-12.8,max:12.8,from:-3.2,to:3.2,step:.1}),$("#range_07").ionRangeSlider({type:"double",grid:!0,from:1,to:5,values:[0,10,100,1e3,1e4,1e5,1e6]}),$("#range_08").ionRangeSlider({grid:!0,from:5,values:["zero","one","two","three","four","five","six","seven","eight","nine","ten"]}),$("#range_09").ionRangeSlider({grid:!0,from:3,values:["January","February","March","April","May","June","July","August","September","October","November","December"]}),$("#range_10").ionRangeSlider({grid:!0,min:1e3,max:1e6,from:1e5,step:1e3,prettify_enabled:!1}),$("#range_11").ionRangeSlider({grid:!0,min:1e3,max:1e6,from:2e5,step:1e3,prettify_enabled:!0}),$("#range_12").ionRangeSlider({grid:!0,min:1e3,max:1e6,from:3e5,step:1e3,prettify_enabled:!0,prettify_separator:"."}),$("#range_13").ionRangeSlider({grid:!0,min:1e3,max:1e6,from:4e5,step:1e3,prettify_enabled:!0,prettify:function(e){return(Math.random()*e).toFixed(0)}}),$("#range_14").ionRangeSlider({type:"double",grid:!0,min:0,max:1e4,from:1e3,step:9e3,prefix:"$"}),$("#range_15").ionRangeSlider({type:"single",grid:!0,min:-90,max:90,from:0,postfix:"°"}),$("#range_16").ionRangeSlider({grid:!0,min:18,max:70,from:30,prefix:"Age ",max_postfix:"+"}),$("#range_17").ionRangeSlider({type:"double",min:100,max:200,from:145,to:155,prefix:"Weight: ",postfix:" million pounds",decorate_both:!0}),$("#range_18").ionRangeSlider({type:"double",min:100,max:200,from:145,to:155,prefix:"Weight: ",postfix:" million pounds",decorate_both:!1}),$("#range_19").ionRangeSlider({type:"double",min:100,max:200,from:148,to:152,prefix:"Weight: ",postfix:" million pounds",values_separator:" → "}),$("#range_20").ionRangeSlider({type:"double",min:100,max:200,from:148,to:152,prefix:"Range: ",postfix:" light years",decorate_both:!1,values_separator:" to "}),$("#range_21").ionRangeSlider({type:"double",min:1e3,max:2e3,from:1200,to:1800,hide_min_max:!0,hide_from_to:!0,grid:!1}),$("#range_22").ionRangeSlider({type:"double",min:1e3,max:2e3,from:1200,to:1800,hide_min_max:!0,hide_from_to:!0,grid:!0}),$("#range_23").ionRangeSlider({type:"double",min:1e3,max:2e3,from:1200,to:1800,hide_min_max:!1,hide_from_to:!0,grid:!1}),$("#range_24").ionRangeSlider({type:"double",min:1e3,max:2e3,from:1200,to:1800,hide_min_max:!0,hide_from_to:!1,grid:!1}),$("#range_25").ionRangeSlider({type:"double",min:1e6,max:2e6,grid:!0}),$("#range_26").ionRangeSlider({type:"double",min:1e6,max:2e6,grid:!0,force_edges:!0}),$("#range_27").ionRangeSlider({type:"double",min:0,max:1e4,grid:!0}),$("#range_28").ionRangeSlider({type:"double",min:0,max:1e4,grid:!0,grid_num:10}),$("#range_29").ionRangeSlider({type:"double",min:0,max:1e4,step:500,grid:!0,grid_snap:!0}),$("#range_30").ionRangeSlider({type:"single",min:0,max:10,step:2.34,grid:!0,grid_snap:!0}),$("#range_31").ionRangeSlider({type:"double",min:0,max:100,from:30,to:70,from_fixed:!0}),$("#range_32").ionRangeSlider({type:"double",min:0,max:100,from:30,to:70,from_fixed:!0,to_fixed:!0}),$("#range_33").ionRangeSlider({min:0,max:100,from:30,from_min:10,from_max:50}),$("#range_34").ionRangeSlider({min:0,max:100,from:30,from_min:10,from_max:50,from_shadow:!0}),$("#range_35").ionRangeSlider({type:"double",min:0,max:100,from:20,from_min:10,from_max:30,from_shadow:!0,to:80,to_min:70,to_max:90,to_shadow:!0,grid:!0,grid_num:10}),$("#range_36").ionRangeSlider({min:0,max:100,from:30,disable:!0}),$("#range_37").ionRangeSlider({type:"double",min:0,max:100,from:30,to:70,keyboard:!0}),$("#range_38").ionRangeSlider({type:"double",min:0,max:100,from:30,to:70,keyboard:!0,keyboard_step:20}),$("#range_39").ionRangeSlider({min:+moment().subtract(1,"years").format("X"),max:+moment().format("X"),from:+moment().subtract(6,"months").format("X"),prettify:function(e){return moment(e,"X").format("LL")}}),$("#range_40").ionRangeSlider({min:+moment().subtract(12,"hours").format("X"),max:+moment().format("X"),from:+moment().subtract(6,"hours").format("X"),prettify:function(e){return moment(e,"X").format("MMM Do, hh:mm A")}}),$("#range_41").ionRangeSlider({min:+moment().subtract(12,"hours").format("X"),max:+moment().format("X"),from:+moment().subtract(6,"hours").format("X"),grid:!0,force_edges:!0,prettify:function(e){return moment(e,"X").locale("ru").format("Do MMMM, HH:mm")}}),$("#range_42").ionRangeSlider({min:+moment().subtract(12,"hours").format("X"),max:+moment().format("X"),from:+moment().subtract(6,"hours").format("X"),grid:!0,force_edges:!0,prettify:function(e){return moment(e,"X").locale("ja").format("Do MMMM, LT")}}),$("#range_119").ionRangeSlider({type:"double",min:0,max:100,from:38,to:58,min_interval:20}),$("#range_120").ionRangeSlider({type:"double",min:0,max:100,from:41,to:91,max_interval:50}),$("#range_121").ionRangeSlider({type:"double",min:0,max:100,from:30,to:70,drag_interval:!0})});