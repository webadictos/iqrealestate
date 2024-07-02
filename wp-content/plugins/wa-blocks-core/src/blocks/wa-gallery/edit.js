/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {
  useBlockProps,
  MediaUpload,
  InspectorControls,
  RichText,
} from '@wordpress/block-editor';
import {
  SelectControl,
  PanelBody,
  ToggleControl,
  TextControl,
} from '@wordpress/components';
import domReady from '@wordpress/dom-ready';
import { registerBlockStyle } from '@wordpress/blocks';

import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Pagination, Scrollbar, A11y } from 'swiper/modules';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
// Import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';

// Register a block style for each icon.
domReady(() => {
  registerBlockStyle('wa-blocks-core/wa-gallery', {
    name: `wa-gallery-layout-dos`,
    label: `Layout Dos`,
  });

  registerBlockStyle('wa-blocks-core/wa-gallery', {
    name: `wa-gallery-layout-tres`,
    label: `Layout Tres`,
  });
});

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit(props) {
  const {
    images,
    isSlider,
    haveNavigation,
    havePagination,
    haveLightbox,
    slidesPerView,
    spaceBetween,
    showLegend,
    captionOver,
    imageRatio,
    anchoBloque,
    unidadAncho,
    galleryCaption,
  } = props.attributes;
  const { setAttributes } = props;

  const onSelectImage = newImages => {
    setAttributes({ images: newImages });
  };

  // console.log(images);

  const toggleSlider = value => {
    setAttributes({ isSlider: value });
  };

  return (
    <div {...useBlockProps()}>
      <InspectorControls>
        <PanelBody title="Opciones de la galería">
          {/* <TextControl
            label="Ancho del Bloque"
            value={anchoBloque}
            onChange={value => setAttributes({ anchoBloque: value })}
          />
          <SelectControl
            label="Unidad del Ancho"
            value={unidadAncho}
            options={[
              { label: '%', value: '%' },
              { label: 'px', value: 'px' },
              { label: 'rem', value: 'rem' },
            ]}
            onChange={value => setAttributes({ unidadAncho: value })}
          /> */}

          <ToggleControl
            label="Habilitar Slider"
            checked={isSlider}
            onChange={toggleSlider}
          />

          {isSlider && ( // Verifica si isSlider es true
            <>
              <ToggleControl
                label="Activar navegación (Flechas)"
                checked={haveNavigation}
                onChange={value => setAttributes({ haveNavigation: value })}
              />

              <ToggleControl
                label="Activar paginación"
                checked={havePagination}
                onChange={value => setAttributes({ havePagination: value })}
              />

              <TextControl
                label="Slides Per View"
                value={slidesPerView}
                onChange={value => {
                  setAttributes({ slidesPerView: value });
                }}
              />
              <TextControl
                label="Space Between Slides"
                value={spaceBetween}
                onChange={value => {
                  setAttributes({ spaceBetween: value });
                }}
              />
              <SelectControl
                label="Proporción de las imagenes"
                value={imageRatio}
                options={[
                  { label: 'Original', value: 'reverse' },
                  { label: '16:9', value: '16/9' },
                  { label: '4:3', value: '4/3' },
                  { label: '1:1', value: '1/1' },
                ]}
                onChange={selectedValue => {
                  setAttributes({ imageRatio: selectedValue });
                }}
              />
            </>
          )}
          <ToggleControl
            label="Activar Lightbox"
            checked={haveLightbox}
            onChange={value => setAttributes({ haveLightbox: value })}
          />

          <ToggleControl
            label="Mostrar leyenda"
            checked={showLegend}
            onChange={value => setAttributes({ showLegend: value })}
          />

          <ToggleControl
            label="Mostrar leyenda encima de la imagen"
            checked={captionOver}
            onChange={value => setAttributes({ captionOver: value })}
          />
        </PanelBody>
      </InspectorControls>

      <MediaUpload
        onSelect={onSelectImage}
        type="image"
        multiple
        gallery
        value={images.map(image => image.id)}
        render={({ open }) => (
          <button
            className="wp-block-wa-blocks-core-wa-gallery__btn"
            onClick={open}
          >
            {images.length > 0
              ? 'Edita las imagenes'
              : 'Selecciona las imágenes'}
          </button>
        )}
      />

      {isSlider ? ( // Verifica si isSlider es true
        <Swiper
          modules={[Navigation, Pagination]}
          spaceBetween={spaceBetween}
          slidesPerView={slidesPerView}
          navigation={haveNavigation} // Habilita la navegación si haveNavigation es verdadero
          pagination={havePagination ? { clickable: true } : false} // Habilita la paginación si havePagination es verdadero
          grabCursor
          //   onSlideChange={() => console.log('slide change')}
          //   onSwiper={swiper => console.log(swiper)}
          style={{
            '--wa-gallery-aspect-ratio': imageRatio,
          }}
        >
          {images.map((image, index) => (
            <SwiperSlide key={image.id} tag="figure">
              {haveLightbox && <button class="wa-gallery-lightbox"></button>}
              <img
                src={image.url}
                alt={image.alt}
                style={{ maxWidth: '100%' }}
              />
              {showLegend && image.caption && (
                <figcaption
                  className={
                    captionOver ? 'wa-gallery__grid-item-caption-over' : ''
                  }
                >
                  <p>{image.caption}</p>
                </figcaption>
              )}
            </SwiperSlide>
          ))}
          <RichText
            tagName="div"
            placeholder="Añadir una descripción de la galería"
            className="wp-block-wa-blocks-core-wa-gallery__caption"
            value={galleryCaption}
            onChange={value => setAttributes({ galleryCaption: value })}
          />
        </Swiper>
      ) : (
        <div className="wp-block-wa-blocks-core-wa-gallery__grid">
          {images.map((image, index) => (
            <figure
              className="wp-block-wa-blocks-core-wa-gallery__grid-item"
              key={image.id}
            >
              {haveLightbox && <button class="wa-gallery-lightbox"></button>}
              <img
                src={image.url}
                alt={image.alt}
                style={{ maxWidth: '100%' }}
              />
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
          <RichText
            tagName="div"
            placeholder="Añadir una descripción de la galería"
            className="wp-block-wa-blocks-core-wa-gallery__caption"
            value={galleryCaption}
            onChange={value => setAttributes({ galleryCaption: value })}
          />
        </div>
      )}
    </div>
  );
}
