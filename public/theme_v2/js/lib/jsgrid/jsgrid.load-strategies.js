!function(t,i,n){function e(t){this._grid=t}function r(t){this._grid=t,this._itemsCount=0}e.prototype={firstDisplayIndex:function(){var t=this._grid;return t.option("paging")?(t.option("pageIndex")-1)*t.option("pageSize"):0},lastDisplayIndex:function(){var t=this._grid,i=t.option("data").length;return t.option("paging")?Math.min(t.option("pageIndex")*t.option("pageSize"),i):i},itemsCount:function(){return this._grid.option("data").length},openPage:function(t){this._grid.refresh()},loadParams:function(){return{}},sort:function(){return this._grid._sortData(),this._grid.refresh(),i.Deferred().resolve().promise()},reset:function(){return this._grid.refresh(),i.Deferred().resolve().promise()},finishLoad:function(t){this._grid.option("data",t)},finishInsert:function(t){var i=this._grid;i.option("data").push(t),i.refresh()},finishDelete:function(t,i){var n=this._grid;n.option("data").splice(i,1),n.reset()}},r.prototype={firstDisplayIndex:function(){return 0},lastDisplayIndex:function(){return this._grid.option("data").length},itemsCount:function(){return this._itemsCount},openPage:function(t){this._grid.loadData()},loadParams:function(){var t=this._grid;return{pageIndex:t.option("pageIndex"),pageSize:t.option("pageSize")}},reset:function(){return this._grid.loadData()},sort:function(){return this._grid.loadData()},finishLoad:function(t){this._itemsCount=t.itemsCount,this._grid.option("data",t.data)},finishInsert:function(t){this._grid.search()},finishDelete:function(t,i){this._grid.search()}},t.loadStrategies={DirectLoadingStrategy:e,PageLoadingStrategy:r}}(jsGrid,jQuery);