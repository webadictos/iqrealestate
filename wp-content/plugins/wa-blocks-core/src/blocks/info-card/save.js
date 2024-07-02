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
 */
export default function save(props) {
  const { attributes } = props;

  return (
    <>
      {!attributes.address &&
      !attributes.phone &&
      !attributes.whatsapp &&
      !attributes.web &&
      !attributes.facebook &&
      !attributes.instagram &&
      !attributes.twitter ? (
        ''
      ) : (
        <div {...useBlockProps.save()}>
          <div className="wp-block-wa-blocks-core-info-card__container">
            <ul className="wp-block-wa-blocks-core-info-card__info">
              {!attributes.address ? null : (
                <li>
                  <span className="wp-block-wa-blocks-core-info-card__label">
                    Dirección:
                  </span>
                  <span className="wp-block-wa-blocks-core-info-card__address">
                    {attributes.address}
                  </span>
                </li>
              )}
              {!attributes.phone ? null : (
                <li>
                  <div className="wp-block-wa-blocks-core-info-card__label">
                    Teléfono:
                  </div>
                  <div className="wp-block-wa-blocks-core-info-card__phone">
                    <a
                      href={'tel:' + attributes.phone}
                      target="_blank"
                      rel="noopener"
                    >
                      {attributes.phone}
                    </a>
                  </div>
                </li>
              )}

              {!attributes.whatsapp ? null : (
                <li>
                  <div className="wp-block-wa-blocks-core-info-card__whatsapp">
                    <a
                      href={
                        'https://wa.me/' +
                        attributes.whatsapp.replace(/\D/g, '')
                      }
                      target="_blank"
                      rel="noopener"
                    >
                      {attributes.whatsapp}
                    </a>
                  </div>
                </li>
              )}
              {!attributes.web && !isURL(attributes.web) ? null : (
                <li>
                  <div className="wp-block-wa-blocks-core-info-card__label">
                    Sitio Web:
                  </div>
                  <div className="wp-block-wa-blocks-core-info-card__url">
                    <a href={attributes.web} target="_blank" rel="noopener">
                      {getAuthority(attributes.web)}
                    </a>
                  </div>
                </li>
              )}

              <li className="wp-block-wa-blocks-core-info-card__social-networks">
                {!attributes.facebook && !isURL(attributes.facebook) ? null : (
                  <>
                    <a
                      className="wp-block-wa-blocks-core-info-card__social--facebook"
                      href={attributes.facebook}
                      target="_blank"
                      rel="noopener"
                    >
                      {getPath(attributes.facebook).replace(/\/$/, '')}
                    </a>
                  </>
                )}
                {!attributes.instagram &&
                !isURL(attributes.instagram) ? null : (
                  <>
                    <a
                      className="wp-block-wa-blocks-core-info-card__social--instagram"
                      href={attributes.instagram}
                      target="_blank"
                      rel="noopener"
                    >
                      {getPath(attributes.instagram).replace(/\/$/, '')}
                    </a>
                  </>
                )}
                {!attributes.twitter && !isURL(attributes.twitter) ? null : (
                  <>
                    <a
                      className="wp-block-wa-blocks-core-info-card__social--twitter"
                      href={attributes.twitter}
                      target="_blank"
                      rel="noopener"
                    >
                      {getPath(attributes.twitter).replace(/\/$/, '')}
                    </a>
                  </>
                )}
              </li>
            </ul>
          </div>
        </div>
      )}
    </>
  );
}
