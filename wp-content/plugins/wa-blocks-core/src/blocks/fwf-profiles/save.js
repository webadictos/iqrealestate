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
 *               <div className="wa-gallery-with-audio__speak-icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-megaphone"
                  viewBox="0 0 16 16"
                >
                  <path d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-.214c-2.162-1.241-4.49-1.843-6.912-2.083l.405 2.712A1 1 0 0 1 5.51 15.1h-.548a1 1 0 0 1-.916-.599l-1.85-3.49-.202-.003A2.014 2.014 0 0 1 0 9V7a2.02 2.02 0 0 1 1.992-2.013 75 75 0 0 0 2.483-.075c3.043-.154 6.148-.849 8.525-2.199zm1 0v11a.5.5 0 0 0 1 0v-11a.5.5 0 0 0-1 0m-1 1.35c-2.344 1.205-5.209 1.842-8 2.033v4.233q.27.015.537.036c2.568.189 5.093.744 7.463 1.993zm-9 6.215v-4.13a95 95 0 0 1-1.992.052A1.02 1.02 0 0 0 1 7v2c0 .55.448 1.002 1.006 1.009A61 61 0 0 1 4 10.065m-.657.975 1.609 3.037.01.024h.548l-.002-.014-.443-2.966a68 68 0 0 0-1.722-.082z" />
                </svg>
              </div>

			                <RichText.Content value={galleryCaption} />

 * @return {Element} Element to render.
 */
export default function save(props) {
  const { items } = props.attributes;

  return (
    <div {...useBlockProps.save()}>
      <div className="wp-block-fw-festival-2024-fwf-profiles__container">
        {items.map((item, itemIndex) => (
          <div
            key={itemIndex}
            class="wp-block-fw-festival-2024-fwf-profiles-front__item"
          >
            <figure className="wp-block-fw-festival-2024-fwf-profiles__figure">
              <img
                src={item.image}
                alt={item.alt}
                className="wp-block-fw-festival-2024-fwf-profiles__img"
                width="100%"
                height="auto"
              />
            </figure>
            <div className="wp-block-fw-festival-2024-fwf-profiles__meta">
              {item?.title !== '' && (
                <RichText.Content
                  className="wp-block-fw-festival-2024-fwf-profiles__meta_title"
                  tagName="h3"
                  value={item.title}
                />
              )}
              {item?.description !== '' && (
                <RichText.Content
                  className="wp-block-fw-festival-2024-fwf-profiles__meta_description"
                  value={item.description}
                  tagName="p"
                />
              )}
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}
