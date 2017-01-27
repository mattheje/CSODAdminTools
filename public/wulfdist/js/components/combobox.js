!function(a){"function"==typeof define&&define.amd?define(["jquery","./dropdowns","fuelux/combobox"],a):"object"==typeof module&&module.exports?module.exports=function(b,c){return void 0===c&&(c="undefined"!=typeof window?require("jquery"):require("jquery")(b)),a(c,require("./dropdowns"),require("fuelux/combobox")),c}:a(jQuery)}(function($){"use strict";function getCurrentStrWidth(a,b){var c=$("<span>").hide().appendTo(document.body);""!==b.css("font")?$(c).html(a).css("font",b.css("font")):$(c).html(a).css("font-size",b.css("font-size"));var d=c.width();return c.remove(),d}function showDropdownItemTooltip(){var a=$(this);a.removeAttr("data-original-title"),a.removeAttr("title");var b=a.find("span").not(".checkbox"),c=getCurrentStrWidth(b.html(),b);c>a.width()?(b.addClass("active"),b.css("border-bottom-color","transparent"),a.attr("data-original-title",$(b).html()),a.tooltip("show")):a.tooltip("hide")}function doFilter(comboBox){if(0!==comboBox.find("ul").length){var allItems=comboBox.find("ul li"),size=allItems.size();if(""!==comboBox.find("input").val())for(var inputText=comboBox.find("input").val(),reg="/"+inputText.replace(/\*/g,".*")+"/gi",i=0;size>i;i++)eval(reg).test(allItems[i].textContent)?$(allItems[i]).removeClass("combobox-item-hidden"):$(allItems[i]).addClass("combobox-item-hidden");else for(var j=0;size>j;j++)$(allItems[j]).removeClass("combobox-item-hidden")}}function comboboxKeyboardHandler(a){var b=$(a.target);13===a.keyCode||32===a.keyCode?b.hasClass("n-clear-button-icon")&&(a.preventDefault(),b.trigger("click")):9===a.keyCode&&blurInDropdown(a)}function blurInDropdown(a){var b=$(a.target);9===a.keyCode&&a.shiftKey?"INPUT"===b[0].tagName&&$(a.currentTarget).hasClass("combobox-open")?$(a.currentTarget).find("button.dropdown-toggle").trigger("click"):b.hasClass("n-combobutton-btn")&&$(a.currentTarget).hasClass("open")&&$(a.currentTarget).find("button.dropdown-toggle").trigger("click"):9!==a.keyCode||a.shiftKey||"A"===b[0].tagName&&0===b.parent().nextAll(":not(.disabled)").length&&$(a.currentTarget).find("button.dropdown-toggle").trigger("click")}$(document).on("click.bs.dropdown.data-api",'[data-toggle="dropdown"]',function(){$(this).parents(".combobox").hasClass("n-page-combox")||$(".n-page-combox").removeClass("combobox-open");var a=$(".combobox-open");0!==a.length&&a.find("button").get(0)!==$(this).get(0)&&a.toggleClass("combobox-open"),0!==$(this).parents(".combobox").length&&$(this).parents(".combobox").toggleClass("combobox-open");var b=$(this).parents(".combobox");if($(b).hasClass("combobox-filter")){var c=b.find("input");if(c.focus(),$(b).hasClass("combobox-open")){$(c).on("input",function(){doFilter(b)});for(var d=b.find("ul li"),e=d.size(),f=0;e>f;f++)$(d[f]).removeClass("combobox-item-hidden")}else c.unbind("input");b.find("ul").addClass("combobox-filter-dropdown-menu")}}),$(document).on("keydown",".combobox input",function(a){var b=$(this).parent(".combobox");if(38===a.which||40===a.which){a.preventDefault();var c=jQuery.Event("keydown");c.which=a.which,b.find("button.dropdown-toggle").trigger(c),b.find("button.dropdown-toggle").focus()}b.hasClass("combobox-filter")&&!b.hasClass("combobox-open")&&(229===a.which||65===a.which||a.which>=48&&a.which<=57||a.which>65&&a.which<=111||a.which>=186&&a.which<=222)&&b.find("button.dropdown-toggle").trigger("click")}),$(document).on("click.bs.dropdown.data-api",function(){var a=$(".combobox-open");0!==a.length&&(a.hasClass("combobox-filter")?a.find("input").is(":focus")?(a.find(".input-group-btn").addClass("open"),a.find("button").attr("aria-expanded","true")):(a.find("input").unbind("input"),a.removeClass("combobox-open")):a.removeClass("combobox-open"))}),$(document).on("mouseenter",".dropdown .dropdown-menu li a",showDropdownItemTooltip).on("focus",".dropdown .dropdown-menu li a",showDropdownItemTooltip).on("mouseleave",".dropdown .dropdown-menu li a",function(){var a=$(this),b=a.find("span").not(".checkbox");b.css("border-bottom-color",""),b.removeClass("active")}).on("blur",".dropdown .dropdown-menu li a",function(){var a=$(this),b=a.find("span").not(".checkbox");b.css("border-bottom-color",""),b.removeClass("active")}).on("mouseenter",".n-combobutton .dropdown-menu li a",showDropdownItemTooltip).on("focus",".n-combobutton .dropdown-menu li a",showDropdownItemTooltip).on("mouseleave",".n-combobutton .dropdown-menu li a",function(){var a=$(this),b=a.find("span").not(".checkbox");b.css("border-bottom-color",""),b.removeClass("active")}).on("blur",".n-combobutton .dropdown-menu li a",function(){var a=$(this),b=a.find("span").not(".checkbox");b.css("border-bottom-color",""),b.removeClass("active")}),$(document).on("keyup change",".n-cancel-button input",function(a){var b=a.target.value,c=$(a.target).next(".n-clear-button-icon");b.length>0?c.show():c.hide()}),$(document).on("click",".n-clear-button-icon",function(){var a=$(this).prev();a.hasClass("n-inputfield")&&($(this).hide(),a.val(""),a.focus())}),$(document).ready(function(){$(document).on("shown.bs.dropdown",".combobox, .n-combobutton",function(){$(this).find("ul.dropdown-menu li a").each(function(){var a=$(this),b="tooltip"===a.attr("data-toggle"),c=a[0].offsetWidth<a[0].scrollWidth;c?b?a.tooltip("enable"):(a.attr("title",a.text()),a.attr("data-toggle","tooltip"),a.attr("data-placement","right"),a.tooltip()):b&&!c&&a.tooltip("disable")})})}),$(document).on("keydown.wf.combobox.keyboard",".combobox",comboboxKeyboardHandler),$(document).on("keydown.wf.combobox.keyboard",".n-combobutton",blurInDropdown)});