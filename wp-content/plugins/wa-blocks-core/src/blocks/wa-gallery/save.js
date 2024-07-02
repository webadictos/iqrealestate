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
    spaceBetween,
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
    spaceBetween: spaceBetween,
    haveLightbox: haveLightbox,
  };

  return (
    <div {...useBlockProps.save()}>
      {isSlider ? ( // Verifica si isSlider es true
        <div
          class="swiper wa-swipper-gallery"
          data-wa-gallery={JSON.stringify(galleryData)}
          style={{
            '--wa-gallery-aspect-ratio': imageRatio,
          }}
        >
          <div class="swiper-wrapper">
            {images.map(image => (
              <figure className="swiper-slide" key={image.id}>
                {haveLightbox && (
                  <button
                    class="wa-gallery-lightbox"
                    data-src={image.sizes.full.url}
                    data-caption={image.caption}
                  ></button>
                )}

                <img src={image.url} alt={image.alt} />
                {showLegend && image.caption && (
                  <figcaption
                    className={
                      captionOver ? 'wa-gallery__grid-item-caption-over' : ''
                    }
                  >
                    <p>{image.caption}</p>
                  </figcaption>
                )}
              </figure>
            ))}
          </div>
          {galleryCaption && (
            <figcaption className="wp-block-wa-blocks-core-wa-gallery__caption">
              <RichText.Content value={galleryCaption} />
            </figcaption>
          )}
          {havePagination && <div class="swiper-pagination"></div>}
          {haveNavigation && (
            <>
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>
            </>
          )}
        </div>
      ) : (
        <div className="wp-block-wa-blocks-core-wa-gallery__grid">
          {images.map(image => (
            <figure
              className="wp-block-wa-blocks-core-wa-gallery__grid-item"
              key={image.id}
            >
              {haveLightbox && (
                <button
                  class="wa-gallery-lightbox"
                  data-src={image.sizes.full.url}
                  data-caption={image.caption}
                  title="Expandir"
                  aria-title="Expandir"
                ></button>
              )}

              <img src={image.url} alt={image.alt} />
              {showLegend && image.caption && (
                <figcaption
                  className={
                    captionOver ? 'wa-gallery__grid-item-caption-over' : ''
                  }
                >
                  <p>{image.caption}</p>
                </figcaption>
              )}
            </figure>
          ))}
          {galleryCaption && (
            <figcaption className="wp-block-wa-blocks-core-wa-gallery__caption">
              <RichText.Content value={galleryCaption} />
            </figcaption>
          )}
        </div>
      )}
    </div>
  );
}
