$(function(){"use strict";function a(){$("#example-1to10").barrating("show",{theme:"bars-1to10"}),$("#example-movie").barrating("show",{theme:"bars-movie"}),$("#example-square").barrating("show",{theme:"bars-square",showValues:!0,showSelectedRating:!1}),$("#example-pill").barrating("show",{theme:"bars-pill",initialRating:"A",showValues:!0,showSelectedRating:!1,allowEmpty:!0,emptyValue:"-- no rating selected --",onSelect:function(e,a){alert("Selected rating: "+e)}}),$("#example-reversed").barrating("show",{theme:"bars-reversed",showSelectedRating:!0,reverse:!0}),$("#example-horizontal").barrating("show",{theme:"bars-horizontal",reverse:!0,hoverState:!1}),$("#example-fontawesome").barrating({theme:"fontawesome-stars",showSelectedRating:!1}),$("#example-css").barrating({theme:"css-stars",showSelectedRating:!1}),$("#example-bootstrap").barrating({theme:"bootstrap-stars",showSelectedRating:!1});var e=$("#example-fontawesome-o").data("current-rating");$(".stars-example-fontawesome-o .current-rating").find("span").html(e),$(".stars-example-fontawesome-o .clear-rating").on("click",function(e){e.preventDefault(),$("#example-fontawesome-o").barrating("clear")}),$("#example-fontawesome-o").barrating({theme:"fontawesome-stars-o",showSelectedRating:!1,initialRating:e,onSelect:function(e,a){e?($(".stars-example-fontawesome-o .current-rating").addClass("hidden"),$(".stars-example-fontawesome-o .your-rating").removeClass("hidden").find("span").html(e)):$("#example-fontawesome-o").barrating("clear")},onClear:function(e,a){$(".stars-example-fontawesome-o").find(".current-rating").removeClass("hidden").end().find(".your-rating").addClass("hidden")}})}$(".rating-enable").on("click",function(e){e.preventDefault(),a(),$(this).addClass("deactivated"),$(".rating-disable").removeClass("deactivated")}),$(".rating-disable").on("click",function(e){e.preventDefault(),$("select").barrating("destroy"),$(this).addClass("deactivated"),$(".rating-enable").removeClass("deactivated")}),a()});