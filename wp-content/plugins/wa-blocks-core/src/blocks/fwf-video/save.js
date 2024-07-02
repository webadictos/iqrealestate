/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {Element} Element to render.
 */
export default function save(props) {
  const { attributes } = props;

  return (
    <figure {...useBlockProps.save()}>
      <video
        className="wp-block-fw-festival-2024-fwf-video__item"
        src={attributes.videoURL}
      />
      <button className="wp-block-fw-festival-2024-fwf-video__control">
        <svg
          width="150"
          height="150"
          viewBox="0 0 150 150"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <g id="Property 1=Default">
            <circle
              id="Ellipse 6"
              cx="75"
              cy="75"
              r="70"
              stroke="#FDFBDF"
              stroke-width="10"
            />
            <path
              id="Rectangle 12"
              d="M54 120L54 38.0002L114.5 79.0001L54 120Z"
              fill="#FDFBDF"
            />
          </g>
        </svg>
      </button>
    </figure>
  );
}
