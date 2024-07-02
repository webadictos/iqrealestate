// Internal dependencies.
// import { ICONS } from './const';

// WordPress dependencies.
import { registerBlockStyle } from '@wordpress/blocks';
import { addFilter } from '@wordpress/hooks';
import domReady from '@wordpress/dom-ready';
// import { __ } from '@wordpress/i18n';

import { __, sprintf } from '@wordpress/i18n';
import { assign, merge } from 'lodash';

function addBorderSupport(settings, name) {
  // Bail early if the block does not have supports.
  if (!settings?.supports) {
    return settings;
  }

  // Only apply to Column, Heading, and Paragraph blocks.
  if (name === 'core/heading') {
    return Object.assign({}, settings, {
      supports: Object.assign(settings.supports, {
        __experimentalBorder: {
          color: true,
          radius: false,
          style: false,
          width: false,
          __experimentalDefaultControls: {
            color: true,
            radius: false,
            style: false,
            width: false,
          },
        },
      }),
    });
  }

  return settings;
}

addFilter(
  'blocks.registerBlockType',
  'modify-block-supports/add-border-support',
  addBorderSupport
);

// addFilter(
//   'blocks.registerBlockType',
//   'wa/alignblockquote',
//   (settings, name) => {
//     // if ('core/quote' === name) {
//     //   return lodash.assign({}, settings, {
//     //     attributes: lodash.assign({}, settings.attributes, {
//     //       supports: {
//     //         align: true,
//     //       },
//     //       styles: [
//     //         { name: 'default', label: 'Predeterminado', isDefault: true },
//     //         { name: 'alignwide', label: 'Ancho Completo' },
//     //         { name: 'alignfull', label: 'Alineación Completa' },
//     //         { name: 'aligncenter', label: 'Centrado' },
//     //       ],
//     //     }),
//     //   });
//     // }
//     if (!settings?.supports) {
//       return settings;
//     }
//     // return settings;
//     if (name === 'core/quote') {
//       // Añadir soporte para alineaciones
//       // settings.supports.align = true;

//       // Definir estilos adicionales
//       // settings.styles = [
//       //   // { name: 'default', label: 'Predeterminado', isDefault: true },
//       //   { name: 'alignwide', label: 'Ancho Completo' },
//       //   { name: 'alignfull', label: 'Alineación Completa' },
//       //   { name: 'aligncenter', label: 'Centrado' },
//       // ];

//       // settings.styles = settings.styles.filter(style =>
//       //   ['alignwide', 'alignfull', 'aligncenter'].includes(style.name)
//       // );

//       return assign({}, settings, {
//         supports: merge(settings.supports, {
//           align: ['wide', 'center'],
//         }),
//       });
//     }

//     return settings;
//   }
// );

// addFilter('blocks.registerBlockType', 'wa/img', (settings, name) => {
//   if ('core/image' === name) {
//     return lodash.assign({}, settings, {
//       attributes: lodash.assign({}, settings.attributes, {
//         align: {
//           type: 'string',
//           default: 'center',
//         },
//       }),
//     });
//   }

//   return settings;
// });

// Register a block style for each icon.
domReady(() => {
  // ICONS.forEach(icon => {
  //   registerBlockStyle('core/separator', {
  //     name: `icon-${icon.value}`,
  //     label: sprintf(__('%s', 'theme-slug'), icon.icon),
  //   });
  //   console.log('HOLA');
  // });

  registerBlockStyle('core/paragraph', {
    name: `paragraph-limited-width`,
    label: `Ancho limitado`,
  });
  registerBlockStyle('core/paragraph', {
    name: `paragraph-font-small`,
    label: `Letra pequeña`,
  });

  registerBlockStyle('core/paragraph', {
    name: `paragraph-font-medium`,
    label: `Letra medium`,
  });
  registerBlockStyle('core/paragraph', {
    name: `paragraph-hero-txt`,
    label: `Letra Hero Banner`,
  });

  registerBlockStyle('core/heading', {
    name: `heading-light`,
    label: `Ligero`,
  });
  registerBlockStyle('core/heading', {
    name: `heading-border`,
    label: `Con borde`,
  });
  registerBlockStyle('core/heading', {
    name: `heading-big`,
    label: `Grande`,
  });
  // registerBlockStyle('core/quote', {
  //   name: `fdp-uno`,
  //   label: `FDP Uno`,
  // });

  // registerBlockStyle('core/quote', {
  //   name: `fdp-dos`,
  //   label: `FDP dos`,
  // });

  // registerBlockStyle('core/quote', {
  //   name: `fdp-tres`,
  //   label: `FDP Tres`,
  // });
  // registerBlockStyle('core/paragraph', {
  //   name: `fdp-paragraph-dos`,
  //   label: `FDP Parrafo Dos`,
  // });
  // registerBlockStyle('core/heading', {
  //   name: `fdp-heading`,
  //   label: `FDP Heading`,
  // });

  // registerBlockStyle('core/heading', {
  //   name: `fdp-heading-dos`,
  //   label: `Heading Dos`,
  // });

  // registerBlockStyle('core/heading', {
  //   name: `fdp-heading-logo`,
  //   label: `Heading Logo`,
  // });
  // registerBlockStyle('core/image', {
  //   name: `fdp-image`,
  //   label: `FDP Imagen`,
  // });
});

/**
 * // Internal dependencies.
import SeparatorIconControl from './control-icon';

// WordPress dependencies.
import { BlockControls } from '@wordpress/block-editor';
import { addFilter } from '@wordpress/hooks';

const withSeparatorIcons = BlockEdit => props => {
  return 'core/separator' === props.name ? (
    <>
      <BlockEdit {...props} />
      <BlockControls group="other">
        <SeparatorIconControl
          attributes={props.attributes}
          setAttributes={props.setAttributes}
        />
      </BlockControls>
    </>
  ) : (
    <BlockEdit {...props} />
  );
};

addFilter('editor.BlockEdit', 'theme-slug/separator-icons', withSeparatorIcons);

 */
