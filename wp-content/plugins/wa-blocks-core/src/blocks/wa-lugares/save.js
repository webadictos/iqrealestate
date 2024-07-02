/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';
import { getAuthority, getPath, isURL, isValidAuthority } from '@wordpress/url';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 * 
 *          data-place-id={selectedContent.id}
          data-place-latitude={
            selectedContent.cmb2.fp_location_fields.fp_location_geolocalizacion
              .latitude
          }
          data-place-longitude={
            selectedContent.cmb2.fp_location_fields.fp_location_geolocalizacion
              .longitude
          }
 */
export default function save(props) {
  const { attributes } = props;
  const { selectedContent } = attributes;

  if (selectedContent) {
    const {
      id,
      cmb2: {
        fp_location_fields: {
          fp_location_geolocalizacion: { latitude, longitude },
        },
      },
    } = selectedContent;

    // const blockProps = useBlockProps.save();

    // Crear un nuevo objeto de atributos con los atributos data- agregados
    const blockProps = useBlockProps.save({
      className: 'wa-place-item',
      'data-place-id': `${id !== undefined ? id : 0}`,
      'data-place-latitude': `${latitude !== undefined ? latitude : 0}`,
      'data-place-longitude': `${longitude !== undefined ? longitude : 0}`,
    });

    return (
      <div {...blockProps}>
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
        {latitude !== '' && longitude !== '' ? (
          <div className="wp-block-wa-blocks-core-wa-lugares__item--button">
            {' '}
            <button className="btn btn-primary btn-map">Ver en mapa</button>
          </div>
        ) : null}
      </div>
    );
  }
}
