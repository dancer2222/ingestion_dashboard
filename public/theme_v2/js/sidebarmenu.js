!function(n,i){if("function"==typeof define&&define.amd)define(["jquery"],i);else if("undefined"!=typeof exports)i(require("jquery"));else{i(n.jquery),n.metisMenu={}}}(this,function(n){"use strict";var i;(i=n)&&i.__esModule;var o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(n){return typeof n}:function(n){return n&&"function"==typeof Symbol&&n.constructor===Symbol&&n!==Symbol.prototype?"symbol":typeof n};var a,t,r,e,s,l,c,g,f=function(e){var i=!1,t={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};function n(n){var i=this,t=!1;return e(this).one(s.TRANSITION_END,function(){t=!0}),setTimeout(function(){t||s.triggerTransitionEnd(i)},n),this}var s={TRANSITION_END:"mmTransitionEnd",triggerTransitionEnd:function(n){e(n).trigger(i.end)},supportsTransitionEnd:function(){return Boolean(i)}};return i=function(){if(window.QUnit)return!1;var n=document.createElement("mm");for(var i in t)if(void 0!==n.style[i])return{end:t[i]};return!1}(),e.fn.emulateTransitionEnd=n,s.supportsTransitionEnd()&&(e.event.special[s.TRANSITION_END]={bindType:i.end,delegateType:i.end,handle:function(n){if(e(n.target).is(this))return n.handleObj.handler.apply(this,arguments)}}),s}(jQuery);a=jQuery,e="."+(r=t="metisMenu"),s=a.fn[t],l={toggle:!0,preventDefault:!0,activeClass:"active",collapseClass:"collapse",collapseInClass:"in",collapsingClass:"collapsing",triggerElement:"a",parentTrigger:"li",subMenu:"ul"},c={SHOW:"show"+e,SHOWN:"shown"+e,HIDE:"hide"+e,HIDDEN:"hidden"+e,CLICK_DATA_API:"click"+e+".data-api"},g=function(){function s(n,i){!function(n,i){if(!(n instanceof i))throw new TypeError("Cannot call a class as a function")}(this,s),this._element=n,this._config=this._getConfig(i),this._transitioning=null,this.init()}return s.prototype.init=function(){var o=this;a(this._element).find(this._config.parentTrigger+"."+this._config.activeClass).has(this._config.subMenu).children(this._config.subMenu).attr("aria-expanded",!0).addClass(this._config.collapseClass+" "+this._config.collapseInClass),a(this._element).find(this._config.parentTrigger).not("."+this._config.activeClass).has(this._config.subMenu).children(this._config.subMenu).attr("aria-expanded",!1).addClass(this._config.collapseClass),a(this._element).find(this._config.parentTrigger).has(this._config.subMenu).children(this._config.triggerElement).on(c.CLICK_DATA_API,function(n){var i=a(this),t=i.parent(o._config.parentTrigger),e=t.siblings(o._config.parentTrigger).children(o._config.triggerElement),s=t.children(o._config.subMenu);o._config.preventDefault&&n.preventDefault(),"true"!==i.attr("aria-disabled")&&(t.hasClass(o._config.activeClass)?(i.attr("aria-expanded",!1),o._hide(s)):(o._show(s),i.attr("aria-expanded",!0),o._config.toggle&&e.attr("aria-expanded",!1)),o._config.onTransitionStart&&o._config.onTransitionStart(n))})},s.prototype._show=function(n){if(!this._transitioning&&!a(n).hasClass(this._config.collapsingClass)){var i=this,t=a(n),e=a.Event(c.SHOW);if(t.trigger(e),!e.isDefaultPrevented()){t.parent(this._config.parentTrigger).addClass(this._config.activeClass),this._config.toggle&&this._hide(t.parent(this._config.parentTrigger).siblings().children(this._config.subMenu+"."+this._config.collapseInClass).attr("aria-expanded",!1)),t.removeClass(this._config.collapseClass).addClass(this._config.collapsingClass).height(0),this.setTransitioning(!0);var s=function(){t.removeClass(i._config.collapsingClass).addClass(i._config.collapseClass+" "+i._config.collapseInClass).height("").attr("aria-expanded",!0),i.setTransitioning(!1),t.trigger(c.SHOWN)};f.supportsTransitionEnd()?t.height(t[0].scrollHeight).one(f.TRANSITION_END,s).emulateTransitionEnd(350):s()}}},s.prototype._hide=function(n){if(!this._transitioning&&a(n).hasClass(this._config.collapseInClass)){var i=this,t=a(n),e=a.Event(c.HIDE);if(t.trigger(e),!e.isDefaultPrevented()){t.parent(this._config.parentTrigger).removeClass(this._config.activeClass),t.height(t.height())[0].offsetHeight,t.addClass(this._config.collapsingClass).removeClass(this._config.collapseClass).removeClass(this._config.collapseInClass),this.setTransitioning(!0);var s=function(){i._transitioning&&i._config.onTransitionEnd&&i._config.onTransitionEnd(),i.setTransitioning(!1),t.trigger(c.HIDDEN),t.removeClass(i._config.collapsingClass).addClass(i._config.collapseClass).attr("aria-expanded",!1)};f.supportsTransitionEnd()?0==t.height()||"none"==t.css("display")?s():t.height(0).one(f.TRANSITION_END,s).emulateTransitionEnd(350):s()}}},s.prototype.setTransitioning=function(n){this._transitioning=n},s.prototype.dispose=function(){a.removeData(this._element,r),a(this._element).find(this._config.parentTrigger).has(this._config.subMenu).children(this._config.triggerElement).off("click"),this._transitioning=null,this._config=null,this._element=null},s.prototype._getConfig=function(n){return n=a.extend({},l,n)},s._jQueryInterface=function(e){return this.each(function(){var n=a(this),i=n.data(r),t=a.extend({},l,n.data(),"object"===(void 0===e?"undefined":o(e))&&e);if(!i&&/dispose/.test(e)&&this.dispose(),i||(i=new s(this,t),n.data(r,i)),"string"==typeof e){if(void 0===i[e])throw new Error('No method named "'+e+'"');i[e]()}})},s}(),a.fn[t]=g._jQueryInterface,a.fn[t].Constructor=g,a.fn[t].noConflict=function(){return a.fn[t]=s,g._jQueryInterface}});