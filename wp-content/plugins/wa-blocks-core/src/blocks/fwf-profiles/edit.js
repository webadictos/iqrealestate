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
import { useBlockProps } from '@wordpress/block-editor';
import { MediaUpload, InspectorControls } from '@wordpress/block-editor';
import {
  PanelBody,
  Button,
  TextControl,
  ToggleControl,
  Modal,
} from '@wordpress/components';

import { RichText } from '@wordpress/block-editor';
import { useState } from '@wordpress/element';
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
  registerBlockStyle('fw-festival-2024/fwf-profiles', {
    name: `fwf-profiles-green`,
    label: `Estilo Verde`,
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
  const { setAttributes } = props;

  const { items } = props.attributes;

  const addItem = newItem => {
    const newItems = [
      ...items,
      {
        image: newItem.image,
        caption: newItem.caption,
      },
    ];
    setAttributes({ items: newItems });
    console.log(items);
  };

  const removeItem = index => {
    const newItems = [...items];
    newItems.splice(index, 1);
    setAttributes({ items: newItems });
  };

  // Estado para realizar un seguimiento del índice de la imagen seleccionada para editar
  const [selectedImageIndex, setSelectedImageIndex] = useState(null);

  return (
    <div {...useBlockProps()}>
      <div className="wp-block-fw-festival-2024-fwf-profiles__btn-container">
        <MediaUpload
          onSelect={media =>
            addItem({ image: media.url, caption: media.caption })
          }
          type="image"
          value={{}}
          render={({ open }) => (
            <Button
              onClick={open}
              className="wwp-block-fw-festival-2024-fwf-profiles__btn"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                fill="currentColor"
                class="bi bi-card-image"
                viewBox="0 0 16 16"
              >
                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                <path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2zm13 1a.5.5 0 0 1 .5.5v6l-3.775-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12v.54L1 12.5v-9a.5.5 0 0 1 .5-.5z" />
              </svg>{' '}
              Añadir Perfil
            </Button>
          )}
          allowedTypes={['image']} // Permitir solo tipos de archivos de imagen
          accept="image/*" // Aceptar todos los tipos de imagen
        />
      </div>
      <div className="wp-block-fw-festival-2024-fwf-profiles__container">
        {items.map((item, itemIndex) => {
          //   console.log('Valor de item.image:', item.image); // Agregar console.log para depurar

          return (
            <div
              key={itemIndex}
              className="wp-block-fw-festival-2024-fwf-profiles__item"
            >
              <div className="wp-block-fw-festival-2024-fwf-profiles__item-container">
                {item.image ? (
                  <figure className="wp-block-fw-festival-2024-fwf-profiles__figure">
                    <MediaUpload
                      onSelect={media => {
                        const newItems = [...items];
                        newItems[itemIndex].image = media.url;
                        newItems[itemIndex].caption = media.caption; // Agregar el título al ítem
                        setAttributes({ items: newItems });
                      }}
                      type="image"
                      value={item.image}
                      render={({ open }) => (
                        <img
                          src={item.image}
                          alt="Imagen de portada"
                          className="wp-block-fw-festival-2024-fwf-profiles__img"
                          // Abrir el selector de medios al hacer clic en la imagen
                          onClick={open}
                        />
                      )}
                    />
                  </figure>
                ) : (
                  <MediaUpload
                    onSelect={media => {
                      const newItems = [...items];
                      newItems[itemIndex].image = media.url;
                      newItems[itemIndex].caption = media.caption; // Agregar el título al ítem
                      setAttributes({ items: newItems });
                    }}
                    type="image"
                    value={item.image}
                    render={({ open }) => (
                      <Button
                        onClick={open}
                        className="wwp-block-fw-festival-2024-fwf-profiles__btn"
                      >
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="16"
                          height="16"
                          fill="currentColor"
                          class="bi bi-card-image"
                          viewBox="0 0 16 16"
                        >
                          <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                          <path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2zm13 1a.5.5 0 0 1 .5.5v6l-3.775-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12v.54L1 12.5v-9a.5.5 0 0 1 .5-.5z" />
                        </svg>{' '}
                        Seleccionar imagen
                      </Button>
                    )}
                  />
                )}
                <div className="wp-block-fw-festival-2024-fwf-profiles__meta">
                  <RichText
                    tagName="h3"
                    className="wp-block-fw-festival-2024-fwf-profiles__meta_title"
                    value={item.title ?? ''}
                    onChange={newTitle => {
                      const newItems = [...items];
                      newItems[itemIndex].title = newTitle;
                      setAttributes({ items: newItems });
                    }}
                    placeholder={__('Encabezado ...')}
                  />

                  <RichText
                    tagName="p"
                    className="wp-block-fw-festival-2024-fwf-profiles__meta_description"
                    value={item.description ?? ''}
                    onChange={newDescription => {
                      const newItems = [...items];
                      newItems[itemIndex].description = newDescription;
                      setAttributes({ items: newItems });
                    }}
                    placeholder={__('Descripción...')}
                  />
                </div>
              </div>

              <Button
                onClick={() => removeItem(itemIndex)}
                className="wp-block-fw-festival-2024-fwf-profiles__remove-image-btn"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-x-circle-fill"
                  viewBox="0 0 16 16"
                >
                  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
                </svg>
              </Button>
            </div>
          );
        })}
      </div>

      {items.length > 1 && (
        <div className="wp-block-fw-festival-2024-fwf-profiles__btn-container">
          <MediaUpload
            onSelect={media =>
              addItem({ image: media.url, caption: media.caption })
            }
            type="image"
            value={{}}
            render={({ open }) => (
              <Button
                onClick={open}
                className="wp-block-fw-festival-2024-fwf-profiles__btn"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-card-image"
                  viewBox="0 0 16 16"
                >
                  <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                  <path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2zm13 1a.5.5 0 0 1 .5.5v6l-3.775-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12v.54L1 12.5v-9a.5.5 0 0 1 .5-.5z" />
                </svg>{' '}
                Añadir perfil
              </Button>
            )}
            allowedTypes={['image']} // Permitir solo tipos de archivos de imagen
            accept="image/*" // Aceptar todos los tipos de imagen
          />
        </div>
      )}
    </div>
  );
}
