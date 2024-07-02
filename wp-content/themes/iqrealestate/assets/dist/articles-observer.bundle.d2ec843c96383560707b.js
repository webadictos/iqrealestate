"use strict";(self.webpackChunk=self.webpackChunk||[]).push([["articles-observer"],{"./js/articles-observer.js":function(e,t,a){a.r(t);var r=a("./js/localstorage.js");(()=>{const c={articlesContainerSelector:".articles-container",articleObserverSelector:"entry-main-text",firstArticleSelector:".post",jetpackID:void 0===WA_ThemeSetup.general.jetpackID?"":WA_ThemeSetup.general.jetpackID,promotedExpire:ThemeSetup.promotedTTL||86400,comscoreC1:void 0===WA_ThemeSetup.general.comscoreC1?"":WA_ThemeSetup.general.comscoreC1,comscoreC2:void 0===WA_ThemeSetup.general.comscoreC2?"":WA_ThemeSetup.general.comscoreC2};let i,l=0,s=[],d;const n=e=>{var t=r.ls.get("promotedviews")||[];!1===t.includes(e)&&t.push(e),0<c.promotedExpire&&r.ls.set("promotedviews",t,c.promotedExpire)},u=(e,t=!0,a=0)=>{a=new CustomEvent("is.post-tracked",{detail:{postID:a,postMeta:e,byInfiniteScroll:t}});document.querySelector("body").dispatchEvent(a)};const a=new IntersectionObserver(e=>{e.forEach(e=>{e.isIntersecting&&t(e)})},{threshold:.02}),p=e=>{var t=document.createElement("textarea");return t.innerHTML=e,t.value},m=(e,a)=>{var t,o,r;e.dataset.isTracking||(t=JSON.parse(e.dataset.meta),o=parseInt(e.dataset.postId),r=t?.author??"Undefined",e.setAttribute("data-is-tracking","true"),s.includes(o)&&n(o),u(t,!0,o),"function"==typeof gtag&&(gtag("event","page_view",{page_location:window.location.href,medium:"infinite",infinite_scroll_index:l}),gtag("event","author_view",{author_tracking:r})),"function"==typeof ga&&ga.hasOwnProperty("create")&&(ga("set","page",a),ga("send","pageview"),ga("send","event","Scroll Pageview",l,a),Array.isArray(t.canal))&&t.canal.forEach(function(e,t){ga("send","event","Pageviews por canal",e,a)}),document.getElementById("wpstats")&&""!==c.jetpackID&&(e=document.location.protocol+"//pixel.wp.com/g.gif?v=ext&j=1%3A9.5&blog="+c.jetpackID+"&post="+o+"&tz=-6&srv="+encodeURIComponent(window.location.hostname)+"&host="+encodeURIComponent(window.location.host)+"&ref="+encodeURIComponent(document.referrer)+"&rand="+Math.random(),document.getElementById("wpstats").src=e),void 0!==self.COMSCORE&&(async()=>{self.COMSCORE&&COMSCORE.beacon({c1:c.comscoreC1,c2:c.comscoreC2});try{await(await fetch("/pageview_candidate.txt?"+Date.now())).text()}catch(e){}})(),void 0!==window.marfeel&&window.marfeel.cmd.push(["compass",function(e){e.trackNewPage({rs:"infinite scroll"})}]))},t=e=>{var t,a,o,r,s,n;1===e.target.nodeType&&(e=e.target.closest("article"),s=(t=JSON.parse(e.dataset.meta)).title,a=e.dataset.slug,o=document.querySelector(c.articlesContainerSelector),r=parseInt(e.dataset.postId),i?i!==e&&(i.removeAttribute("data-is-visible"),e.setAttribute("data-is-visible","true"),s=s,n=a,document.title=p(s),history.replaceState({},p(s),n),i=e,WA_ThemeSetup.currentID=r,m(e,a),"0"!==e.dataset.scrollIndex?o.classList.contains("isScroll")||o.classList.add("isScroll"):o.classList.contains("isScroll")&&o.classList.remove("isScroll")):((i=e).setAttribute("data-is-visible","true"),e.setAttribute("data-is-tracking","true"),e.setAttribute("data-scroll-index",l++),u(t,!1),d=window.location.pathname+window.location.search,e.setAttribute("data-slug",d)))},o=e=>{e.forEach(function(e){"childList"===e.type&&e.addedNodes.forEach(e=>{var t;1===e.nodeType&&e.classList.contains("post")&&(t=(e=document.querySelector(`#${e.id} .entry-main-text`)).closest("article"),a.observe(e),t.setAttribute("data-scroll-index",l++))})})};return{init:()=>{var e=document.querySelector(c.articlesContainerSelector),e=(new MutationObserver(o).observe(e,{attributes:!0,childList:!0,characterData:!0}),document.querySelector(c.firstArticleSelector)),e=(e&&1===e.nodeType&&a.observe(e),document.querySelector("body"));e&&e.addEventListener("is.post-load",e=>{e.detail.postID&&e.detail.isPromoted&&s.push(parseInt(e.detail.postID,10))})}}})().init()},"./js/localstorage.js":function(e,t,a){a.d(t,{ls:function(){return o}});const o={set:(e,t,a=86400)=>{t={value:t,ttl:Date.now()+1e3*a};localStorage.setItem(e,JSON.stringify(t))},get:e=>{var t=localStorage.getItem(e);return t?(t=JSON.parse(t),Date.now()>t.ttl?(localStorage.removeItem(e),null):t.value):null}}}}]);