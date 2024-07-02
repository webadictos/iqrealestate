/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { RichText } from '@wordpress/block-editor';
import { URLInputButton } from '@wordpress/block-editor';
import { InspectorControls } from '@wordpress/block-editor';
import { Panel, PanelBody, TextControl } from '@wordpress/components';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

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

  const handleCaptionChange = newCaption => {
    setAttributes({ ...attributes, caption: newCaption });
  };

  return (
    <>
      <InspectorControls>
        <Panel>
          <PanelBody title="Leyenda" icon="editor-textcolor">
            <TextControl
              label="Leyenda"
              help="Leyenda antes del enlace, por default es Te puede interesar:"
              onChange={caption => setAttributes({ caption })}
              value={attributes.caption}
            />
          </PanelBody>
        </Panel>
      </InspectorControls>
      <div {...useBlockProps()}>
        <URLInputButton
          url={attributes.url}
          onChange={(url, post) =>
            setAttributes({
              url,
              text: (post && post.title) || 'Introduce el texto del enlace',
            })
          }
        />

        <p
          className="wp-block-wa-blocks-core-wa-internal-link__preview"
          style={
            attributes.caption
              ? { '--wa-internal-link-txt': '"' + attributes.caption + '"' }
              : {}
          }
        >
          <RichText
            format="string" // Default is 'element'. Wouldn't work for a tag attribute
            className="input-box" // Automatic class: gutenberg-blocks-sample-block-editable
            onChange={text => setAttributes({ text })} // onChange event callback
            value={attributes.text} // Binding
            placeholder="Texto del enlace"
            allowedFormats={['core/plain-text']}
          />
        </p>
      </div>
    </>
  );
}
