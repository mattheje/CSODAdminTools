!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?module.exports=a(require("jquery")):a(jQuery)}(function(a){var b=a.fn.loader,c=function(b,c){this.$element=a(b),this.options=a.extend({},a.fn.loader.defaults,c),this.begin=this.$element.is("[data-begin]")?parseInt(this.$element.attr("data-begin"),10):1,this.delay=this.$element.is("[data-delay]")?parseFloat(this.$element.attr("data-delay")):150,this.end=this.$element.is("[data-end]")?parseInt(this.$element.attr("data-end"),10):8,this.frame=this.$element.is("[data-frame]")?parseInt(this.$element.attr("data-frame"),10):this.begin,this.isIElt9=!1,this.timeout={};var d=this.msieVersion();d!==!1&&9>d&&(this.$element.addClass("iefix"),this.isIElt9=!0),this.$element.attr("data-frame",this.frame+""),this.play()};c.prototype={constructor:c,destroy:function(){return this.pause(),this.$element.remove(),this.$element[0].outerHTML},ieRepaint:function(){this.isIElt9&&this.$element.addClass("iefix_repaint").removeClass("iefix_repaint")},msieVersion:function(){var a=window.navigator.userAgent,b=a.indexOf("MSIE ");return b>0?parseInt(a.substring(b+5,a.indexOf(".",b)),10):!1},next:function(){this.frame++,this.frame>this.end&&(this.frame=this.begin),this.$element.attr("data-frame",this.frame+""),this.ieRepaint()},pause:function(){clearTimeout(this.timeout)},play:function(){var a=this;clearTimeout(this.timeout),this.timeout=setTimeout(function(){a.next(),a.play()},this.delay)},previous:function(){this.frame--,this.frame<this.begin&&(this.frame=this.end),this.$element.attr("data-frame",this.frame+""),this.ieRepaint()},reset:function(){this.frame=this.begin,this.$element.attr("data-frame",this.frame+""),this.ieRepaint()}},a.fn.loader=function(b){var d,e=Array.prototype.slice.call(arguments,1),f=this.each(function(){var f=a(this),g=f.data("fu.loader"),h="object"==typeof b&&b;g||f.data("fu.loader",g=new c(this,h)),"string"==typeof b&&(d=g[b].apply(g,e))});return void 0===d?f:d},a.fn.loader.defaults={},a.fn.loader.Constructor=c,a.fn.loader.noConflict=function(){return a.fn.loader=b,this},a(function(){a("[data-initialize=loader]").each(function(){var b=a(this);b.data("fu.loader")||b.loader(b.data())})})});