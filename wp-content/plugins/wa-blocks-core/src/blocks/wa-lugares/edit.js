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

import { registerBlockType } from '@wordpress/blocks';
import { Button, Modal, TextControl, Spinner } from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';
import { getAuthority, getPath, isURL, isValidAuthority } from '@wordpress/url';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
  const [isModalOpen, setModalOpen] = useState(false);
  const [selectedContent, setSelectedContent] = useState(
    attributes.selectedContent || null
  );
  const [searchTerm, setSearchTerm] = useState(attributes.searchTerm || '');
  const [isLoading, setLoading] = useState(false);
  const [searchResults, setSearchResults] = useState([]);

  const openModal = () => {
    setModalOpen(true);
    setSearchTerm('');
    setSearchResults([]);
  };

  const closeModal = () => {
    setModalOpen(false);
  };

  const handleContentSelection = content => {
    setSelectedContent(content);
    closeModal();
    setAttributes({ selectedContent: content });
    console.log(content);
  };

  const handleSearchTermChange = value => {
    setSearchTerm(value);
  };

  const fetchSearchResults = async () => {
    setLoading(true);

    try {
      const results = await apiFetch({
        path: `/wp/v2/fp_location?search=${encodeURIComponent(searchTerm)}`,
      });

      setSearchResults(results);
    } catch (error) {
      console.error('Error fetching search results:', error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    if (searchTerm) {
      fetchSearchResults();
    }
  }, [searchTerm]);

  /**
   * 
   * fp_location_fields
: 
fp_location_direccion
: 
"Bryan's, Calle 7, Residencial Montecristo, Mérida, Yuc., México"
fp_location_geolocalizacion
: 
{latitude: '21.0184178', longitude: '-89.5933276'}
fp_location_social_networks
: 
(3) [{…}, {…}, {…}]
fp_location_telefono
: 
"9992783884"
fp_location_web
: 
"https://webadictos.com"
fp_location_whatsapp
: 
"9992783884"

         data-place-id={selectedContent.id}
          data-place-latitude={
            selectedContent.cmb2.fp_location_fields.fp_location_geolocalizacion
              .latitude
          }
          data-place-longitude={
            selectedContent.cmb2.fp_location_fields.fp_location_geolocalizacion
              .longitude
          }
   */
  const blockProps = useBlockProps({
    className: 'wa-place-item',
    'data-place-id': `${
      selectedContent && selectedContent.id !== undefined
        ? selectedContent.id
        : 0
    }`,
    'data-place-latitude': `${
      selectedContent &&
      selectedContent.cmb2.fp_location_fields.fp_location_geolocalizacion
        .latitude !== undefined
        ? selectedContent.cmb2.fp_location_fields.fp_location_geolocalizacion
            .latitude
        : 0
    }`,
    'data-place-longitude': `${
      selectedContent &&
      selectedContent.cmb2.fp_location_fields.fp_location_geolocalizacion
        .longitude !== undefined
        ? selectedContent.cmb2.fp_location_fields.fp_location_geolocalizacion
            .longitude
        : 0
    }`,
  });

  return (
    <div {...blockProps}>
      {selectedContent && (
        <div className="wp-block-wa-blocks-core-wa-lugares__item">
          <h3 className="wp-block-wa-blocks-core-wa-lugares__item--title">
            {selectedContent.title.rendered}
          </h3>
          <ul className="wp-block-wa-blocks-core-wa-lugares__info">
            {!selectedContent.cmb2.fp_location_fields
              .fp_location_direccion ? null : (
              <li>
                <span className="wp-block-wa-blocks-core-wa-lugares__info--label">
                  Dirección:
                </span>{' '}
                <span className="wp-block-wa-blocks-core-wa-lugares__info--value">
                  {
                    selectedContent.cmb2.fp_location_fields
                      .fp_location_direccion
                  }
                </span>
              </li>
            )}
            {!selectedContent.cmb2.fp_location_fields
              .fp_location_telefono ? null : (
              <li>
                <span className="wp-block-wa-blocks-core-wa-lugares__info--label">
                  Teléfono:
                </span>{' '}
                <span className="wp-block-wa-blocks-core-wa-lugares__info--value">
                  {selectedContent.cmb2.fp_location_fields.fp_location_telefono}
                </span>
              </li>
            )}

            {!selectedContent.cmb2.fp_location_fields.fp_location_web &&
            !isURL(
              selectedContent.cmb2.fp_location_fields.fp_location_web
            ) ? null : (
              <li>
                <span className="wp-block-wa-blocks-core-wa-lugares__info--label">
                  Sitio Web:
                </span>{' '}
                <span className="wp-block-wa-blocks-core-wa-lugares__info--value">
                  <a
                    href={
                      selectedContent.cmb2.fp_location_fields.fp_location_web
                    }
                    target="_blank"
                    rel="noopener"
                  >
                    {getAuthority(
                      selectedContent.cmb2.fp_location_fields.fp_location_web
                    )}
                  </a>
                </span>
              </li>
            )}

            {selectedContent.cmb2.fp_location_fields
              .fp_location_social_networks ? (
              <li className="wp-block-wa-blocks-core-wa-lugares__social-networks">
                <span className="wp-block-wa-blocks-core-wa-lugares__info--label">
                  Redes sociales:
                </span>{' '}
                {selectedContent.cmb2.fp_location_fields.fp_location_social_networks.map(
                  (element, index) => (
                    <>
                      <a
                        className={`wp-block-wa-blocks-core-wa-lugares__info--value wp-block-wa-blocks-core-wa-lugares__social--${element.social}`}
                        href={element.url}
                        target="_blank"
                        rel="noopener"
                        key={index}
                      >
                        {getPath(element.url).replace(/\/$/, '')}
                      </a>{' '}
                    </>
                  )
                )}
              </li>
            ) : null}
          </ul>
        </div>
      )}
      <Button onClick={openModal}>
        {selectedContent ? 'Cambiar lugar' : 'Seleccionar lugar'}
      </Button>

      {isModalOpen && (
        <Modal title="Seleccionar lugar" onRequestClose={closeModal}>
          <TextControl
            value={searchTerm}
            onChange={handleSearchTermChange}
            placeholder="Introduce un término de búsqueda"
          />
          {isLoading ? (
            <Spinner />
          ) : (
            <ul>
              {searchResults.map(result => (
                <li key={result.id}>
                  <Button onClick={() => handleContentSelection(result)}>
                    {result.title.rendered}
                  </Button>
                </li>
              ))}
            </ul>
          )}
        </Modal>
      )}
    </div>
  );
}
