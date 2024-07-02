import { ls } from './localstorage';

const articlesObserver = (() => {
  const config = {
    articlesContainerSelector: '.articles-container',
    articleObserverSelector: 'entry-main-text',
    firstArticleSelector: '.post',
    jetpackID:
      typeof WA_ThemeSetup.general.jetpackID === 'undefined'
        ? ''
        : WA_ThemeSetup.general.jetpackID,
    promotedExpire: ThemeSetup.promotedTTL || 86400,
    comscoreC1:
      typeof WA_ThemeSetup.general.comscoreC1 === 'undefined'
        ? ''
        : WA_ThemeSetup.general.comscoreC1,
    comscoreC2:
      typeof WA_ThemeSetup.general.comscoreC2 === 'undefined'
        ? ''
        : WA_ThemeSetup.general.comscoreC2,
  };

  let previousArticle;
  let scrollIndex = 0;
  let promotedArticles = [];
  let firstArticleSlug = '';

  const trackedPromotedposts = postID => {
    const promotedviews = ls.get('promotedviews') || [];

    // console.log('Promoted', promotedviews);

    if (promotedviews.includes(postID) === false) promotedviews.push(postID);

    if (config.promotedExpire > 0)
      ls.set('promotedviews', promotedviews, config.promotedExpire);
  };

  const dispatchTrackedEvent = (meta, infiniteScroll = true, postID = 0) => {
    const newPostLoaded = new CustomEvent('is.post-tracked', {
      detail: {
        postID: postID,
        postMeta: meta,
        byInfiniteScroll: infiniteScroll,
      },
    });
    document.querySelector('body').dispatchEvent(newPostLoaded);
  };

  const intersectionHandler = entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        intersectionArticleHandler(entry);
      }
    });
  };

  // const newArticlesLoadedObserver;
  // const articleIntersectionObserver;
  const articleIntersectionObserver = new IntersectionObserver(
    intersectionHandler,
    {
      threshold: 0.02,
    }
  );

  const decodeEntity = inputStr => {
    var textarea = document.createElement('textarea');
    textarea.innerHTML = inputStr;
    return textarea.value;
  };

  const changeTitle = (newTitle, slug) => {
    document.title = decodeEntity(newTitle);
    history.replaceState({}, decodeEntity(newTitle), slug);
  };

  const trackingArticle = (article, slug) => {
    if (article.dataset.isTracking) {
    } else {
      const meta = JSON.parse(article.dataset.meta);
      const postId = parseInt(article.dataset.postId);
      const authorName = meta?.author ?? 'Undefined';

      article.setAttribute('data-is-tracking', 'true');

      // console.log('Current Article', postId);
      // console.log('PRomoted articles', promotedArticles);
      // console.log('Es promoted?', promotedArticles.includes(postId));

      if (promotedArticles.includes(postId)) {
        trackedPromotedposts(postId);
      }

      dispatchTrackedEvent(meta, true, postId);

      if (typeof gtag === 'function') {
        // Google Analytics 4 is being used.
        gtag('event', 'page_view', {
          page_location: window.location.href,
          medium: 'infinite',
          infinite_scroll_index: scrollIndex,
          //  post_category: meta.canal,
        });

        // console.log('Tracking Author');

        gtag('event', 'author_view', {
          author_tracking: authorName,
        });

        // if (Array.isArray(meta.canal)) {
        //   meta.canal.forEach(function (item, index) {
        //     gtag('event', 'page_view', {
        //       post_category: item,
        //       page_location: window.location.href,
        //       non_interaction: true,
        //     });
        //   });
        // }
      }

      //Send Google Analytics Pageview
      if (typeof ga === 'function' && ga.hasOwnProperty('create')) {
        ga('set', 'page', slug);
        ga('send', 'pageview');
        //Evento para analizar cuantos pageviews da cada scroll
        ga('send', 'event', 'Scroll Pageview', scrollIndex, slug);

        //Pageviews por canal
        if (Array.isArray(meta.canal)) {
          meta.canal.forEach(function (item, index) {
            ga('send', 'event', 'Pageviews por canal', item, slug);
          });
        }
      }
      //JETPACK ANALYTICS
      if (document.getElementById('wpstats') && config.jetpackID !== '') {
        var pixelsrc =
          document.location.protocol +
          '//pixel.wp.com/g.gif' +
          '?v=ext&j=1%3A9.5&blog=' +
          config.jetpackID +
          '&post=' +
          postId +
          '&tz=-6&srv=' +
          encodeURIComponent(window.location.hostname) +
          '&host=' +
          encodeURIComponent(window.location.host) +
          '&ref=' +
          encodeURIComponent(document.referrer) +
          '&rand=' +
          Math.random();

        document.getElementById('wpstats').src = pixelsrc;
      }

      const comscoreTracking = async () => {
        // console.log('Tracking Comscore');
        self.COMSCORE &&
          COMSCORE.beacon({ c1: config.comscoreC1, c2: config.comscoreC2 });

        try {
          const request = await fetch('/pageview_candidate.txt?' + Date.now());
          const txt = await request.text();

          //console.log(txt);
        } catch (e) {
          //console.log(e);
        }
      };
      if (typeof self.COMSCORE !== 'undefined') {
        comscoreTracking();
      }

      if (typeof window.marfeel !== 'undefined') {
        window.marfeel.cmd.push([
          'compass',
          function (compass) {
            compass.trackNewPage({ rs: 'infinite scroll' });
          },
        ]);
      }
    }
  };

  const intersectionArticleHandler = entry => {
    if (entry.target.nodeType === 1) {
      const newTarget = entry.target;
      const parentArticle = newTarget.closest('article');
      const currentMeta = JSON.parse(parentArticle.dataset.meta);
      const title = currentMeta.title;
      const permalink = parentArticle.dataset.slug;
      const articlesContainer = document.querySelector(
        config.articlesContainerSelector
      );
      const postId = parseInt(parentArticle.dataset.postId);

      // console.log(parentArticle);

      // Prhimera ejecucción
      if (!previousArticle) {
        previousArticle = parentArticle;
        parentArticle.setAttribute('data-is-visible', 'true');
        parentArticle.setAttribute('data-is-tracking', 'true');
        parentArticle.setAttribute('data-scroll-index', scrollIndex++);
        dispatchTrackedEvent(currentMeta, false);
        firstArticleSlug = window.location.pathname + window.location.search;
        parentArticle.setAttribute('data-slug', firstArticleSlug);

        // Hay un nuevo articulo visible
      } else if (previousArticle !== parentArticle) {
        // console.log(parentArticle.dataset);
        // console.log(title, permalink);
        previousArticle.removeAttribute('data-is-visible');
        parentArticle.setAttribute('data-is-visible', 'true');
        changeTitle(title, permalink);
        previousArticle = parentArticle;
        WA_ThemeSetup.currentID = postId;

        trackingArticle(parentArticle, permalink);
        if (parentArticle.dataset.scrollIndex !== '0') {
          if (!articlesContainer.classList.contains('isScroll'))
            articlesContainer.classList.add('isScroll');
        } else {
          if (articlesContainer.classList.contains('isScroll'))
            articlesContainer.classList.remove('isScroll');
        }
      }
    }
  };

  const newArticleHandler = mutations => {
    mutations.forEach(function (mutation) {
      if (mutation.type === 'childList') {
        mutation.addedNodes.forEach(node => {
          if (node.nodeType === 1) {
            if (node.classList.contains('post')) {
              const mainText = document.querySelector(
                `#${node.id} .entry-main-text`
              );
              const parentArticle = mainText.closest('article');

              articleIntersectionObserver.observe(mainText);
              // console.log('Nuevo Artículo', 'Observer agregado');

              parentArticle.setAttribute('data-scroll-index', scrollIndex++);
            }
          }
        });
      }
    });
  };

  const init = () => {
    //console.log('Empieza a observar');

    const articlesContainer = document.querySelector(
      config.articlesContainerSelector
    );

    const newArticlesLoadedObserver = new MutationObserver(newArticleHandler);

    // pasa al observer el nodo y la configuracion
    newArticlesLoadedObserver.observe(articlesContainer, {
      attributes: true,
      childList: true,
      characterData: true,
    });

    const firstArticle = document.querySelector(config.firstArticleSelector);
    if (firstArticle && firstArticle.nodeType === 1) {
      articleIntersectionObserver.observe(firstArticle);
      // console.log('Primer articulo Observando');
    }

    const bodyEl = document.querySelector('body');
    if (bodyEl) {
      bodyEl.addEventListener('is.post-load', e => {
        // console.log('Es promoted ID', e.detail.postID);
        // console.log('Es promoted', e.detail.isPromoted);

        if (e.detail.postID && e.detail.isPromoted) {
          promotedArticles.push(parseInt(e.detail.postID, 10));

          // promotedArticles.push(e.detail.postID);
        }
      });

      //   bodyEl.addEventListener('is.post-tracked', e => {
      //     console.log('Artículo trackeado:', e.detail.postMeta);
      //     console.log('By Infinite Scroll:', e.detail.byInfiniteScroll);
      //   });
    }
  };

  return {
    init: init,
  };
})();

articlesObserver.init();
