/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { RichText } from '@wordpress/block-editor';
import { InspectorControls } from '@wordpress/block-editor';
import domReady from '@wordpress/dom-ready';
import { registerBlockStyle } from '@wordpress/blocks';

import {
  Panel,
  PanelBody,
  TextControl,
  PanelRow,
  ToggleControl,
  Button,
} from '@wordpress/components';
import { InnerBlocks } from '@wordpress/block-editor';

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

domReady(() => {
  registerBlockStyle('wa-blocks-core/callout', {
    name: `wa-callout-no-border`,
    label: `Sin borde`,
  });

  // registerBlockStyle('wa-blocks-core/callout', {
  //   name: `wa-gallery-layout-tres`,
  //   label: `Layout Tres`,
  // });
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

  const containerMaxWidthStyle =
    attributes.maxWidth > 0
      ? { '--wa-callout-container-max-width': `${attributes.maxWidth}px` }
      : {};

  const blockProps = useBlockProps({
    style: containerMaxWidthStyle,
  });

  return (
    <>
      <InspectorControls>
        <Panel>
          <PanelBody title="Leyenda" icon="editor-textcolor">
            <PanelRow>
              <ToggleControl
                label="Habilitar boton CTA"
                checked={attributes.haveCTA}
                onChange={value => setAttributes({ haveCTA: value })}
              />

              {/* <TextControl
                label="Leyenda"
                help="Leyenda para resaltar el callout"
                onChange={newCaption => setAttributes({ caption: newCaption })}
                value={attributes.caption}
              /> */}
            </PanelRow>
            <PanelRow>
              <TextControl
                label="Ancho máximo del contenedor (PX)"
                value={attributes.maxWidth}
                onChange={value => setAttributes({ maxWidth: value })}
              />
            </PanelRow>

            {/* <PanelRow>
              <SelectControl
                label="Estilo del cuadro"
                value={attributes.style}
                options={[
                  { label: 'Primario', value: 'primary' },
                  { label: 'Secundario', value: 'secondary' },
                ]}
                onChange={newval => setAttributes({ style: newval })}
              />
            </PanelRow> */}
            {/* <PanelRow>
              <ColorPicker
                label="Color del borde"
                color={attributes.borderColor}
                onChangeComplete={color =>
                  setAttributes({ borderColor: color.hex })
                }
              />
            </PanelRow> */}
          </PanelBody>
        </Panel>
      </InspectorControls>
      <div {...blockProps}>
        <InnerBlocks />

        {attributes.haveCTA && (
          <RichText
            tagName="div"
            className="wp-block-wa-blocks-core-callout__cta-button"
            value={attributes.ctaText}
            onChange={newText => setAttributes({ ctaText: newText })}
            placeholder="Añadir texto del CTA"
            allowedFormats={['core/link']}
          />
        )}
      </div>
    </>
  );
}
