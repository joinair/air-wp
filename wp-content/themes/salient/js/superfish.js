!function(e){"use strict";var s=function(){var s={bcClass:"sf-breadcrumb",menuClass:"sf-js-enabled",anchorClass:"sf-with-ul",menuArrowClass:"sf-arrows"},t=function(){var s=/iPhone|iPad|iPod/i.test(navigator.userAgent);return s&&e(window).load(function(){e("body").children().on("click",e.noop)}),s}(),n=function(){var e=document.documentElement.style;return"behavior"in e&&"fill"in e&&/iemobile/i.test(navigator.userAgent)}(),o=function(e,t){var n=s.menuClass;t.cssArrows&&(n+=" "+s.menuArrowClass),e.toggleClass(n)},i=function(t,n){return t.find("li."+n.pathClass).slice(0,n.pathLevels).addClass(n.hoverClass+" "+s.bcClass).filter(function(){return e(this).children(n.popUpSelector).hide().show().length}).removeClass(n.pathClass)},r=function(e){e.children("a").toggleClass(s.anchorClass)},a=function(e){var s=e.css("ms-touch-action");s="pan-y"===s?"auto":"pan-y",e.css("ms-touch-action",s)},l=function(s,o){var i="li:has("+o.popUpSelector+")";e.fn.hoverIntent&&!o.disableHI?s.hoverIntent(p,u,i):s.on("mouseenter.superfish",i,p).on("mouseleave.superfish",i,u);var r="MSPointerDown.superfish";t||(r+=" touchend.superfish"),n&&(r+=" mousedown.superfish"),s.on("focusin.superfish","li",p).on("focusout.superfish","li",u).on(r,"a",o,h)},h=function(s){var t=e(this),n=t.siblings(s.data.popUpSelector);n.length>0&&n.is(":hidden")&&(t.one("click.superfish",!1),"MSPointerDown"===s.type?t.trigger("focus"):e.proxy(p,t.parent("li"))())},p=function(){var s=e(this),t=d(s);clearTimeout(t.sfTimer),s.siblings().superfish("hide").end().superfish("show")},u=function(){var s=e(this),n=d(s);t?e.proxy(f,s,n)():(clearTimeout(n.sfTimer),n.sfTimer=setTimeout(e.proxy(f,s,n),n.delay))},f=function(s){s.retainPath=e.inArray(this[0],s.$path)>-1,this.superfish("hide"),this.parents("."+s.hoverClass).length||(s.onIdle.call(c(this)),s.$path.length&&e.proxy(p,s.$path)())},c=function(e){return e.closest("."+s.menuClass)},d=function(e){return c(e).data("sf-options")};return{hide:function(s){if(this.length){var t=this,n=d(t);if(!n)return this;var o=n.retainPath===!0?n.$path:"",i=t.find("li."+n.hoverClass).add(this).not(o).removeClass(n.hoverClass).children(n.popUpSelector),r=n.speedOut;s&&(i.show(),r=0),n.retainPath=!1,n.onBeforeHide.call(i),i.stop(!0,!0).animate(n.animationOut,r,function(){var s=e(this);n.onHide.call(s)})}return this},show:function(){var s=d(this);if(!s)return this;var t=this.addClass(s.hoverClass),n=t.children(s.popUpSelector);if(s.onBeforeShow.call(n),!e(n).parents("li").hasClass("megamenu")&&!e(n).parents("ul").hasClass("sub-menu")&&n.offset()){n.addClass("temp-hidden-display");var o=e("#top .container").width(),i=n,r=i.offset(),a=r.left-(e(window).width()-o)/2,l=i.width(),h=a+l<=e(window).width()-100;h?n.parents("li").removeClass("edge"):n.parents("li").addClass("edge"),n.removeClass("temp-hidden-display")}return n.stop(!0,!0).animate(s.animation,s.speed,function(){s.onShow.call(n)}),this},destroy:function(){return this.each(function(){var t,n=e(this),i=n.data("sf-options");return i?(t=n.find(i.popUpSelector).parent("li"),clearTimeout(i.sfTimer),o(n,i),r(t),a(n),n.off(".superfish").off(".hoverIntent"),t.children(i.popUpSelector).attr("style",function(e,s){return s.replace(/display[^;]+;?/g,"")}),i.$path.removeClass(i.hoverClass+" "+s.bcClass).addClass(i.pathClass),n.find("."+i.hoverClass).removeClass(i.hoverClass),i.onDestroy.call(n),void n.removeData("sf-options")):!1})},init:function(t){return this.each(function(){var n=e(this);if(n.data("sf-options"))return!1;var h=e.extend({},e.fn.superfish.defaults,t),p=n.find(h.popUpSelector).parent("li");h.$path=i(n,h),n.data("sf-options",h),o(n,h),r(p),a(n),l(n,h),p.not("."+s.bcClass).superfish("hide",!0),h.onInit.call(this)})}}}();e.fn.superfish=function(t,n){return s[t]?s[t].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof t&&t?e.error("Method "+t+" does not exist on jQuery.fn.superfish"):s.init.apply(this,arguments)},e.fn.superfish.defaults={popUpSelector:"ul,.sf-mega",hoverClass:"sfHover",pathClass:"overrideThisToUse",pathLevels:1,delay:800,animation:{opacity:"show"},animationOut:{opacity:"hide"},speed:"normal",speedOut:"fast",cssArrows:!0,disableHI:!1,onInit:e.noop,onBeforeShow:e.noop,onShow:e.noop,onBeforeHide:e.noop,onHide:e.noop,onIdle:e.noop,onDestroy:e.noop},e.fn.extend({hideSuperfishUl:s.hide,showSuperfishUl:s.show})}(jQuery);