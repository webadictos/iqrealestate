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
import { createBlock } from '@wordpress/blocks';

import { useBlockProps } from '@wordpress/block-editor';
import { RichText } from '@wordpress/block-editor';
import { withSelect } from '@wordpress/data';

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
function Edit(props) {
  const { attributes, setAttributes, blockIndex, totalBlocks } = props;
  const { contenidoEncabezado, numeroEncabezado, itemId } = attributes;

  const paddedBlockIndex = String(blockIndex + 1).padStart(2, '0');

  setAttributes({
    totalEncabezados: totalBlocks,
    numeroEncabezado: paddedBlockIndex,
  });

  const generateItemId = title => {
    // Elimina las etiquetas HTML del texto
    const cleanTitle = title.replace(/<[^>]*>/g, '');

    // Normaliza y formatea el título
    const normalizedTitle = cleanTitle
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '');
    const formattedTitle = normalizedTitle
      .replace(/[^\p{L}\p{N}]+/gu, '-')
      .toLowerCase()
      .replace(/(^-+)|(-+$)/g, '');

    // Combina el título formateado con el índice del bloque
    return `${formattedTitle}-${numeroEncabezado}`;
  };

  // const generateItemId = title => {
  //   title = title.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
  //   title = title
  //     .replace(/[^\p{L}\p{N}]+/gu, '-')
  //     .toLowerCase()
  //     .replace(/(^-+)|(-+$)/g, '');
  //   return `${title}-${paddedBlockIndex}`;
  // };

  if (!itemId || itemId === '') {
    const newItemId = generateItemId(contenidoEncabezado);
    setAttributes({
      itemId: newItemId,
    });
  }

  // Actualiza el itemId cuando cambia el contenido del encabezado
  const onContentChange = newText => {
    const newItemId = generateItemId(newText);
    setAttributes({
      itemId: newItemId,
      contenidoEncabezado: newText,
    });
  };

  // const onContentChange = value => {
  //   let title = value;

  //   title = title.normalize('NFD').replace(/[\u0300-\u036f]/g, '');

  //   title = title
  //     .replace(/[^\p{L}\p{N}]+/gu, '-')
  //     // Convert to lowercase
  //     .toLowerCase()
  //     // Remove any remaining leading or trailing hyphens.
  //     .replace(/(^-+)|(-+$)/g, '');

  //   const listItemId = `${title}-${paddedBlockIndex}`;

  //   setAttributes({
  //     itemId: listItemId,
  //     contenidoEncabezado: value,
  //   });
  // };

  return (
    <div {...useBlockProps()}>
      <div class="wa-blocks-core-wa-list-items__item-counter">
        <span class="wa-blocks-core-wa-list-items__item-counter--number">
          {attributes.numeroEncabezado}
        </span>
        <span class="wa-blocks-core-wa-list-items__item-counter--total">
          {attributes.totalEncabezados}
        </span>
      </div>

      <RichText
        tagName="h2"
        value={contenidoEncabezado}
        placeholder="Encabezado"
        className="wa-blocks-core-wa-list-items__item-title"
        onChange={onContentChange}
        id={itemId}
        //onChange={newText => setAttributes({ contenidoEncabezado: newText })}
      />
    </div>
  );
}

export default withSelect((select, ownProps) => {
  const { getBlocks } = select('core/block-editor');
  const { clientId } = ownProps;
  const blocks = getBlocks();

  // Encuentra todos los bloques del mismo tipo que el bloque actual
  const blocksOfSameType = blocks.filter(
    block => block.name === 'wa-blocks-core/wa-list-items'
  );

  const totalBlocks = blocksOfSameType.length;
  // Encuentra el índice del bloque actual entre los bloques del mismo tipo
  const blockIndex = blocksOfSameType.findIndex(
    block => block.clientId === clientId
  );

  return {
    blockIndex,
    totalBlocks,
  };
})(Edit);
