!function(m){m.plot.plugins.push({init:function(o){function h(o,s,t,n,l){var h,r,e,i,p,u=t.pointsize,a=m.extend({},s);a.datapoints={points:[],pointsize:u,format:t.format},a.label=null,a.color=l,a.threshold=null,a.originSeries=s,a.data=[];var f,d=t.points,c=s.lines.show,g=[],b=[];for(h=0;h<d.length;h+=u){if(r=d[h],p=i,i=(e=d[h+1])<n?g:b,c&&p!=i&&null!=r&&0<h&&null!=d[h-u]){var v=r+(n-e)*(r-d[h-u])/(e-d[h-u+1]);for(p.push(v),p.push(n),f=2;f<u;++f)p.push(d[h+f]);for(i.push(null),i.push(null),f=2;f<u;++f)i.push(d[h+f]);for(i.push(v),i.push(n),f=2;f<u;++f)i.push(d[h+f])}for(i.push(r),i.push(e),f=2;f<u;++f)i.push(d[h+f])}if(t.points=b,a.datapoints.points=g,0<a.datapoints.points.length){var w=m.inArray(s,o.getData());o.getData().splice(w+1,0,a)}}o.hooks.processDatapoints.push(function(t,n,l){n.threshold&&(n.threshold instanceof Array?(n.threshold.sort(function(o,s){return o.below-s.below}),m(n.threshold).each(function(o,s){h(t,n,l,s.below,s.color)})):h(t,n,l,n.threshold.below,n.threshold.color))})},options:{series:{threshold:null}},name:"threshold",version:"1.2"})}(jQuery);