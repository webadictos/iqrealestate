/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

import { registerBlockType } from '@wordpress/blocks';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';

import { Autocomplete, Button, TextControl } from '@wordpress/components';

import { useState } from '@wordpress/element';
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
export default function Edit(props) {
  const { attributes, setAttributes } = props;
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedPost, setSelectedPost] = useState(attributes.selectedPost);

  let locations = useSelect(
    select => {
      const { getEntityRecords } = select('core');

      return select('core').getEntityRecords('postType', 'fp_location', {
        per_page: 20,
        search: searchTerm,
      });
    },
    [searchTerm]
  );

  //   const latestPosts = useSelect(select => {
  //     return select('core').getEntityRecords('postType', 'post', {
  //       per_page: 10,
  //     });
  //   });

  console.log(locations);

  const handleSearchChange = value => {
    setSearchTerm(value);
  };

  const handlePostSelect = post => {
    setSelectedPost(post);
    setAttributes({ selectedPost: post });
  };

  const handleClick = () => {
    if (!selectedPost) {
      alert('Please select a location.');
      return;
    }

    const { title, meta } = selectedPost;

    console.log(selectedPost);

    const address = meta['fp_location_direccion']
      ? meta['fp_location_direccion'][0]
      : '';
    // const longitude = meta['longitude'] ? meta['longitude'][0] : '';
  };

  const getLocationOptions = () => {
    return locations.map(location => ({
      value: location,
      label: location.title.rendered,
    }));
  };

  return (
    <div>
      <p>Elements</p>

      <Autocomplete
        label={__('Search for Location', 'my-custom-block')}
        value={selectedPost}
        options={getLocationOptions()}
        // onChange={handlePostSelect}
        getOptionLabel={option => option.label}
        noOptionsMessage={__('No locations found.', 'my-custom-block')}
        renderInput={inputProps => (
          <TextControl
            {...inputProps}
            value={searchTerm}
            onChange={handleSearchChange}
          />
        )}
      />

      {/* <Autocomplete
        label={__('Search for Location', 'my-custom-block')}
        value={selectedPost}
        options={getLocationOptions()}
        onChange={handlePostSelect}
        getOptionLabel={option => option.label}
        noOptionsMessage={__('No locations found.', 'my-custom-block')}
        renderInput={inputProps => (
          <TextControl
            {...inputProps}
            value={searchTerm}
            onChange={handleSearchChange}
          />
        )}
      />
      <Button onClick={handleClick}>{__('Search', 'my-custom-block')}</Button>
      {selectedPost && (
        <div>
          <h3>{selectedPost.title.rendered}</h3>
          <p>{selectedPost.meta['fp_location_direccion']}</p>
        </div>
      )} */}
    </div>
  );
}
