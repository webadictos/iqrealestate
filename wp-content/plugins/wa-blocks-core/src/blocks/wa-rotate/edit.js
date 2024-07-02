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

import {
  useBlockProps,
  InspectorControls,
  RichText,
} from '@wordpress/block-editor';
import {
  PanelBody,
  Button,
  TextControl,
  RangeControl,
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
 * @return {Element} Element to render.
 */
export default function Edit(props) {
  const { attributes, setAttributes } = props;
  const { prefix, words, suffix, maxWidth } = attributes;
  const addWord = () => {
    setAttributes({ words: [...words, ''] });
  };

  const updateWord = (index, value) => {
    const newWords = [...words];
    newWords[index] = value;
    setAttributes({ words: newWords });
  };

  const removeWord = index => {
    if (confirm('¿Seguro que deseas eliminar la palabra?')) {
      const newWords = [...words];
      newWords.splice(index, 1);
      setAttributes({ words: newWords });
    }
  };

  const containerMaxWidthStyle =
    maxWidth > 0 ? { '--wa-rotate-container-max-width': `${maxWidth}px` } : {};

  const blockProps = useBlockProps({
    className: `text-slide num-words-${words.length}`,
    style: containerMaxWidthStyle,
  });

  return (
    <div {...blockProps}>
      <InspectorControls>
        <PanelBody title="Configuración del texto">
          <label className="rotate-text__label">Prefijo </label>

          <RichText
            label="Prefijo"
            value={prefix}
            onChange={value => setAttributes({ prefix: value })}
            placeholder="Prefijo..."
            className="rotate-text__control"
          />
          {/* <TextControl
                        label={__('Prefix', 'my-plugin')}
                        value={prefix}
                        onChange={(value) => setAttributes({ prefix: value })}
                    /> */}
          <label className="rotate-text__label">Sufijo</label>
          <RichText
            label="Sufijo"
            value={suffix}
            onChange={value => setAttributes({ suffix: value })}
            placeholder="Sufijo"
            className="rotate-text__control"
          />

          <TextControl
            label="Ancho máximo del contenedor (PX)"
            value={maxWidth}
            onChange={value => setAttributes({ maxWidth: value })}
          />

          {/* <RangeControl
            label="Ancho máximo del contenedor (%)"
            value={maxWidth}
            onChange={value => setAttributes({ maxWidth: value })}
            min={10}
            max={100}
            step={1}
          /> */}
          <Button variant="primary" onClick={addWord}>
            Agregar palabra
          </Button>
          {words.length > 0 && (
            <ul>
              {words.map((word, index) => (
                <li
                  key={index}
                  style={{
                    display: 'flex',
                    alignItems: 'flex-start',
                    gap: '8px',
                  }}
                >
                  <TextControl
                    value={word}
                    onChange={value => updateWord(index, value)}
                  />
                  <Button isDestructive onClick={() => removeWord(index)}>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="16"
                      height="16"
                      fill="currentColor"
                      class="bi bi-trash-fill"
                      viewBox="0 0 16 16"
                    >
                      <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                    </svg>
                  </Button>
                </li>
              ))}
            </ul>
          )}
        </PanelBody>
      </InspectorControls>

      <h2 className={`wa-rotate-text__main num-words-${words.length}`}>
        <RichText.Content
          tagName="span"
          className="wa-rotate-text__prefix"
          value={prefix}
        />
        <span className="wa-rotate-text__text-wrap">
          <span className="wa-rotate-text__text">
            {words.map((word, index) => (
              <span key={index}>{word}</span>
            ))}
          </span>
        </span>
        <RichText.Content
          tagName="span"
          className="wa-rotate-text__suffix"
          value={suffix}
        />
      </h2>
    </div>
  );
}
