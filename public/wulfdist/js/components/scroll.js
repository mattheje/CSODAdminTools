!function(a){"function"==typeof define&&define.amd?define(["jquery","malihu-custom-scrollbar-plugin"],a):"object"==typeof module&&module.exports?module.exports=function(b,c){return void 0===c&&(c="undefined"!=typeof window?require("jquery"):require("jquery")(b)),a(c,require("jquery-mousewheel"),require("malihu-custom-scrollbar-plugin")),c}:a(jQuery)}(function(a){"use strict";function b(b){return function(){a(b).parent().find(".n-dropdown-menu-scroll").mCustomScrollbar("update")}}a.fn.extend({nScrollbar:function(c){function d(b){if(a(b).find("thead").hasClass("n-table-thead")){a(b).find(".n-table-thead").addClass("table-scroll-thead"),a(b).find(".n-table-tbody").addClass("table-scroll-tbody");var c=a(b).find(".n-table-tbody").innerHeight(),d=a(b).find(".n-table-thead").innerHeight(),e=a(b).innerHeight();a(b).find(".n-table-tbody")&&null!==c&&e>c&&a(b).height(c+d-10),a(".n-table").parent().parent().parent().siblings(".mCSB_scrollTools_vertical").css("top","30px"),a(b).find(".mCSB_container > div").css("height",c-18+"px"),a(b).find(".mCustomScrollBox").css("padding",0),a(b).find("table").css("border",0)}}function e(b){if(a(b).find("thead").hasClass("n-table-thead")){var c=a(b).find(".n-table-tbody").innerHeight();a(b).find(".mCSB_container > div").height(c-18),a(b).find(".n-table-thead").css("top",-b.mcs.top+"px")}a(".dropdown-menu").each(function(){"block"===a(this).css("display")&&"fixed"===a(this).closest(".selectlist").data("position")&&a(this).parent().find("button.dropdown-toggle").trigger("click")}),a(".datepicker-calendar-wrapper").each(function(){if("block"===a(this).css("display")){var b=a(this).closest(".n-calendar").find("input");"fixed"===b.data("position")&&a(this).parent().find("button.dropdown-toggle").trigger("click")}})}var f=a(this);return"string"==typeof c?void f.mCustomScrollbar(c):((f.hasClass("n-dropdown-menu-scroll")||f.hasClass("tree-scroll")||f.hasClass("n-table-scrollbar")||f.hasClass("n-list-group-scroll")&&(f.find("li.n-list-group-item").length>0||f.find("dd.n-list-group-item").length>0))&&(c=a.extend({},c,{keyboard:{enable:!1}})),f.hasClass("n-table-scrollbar")&&f.find(".datepicker-calendar").length>0&&(c=a.extend({},c,{advanced:{autoScrollOnFocus:!1}})),(void 0!==c&&c.notAutoUpdate||f.hasClass("scrollbar-not-autoupdate"))&&(c=f.hasClass("n-table-scrollbar")&&f.find(".datepicker-calendar").length>0?a.extend({},c,{advanced:{autoScrollOnFocus:!1,updateOnContentResize:!1,updateOnImageLoad:!1,autoUpdateTimeout:100}}):a.extend({},c,{advanced:{updateOnContentResize:!1,updateOnImageLoad:!1,autoUpdateTimeout:100}}),f.hasClass("n-dropdown-menu-scroll")&&a(".dropdown-toggle").on("click",function(){setTimeout(b(this),10)})),c=a.extend({},c,{callbacks:{onInit:function(){d(this)},whileScrolling:function(){e(this)}}}),void f.mCustomScrollbar(c))}})});