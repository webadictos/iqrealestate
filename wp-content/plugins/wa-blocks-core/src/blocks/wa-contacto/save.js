/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {Element} Element to render.
 */
const getSocialIcon = url => {
  if (url.includes('facebook.com')) {
    return <i className="fab fa-facebook"></i>;
  } else if (url.includes('twitter.com')) {
    return <i className="fab fa-twitter"></i>;
  } else if (url.includes('instagram.com')) {
    return <i className="fab fa-instagram"></i>;
  } else if (url.includes('linkedin.com')) {
    return <i className="fab fa-linkedin"></i>;
  } else if (url.includes('youtube.com')) {
    return <i className="fab fa-youtube"></i>;
  } else {
    return <i className="fas fa-link"></i>;
  }
};

export default function save({ attributes }) {
  const { address, phones, emails, socialLinks, backgroundImage } = attributes;
  const blockProps = useBlockProps.save();

  return (
    <div {...blockProps}>
      <div className="wp-block-wa-blocks-core-wa-contacto__wrapper">
        {backgroundImage && (
          <div className="wp-block-wa-blocks-core-wa-contacto__background">
            <img
              src={backgroundImage.sizes.full.url}
              width={backgroundImage.sizes.full.width}
              height={backgroundImage.sizes.full.height}
            />
          </div>
        )}
        <div className="wp-block-wa-blocks-core-wa-contacto__info-wrapper">
          <h2 className="wp-block-wa-blocks-core-wa-contacto__info-title">
            Contáctanos:
          </h2>
          <div className="wp-block-wa-blocks-core-wa-contacto__info-address wa-contacto-info">
            {address}
          </div>
          <div className="wp-block-wa-blocks-core-wa-contacto__info-phone wa-contacto-info">
            <ul>
              {phones.map((phone, index) => (
                <li key={index}>{phone}</li>
              ))}
            </ul>
          </div>
          <div className="wp-block-wa-blocks-core-wa-contacto__info-email wa-contacto-info">
            <ul>
              {emails.map((email, index) => (
                <li key={index}>{email}</li>
              ))}
            </ul>
          </div>
          <div className="wp-block-wa-blocks-core-wa-contacto__info-social wa-contacto-info">
            <p>Síguenos:</p>
            <ul>
              {socialLinks.map((link, index) => (
                <li key={index}>
                  <a
                    href={link.url}
                    target="_blank"
                    rel="noopener noreferrer"
                    title={link.name}
                  >
                    {getSocialIcon(link.url)}
                  </a>
                </li>
              ))}
            </ul>
          </div>
        </div>
        <div className="wp-block-wa-blocks-core-wa-contacto__form-wrapper">
          <InnerBlocks.Content />
        </div>
      </div>
    </div>
  );
}
