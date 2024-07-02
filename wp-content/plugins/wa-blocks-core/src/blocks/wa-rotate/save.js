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
export default function save(props) {
  const { attributes } = props;
  const { prefix, words, suffix, maxWidth } = attributes;

  const containerMaxWidthStyle =
    maxWidth > 0 ? { '--wa-rotate-container-max-width': `${maxWidth}px` } : {};

  const blockProps = useBlockProps.save({
    className: `text-slide num-words-${words.length}`,
    style: containerMaxWidthStyle,
  });

  return (
    <div {...blockProps}>
      <h2 className={`wa-rotate-text__main num-words-${words.length}`}>
        <RichText.Content
          tagName="span"
          className="wa-rotate-text__prefix"
          value={prefix}
        />
        <span className="wa-rotate-text__text-wrap">
          <span className="wa-rotate-text__text">
            {words.map((word, index) => (
              <span key={index}>{word}</span>
            ))}
          </span>
        </span>
        <RichText.Content
          tagName="span"
          className="wa-rotate-text__suffix"
          value={suffix}
        />
      </h2>
    </div>
  );
}
