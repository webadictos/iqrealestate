/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';
import { select } from '@wordpress/data';

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
  const headings = attributes.items; // Asegúrate de que este atributo exista en tus atributos de bloque

  if (!headings || headings.length === 0) {
    return null;
  }
  // Contenido HTML de la tabla de contenidos para mostrar en el frontend
  //   const blockProps = useBlockProps.save({
  //     className: 'toc-wrapper expanded',
  //   });
  const blockProps = useBlockProps.save({
    'data-heading': `${attributes.title ? `${attributes.title}` : ''}`,
    className: 'toc-wrapper',
  });
  return (
    <nav
      {...blockProps}
      style={
        attributes.borderColor
          ? { '--toc-main-color': '' + attributes.borderColor + '' }
          : {}
      }
    >
      <ul>
        {headings.map((heading, index) => {
          if (heading.attributes.anchor) {
            return (
              <li key={heading.clientId}>
                <a href={`#${heading.attributes.anchor}`}>
                  {heading.attributes.content}
                </a>
              </li>
            );
          }
          return null; // Ignora los headings sin anchor válido
        })}
      </ul>
      <div class="toc-wrapper-view-all">
        {' '}
        <button class="btn btn-view-all">Ver todo</button>
      </div>
    </nav>
  );
}
