/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';
import { select } from '@wordpress/data';
import { InspectorControls } from '@wordpress/block-editor';
import {
  Panel,
  PanelBody,
  TextControl,
  PanelRow,
  SelectControl,
  ColorPicker,
  Button,
  Flex,
} from '@wordpress/components';

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
  const { attributes, setAttributes } = props;

  const blockProps = useBlockProps({
    'data-heading': `${attributes.title ? `${attributes.title}` : ''}`,
    className: 'toc-wrapper',
  });

  return (
    <>
      <InspectorControls>
        <Panel>
          <PanelBody title="Leyenda" icon="editor-textcolor">
            <PanelRow>
              <TextControl
                label="Leyenda"
                help="Leyenda para resaltar el callout"
                onChange={newCaption => setAttributes({ title: newCaption })}
                value={attributes.title}
              />
            </PanelRow>
          </PanelBody>
          <PanelBody title="Color principal" icon="editor-backgroundcolor">
            <PanelRow>
              <ColorPicker
                label="Color del borde"
                color={attributes.borderColor} // Mostrar el valor actual
                onChangeComplete={color => {
                  setAttributes({ borderColor: color.hex });
                }}
              />
            </PanelRow>
            <PanelRow>
              <Button
                onClick={() => {
                  setAttributes({ borderColor: undefined }); // Establecer como undefined para eliminar el valor
                }}
              >
                Eliminar Color
              </Button>
            </PanelRow>
          </PanelBody>
        </Panel>
      </InspectorControls>

      <div
        {...blockProps}
        style={
          attributes.borderColor
            ? { '--toc-main-color': '' + attributes.borderColor + '' }
            : {}
        }
      >
        <em>
          Aquí se generará la tabla de contenido de manera dinámica en la vista
          pública del artículo. Solamente configura la leyenda y elige la
          posición dentro del artículo donde quieras que aparezca.
        </em>
      </div>
    </>
  );
}
