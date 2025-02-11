/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { RichText } from '@wordpress/block-editor';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';

import domReady from '@wordpress/dom-ready';
import { registerBlockStyle } from '@wordpress/blocks';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

// Register a block style for each icon.
domReady(() => {
  registerBlockStyle('fw-festival-2024/fwf-headings', {
    name: `fwf-heading-bnf`,
    label: `Best New Chefs`,
  });
});

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit(props) {
  let { attributes, setAttributes } = props;

  return (
    <>
      <div {...useBlockProps()}>
        <div className="wp-block wp-block-fw-festival-2024-fwf__heading-wrapper">
          <RichText
            tagName="h2"
            value={attributes.heading}
            placeholder="Encabezado"
            className="wp-block-fw-festival-2024-fwf__heading"
            onChange={newText => setAttributes({ heading: newText })}
          />
        </div>
      </div>
    </>
  );
}
