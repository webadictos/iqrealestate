"use strict";(self.webpackChunk=self.webpackChunk||[]).push([["single"],{"./js/single.js":function(e,t,l){l.r(t),l.d(t,{Single:function(){return n}});var r=l("./js/wordpress-functions.js"),d=l("./js/file-loader.js");const n=(()=>{let e=!1,t,s=!1;const o=e=>{e.detail.postID&&(WA_ThemeSetup.currentID=e.detail.postID,i("#post-"+e.detail.postID),void 0!==window.lazyLoadInstance&&window.lazyLoadInstance.update(),t&&t.init(),!s)&&document.querySelector(".single-project__map")&&Promise.all([l.e("vendors-node_modules_leaflet_dist_leaflet-src_js"),l.e("map-places")]).then(l.bind(l,"./js/leaflet-places.js")).then(e=>{s=!0,e.PlacesMap.init(),console.log("Tiene mapa también")})},a=()=>{10<(window.pageYOffset||document.documentElement.scrollTop||document.body.scrollTop||0)&!e&&(window.removeEventListener("scroll",a),n(),e=!0)},n=()=>{ThemeSetup.infinite_scroll&&document.querySelector(".articles-container")&&l.e("infinite-scroll").then(l.bind(l,"./js/infinite-scroll.js")).then(l.e("articles-observer").then(l.bind(l,"./js/articles-observer.js"))),i(),l.e("social-share").then(l.bind(l,"./js/social-share.js")).then(e=>{(t=e.SocialShare).init()}),window.lazyLoadOptions={elements_selector:".lazy-wa",threshold:"20"},window.addEventListener("LazyLoad::Initialized",function(e){window.lazyLoadInstance=e.detail.instance},!1),d.D.js("https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.4.0/dist/lazyload.min.js","vanilla-lazyload-js")},i=e=>{let t;var n;t=void 0===e?document:document.querySelector(e),(0,r.Ge)()&&(t.querySelector(".instagram-media")&&(void 0===window.instgrm?(console.log("Load Instagram JS"),d.D.js("//platform.instagram.com/en_US/embeds.js","instagram-js").then(e=>window.instgrm.Embeds.process())):window.instgrm.Embeds.process()),t.querySelector("a[data-pin-do]")&&(e=window,n=document,e.hazPinIt||(console.log("Load Pinterest JS"),e.hazPinIt=!0,(e=n.createElement("SCRIPT")).src="//assets.pinterest.com/js/pinit.js",e.type="text/javascript",e.setAttribute("data-pin-build","parsePins"),n.body.appendChild(e),window.parsePins())),t.querySelector(".twitter-tweet")&&("undefined"!=typeof twttr?twttr.widgets.load():(console.log("Load Twitter JS"),d.D.js("https://platform.twitter.com/widgets.js","twitter-js").then(e=>twttr.widgets.load()))),t.querySelector(".fb-post"))&&(console.log("Load FB JS"),d.D.js("https://connect.facebook.net/en_US/all.js#xfbml=1","fb-js").then(e=>{FB.init({status:!0,cookie:!0,xfbml:!0}),FB.XFBML.parse()}))};return{init:()=>{{const e=(0,r.A1)(ThemeSetup.current.postID),n=document.querySelector("#post-"+ThemeSetup.current.postID),t=ThemeSetup?.current?.author??"Undefined";"function"==typeof gtag&&gtag("event","author_view",{author_tracking:t}),Array.isArray(e.canal)&&e.canal.forEach(function(e,t){try{ga("send","event","Pageviews por canal",e,n.dataset.slug)}catch(e){}})}window.addEventListener("scroll",a),document.querySelector("body").addEventListener("is.post-load",o),(document.querySelector("[data-full-image]")||document.querySelector(".wa-gallery-lightbox"))&&Promise.all([l.e("vendors-node_modules_simplelightbox_dist_simple-lightbox_modules_js"),l.e("lightbox")]).then(l.bind(l,"./js/lightbox.js")).then(e=>{}),l.e("ads-sidebar").then(l.bind(l,"./js/ads-sidebar.js")).then(e=>{}),l.e("video-portada").then(l.bind(l,"./js/video-portada.js")).then(e=>{}),!s&&document.querySelector(".single-project__map")&&Promise.all([l.e("vendors-node_modules_leaflet_dist_leaflet-src_js"),l.e("map-places")]).then(l.bind(l,"./js/leaflet-places.js")).then(e=>{s=!0,e.PlacesMap.init()})}}})()}}]);