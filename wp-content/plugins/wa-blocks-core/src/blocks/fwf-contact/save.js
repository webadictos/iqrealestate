/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, RichText } from '@wordpress/block-editor';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {Element} Element to render.
 */
export default function save({ attributes }) {
  const { contacts } = attributes;

  return (
    <div {...useBlockProps.save()}>
      {contacts.map((contact, index) => (
        <div
          className="wp-block-fw-festival-2024-fwf-contact__item"
          key={index}
        >
          {contact.name && (
            <RichText.Content
              tagName="p"
              className="wp-block-fw-festival-2024-fwf-contact__name"
              value={contact.name}
            />
          )}

          {contact.email && (
            <a
              href={`mailto:${contact.email}`}
              className="wp-block-fw-festival-2024-fwf-contact__email"
            >
              <RichText.Content value={contact.email} />
            </a>
          )}
        </div>
      ))}
    </div>
  );
}
