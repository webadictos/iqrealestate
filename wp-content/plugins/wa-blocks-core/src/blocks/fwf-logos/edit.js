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
  MediaUpload,
  MediaUploadCheck,
  InspectorControls,
  useBlockProps,
} from '@wordpress/block-editor';
import {
  Button,
  PanelBody,
  RangeControl,
  TextControl,
} from '@wordpress/components';

import domReady from '@wordpress/dom-ready';
import { registerBlockStyle } from '@wordpress/blocks';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

// Register a block style for each icon.
domReady(() => {
  registerBlockStyle('wa-blocks-core/wa-gallery', {
    name: `fwf-logos-layout-dos`,
    label: `Layout Dos`,
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
  const { images } = props.attributes;
  const { setAttributes } = props;

  //   const onSelectImages = newImages => {
  //     setAttributes({
  //       images: newImages.map(img => ({
  //         id: img.id,
  //         url: img.url,
  //         originalWidth: img.sizes.full.width, // Guardamos el ancho original de la imagen
  //         originalHeight: img.sizes.full.height, // Guardamos el alto original de la imagen
  //         maxWidth: img.sizes.full.width, // Inicialmente, el ancho máximo es el ancho original
  //         className: '',
  //       })),
  //     });
  //   };
  const onSelectImages = newImages => {
    // Crear un mapa de las imágenes existentes por ID
    const existingImagesMap = images.reduce((map, img) => {
      map[img.id] = img;
      return map;
    }, {});

    // Procesar las imágenes seleccionadas
    const updatedImages = newImages.map(img => {
      // Si la imagen ya existe, mantenemos sus atributos actuales
      if (existingImagesMap[img.id]) {
        return existingImagesMap[img.id];
      }
      // Si la imagen es nueva, creamos sus atributos usando las dimensiones de img.sizes.full
      const originalWidth = img.sizes.full.width;
      const originalHeight = img.sizes.full.height;

      return {
        id: img.id,
        url: img.url,
        originalWidth: originalWidth,
        originalHeight: originalHeight,
        maxWidth: originalWidth > 200 ? 200 : originalWidth,
        className: '',
      };
    });

    setAttributes({ images: updatedImages });
  };

  const onChangeMaxWidth = (index, value) => {
    const newImages = [...images];
    newImages[index].maxWidth = value;
    setAttributes({ images: newImages });
  };

  const onChangeClassName = (index, value) => {
    const newImages = [...images];
    newImages[index].className = value;
    setAttributes({ images: newImages });
  };

  return (
    <div {...useBlockProps()}>
      <InspectorControls>
        {images.length > 0 && (
          <PanelBody title="Configuración de los logos">
            {images.map((img, index) => (
              <div
                key={img.id}
                className="wp-block-fw-festival-2024-fwf-logos__settings"
              >
                <img src={img.url} width="100" height="auto" />
                <RangeControl
                  label="Ancho máximo"
                  value={img.maxWidth}
                  onChange={value => onChangeMaxWidth(index, value)}
                  min={10}
                  max={img.originalWidth}
                />
                <TextControl
                  label={__('Class Name', 'custom-image-block')}
                  value={img.className}
                  onChange={value => onChangeClassName(index, value)}
                />
              </div>
            ))}
          </PanelBody>
        )}
      </InspectorControls>
      <MediaUploadCheck>
        <MediaUpload
          onSelect={onSelectImages}
          allowedTypes={['image']}
          multiple
          gallery
          value={images.map(img => img.id)}
          render={({ open }) => (
            <Button
              onClick={open}
              className="wp-block-fw-festival-2024-fwf-logos__btn"
            >
              {images.length === 0
                ? __('Cargar Logos', 'custom-image-block')
                : __('Editar Logos', 'custom-image-block')}
            </Button>
          )}
        />
      </MediaUploadCheck>
      <div className="wp-block-fw-festival-2024-fwf-logos__wrapper">
        {images.map(img => (
          <img
            src={img.url}
            alt=""
            width={img.maxWidth}
            height={(img.maxWidth / img.originalWidth) * img.originalHeight}
            key={img.id}
            className={`wp-block-fw-festival-2024-fwf-logos__img ${img.className}`}
          />
        ))}
      </div>
    </div>
  );
}
