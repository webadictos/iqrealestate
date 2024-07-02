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
  RichText,
  URLInputButton,
  InspectorControls,
} from '@wordpress/block-editor';
import {
  PanelBody,
  SelectControl,
  RangeControl,
  ToggleControl,
} from '@wordpress/components';
import domReady from '@wordpress/dom-ready';
import { registerBlockStyle } from '@wordpress/blocks';

import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Pagination } from 'swiper/modules';

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

// Register a block style for each icon.
domReady(() => {
  registerBlockStyle('wa-blocks-core/wa-slides', {
    name: `wa-slides-simple`,
    label: `Solo imágenes`,
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
  const { attributes, setAttributes } = props;
  const {
    images,
    slidesPerView,
    slidesPerViewTablet,
    slidesPerViewMobile,
    spaceBetween,
    spaceBetweenTablet,
    spaceBetweenMobile,
    direction,
    directionMobile,
    directionTablet,
    haveNavigation,
    havePagination,
  } = attributes;

  const onSelectImage = newImages => {
    const updatedImages = newImages.map((image, index) => ({
      id: image.id,
      url: image.url,
      alt: image.alt,
      sizes: image.sizes,
      caption: images[index]?.caption || image.caption || '',
      title: images[index]?.title || '',
      linkTarget: images[index]?.linkTarget || '',
    }));
    setAttributes({ images: updatedImages });
  };

  const onChangeCaption = (caption, index) => {
    const updatedImages = images.map((image, i) =>
      i === index ? { ...image, caption } : image
    );
    setAttributes({ images: updatedImages });
  };

  const onChangeLink = (linkTarget, index) => {
    const updatedImages = images.map((image, i) =>
      i === index ? { ...image, linkTarget } : image
    );
    setAttributes({ images: updatedImages });
  };

  return (
    <div {...useBlockProps()}>
      <InspectorControls>
        <PanelBody title="Dirección del slider" initialOpen={false}>
          <SelectControl
            label="Dirección en Desktop"
            value={direction}
            options={[
              { label: 'Horizontal', value: 'horizontal' },
              { label: 'Vertical', value: 'vertical' },
            ]}
            onChange={value => setAttributes({ direction: value })}
          />
          <SelectControl
            label="Dirección en Tablet"
            value={directionTablet}
            options={[
              { label: 'Horizontal', value: 'horizontal' },
              { label: 'Vertical', value: 'vertical' },
            ]}
            onChange={value => setAttributes({ directionTablet: value })}
          />
          <SelectControl
            label="Dirección en Móvil"
            value={directionMobile}
            options={[
              { label: 'Horizontal', value: 'horizontal' },
              { label: 'Vertical', value: 'vertical' },
            ]}
            onChange={value => setAttributes({ directionMobile: value })}
          />
        </PanelBody>

        <PanelBody title="Slides a mostrar">
          <RangeControl
            label="Slides a mostrar (Desktop)"
            value={slidesPerView}
            onChange={value => setAttributes({ slidesPerView: value })}
            min={1}
            max={10}
            step={0.5}
          />
          <RangeControl
            label="Slides a mostrar (Tablet)"
            value={slidesPerViewTablet}
            onChange={value => setAttributes({ slidesPerViewTablet: value })}
            min={1}
            max={10}
            step={0.5}
          />
          <RangeControl
            label="Slides a mostrar (Móvil)"
            value={slidesPerViewMobile}
            onChange={value => setAttributes({ slidesPerViewMobile: value })}
            min={1}
            max={10}
            step={0.5}
          />
        </PanelBody>

        <PanelBody title="Espacio entre slides" initialOpen={false}>
          <RangeControl
            label="Espacio en Desktop"
            value={spaceBetween}
            onChange={value => setAttributes({ spaceBetween: value })}
            min={0}
            max={500}
            step={1}
          />
          <RangeControl
            label="Espacio en Tablet"
            value={spaceBetweenTablet}
            onChange={value => setAttributes({ spaceBetweenTablet: value })}
            min={0}
            max={500}
            step={1}
          />
          <RangeControl
            label="Espacio en Móvil"
            value={spaceBetweenMobile}
            onChange={value => setAttributes({ spaceBetweenMobile: value })}
            min={0}
            max={500}
            step={1}
          />
        </PanelBody>
        <PanelBody title="Opciones de navegación" initialOpen={false}>
          <ToggleControl
            label="Habilitar Navegación"
            checked={haveNavigation}
            onChange={value => setAttributes({ haveNavigation: value })}
          />
          <ToggleControl
            label="Habilitar Paginación"
            checked={havePagination}
            onChange={value => setAttributes({ havePagination: value })}
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
            className="wp-block-wa-blocks-core-wa-slides__btn"
            onClick={open}
          >
            {images.length > 0
              ? 'Edita las imagenes'
              : 'Selecciona las imágenes'}
          </button>
        )}
      />

      <Swiper
        modules={[Navigation, Pagination]}
        spaceBetween={spaceBetween}
        slidesPerView={slidesPerView}
        breakpoints={{
          640: {
            slidesPerView: slidesPerViewMobile,
            spaceBetween: spaceBetweenMobile,
          },
          768: {
            slidesPerView: slidesPerViewTablet,
            spaceBetween: spaceBetweenTablet,
          },
          1024: {
            slidesPerView: slidesPerView,
            spaceBetween: spaceBetween,
          },
        }}
        navigation={haveNavigation}
        pagination={havePagination}
        grabCursor={false}
      >
        {images.map((image, index) => (
          <SwiperSlide key={image.id} tag="div">
            <div className="wp-block-wa-blocks-core-wa-slides__meta">
              <RichText
                tagName="h3"
                value={image.caption}
                onChange={caption => onChangeCaption(caption, index)}
                placeholder={__('Añade una descripción...', 'text-domain')}
                className="wp-block-wa-blocks-core-wa-slides__meta--title"
              />
            </div>
            <figure className="wp-block-wa-blocks-core-wa-slides__figure">
              <img
                src={image.url}
                alt={image.alt}
                style={{ maxWidth: '100%' }}
              />
              <URLInputButton
                className="wp-block-wa-blocks-core-wa-slides__url"
                url={image.linkTarget}
                onChange={link => onChangeLink(link, index)}
              />
            </figure>
          </SwiperSlide>
        ))}
      </Swiper>
    </div>
  );
}
