/**
 * Cuevas Western Wear - Home Page Animations
 * 
 * Features:
 * - Smooth scrolling with Lenis
 * - Section snapping with GSAP ScrollTrigger
 * - Responsive touch and wheel controls
 * - Smooth slider transitions
 * - Parallax effects
 * - Keyboard navigation and accessibility
 */

// Lenis smooth scrolling - inline version (if CDN fails)
!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):(e="undefined"!=typeof globalThis?globalThis:e||self).Lenis=t()}(this,(function(){"use strict";function e(e,t){for(var i=0;i<t.length;i++){var o=t[i];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}function t(e,t,i){return t in e?Object.defineProperty(e,t,{value:i,enumerable:!0,configurable:!0,writable:!0}):e[t]=i,e}function i(e,t){var i=Object.keys(e);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(e);t&&(o=o.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),i.push.apply(i,o)}return i}function o(e){for(var o=1;o<arguments.length;o++){var s=null!=arguments[o]?arguments[o]:{};o%2?i(Object(s),!0).forEach((function(i){t(e,i,s[i])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(s)):i(Object(s)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(s,t))}))}return e}function s(e){return function(e){if(Array.isArray(e))return n(e)}(e)||function(e){if("undefined"!=typeof Symbol&&null!=e[Symbol.iterator]||null!=e["@@iterator"])return Array.from(e)}(e)||function(e,t){if(!e)return;if("string"==typeof e)return n(e,t);var i=Object.prototype.toString.call(e).slice(8,-1);"Object"===i&&e.constructor&&(i=e.constructor.name);if("Map"===i||"Set"===i)return Array.from(e);if("Arguments"===i||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(i))return n(e,t)}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function n(e,t){(null==t||t>e.length)&&(t=e.length);for(var i=0,o=new Array(t);i<t;i++)o[i]=e[i];return o}function r(e,t){var i=arguments.length>2&&void 0!==arguments[2]?arguments[2]:0;if(0===t||Math.abs(t)===1/0)return i;var o=t,s=Math.abs(o),n=0;if(1===arguments.length)return e;for(;s>=1;)n++,s/=10;return n<=i?Number(e.toFixed(i)):parseInt(e*Math.pow(10,-(n-i)))/Math.pow(10,i)}function l(e,t){var i=t.wheelMultiplier||1,o=t.touchMultiplier||1,s=t.normalizeWheel||!1;return e.forEach((function(e){var t=0,r=0,l=0,c=0,a=0,h=0,u=0;e.addEventListener("wheel",(function(e){if(!e.defaultPrevented){s?(t+=e.deltaX||0,r+=e.deltaY||0,l+=e.deltaZ||0,c=Math.sqrt(t*t+r*r),a=Math.max(-1,Math.min(1,r)),h=Math.max(-1,Math.min(1,t)),u=e.detail||0):(t=e.wheelDeltaX||0,r=-e.deltaY||e.wheelDeltaY||0,l=0,c=Math.sqrt(t*t+r*r),a=Math.max(-1,Math.min(1,r>0?-1:1)),h=Math.max(-1,Math.min(1,t>0?-1:1)));var o=r*i,f=t*i;c<=20&&(o=Math.max(-20,Math.min(20,o)),f=Math.max(-20,Math.min(20,f))),n(e,{deltaX:f,deltaY:o,deltaZ:l,angle:a,axisX:h,axis:a?"y":"x",detail:u})}})),e.addEventListener("touchstart",(function(e){f=e.targetTouches?e.targetTouches[0]:e,d=Date.now(),p=f.pageX,m=f.pageY})),e.addEventListener("touchmove",(function(e){if(!e.defaultPrevented){var t=e.targetTouches?e.targetTouches[0]:e,i=t.pageX,s=t.pageY,r=i-p,l=s-m,c=e.timeStamp-d,a=Math.max(-1,Math.min(1,l>0?-1:1)),h=Math.max(-1,Math.min(1,r>0?-1:1));c<=100||n(e,{deltaX:r*o,deltaY:l*o,deltaZ:0,angle:a,axisX:h,axis:Math.abs(l)>=Math.abs(r)?"y":"x",detail:0})}})),e.addEventListener("touchend",(function(e){}))})),{onNormalize:n};var f,d,p,m;function n(t,i){var o=t.currentTarget;if(!o)return!1;var s=o.__slidr;s||(s=o.__slidr={active:!1,touchstart:!1,keydown:!1,deltaX:0,deltaY:0,timeStart:0,timeMove:0,transition:{easing:"linear",duration:0},watchTimeout:null},o.__slidr=s);var n=s;if("touchstart"===t.type)clearTimeout(n.watchTimeout),n.touchstart=!0,n.active=!1,n.timeStart=Date.now();else if("wheel"===t.type)clearTimeout(n.watchTimeout),n.active=!0,n.touchstart=!1,n.timeStart=Date.now();else if("touchmove"===t.type)if(!1===n.active&&!1===n.touchstart)n.touchstart=!0;else{var r=Date.now();n.timeMove=r,n.active=!0}else"resize"!==t.type&&"touchend"!==t.type&&"touchcancel"!==t.type||(n.active=!1,n.touchstart=!1,n.keydown=!1);void 0===i&&(i={deltaX:0,deltaY:0}),n.deltaX=i.deltaX,n.deltaY=i.deltaY,i.timeStamp=Date.now(),function(t,i,o){var s=o.timeStamp,n=t.scrollTop,r=t.scrollLeft,l=t.scrollWidth,c=t.scrollHeight,a=t.clientWidth,h=t.clientHeight,u=r+a>=l,f=n+h>=c,d=r<=0,p=n<=0,m=i.deltaX,v=i.deltaY;if("wheel"===o.type||"touchmove"===o.type)if("x"===o.axis&&(u&&m>0||d&&m<0)||"y"===o.axis&&(f&&v>0||p&&v<0))return!1;var g={target:t,timeStamp:s,x:r,y:n,deltaX:m,deltaY:v,type:o.type,axis:o.axis,axisX:o.axisX,angle:o.angle,detail:o.detail||0};e.__slidr||(e.__slidr={callbacks:[]}),e.__slidr.callbacks.forEach((function(e){return e(g)})),o.stopPropagation()}}return l.subscribe=function(t){return e.__slidr||(e.__slidr={callbacks:[]}),e.__slidr.callbacks.push(t),function(){var i=e.__slidr.callbacks.indexOf(t);-1!==i&&e.__slidr.callbacks.splice(i,1)}},l.unsubscribe=function(t){if(e.__slidr){var i=e.__slidr.callbacks.indexOf(t);-1!==i&&e.__slidr.callbacks.splice(i,1)}},l}var c,a={lerp:function(e,t,i){return e*(1-i)+t*i},clamp:function(e,t,i){return Math.min(Math.max(e,t),i)},clampScroll:function(e,t){return a.clamp(e,0,t)},clampRound:function(e,t,i){return a.clamp(Math.round(e),t,i)}};function h(e){return{x:window.pageXOffset||e.scrollX||document.documentElement.scrollLeft||0,y:window.pageYOffset||e.scrollY||document.documentElement.scrollTop||0}}var u=function(){function t(i){var s=this,n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t),c=this,this.onVirtualScroll=function(e){var t=e.deltaX,i=e.deltaY,o=e.type,n=Date.now(),r="touchmove"===o;if(!((r||!s.isStopped&&!s.isLocked)&&0!==i)){if(!r&&s.isStopped&&"wheel"===o&&Math.abs(i)>75)return s.isStopped=!1,void(s.isScrolling=!1);var l=Math.abs(t)>=Math.abs(i)&&Math.abs(t)>1,a=l?"x":"y";s.isScrolling||"x"!==a&&"y"!==s.options.orientation||s.onScrollStart(e),s.isScrolling=!0;var h=n-s.lastFrameTime,u=h>200;s.lastFrameTime=n,!u&&(s.options.infinite?s.velocity[a]+=(l?t:i)*(s.options.multiplier||1):s.isLocked||s.currentScroll>s.maxScroll||s.currentScroll<0?s.velocity[a]+=(l?t:i)*(s.options.multiplier||1)*.5:s.velocity[a]+=(l?t:i)*(s.options.multiplier||1)),(!s.lastDelta[a]||Math.abs(s.lastDelta[a])>Math.abs(l?t:i))&&(s.lastDelta[a]=l?t:i)}},this.onScroll=function(e){var t=s.clampScroll(s.animatedScroll),i=s.clampScroll(s.targetScroll),o=Math.abs(t-i)<=.2;if(!s.isScrolling||o)return s.animatedScroll=i,s.animate(),s.isScrolling&&s.onScrollEnd(),s.isScrolling=!1,!1;var n=s.dimensions.scrollHeight||0;s.options.infinite||(s.options.currentScroll<=0&&s.targetScroll<=0&&(s.targetScroll=0),s.options.currentScroll>=s.maxScroll&&s.targetScroll>=n-s.dimensions.height&&(s.targetScroll=s.maxScroll)),s.animatedScroll=a.lerp(s.animatedScroll,s.targetScroll,1-Math.pow(s.options.smoothWheel||s.options.smooth,h/16.67)),s.animate()};var u=n.wrapper,f=n.content,d=n.autoResize,p=void 0===d||d,v=n.duration,g=void 0===v?1.2:v,m=n.easing,y=void 0===m?function(e){return Math.min(1,1.001-Math.pow(2,-10*e))}:m,b=n.smooth,S=void 0===b?.1:b,w=n.touchMultiplier,O=void 0===w?2:w,E=n.direction,T=void 0===E?"vertical":E,M=n.gestureDirection,X=void 0===M?"vertical":M,I=n.infinite,R=void 0!==I&&I,z=n.wrapper,W=void 0===z?window:z,k=n.content,L=void 0===k?document.documentElement:k,Y=n.wheelMultiplier,A=void 0===Y?1:Y,D=n.touchMultiplier,j=void 0===D?1:D,Z=n.normalizeWheel,_=void 0!==Z&&Z,C=n.momentum,P=void 0===C||C,H={x:0,y:0},N={x:0,y:0},B={x:0,y:0},F=0,x=0,$={x:0,y:0},{el:q,options:U,targetScroll:G,animatedScroll:J,dimensions:K,currentScroll:Q,isLocked:V,isStopped:ee,isScrolling:te,lastFrameTime:ie,velocity:oe,lastDelta:se}={el:L,options:{wrapper:W,autoResize:p,smooth:S,duration:g,easing:y,touchMultiplier:O,direction:T,gestureDirection:X,smooth:S,mouseMultiplier:A,wheelMultiplier:A,touchMultiplier:j,normalizeWheel:_,infinite:R,momentum:P},targetScroll:0,animatedScroll:0,dimensions:{width:0,height:0,scrollWidth:0,scrollHeight:0},currentScroll:0,isLocked:!1,isStopped:!1,isScrolling:!1,velocity:{x:0,y:0},lastFrameTime:0,lastDelta:{x:null,y:null},clampScroll:function(e){return R?e:a.clamp(e,0,F)}};this.el=q,this.options=U,this.targetScroll=G,this.animatedScroll=J,this.dimensions=K,this.currentScroll=Q,this.isLocked=V,this.isStopped=ee,this.isScrolling=te,this.lastFrameTime=ie,this.velocity=oe,this.lastDelta=se,this.clampScroll=ne,this.__=function(){return{get isSmooth(){return"smooth"in s.options&&(S>0||s.options.smooth>0&&!s.isTouching)}}};var re=u||window,le="vertical"===X?"y":"x",ce="vertical"===(T||X);this.direction=le,this.isTouching=!1;var ae=null;this.maxScroll=F,this.event={},this.listeners={},window.lenisVersion="1.0.0",window.lenis=this,this.onVirtualScroll=this.onVirtualScroll.bind(this),this.onScroll=this.onScroll.bind(this);var he=document.documentElement,ue=re===window,fe=ue?he:"string"==typeof re?document.querySelector(re):re,de=ue?function(){return h(re)}:function(){return{x:fe.scrollLeft,y:fe.scrollTop}},pe=ue?function(e,t){var i=t.x,o=t.y;return window.scroll(i,o)}:function(e,t){var i=t.x,o=t.y;return e===he?(window.scroll(i,o),null):(e.scrollLeft=i,void(e.scrollTop=o))},me=ce?"vertical":"horizontal";if(this.notify={},this.wrapperNode=fe,this.wrapperNode===he&&document.scrollingElement&&(this.wrapperNode=document.scrollingElement),this.contentNode=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:me;if("string"==typeof e)return document.querySelector(e);if(e instanceof HTMLElement==!1)throw"content invalid. should be an HTML Element or a selector";return e}(f||he),this.wrapper=re,ue||(H=de()),this.targetScroll=this.animatedScroll=this.currentScroll=ce?H.y:H.x,p){var ve=this.resize.bind(this);new ResizeObserver(ve).observe(this.contentNode),fe!==window&&fe!==document.documentElement&&fe!==document.body&&new ResizeObserver(ve).observe(this.wrapperNode),this.resize()}this.emitter={capturedListeners:{},on:function(e,t){this.capturedListeners[e]||(this.capturedListeners[e]=[]),this.capturedListeners[e].push(t)},off:function(e,t){if(this.capturedListeners[e]){var i=this.capturedListeners[e].indexOf(t);-1!==i&&this.capturedListeners[e].splice(i,1)}}},this.options.duration=g>50?g:1e3*g;var ge=this.__(),ye={},be="undefined"!=typeof document&&"scrollBehavior"in document.documentElement.style;var Se={scrollTo:this.scrollTo.bind(this),raf:this.raf.bind(this),on:this.on.bind(this),off:this.off.bind(this),destroy:this.destroy.bind(this)},we=this;return"scrollY"in window&&h(window),this.notify.scroll=function(e){if(re.dispatchEvent(new CustomEvent("scroll")),we.emitter.capturedListeners.scroll)for(var t=0,i=we.emitter.capturedListeners.scroll.length;t<i;t++)we.emitter.capturedListeners.scroll[t](e)},this.notify.targetScroll=function(e){re.dispatchEvent(new CustomEvent("scroll")),we.emitter.capturedListeners["change:targetScroll"]&&we.emitter.capturedListeners["change:targetScroll"].forEach((function(t){t(e)}))},this.notify.animatedScroll=function(e){re.dispatchEvent(new CustomEvent("scroll")),we.emitter.capturedListeners["change:animatedScroll"]&&we.emitter.capturedListeners["change:animatedScroll"].forEach((function(t){t(e)}))},this.notify.toUpdate=function(){we.emitter.capturedListeners["change:toUpdate"]&&we.emitter.capturedListeners["change:toUpdate"].forEach((function(e){return e(x)}))},this.notify.stopped=function(e){we.emitter.capturedListeners.stopped&&we.emitter.capturedListeners.stopped.forEach((function(t){return t(e)}))},ye.viewport=function(){var e=window.innerWidth,t=window.innerHeight,i=e*window.devicePixelRatio,o=t*window.devicePixelRatio;return{width:e,height:t,dpr:window.devicePixelRatio,dprWidth:i,dprHeight:o}},ye.dimensions=function(){var e=ce?"y":"x",t=ce?0:H.x,i=ce?H.y:0,o=ue?ye.viewport():{width:fe.offsetWidth,height:fe.offsetHeight,dpr:window.devicePixelRatio,dprWidth:fe.offsetWidth*window.devicePixelRatio,dprHeight:fe.offsetHeight*window.devicePixelRatio},s=o.width,n=o.height,r=ce?Math.max(we.contentNode.offsetHeight,we.contentNode.scrollHeight):we.contentNode.offsetWidth,l=r-("x"===e?s:n),c=Math.round(r);return{width:s,height:n,scrollWidth:c,scrollHeight:c,scrollLeft:t,scrollTop:i,max:l}},this.resize(),l([document.documentElement],{wheelMultiplier:A,touchMultiplier:j,normalizeWheel:_}).subscribe(this.onVirtualScroll),this.__proto__=Se,this}var i,s,n;return i=t,(s=[{key:"start",value:function(){var e=this;this.isStopped&&("function"==typeof document.hidden?document.hidden:document.visibilityState&&"hidden"===document.visibilityState||document.visibilityState&&"prerender"===document.visibilityState?document.addEventListener("visibilitychange",(function t(){("function"==typeof document.hidden?!document.hidden:document.visibilityState&&"visible"===document.visibilityState)&&(e.isStopped=!1,document.removeEventListener("visibilitychange",t))})):this.isStopped=!1,this.notify.stopped(!1))}},{key:"stop",value:function(){this.isStopped=!0,this.notify.stopped(!0)}},{key:"destroy",value:function(){c===this&&(c=null)}},{key:"on",value:function(e,t){this.emitter.on(e,t)}},{key:"off",value:function(e,t){this.emitter.off(e,t)}},{key:"setScroll",value:function(e){this.animatedScroll=this.targetScroll=this.currentScroll=e,this.velocity={x:0,y:0};var t="vertical"===this.options.direction?{x:0,y:e}:{x:e,y:0};pe(this.wrapperNode,t),this.notify.scroll({currentScroll:e,lastScroll:e})}},{key:"resize",value:function(){var e=ye.dimensions(),t=e.scrollWidth,i=e.scrollHeight,o=e.width,s=e.height,n=e.scrollTop,l=e.scrollLeft,c=ce?i-s:t-o;this.dimensions={width:o,height:s,scrollWidth:t,scrollHeight:i},this.maxScroll=Math.max(0,c),B={x:l,y:n},this.animatedScroll=this.targetScroll=this.currentScroll=ce?n:l;var a=this.options.infinite?this.animatedScroll:this.clampScroll(this.animatedScroll);pe(this.wrapperNode,"vertical"===this.options.direction?{x:0,y:a}:{x:a,y:0})}},{key:"toUpdate",get:function(){return x}},{key:"isSmooth",get:function(){return this.options.smooth>0}},{key:"progress",get:function(){return a.clamp(this.currentScroll/this.maxScroll,0,1)}},{key:"scrollTo",value:function(e){var t=this,i=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};if(e!==Number.NEGATIVE_INFINITY&&void 0!==e&&null!==e){var s=i.offset||0,n=i.immediate,l=i.duration||this.options.duration,c=i.easing||this.options.easing,a=i.lerp,h=i.onComplete,u=!!i.force,f=i.lock,d=i.align;void 0!==d&&(null!==d&&"start"!==d&&"center"!==d&&"end"!==d||(d=null));var p=!!n||0===this.options.duration||0===l||a,m=p?1:a||(l>0?0:1);if("string"==typeof e&&(e=document.querySelector(e)||document.getElementById(e)||document.getElementsByClassName(e)[0]),null===e||this.isStopped&&!u)return!1;var v=H;"number"==typeof e?e+=s:e instanceof HTMLElement&&(e=((null==d?i.offset?e.offsetTop:e.getBoundingClientRect().top+H.y:this.dimensions.height/2-e.offsetHeight*(("center"===d?.5:"end"===d?1:0)||0)-e.getBoundingClientRect().top-H.y)||0)+s);var g=this.options.infinite?e:a?e:this.clampScroll(e);this.isLocked=!!f;var y=this.targetScroll;if(this.targetScroll=g,this.options.infinite||(this.targetScroll=this.clampScroll(this.targetScroll)),this.clampScroll(e)!==this.clampScroll(y)){this.notify.targetScroll({target:e,offset:s}),p?(this.animatedScroll=e,this.animate(),h&&h()):a||(n=n||0===this.options.duration,x=Date.now(),ae=y||this.getCurrentScroll(),this.options.duration=l,this.options.easing=c);var b=this;return m>0&&!p&&(N={x:0,y:0},function e(){b.isLocked&&(ae=b.targetScroll,N={x:0,y:0});var i=a?b.targetScroll:b.animatedScroll,o=a?m:"number"==typeof m?m:b.options.smoothTouch&&b.isTouching?.5:"auto"===b.options.smooth?Object.assign({},{smooth:.075+Math.pow(5*Math.abs((v.y-ae)/(window.innerHeight||document.documentElement.clientHeight)),-.75)*.05,smoothTouch:.1,lerp:.1})[b.isTouching?"smoothTouch":m||b.options.smooth||"smooth"]:b.options.smooth||.1,s=a?o:1-Math.pow(1-o,ae&&x?Math.min(1,(Date.now()-x)/l):1),r=b.options.infinite?i:b.clampScroll(i);(Math.round(r)!==Math.round(ae)||N.y)&&(N=a?function(e,t,i){return{x:a.lerp(e.x,t.x,i),y:a.lerp(e.y,t.y,i)}}({x:0,y:ae},N,o):{x:0,y:b.options.infinite?i:function(e,t,i,o){var s=1-o,n=1/(Math.exp(4*Math.abs(e-t)/i)||1);return e<t?(t+(e-t)*s)*(1-n)+e*n:e>t?(t+(e-t)*s)*(1-n)+e*n:e}(ae,b.targetScroll,window.innerHeight||document.documentElement.clientHeight,.5*s)},ae=b.options.infinite?r:ae+(N.y-ae)*s,b.isScrolling=!0,b.velocity.y=N.y-r,b.direction=b.velocity.y<0?"up":"down",b.animator(ae),b.notify.animatedScroll({currentScroll:b.clampScroll(ae),lastScroll:b.clampScroll(r)}),Math.round(ae)!==Math.round(b.targetScroll)?requestAnimationFrame(e):(b.velocity.y=0,b.isScrolling=!1,b.isLocked=!1,N={x:0,y:0},h&&h(),b.emit("scroll:complete")))}()),!0}}}},{key:"reset",value:function(){this.emit("scroll"),this.setScroll(0)}},{key:"emit",value:function(e){for(var t=arguments.length,i=new Array(t>1?t-1:0),o=1;o<t;o++)i[o-1]=arguments[o];switch(e){case"scroll":this.notify.scroll({currentScroll:this.currentScroll,lastScroll:this.currentScroll});break;case"scroll:complete":this.notify.scroll({currentScroll:this.currentScroll,lastScroll:this.currentScroll})}}},{key:"raf",value:function(e){var t=e>1e4?performance.now():e;if(this.lastFrameTime){var i=t-this.lastFrameTime;this.onScroll(i)}this.lastFrameTime=t,this.scrollToRaf=window.requestAnimationFrame(this.raf.bind(this))}},{key:"getCurrentScroll",value:function(){return this.currentScroll}},{key:"onScrollStart",value:function(e){this.event=e,this.isScrolling=!0;var t=this.animatedScroll;this.isTouching&&(this.targetScroll=t);var i=ce?t:H.x,o=ce?H.y:t,s=ce?e.deltaY:e.deltaX;this.emit("scroll:start",{currentScroll:this.currentScroll,lastScroll:i,direction:s<0?"up":"down"})}},{key:"onScrollEnd",value:function(){this.emit("scroll:end")}},{key:"onTouchStart",value:function(){var e=this;this.isTouching=!0,function t(){e.isTouching&&(requestAnimationFrame(t),e.raf())}()}},{key:"onTouchEnd",value:function(){var e=this;this.isTouching=!1,this.options.momentum&&setTimeout((function(){!e.isTouching&&e.velocity.y&&(e.animatedScroll=e.targetScroll-=3*e.velocity.y)}),50)}},{key:"animate",value:function(){var e=this.animatedScroll,t=ce?0:e,i=ce?e:0;pe(this.wrapperNode,{x:t,y:i}),this.currentScroll=e,this.emit("scroll")}},{key:"animator",value:function(e){var t=ce?0:e,i=ce?e:0;pe(this.wrapperNode,{x:t,y:i}),this.currentScroll=e,this.emit("scroll")}},{key:"manageAttr",value:function(e,t,i){var o=("data-".concat(t)).toString();i?e.setAttribute(o,""):e.removeAttribute(o)}}])&&e(i.prototype,s),n&&e(i,n),Object.defineProperty(i,"prototype",{writable:!1}),t}();return u}));

// Namespace to avoid global scope pollution
const CuevasHome = (() => {
    // Configuration constants
    const CONFIG = {
        WHEEL_DEBOUNCE: 100,          // Debounce time for wheel events (ms)
        SCROLL_COOLDOWN: 500,         // Cooldown between scroll actions (ms)
        ANIMATION_DURATION: 0.8,      // Standard animation duration (s)
        SWIPE_THRESHOLD: 50,          // Minimum distance for swipe detection (px)
        ANIMATION_EASE: 'power2.out', // Standard easing function
        PIN_SECTIONS: true,           // Whether to pin sections during scrolling
        LENIS_DURATION: 1.2,          // Lenis smooth scroll duration
        LENIS_SMOOTH: 0.08,           // Lenis smooth value (lower = smoother)
        SECTION_SNAP_THRESHOLD: 0.2   // ScrollTrigger snap threshold (0-1)
    };

    // State variables
    let lenis;
    let currentSection = 0;
    let currentSlide = 0;
    let isScrolling = false;
    let prefersReducedMotion = false;
    let sections = [];
    let sectionsReady = false;
    let scrollTriggers = [];
    let sliderTimeline;
    let isResizing = false;
    let resizeTimer;
    let touchStartY = 0;
    let touchStartX = 0;
    let touchStartTime = 0;
    
    /**
     * Check for reduced motion preference
     */
    function checkReducedMotion() {
        prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        return prefersReducedMotion;
    }
    
    /**
     * Add accessibility styles
     */
    function addA11yStyles() {
        if (document.getElementById('cuevas-a11y-styles')) return;
        
        const style = document.createElement('style');
        style.id = 'cuevas-a11y-styles';
        style.textContent = `
            .sr-only {
                position: absolute;
                width: 1px;
                height: 1px;
                padding: 0;
                margin: -1px;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
                white-space: nowrap;
                border: 0;
            }
        `;
        document.head.appendChild(style);
    }
    
    /**
     * Announce to screen readers
     */
    function announceToScreenReader(message, politeness = 'polite') {
        const id = `${politeness}-announcer`;
        let announcer = document.getElementById(id);
        
        if (!announcer) {
            announcer = document.createElement('div');
            announcer.id = id;
            announcer.className = 'sr-only';
            announcer.setAttribute('aria-live', politeness);
            announcer.setAttribute('aria-atomic', 'true');
            document.body.appendChild(announcer);
        }
        
        // Set the content after a brief delay to ensure it's read
        setTimeout(() => {
            announcer.textContent = message;
        }, 50);
    }
    
    /**
     * Cleanup animations and scroll triggers
     */
    function cleanupAnimations() {
        // Kill all ScrollTriggers
        scrollTriggers.forEach(trigger => {
            if (trigger && trigger.kill) {
                trigger.kill();
            }
        });
        scrollTriggers = [];
        
        // Kill any timelines
        if (sliderTimeline && sliderTimeline.kill) {
            sliderTimeline.kill();
        }
        
        // Clear any GSAP contexts
        ScrollTrigger.getAll().forEach(st => st.kill());
        gsap.killTweensOf("*");
    }
    
    /**
     * Initialize Lenis smooth scrolling
     */
    function initSmoothScrolling() {
        // Create Lenis instance for smooth scrolling
        lenis = new Lenis({
            duration: prefersReducedMotion ? 0 : CONFIG.LENIS_DURATION,
            smoothWheel: !prefersReducedMotion,
            touchMultiplier: 1.5,
            wheelMultiplier: 1.5,
            smoothTouch: false, // We'll handle touch directly
            infinite: false,
            orientation: 'vertical',
            gestureOrientation: 'vertical',
            smooth: prefersReducedMotion ? false : CONFIG.LENIS_SMOOTH,
            normalizeWheel: true
        });
        
        // Integrate GSAP's ticker with Lenis
        gsap.ticker.add((time) => {
            lenis.raf(time * 1000);
        });
        
        // Stop default wheel scroll events since we'll handle them manually
        lenis.on('scroll', ScrollTrigger.update);
        
        // Start the Lenis smooth scroller
        gsap.ticker.lagSmoothing(false);
        
        return lenis;
    }
    
    /**
     * Initialize hero animations with GSAP timeline
     */
    function initHeroAnimations() {
        const heroTitle = document.querySelector('.hero-title');
        const heroSubtitle = document.querySelector('.hero-subtitle');
        const scrollIndicator = document.querySelector('.scroll-indicator');
        
        if (!heroTitle || !heroSubtitle) return;
        
        // Create a timeline for coordinated animations
        const tl = gsap.timeline({
            paused: prefersReducedMotion,
            defaults: {
                duration: CONFIG.ANIMATION_DURATION,
                ease: CONFIG.ANIMATION_EASE
            }
        });
        
        // Set initial state
        gsap.set([heroTitle, heroSubtitle, scrollIndicator], {opacity: 0, y: 20});
        
        // Add animations to timeline
        tl.to(heroTitle, {
            opacity: 1,
            y: 0,
            delay: 0.2
        })
        .to(heroSubtitle, {
            opacity: 1,
            y: 0
        }, "-=0.5")
        .to(scrollIndicator, {
            opacity: 1,
            y: 0
        }, "-=0.3");
        
        // Play the timeline
        tl.play();
        
        // Add pulsing animation for scroll arrow if motion is allowed
        if (!prefersReducedMotion && scrollIndicator) {
            gsap.to(scrollIndicator.querySelector('.scroll-arrow'), {
                y: 10,
                repeat: -1,
                yoyo: true,
                duration: 0.8
            });
        }
        
        // Add background parallax effect
        const heroSection = document.querySelector('.hero-section');
        if (heroSection && heroSection.style.backgroundImage) {
            scrollTriggers.push(
                ScrollTrigger.create({
                    trigger: heroSection,
                    start: 'top top',
                    end: 'bottom top',
                    scrub: true,
                    onUpdate: (self) => {
                        const progress = self.progress;
                        gsap.set(heroSection, {
                            backgroundPosition: `center ${20 * progress}%`
                        });
                    }
                })
            );
        }
        
        // Add click handler for scroll indicator
        if (scrollIndicator) {
            scrollIndicator.addEventListener('click', () => {
                scrollToSection(1);
            });
            
            // Keyboard handler for accessibility
            scrollIndicator.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    scrollToSection(1);
                }
            });
        }
    }
    
    /**
     * Initialize featured slider animations
     */
    function initFeaturedSlider() {
        const slides = document.querySelectorAll('.slide');
        const sliderDots = document.querySelectorAll('.slider-dot');
        
        if (!slides.length || !sliderDots.length) return;
        
        // Set up the slider with GSAP
        gsap.set(slides, {
            opacity: 0,
            scale: 0.9,
            zIndex: 0
        });
        
        // Set initial slide
        gsap.set(slides[0], {
            opacity: 1,
            scale: 1,
            zIndex: 1
        });
        
        // Create timeline for slide transitions
        sliderTimeline = gsap.timeline({paused: true});
        
        // Update slider indicators
        function updateIndicators() {
            sliderDots.forEach((dot, i) => {
                if (i === currentSlide) {
                    dot.classList.add('active');
                    dot.setAttribute('aria-selected', 'true');
                    dot.tabIndex = 0;
                } else {
                    dot.classList.remove('active');
                    dot.setAttribute('aria-selected', 'false');
                    dot.tabIndex = -1;
                }
            });
            
            // Update accessibility attributes
            slides.forEach((slide, i) => {
                slide.setAttribute('aria-hidden', i === currentSlide ? 'false' : 'true');
            });
            
            // Announce slide change to screen readers
            announceToScreenReader(`Slide ${currentSlide + 1} of ${slides.length}`);
        }
        
        // Go to a specific slide
        function goToSlide(index) {
            if (index < 0 || index >= slides.length || index === currentSlide) return;
            
            // Create new timeline for this transition
            const tl = gsap.timeline({
                onComplete: () => {
                    updateIndicators();
                }
            });
            
            // Fade out current slide
            tl.to(slides[currentSlide], {
                opacity: 0,
                scale: 0.9,
                duration: 0.5,
                ease: 'power2.out',
                zIndex: 0
            });
            
            // Fade in new slide
            tl.to(slides[index], {
                opacity: 1,
                scale: 1,
                duration: 0.5,
                ease: 'power2.out',
                zIndex: 1
            }, '-=0.3');
            
            // Update current slide
            currentSlide = index;
        }
        
        // Set up auto rotation if more than one slide
        if (slides.length > 1 && !prefersReducedMotion) {
            // Auto-advance slides every 5 seconds
            const autoSlideInterval = setInterval(() => {
                const nextSlide = (currentSlide + 1) % slides.length;
                goToSlide(nextSlide);
            }, 5000);
            
            // Clear interval when user interacts with slider
            const clearAutoSlide = () => {
                clearInterval(autoSlideInterval);
            };
            
            sliderDots.forEach(dot => {
                dot.addEventListener('click', clearAutoSlide);
                dot.addEventListener('keydown', clearAutoSlide);
            });
            
            document.querySelector('.gallery-section').addEventListener('touchstart', clearAutoSlide);
            
            // Add to cleanup
            window.addEventListener('beforeunload', () => {
                clearInterval(autoSlideInterval);
            });
        }
        
        // Add click event listeners to dots
        sliderDots.forEach((dot, i) => {
            dot.addEventListener('click', () => goToSlide(i));
            
            // Add keyboard support for accessibility
            dot.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    goToSlide(i);
                }
            });
        });
        
        // Add swipe support for gallery
        const gallerySection = document.querySelector('.gallery-section');
        
        if (gallerySection) {
            // Handle wheel events in gallery
            const handleWheel = (e) => {
                // Only if we're in the gallery section
                if (currentSection !== 1) return;
                
                // Prevent default scrolling
                e.preventDefault();
                
                if (isScrolling) return;
                isScrolling = true;
                
                // Determine direction
                if (e.deltaX > 20) {
                    // Scrolling right (next slide)
                    if (currentSlide < slides.length - 1) {
                        goToSlide(currentSlide + 1);
                    } else {
                        // Last slide, go to next section
                        scrollToSection(2);
                    }
                } else if (e.deltaX < -20) {
                    // Scrolling left (previous slide)
                    if (currentSlide > 0) {
                        goToSlide(currentSlide - 1);
                    } else {
                        // First slide, go to previous section
                        scrollToSection(0);
                    }
                } else if (e.deltaY > 50) {
                    // Scrolling down (next section)
                    scrollToSection(2);
                } else if (e.deltaY < -50) {
                    // Scrolling up (previous section)
                    scrollToSection(0);
                }
                
                // Reset isScrolling after delay
                setTimeout(() => {
                    isScrolling = false;
                }, CONFIG.SCROLL_COOLDOWN);
            };
            
            gallerySection.addEventListener('wheel', handleWheel, { passive: false });
            
            // Add touch events to gallery
            gallerySection.addEventListener('touchstart', (e) => {
                touchStartX = e.touches[0].clientX;
                touchStartY = e.touches[0].clientY;
                touchStartTime = Date.now();
            }, { passive: true });
            
            gallerySection.addEventListener('touchend', (e) => {
                const touchEndX = e.changedTouches[0].clientX;
                const touchEndY = e.changedTouches[0].clientY;
                const deltaX = touchStartX - touchEndX;
                const deltaY = touchStartY - touchEndY;
                const touchDuration = Date.now() - touchStartTime;
                
                // Only process fast swipes
                if (touchDuration > 500) return;
                
                if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > CONFIG.SWIPE_THRESHOLD) {
                    // Horizontal swipe - handle slide change
                    if (deltaX > 0) {
                        // Swiping left (next slide)
                        if (currentSlide < slides.length - 1) {
                            goToSlide(currentSlide + 1);
                        } else {
                            scrollToSection(2);
                        }
                    } else {
                        // Swiping right (previous slide)
                        if (currentSlide > 0) {
                            goToSlide(currentSlide - 1);
                        } else {
                            scrollToSection(0);
                        }
                    }
                } else if (Math.abs(deltaY) > CONFIG.SWIPE_THRESHOLD) {
                    // Vertical swipe - navigate sections
                    if (deltaY > 0) {
                        scrollToSection(2);
                    } else {
                        scrollToSection(0);
                    }
                }
            }, { passive: true });
        }
        
        // Export slide navigation function
        return { goToSlide };
    }
    
    /**
     * Initialize section animations
     */
    function initSectionAnimations() {
        const productSection = document.querySelector('#products');
        const shopSection = document.querySelector('#shop');
        
        if (productSection) {
            // Animate product cards
            const productCards = productSection.querySelectorAll('.product-card');
            if (productCards.length) {
                scrollTriggers.push(
                    ScrollTrigger.create({
                        trigger: productSection,
                        start: 'top 80%',
                        once: true,
                        onEnter: () => {
                            gsap.from(productCards, {
                                y: 50,
                                opacity: 0,
                                duration: 0.6,
                                stagger: 0.1,
                                ease: 'power2.out'
                            });
                        }
                    })
                );
            }
        }
        
        if (shopSection) {
            // Animate category buttons
            const categoryButtons = shopSection.querySelectorAll('.category-button');
            const shopHeading = shopSection.querySelector('h2');
            
            if (categoryButtons.length) {
                scrollTriggers.push(
                    ScrollTrigger.create({
                        trigger: shopSection,
                        start: 'top 80%',
                        once: true,
                        onEnter: () => {
                            // Animate heading first
                            if (shopHeading) {
                                gsap.from(shopHeading, {
                                    y: 30,
                                    opacity: 0,
                                    duration: 0.7,
                                    ease: 'power2.out'
                                });
                            }
                            
                            // Then animate buttons with stagger
                            gsap.from(categoryButtons, {
                                y: 40,
                                opacity: 0,
                                duration: 0.5,
                                stagger: 0.1,
                                ease: 'back.out(1.2)',
                                delay: 0.2
                            });
                        }
                    })
                );
            }
        }
    }
    
    /**
     * Smoothly scroll to section
     */
    function scrollToSection(sectionIndex) {
        if (isScrolling || !sections[sectionIndex]) return;
        
        isScrolling = true;
        currentSection = sectionIndex;
        
        // Update navigation
        updateSectionNav();
        
        // Get section position
        const targetSection = sections[sectionIndex];
        const target = targetSection.offsetTop;
        
        // Announce section change to screen readers
        const sectionName = targetSection.getAttribute('aria-label') || `Section ${sectionIndex + 1}`;
        announceToScreenReader(`Navigating to ${sectionName}`);
        
        // Scroll with Lenis for smooth motion
        if (lenis) {
            lenis.scrollTo(target, {
                duration: prefersReducedMotion ? 0 : CONFIG.ANIMATION_DURATION,
                lock: true,
                onComplete: () => {
                    isScrolling = false;
                }
            });
        } else {
            // Fallback to GSAP if Lenis isn't available
            gsap.to(window, {
                duration: prefersReducedMotion ? 0 : CONFIG.ANIMATION_DURATION,
                scrollTo: {
                    y: target,
                    autoKill: false
                },
                ease: CONFIG.ANIMATION_EASE,
                onComplete: () => {
                    isScrolling = false;
                }
            });
        }
    }
    
    /**
     * Update section visibility
     */
    function updateSectionVisibility(activeSection, animate = true) {
        // Current section changed, update navigation
        currentSection = activeSection;
        updateSectionNav();
        
        // Update which section is active for accessibility
        sections.forEach((section, index) => {
            const isActive = index === activeSection;
            section.setAttribute('aria-hidden', isActive ? 'false' : 'true');
            
            if (index === 1 && isActive) {
                // Reset slider when entering gallery section
                const firstDot = document.querySelector('.slider-dot[data-index="0"]');
                if (firstDot) {
                    firstDot.click();
                }
            }
        });
    }
    
    /**
     * Initialize smooth sectioning with ScrollTrigger
     */
    function initSmoothSectioning() {
        // Get all sections
        sections = Array.from(document.querySelectorAll('.section'));
        
        if (sections.length === 0) return;
        
        // Check for reduced motion preference
        if (prefersReducedMotion) {
            // For reduced motion, we'll just add basic scroll animations
            sections.forEach((section, index) => {
                scrollTriggers.push(
                    ScrollTrigger.create({
                        trigger: section,
                        start: 'top center',
                        end: 'bottom center',
                        onEnter: () => updateSectionVisibility(index, false),
                        onEnterBack: () => updateSectionVisibility(index, false)
                    })
                );
            });
            return;
        }
        
        // Initialize ScrollTrigger for each section
        // Pin the first section
        let mainTrigger = null;
        
        // Set up smooth snapping between sections
        sections.forEach((section, i) => {
            const trigger = ScrollTrigger.create({
                trigger: section,
                start: 'top top',
                end: 'bottom top',
                onEnter: () => updateSectionVisibility(i),
                onEnterBack: () => updateSectionVisibility(i),
                markers: false
            });
            
            scrollTriggers.push(trigger);
        });
        
        // Add observer for section heights
        ScrollTrigger.refresh();
        
        // Set up handles for touch and wheel events to control scrolling between sections
        const handleSectionControls = () => {
            // Flag to track if a scroll is in progress
            let scrollTimeout;
            
            // Listen for wheel events on the document
            document.addEventListener('wheel', (e) => {
                if (isScrolling || isResizing) return;
                
                // Clear any pending timeouts
                clearTimeout(scrollTimeout);
                
                // Debounce the wheel event
                scrollTimeout = setTimeout(() => {
                    const direction = e.deltaY > 0 ? 1 : -1;
                    const nextSection = Math.max(0, Math.min(sections.length - 1, currentSection + direction));
                    
                    if (nextSection !== currentSection) {
                        scrollToSection(nextSection);
                    }
                }, 50);
            }, { passive: true });
            
            // Handle touch events for mobile
            const touchStartHandler = (e) => {
                touchStartY = e.touches[0].clientY;
                touchStartX = e.touches[0].clientX;
                touchStartTime = Date.now();
            };
            
            const touchEndHandler = (e) => {
                if (isScrolling || isResizing) return;
                
                const touchEndY = e.changedTouches[0].clientY;
                const touchEndX = e.changedTouches[0].clientX;
                const deltaY = touchStartY - touchEndY;
                const deltaX = touchStartX - touchEndX;
                const touchDuration = Date.now() - touchStartTime;
                
                // Only process fast swipes
                if (touchDuration > 500) return;
                
                // Verify it's a vertical swipe
                if (Math.abs(deltaY) > Math.abs(deltaX) && Math.abs(deltaY) > CONFIG.SWIPE_THRESHOLD) {
                    const direction = deltaY > 0 ? 1 : -1;
                    const nextSection = Math.max(0, Math.min(sections.length - 1, currentSection + direction));
                    
                    if (nextSection !== currentSection) {
                        scrollToSection(nextSection);
                    }
                }
            };
            
            // Add touch event listeners
            document.addEventListener('touchstart', touchStartHandler, { passive: true });
            document.addEventListener('touchend', touchEndHandler, { passive: true });
        };
        
        // Initialize section controls
        handleSectionControls();
        
        // Set sectionsReady flag
        sectionsReady = true;
    }
    
    /**
     * Initialize navigation dots
     */
    function initNavigationDots() {
        const navDots = document.querySelectorAll('.nav-dot');
        
        if (navDots.length === 0) return;
        
        // Set up click handlers for navigation dots
        navDots.forEach((dot) => {
            const sectionIndex = parseInt(dot.getAttribute('data-section'), 10);
            
            // Click handler
            dot.addEventListener('click', () => {
                scrollToSection(sectionIndex);
            });
            
            // Keyboard handler for accessibility
            dot.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    scrollToSection(sectionIndex);
                }
            });
        });
        
        // Update navigation function to highlight the current dot
        function updateSectionNav() {
            navDots.forEach((dot, i) => {
                const sectionIndex = parseInt(dot.getAttribute('data-section'), 10);
                
                if (sectionIndex === currentSection) {
                    dot.classList.add('active');
                    dot.setAttribute('aria-current', 'true');
                    dot.tabIndex = 0;
                } else {
                    dot.classList.remove('active');
                    dot.setAttribute('aria-current', 'false');
                    dot.tabIndex = -1;
                }
            });
            
            // Update prev/next button states
            const prevButton = document.querySelector('.fixed-nav-btn.prev');
            const nextButton = document.querySelector('.fixed-nav-btn.next');
            
            if (prevButton) {
                prevButton.disabled = currentSection === 0;
                prevButton.style.opacity = currentSection === 0 ? 0.3 : 1;
                prevButton.setAttribute('aria-disabled', currentSection === 0 ? 'true' : 'false');
            }
            
            if (nextButton) {
                nextButton.disabled = currentSection === sections.length - 1;
                nextButton.style.opacity = currentSection === sections.length - 1 ? 0.3 : 1;
                nextButton.setAttribute('aria-disabled', currentSection === sections.length - 1 ? 'true' : 'false');
            }
        }
        
        return { updateSectionNav };
    }
    
    /**
     * Setup keyboard navigation
     */
    function setupKeyboardNavigation() {
        document.addEventListener('keydown', (e) => {
            // Don't handle events during scrolling
            if (isScrolling) return;
            
            // Check if any form element is active
            const activeElement = document.activeElement;
            const isInputActive = activeElement.tagName === 'INPUT' || 
                                activeElement.tagName === 'TEXTAREA' || 
                                activeElement.tagName === 'SELECT' ||
                                activeElement.isContentEditable;
            
            // Skip keyboard navigation if typing in a form
            if (isInputActive) return;
            
            switch(e.key) {
                case 'ArrowDown':
                case 'PageDown':
                    // Navigate to next section
                    if (currentSection < sections.length - 1) {
                        e.preventDefault();
                        scrollToSection(currentSection + 1);
                    }
                    break;
                    
                case 'ArrowUp':
                case 'PageUp':
                    // Navigate to previous section
                    if (currentSection > 0) {
                        e.preventDefault();
                        scrollToSection(currentSection - 1);
                    }
                    break;
                    
                case 'Home':
                    // Navigate to first section
                    e.preventDefault();
                    scrollToSection(0);
                    break;
                    
                case 'End':
                    // Navigate to last section
                    e.preventDefault();
                    scrollToSection(sections.length - 1);
                    break;
                    
                case 'ArrowRight':
                    // If in gallery, go to next slide
                    if (currentSection === 1) {
                        const slides = document.querySelectorAll('.slide');
                        if (currentSlide < slides.length - 1) {
                            e.preventDefault();
                            const sliderDot = document.querySelector(`.slider-dot[data-index="${currentSlide + 1}"]`);
                            if (sliderDot) sliderDot.click();
                        }
                    }
                    break;
                    
                case 'ArrowLeft':
                    // If in gallery, go to previous slide
                    if (currentSection === 1) {
                        if (currentSlide > 0) {
                            e.preventDefault();
                            const sliderDot = document.querySelector(`.slider-dot[data-index="${currentSlide - 1}"]`);
                            if (sliderDot) sliderDot.click();
                        }
                    }
                    break;
            }
        });
    }
    
    /**
     * Setup navigation buttons
     */
    function setupNavigationButtons() {
        const prevBtn = document.querySelector('.fixed-nav-btn.prev');
        const nextBtn = document.querySelector('.fixed-nav-btn.next');
        
        if (!prevBtn || !nextBtn) return;
        
        // Navigation helper function
        const navigateToSection = (direction) => {
            // Don't navigate if scrolling
            if (isScrolling) return;
            
            // Check if we're in the gallery section
            if (currentSection === 1) {
                const slides = document.querySelectorAll('.slide');
                
                if (direction === 'prev') {
                    // If first slide, go to previous section
                    if (currentSlide === 0) {
                        scrollToSection(0);
                    } else {
                        // Go to previous slide
                        const sliderDot = document.querySelector(`.slider-dot[data-index="${currentSlide - 1}"]`);
                        if (sliderDot) sliderDot.click();
                    }
                } else if (direction === 'next') {
                    // If last slide, go to next section
                    if (currentSlide === slides.length - 1) {
                        scrollToSection(2);
                    } else {
                        // Go to next slide
                        const sliderDot = document.querySelector(`.slider-dot[data-index="${currentSlide + 1}"]`);
                        if (sliderDot) sliderDot.click();
                    }
                }
            } else {
                // Standard section navigation
                if (direction === 'prev' && currentSection > 0) {
                    scrollToSection(currentSection - 1);
                } else if (direction === 'next' && currentSection < sections.length - 1) {
                    scrollToSection(currentSection + 1);
                }
            }
        };
        
        // Setup click handlers
        prevBtn.addEventListener('click', () => navigateToSection('prev'));
        nextBtn.addEventListener('click', () => navigateToSection('next'));
        
        // Keyboard handlers for accessibility
        prevBtn.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                navigateToSection('prev');
            }
        });
        
        nextBtn.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                navigateToSection('next');
            }
        });
    }
    
    /**
     * Handle resize events
     */
    function setupResizeHandler() {
        window.addEventListener('resize', () => {
            // Set resizing flag
            isResizing = true;
            
            // Clear any existing timer
            clearTimeout(resizeTimer);
            
            // Update after resize completes
            resizeTimer = setTimeout(() => {
                isResizing = false;
                
                // Refresh ScrollTrigger
                ScrollTrigger.refresh();
                
                // Reset scroll position to current section
                if (sections[currentSection]) {
                    const sectionTop = sections[currentSection].offsetTop;
                    window.scrollTo(0, sectionTop);
                }
            }, 200);
        });
    }
    
    /**
     * Initialize everything
     */
    function init() {
        console.log("Initializing Cuevas Home Animations");
        
        // Check if Lenis is available - if not, create basic fallback
        if (typeof Lenis === 'undefined') {
            console.warn("Lenis not found - using basic scroll fallback");
            window.Lenis = class BasicLenis {
                constructor(options) {
                    this.options = options || {};
                    this.isScrolling = false;
                    this.scrollCallbacks = [];
                    this._onScroll = this._onScroll.bind(this);
                    window.addEventListener('scroll', this._onScroll, { passive: true });
                }
                
                _onScroll() {
                    this.scrollCallbacks.forEach(callback => callback());
                }
                
                on(event, callback) {
                    if (event === 'scroll') {
                        this.scrollCallbacks.push(callback);
                    }
                    return this;
                }
                
                raf(time) {
                    // Nothing to do in basic version
                }
                
                scrollTo(target, options = {}) {
                    const targetPosition = typeof target === 'number' ? target : 
                        target instanceof HTMLElement ? target.offsetTop : 0;
                        
                    window.scrollTo({
                        top: targetPosition + (options.offset || 0),
                        behavior: options.duration === 0 ? 'auto' : 'smooth'
                    });
                    
                    if (options.onComplete) {
                        setTimeout(options.onComplete, 500);
                    }
                }
                
                destroy() {
                    window.removeEventListener('scroll', this._onScroll);
                }
            };
        }
        
        // Check for reduced motion preference
        checkReducedMotion();
        
        // Add accessibility styles
        addA11yStyles();
        
        // Initialize Lenis smooth scrolling
        initSmoothScrolling();
        
        // Initialize GSAP ScrollTrigger
        gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);
        
        // Set up ScrollTrigger defaults
        ScrollTrigger.config({
            ignoreMobileResize: true
        });
        
        // Setup DOM-dependent animations
        const { updateSectionNav } = initNavigationDots();
        window.updateSectionNav = updateSectionNav;
        
        // Initialize hero animations
        initHeroAnimations();
        
        // Initialize featured slider
        const sliderControls = initFeaturedSlider();
        
        // Initialize section animations
        initSectionAnimations();
        
        // Setup smooth sectioning
        initSmoothSectioning();
        
        // Setup keyboard navigation
        setupKeyboardNavigation();
        
        // Setup navigation buttons
        setupNavigationButtons();
        
        // Setup resize handler
        setupResizeHandler();
        
        // Initialize scroll position
        setTimeout(() => {
            window.scrollTo(0, 0);
            updateSectionVisibility(0, false);
        }, 100);
        
        console.log("Cuevas Home Animations Initialized");
    }
    
    // Handle window load event
    window.addEventListener('load', init);
    
    // Public API
    return {
        scrollToSection,
        cleanupAnimations,
        updateSectionVisibility
    };
})();

// Make globally available
window.CuevasHome = CuevasHome;

// Check if ScrollTrigger is available - if not, create basic fallback
if (typeof gsap === 'undefined' || !gsap.registerPlugin || typeof ScrollTrigger === 'undefined') {
    console.warn("GSAP or ScrollTrigger not found - using basic scroll fallback");
    
    window.gsap = window.gsap || {};
    window.gsap.to = window.gsap.to || function(target, vars) {
        console.log("GSAP to() called with", target, vars);
        if (!target) return;
        
        const elements = typeof target === 'string' ? document.querySelectorAll(target) : 
                         target.length ? target : [target];
        
        Array.from(elements).forEach(el => {
            if (!el || !el.style) return;
            
            if (vars.opacity !== undefined) el.style.opacity = vars.opacity;
            if (vars.x !== undefined) el.style.transform = `translateX(${vars.x}px)`;
            if (vars.y !== undefined) el.style.transform = `translateY(${vars.y}px)`;
            if (vars.scale !== undefined) el.style.transform = `scale(${vars.scale})`;
            
            el.style.transition = `all ${vars.duration || 0.5}s ease`;
            
            if (vars.onComplete) {
                setTimeout(vars.onComplete, (vars.duration || 0.5) * 1000);
            }
        });
        
        return { progress: () => 0 };
    };
    
    window.gsap.from = window.gsap.from || function(target, vars) {
        return window.gsap.to(target, vars);
    };
    
    window.gsap.set = window.gsap.set || function(target, vars) {
        return window.gsap.to(target, {...vars, duration: 0});
    };
    
    window.gsap.timeline = window.gsap.timeline || function(options) {
        return {
            to: function() { return this; },
            from: function() { return this; },
            fromTo: function() { return this; },
            play: function() { return this; }
        };
    };
    
    window.gsap.registerPlugin = window.gsap.registerPlugin || function() {};
    window.gsap.ticker = window.gsap.ticker || { 
        add: function(callback) {
            let lastTime = 0;
            const tick = (time) => {
                const delta = time - lastTime;
                lastTime = time;
                callback(delta / 1000);
                requestAnimationFrame(tick);
            };
            requestAnimationFrame(tick);
        },
        lagSmoothing: function() {}
    };
    
    window.gsap.killTweensOf = window.gsap.killTweensOf || function() {};
    
    window.ScrollTrigger = window.ScrollTrigger || {
        create: function(options) {
            console.log("ScrollTrigger.create called with", options);
            const trigger = options.trigger;
            
            if (!trigger) return {};
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && options.onEnter) {
                        options.onEnter();
                    } else if (!entry.isIntersecting && options.onLeave) {
                        options.onLeave();
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: (options.start || "0px") + " 0px " + (options.end || "0px") + " 0px"
            });
            
            observer.observe(typeof trigger === 'string' ? document.querySelector(trigger) : trigger);
            
            return {
                kill: function() {
                    observer.disconnect();
                }
            };
        },
        refresh: function() {},
        update: function() {},
        getAll: function() { return []; },
        config: function() {}
    };
    
    window.ScrollToPlugin = window.ScrollToPlugin || {};
} 