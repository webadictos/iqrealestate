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
    address: {
      source: 'html',
      selector: '.wp-block-wa-blocks-core-info-card__address',
    },
    phone: {
      source: 'html',
      selector: '.wp-block-wa-blocks-core-info-card__phone > a',
    },
    whatsapp: {
      source: 'html',
      selector: '.wp-block-wa-blocks-core-info-card__whatsapp > a',
    },
    web: {
      type: 'string',
      source: 'attribute',
      selector: '.wp-block-wa-blocks-core-info-card__url > a',
      attribute: 'href',
    },
    facebook: {
      type: 'string',
      source: 'attribute',
      selector: 'a.wp-block-wa-blocks-core-info-card__social--facebook',
      attribute: 'href',
    },
    instagram: {
      type: 'string',
      source: 'attribute',
      selector: 'a.wp-block-wa-blocks-core-info-card__social--instagram',
      attribute: 'href',
    },
    twitter: {
      type: 'string',
      source: 'attribute',
      selector: 'a.wp-block-wa-blocks-core-info-card__social--twitter',
      attribute: 'href',
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
