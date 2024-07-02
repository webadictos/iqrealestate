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
  MediaUpload,
  InnerBlocks,
  RichText,
} from '@wordpress/block-editor';
import {
  PanelBody,
  TextControl,
  TextareaControl,
  Button,
  IconButton,
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
export default function Edit({ attributes, setAttributes }) {
  const { address, phones, emails, socialLinks, backgroundImage } = attributes;
  const blockProps = useBlockProps();

  const onChangeAddress = value => setAttributes({ address: value });
  const onSelectImage = media => {
    setAttributes({ backgroundImage: media });
  };
  const clearBackgroundImage = () => setAttributes({ backgroundImage: null });

  const addPhone = () => {
    const newPhones = [...phones, ''];
    setAttributes({ phones: newPhones });
  };

  const updatePhone = (value, index) => {
    const newPhones = [...phones];
    newPhones[index] = value;
    setAttributes({ phones: newPhones });
  };

  const removePhone = index => {
    const newPhones = [...phones];
    newPhones.splice(index, 1);
    setAttributes({ phones: newPhones });
  };

  const addEmail = () => {
    const newEmails = [...emails, ''];
    setAttributes({ emails: newEmails });
  };

  const updateEmail = (value, index) => {
    const newEmails = [...emails];
    newEmails[index] = value;
    setAttributes({ emails: newEmails });
  };

  const removeEmail = index => {
    const newEmails = [...emails];
    newEmails.splice(index, 1);
    setAttributes({ emails: newEmails });
  };

  const addSocialLink = () => {
    const newSocialLinks = [...socialLinks, { name: '', url: '' }];
    setAttributes({ socialLinks: newSocialLinks });
  };

  const updateSocialLink = (value, index, key) => {
    const newSocialLinks = [...socialLinks];
    newSocialLinks[index][key] = value;
    setAttributes({ socialLinks: newSocialLinks });
  };

  const removeSocialLink = index => {
    const newSocialLinks = [...socialLinks];
    newSocialLinks.splice(index, 1);
    setAttributes({ socialLinks: newSocialLinks });
  };

  return (
    <>
      <InspectorControls>
        <PanelBody title="Imagen de fondo">
          <MediaUpload
            onSelect={onSelectImage}
            allowedTypes={['image']}
            render={({ open }) => (
              <Button variant="primary" onClick={open}>
                {!backgroundImage ? 'Select Image' : 'Change Image'}
              </Button>
            )}
          />

          {backgroundImage && (
            <Button
              variant="secondary"
              onClick={clearBackgroundImage}
              style={{ marginTop: '10px' }}
            >
              Clear Image
            </Button>
          )}
        </PanelBody>
      </InspectorControls>
      <div {...blockProps}>
        <div className="wp-block-wa-blocks-core-wa-contacto__wrapper">
          {backgroundImage && (
            <div className="wp-block-wa-blocks-core-wa-contacto__background">
              <img
                src={backgroundImage.sizes.full.url}
                width={backgroundImage.sizes.full.width}
                height={backgroundImage.sizes.full.height}
              />
            </div>
          )}
          <div className="wp-block-wa-blocks-core-wa-contacto__info-wrapper">
            <TextControl
              label="Dirección"
              value={address}
              onChange={onChangeAddress}
            />
            <PanelBody title="Teléfonos de contacto">
              {phones.map((phone, index) => (
                <div key={index} className="phone-control">
                  <TextControl
                    value={phone}
                    onChange={value => updatePhone(value, index)}
                  />
                  <Button isDestructive onClick={() => removePhone(index)}>
                    Quitar teléfono
                  </Button>
                </div>
              ))}
              <Button variant="primary" onClick={addPhone}>
                Agregar teléfono
              </Button>
            </PanelBody>
            <PanelBody title="Emails">
              {emails.map((email, index) => (
                <div key={index} className="email-control">
                  <TextControl
                    value={email}
                    onChange={value => updateEmail(value, index)}
                  />
                  <Button isDestructive onClick={() => removeEmail(index)}>
                    Quitar Email
                  </Button>
                </div>
              ))}
              <Button variant="primary" onClick={addEmail}>
                Agregar Email
              </Button>
            </PanelBody>
            <PanelBody title="Redes sociales">
              {socialLinks.map((link, index) => (
                <div key={index} className="social-link-control">
                  <TextControl
                    label="Name"
                    value={link.name}
                    onChange={value => updateSocialLink(value, index, 'name')}
                  />
                  <TextControl
                    label="URL"
                    value={link.url}
                    onChange={value => updateSocialLink(value, index, 'url')}
                  />

                  <Button isDestructive onClick={() => removeSocialLink(index)}>
                    Quitar red social
                  </Button>
                </div>
              ))}
              <Button variant="primary" onClick={addSocialLink}>
                Agregar red social
              </Button>
            </PanelBody>
          </div>
          <div className="wp-block-wa-blocks-core-wa-contacto__form-wrapper">
            <InnerBlocks />
          </div>
        </div>
      </div>
    </>
  );
}
