/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';
import { InnerBlocks, RichText } from '@wordpress/block-editor';

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

  const containerMaxWidthStyle =
    attributes.maxWidth > 0
      ? { '--wa-callout-container-max-width': `${attributes.maxWidth}px` }
      : {};

  const blockProps = useBlockProps.save({
    style: containerMaxWidthStyle,
  });

  return (
    <div {...blockProps}>
      <InnerBlocks.Content />

      {attributes.haveCTA && (
        <RichText.Content
          tagName="div"
          className="wp-block-wa-blocks-core-callout__cta-button"
          value={attributes.ctaText}
        />
      )}
    </div>
  );
}
