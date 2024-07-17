/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import metadata from './block.json';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import { useState, useEffect } from '@wordpress/element';
import { InspectorControls, BlockControls } from '@wordpress/block-editor';
import {
  PanelBody,
  Button,
  Modal,
  TextControl,
  SelectControl,
  Disabled,
} from '@wordpress/components';
import { plusCircleFilled } from '@wordpress/icons';

import { ToolbarGroup, ToolbarButton } from '@wordpress/components';

import apiFetch from '@wordpress/api-fetch';

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
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [searchTerm, setSearchTerm] = useState('');
  const [searchResults, setSearchResults] = useState([]);
  const [initialLoad, setInitialLoad] = useState(true);

  useEffect(() => {
    if (initialLoad) {
      apiFetch({ path: '/wp/v2/iq_realestate?per_page=10' }).then(posts => {
        setSearchResults(
          posts.map(post => ({ label: post.title.rendered, value: post.id }))
        );
        setInitialLoad(false);
      });
    }
  }, [initialLoad]);

  const fetchProjects = term => {
    apiFetch({ path: `/wp/v2/iq_realestate?search=${term}` }).then(posts => {
      setSearchResults(
        posts.map(post => ({ label: post.title.rendered, value: post.id }))
      );
    });
  };

  const onSearchChange = term => {
    setSearchTerm(term);
    if (term.length > 2) {
      fetchProjects(term);
    } else if (term.length === 0) {
      setInitialLoad(true);
    }
  };

  const onAddProjects = () => {
    setIsModalOpen(true);
  };

  const toggleProjectSelection = selectedId => {
    const projectExists = attributes.selectedProjects.some(
      project => project.value === selectedId
    );

    if (!projectExists) {
      const projectToAdd = searchResults.find(
        project => project.value === selectedId
      );
      if (projectToAdd) {
        setAttributes({
          selectedProjects: [...attributes.selectedProjects, projectToAdd],
        });
      }
    }
  };

  const onRemoveProject = projectId => {
    setAttributes({
      selectedProjects: attributes.selectedProjects.filter(
        project => project.value !== projectId
      ),
    });
  };

  return (
    <div {...useBlockProps()}>
      <BlockControls>
        <ToolbarGroup>
          <ToolbarButton
            icon={plusCircleFilled}
            label="Agregar proyecto"
            onClick={onAddProjects}
            text="Agregar proyecto"
          />
        </ToolbarGroup>
      </BlockControls>
      <InspectorControls>
        <PanelBody title="Configuración del bloque">
          <TextControl
            label="Título de la sección"
            value={attributes.blockTitle || ''}
            onChange={blockTitle => setAttributes({ blockTitle })}
          />
          <TextControl
            label="URL de la sección"
            value={attributes.blockLink || ''}
            onChange={blockLink => setAttributes({ blockLink })}
          />
        </PanelBody>
        <PanelBody title="Proyectos seleccionados">
          <ul>
            {attributes.selectedProjects &&
              attributes.selectedProjects.map(project => (
                <li key={project.value}>
                  {project.label}
                  <Button
                    isDestructive
                    onClick={() => onRemoveProject(project.value)}
                  >
                    Quitar
                  </Button>
                </li>
              ))}
          </ul>
          <Button variant="primary" onClick={onAddProjects}>
            Agregar proyecto
          </Button>
        </PanelBody>
      </InspectorControls>
      {isModalOpen && (
        <Modal
          title="Seleccionar proyectos"
          onRequestClose={() => setIsModalOpen(false)}
        >
          <input
            type="text"
            placeholder="Buscar proyectos"
            value={searchTerm}
            onChange={e => onSearchChange(e.target.value)}
          />
          <ul>
            {searchResults.map(project => (
              <li
                key={project.value}
                onClick={() => toggleProjectSelection(project.value)}
                style={{
                  cursor: 'pointer',
                  backgroundColor: attributes.selectedProjects.some(
                    selected => selected.value === project.value
                  )
                    ? '#e0e0e0'
                    : 'transparent',
                }}
              >
                {project.label}
                {attributes.selectedProjects.some(
                  selected => selected.value === project.value
                ) && ' ✅'}
              </li>
            ))}
          </ul>
        </Modal>
      )}
      <Disabled>
        <ServerSideRender
          block={metadata.name}
          skipBlockSupportAttributes
          attributes={attributes}
        />
      </Disabled>
    </div>
  );
}
