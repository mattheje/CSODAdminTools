!function(a){"function"==typeof define&&define.amd?define(["jquery","bootstrap","fuelux/selectlist","./inputfield"],a):"object"==typeof module&&module.exports?module.exports=function(b,c){return void 0===c&&(c="undefined"!=typeof window?require("jquery"):require("jquery")(b)),a(c,require("bootstrap"),require("fuelux"),require("./inputfield")),c}:a(jQuery)}(function(a){"use strict";function b(b){return this.each(function(){var c=a(this),d=c.data("wf.search"),e="object"==typeof b&&b;(d||!/destroy|hide/.test(b))&&(d||c.data("wf.search",d=new g(this,e)),"string"==typeof b&&d[b]())})}function c(){a(this).parent(".n-search").hasClass("open")&&(a(this).parent(".n-search").removeClass("open"),a(this).prev(".dropdown-toggle").attr("aria-expanded","false"))}function d(){a(this).parent(".n-search-clearable").hasClass("open")&&a(this).siblings(".n-inputfield").is(":focus")&&a(this).parent().addClass("n-search-input-move"),a(this).siblings(".dropdown-toggle").is(":focus")&&!a(this).parent().hasClass("open")&&a(this).parent().addClass("n-search-dropdown-focus")}function e(){a(this).parent().removeClass("n-search-input-move"),a(this).parent().removeClass("n-search-dropdown-focus")}function f(){a(this).parent().siblings(".n-search-input").attr("placeholder",a(this).find("a>span").html()),a(this).parent().siblings(".n-search-input").focus()}var g=function(a,b){};if(!a.fn.nInputField)throw new Error("Balloon requires WULF inputfield.js");g.VERSION="1.1.0",g.prototype=a.extend({},a.fn.nInputField.Constructor.prototype),g.prototype.constructor=g;var h=a.fn.nSearch;a.fn.nSearch=b,a.fn.nSearch.Constructor=g,a.fn.nSearch.noConflict=function(){return a.fn.nSearch=h,this},a(document).on("click.wf.forms",".n-search-clearable .n-search-control-icon",g.prototype.clearContent).on("click.wf.forms",".dropdown-menu>li",f).on("click.wf.search.mouse",".n-search-input",c).on("mouseover.wf.search.mouse",".n-search-control-icon",d).on("mouseleave.wf.search.mouse",".n-search-control-icon",e).on("mouseover.wf.search.mouse",".n-search-button",d).on("mouseleave.wf.search.mouse",".n-search-button",e).on("keypress.wf.search.keyboard",".n-search-input",c)});