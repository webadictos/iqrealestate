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
import { RichText } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';

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
export default function Edit({ attributes, setAttributes }) {
  const { contacts } = attributes;

  const addContact = () => {
    const newContact = { name: '', email: '' };
    setAttributes({ contacts: [...contacts, newContact] });
  };

  const updateContact = (index, key, value) => {
    const updatedContacts = [...contacts];
    updatedContacts[index][key] = value;
    setAttributes({ contacts: updatedContacts });
  };

  const removeContact = index => {
    const updatedContacts = contacts.filter((_, i) => i !== index);
    setAttributes({ contacts: updatedContacts });
  };

  return (
    <div {...useBlockProps()}>
      <Button className="contact__button" onClick={addContact}>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="16"
          height="16"
          fill="currentColor"
          class="bi bi-person-vcard-fill"
          viewBox="0 0 16 16"
        >
          <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5M9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8m1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5m-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96q.04-.245.04-.5M7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0" />
        </svg>
        {__('Añadir contacto', 'custom')}
      </Button>
      {contacts.map((contact, index) => (
        <div
          className="wp-block-fw-festival-2024-fwf-contact__item"
          key={index}
        >
          <RichText
            tagName="p"
            className="wp-block-fw-festival-2024-fwf-contact__name"
            value={contact.name}
            onChange={value => updateContact(index, 'name', value)}
            placeholder={__('Nombre', 'custom')}
          />
          <RichText
            tagName="p"
            className="wp-block-fw-festival-2024-fwf-contact__email"
            value={contact.email}
            onChange={value => updateContact(index, 'email', value)}
            placeholder={__('Correo', 'custom')}
          />
          <Button isDestructive onClick={() => removeContact(index)}>
            {__('Eliminar contacto', 'custom')}
          </Button>
        </div>
      ))}
    </div>
  );
}
