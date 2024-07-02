/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './style.scss';

/**
 * Internal dependencies
 */
import Edit from './edit';
import save from './save';
import metadata from './block.json';

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType(metadata.name, {
  attributes: {
    caption: {
      type: 'string',
    },
    heading: {
      type: 'string',
    },
    style: {
      type: 'string',
      default: 'primary', // Este será el valor predeterminado
    },
    borderColor: {
      type: 'string',
      default: '', // Color de borde predeterminado
    },
    haveCTA: {
      type: 'boolean',
      default: true,
    },
    ctaUrl: {
      type: 'string',
      default: '',
    },
    ctaText: {
      type: '',
      default: '',
    },
    maxWidth: {
      type: 'string',
      default: '0',
    },
  },
  supports: {
    styles: true, // Habilita el soporte para estilos CSS
    color: true,
    align: ['wide', 'full', 'center'],
    __experimentalBorder: {
      color: true,
      radius: true,
      style: true,
      width: true,
      __experimentalDefaultControls: {
        color: true,
        radius: true,
        style: true,
        width: true,
        padding: true,
      },
    },
    spacing: {
      margin: true,
      padding: true,
      __experimentalDefaultControls: {
        padding: true,
        margin: true,
      },
    },
  },
  /**
   * @see ./edit.js
   */
  edit: Edit,

  /**
   * @see ./save.js
   */
  save,
});
