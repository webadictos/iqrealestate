<?php

class WA_External_Author_Module extends WA_Module
{

    protected $theme_options_key;
    public $prefix = 'wa_theme_options_';



    public function init()
    {

        $this->theme_options_key = "wa_theme_options";
        $this->loader->add_filter('wa_theme_set_metaboxes', $this, 'add_metaboxes', 10, 2);
        $this->loader->add_filter('wpseo_meta_author', $this, 'change_external_author', 10, 1);
        $this->loader->add_filter('wpseo_opengraph_author_facebook', $this, 'change_external_author', 10, 1);

        $this->loader->add_filter('the_author_posts_link', $this, 'change_external_author_link', 10, 1);

        //add_filter( 'wpseo_meta_author', '__return_false' );
        //the_author_posts_link
        //wpseo_opengraph_author_facebook

    }

    public function change_external_author_link($link)
    {
        $external_author = get_post_meta(get_the_ID(), 'wa_meta_external_author', true);

        if (!empty($external_author)) {
            $link = sprintf(
                '<span rel="author">%1$s</span>',
                $external_author
            );
        }

        return $link;
    }

    public function change_external_author($author)
    {
        $external_author = get_post_meta(get_the_ID(), 'wa_meta_external_author', true);

        if (!empty($external_author)) {
            $author = $external_author;
        }
        return $author;
    }

    public function add_metaboxes($metaboxes, $prefix)
    {

        $author_metabox_id = $prefix . 'external_author_metabox';


        $author_fields = array(
            $prefix . 'external_author' => array(
                'name' => 'Nombre del author externo',
                'desc' => 'Escriba el nombre como desea que aparezca en la vista del artículo. Los autores externos no tienen un archivo de notas, si desea tener un archivo de artículos de ese autor, considere crear un usuario de wordpress',
                'id'   => $prefix . 'external_author',
                'type' => 'text',
                'default' => '',
            ),
        );




        $_author_metabox = array(
            'id'            => $author_metabox_id,
            'title'         => esc_html__('Autor externo', 'cmb2'),
            'object_types'  => array('post'), //array('post', 'page'), // Post type
            'context'    => 'side',
            'priority'   => 'high',
            'wa_metabox_fields' => apply_filters("wa_theme_get_{$author_metabox_id}_fields", $author_fields),
        );

        $metaboxes[$author_metabox_id] = $_author_metabox;



        return $metaboxes;
    }
}
