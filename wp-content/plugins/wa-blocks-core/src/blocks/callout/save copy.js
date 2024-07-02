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

  return (
    <div {...useBlockProps.save()}>
      <div class="wa-blocks-core-wa-list-items__item-counter">
        <span class="wa-blocks-core-wa-list-items__item-counter--number">
          {attributes.numeroEncabezado}
        </span>
        <span class="wa-blocks-core-wa-list-items__item-counter--total">
          {attributes.totalEncabezados}
        </span>
      </div>

      <h2 className="wa-blocks-core-wa-list-items__item-title">
        <RichText.Content value={attributes.contenidoEncabezado} />
      </h2>
    </div>
  );
}
