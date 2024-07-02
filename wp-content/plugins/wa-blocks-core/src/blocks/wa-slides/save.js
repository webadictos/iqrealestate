/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, RichText } from '@wordpress/block-editor';

// import { Swiper, SwiperSlide } from 'swiper/react';
// import Swiper, { SwiperSlide } from 'swiper';
// import 'swiper/swiper-bundle.css'; // Importa los estilos CSS de SwiperJS

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {Element} Element to render.
 */
export default function save(props) {
  const {
    images,
    isSlider,
    haveNavigation,
    havePagination,
    slidesPerView,
    slidesPerViewTablet,
    slidesPerViewMobile,
    spaceBetween,
    spaceBetweenTablet,
    spaceBetweenMobile,
    direction,
    directionTablet,
    directionMobile,
    showLegend,
    haveLightbox,
    captionOver,
    imageRatio,
    anchoBloque,
    unidadAncho,
    galleryCaption,
  } = props.attributes;

  const galleryData = {
    pagination: havePagination,
    navigation: haveNavigation,
    slidesPerView: slidesPerView,
    slidesPerViewTablet: slidesPerViewTablet,
    slidesPerViewMobile: slidesPerViewMobile,
    spaceBetween: spaceBetween,
    spaceBetweenTablet: spaceBetweenTablet,
    spaceBetweenMobile: spaceBetweenMobile,
    direction: direction,
    directionTablet: directionTablet,
    directionMobile: directionMobile,
    haveLightbox: haveLightbox,
  };

  return (
    <div {...useBlockProps.save()}>
      <div
        class="swiper wa-swipper-slides"
        data-wa-gallery={JSON.stringify(galleryData)}
        style={{
          '--wa-gallery-aspect-ratio': imageRatio,
        }}
      >
        <div class="swiper-wrapper">
          {images.map(image => (
            <div className="swiper-slide" key={image.id}>
              {image.caption && (
                <div class="wp-block-wa-blocks-core-wa-slides__meta">
                  <RichText.Content
                    tagName="h3"
                    value={image.caption}
                    className="wp-block-wa-blocks-core-wa-slides__meta--title"
                  />
                </div>
              )}

              <figure className="wp-block-wa-blocks-core-wa-slides__figure">
                {image.linkTarget ? (
                  <a
                    href={image.linkTarget}
                    className="wp-block-wa-blocks-core-wa-slides__url"
                  >
                    <img
                      src={image.url}
                      alt={image.alt}
                      width={image?.sizes?.full?.width}
                      height={image?.sizes?.full?.height}
                    />
                  </a>
                ) : (
                  <img
                    src={image.url}
                    alt={image.alt}
                    width={image.sizes.full.width}
                    height={image.sizes.full.height}
                  />
                )}
              </figure>
            </div>
          ))}
        </div>
        {haveNavigation && (
          <>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
          </>
        )}
      </div>
    </div>
  );
}
