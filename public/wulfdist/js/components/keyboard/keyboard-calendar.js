!function(a){"function"==typeof define&&define.amd?define(["jquery","./keyboard-table"],a):"object"==typeof module&&module.exports?module.exports=function(b,c){return void 0===c&&(c="undefined"!=typeof window?require("jquery"):require("jquery")(b)),a(c,require("./keyboard-table")),c}:a(jQuery)}(function(a){"use strict";function b(b,c){var d=a(b.target);d.closest("table").find("td").each(function(){a(this).removeClass(c)})}function c(b,c){a.wfKBTable.handleTableDirectionKeyAction(b,c)}function d(b,c){var d=a(b.target);d.removeAttr("tabindex"),d.closest(".datepicker-calendar-days").find("td").each(function(){a(this).removeClass(c)})}var e=13,f=32,g=37,h=39,i=38,j=40,k=9;a.wfKBCalendar={calendarKeyboardHandler:function(l){var m=[k,f,e,g,h,i,j],n="selected";if(-1!==m.indexOf(l.which))switch(b(l,n),l.keyCode){case g:case h:case i:case j:c(l,n);break;case k:d(l,n);break;case f:case e:a(l.target).find("button").trigger("click")}},calendarFocusinHandler:function(c){var d=a(c.target).closest("td");d.hasClass("selected")||b(c,"selected")}}});