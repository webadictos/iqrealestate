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
    images: {
      type: 'array',
      default: [],
    },
    isSlider: {
      type: 'boolean',
      default: true,
    },
    haveNavigation: {
      type: 'boolean',
      default: true,
    },
    havePagination: {
      type: 'boolean',
      default: false,
    },
    slidesPerView: {
      type: 'number', // Cambiado a 'integer'
      default: 2,
    },
    slidesPerViewTablet: {
      type: 'number', // Cambiado a 'integer'
      default: 2,
    },
    slidesPerViewMobile: {
      type: 'number', // Cambiado a 'integer'
      default: 2,
    },
    spaceBetween: {
      type: 'number', // Cambiado a 'integer'
      default: 20,
    },
    spaceBetweenTablet: {
      type: 'number', // Cambiado a 'integer'
      default: 10,
    },
    spaceBetweenMobile: {
      type: 'number', // Cambiado a 'integer'
      default: 10,
    },
    direction: {
      type: 'string',
      default: 'horizontal',
    },
    directionTablet: {
      type: 'string',
      default: 'horizontal',
    },
    directionMobile: {
      type: 'string',
      default: 'horizontal',
    },

    imageRatio: {
      type: 'string',
      default: '1/1',
    },
  },
  supports: {
    styles: true, // Habilita el soporte para estilos CSS
    color: true,
    align: ['wide', 'full', 'center'],
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
