<?php

class WA_Fields_Module extends WA_Module
{

    protected $theme_options_key;
    public $prefix = 'wa_theme_options_';



    public function init()
    {
        $this->theme_options_key = "wa_theme_options";
        $this->loader->add_filter('wa_theme_set_metaboxes', $this, 'add_metaboxes', 10, 2);
        $this->loader->add_filter('wa_get_thumbnail_attributes', $this, 'get_thumbnail_attributes', 10, 2);

        $this->loader->add_filter('wa_thumbnail_attributes', $this, 'thumbnail_attributes', 10, 2);
    }

    public function add_metaboxes($metaboxes, $prefix)
    {

        $tax_id = $prefix . 'general_tax_metabox';


        $ads_tax_fields = array(
            $prefix . 'opciones_generales' => array(
                'name' => 'Opciones generales',
                'type' => 'title',
                'id'   => $prefix . 'opciones_generales'
            ),
            $prefix . 'banner' =>                         array(
                'name'    => 'Banner',
                'desc'    => 'Seleccione el banner para mostrar en la página de archivo.',
                'id'          => $prefix . 'term_banner',
                'type'    => 'file',
                // Optional:
                'options' => array(
                    'url' => true, // Hide the text input for the url
                ),
                'text'    => array(
                    'add_upload_file_text' => 'Agregar banner' // Change upload button text. Default: "Add or Upload File"
                ),
                // query_args are passed to wp.media's library query.
                'query_args' => array(
                    //'type' => 'application/pdf', // Make library only display PDFs.
                    // Or only allow gif, jpg, or png images
                    'type' => array(
                        'image/gif',
                        'image/jpeg',
                        'image/png',
                        'video/mp4',
                        'video/mpeg',
                        'video/x-mpeg',
                    ),
                ),
                'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
            ),


        );


        $_taxonomy_metabox = array(
            'id'            => $tax_id,
            'title'         => esc_html__('Opciones generales', 'cmb2'),
            'object_types'     => array('term'), // Tells CMB2 to use term_meta vs post_meta
            'taxonomies'       => get_taxonomies(array('public' => true)), //array('category', 'post_tag'), // Tells CMB2 which taxonomies should have these fields
            'wa_metabox_fields' => apply_filters("wa_theme_get_{$tax_id}_fields", $ads_tax_fields),
        );

        $metaboxes[$tax_id] = $_taxonomy_metabox;


        $hero_id = $prefix . 'portada_metabox';


        $portada_fields = array(

            $prefix . 'portada_video_enable' => array(
                'name' => 'Habilitar Video Portada',
                'id'   => $prefix . 'portada_video_enable',
                'type' => 'checkbox',
                'desc' => "Marque si desea agregar un video como portada en el artículo",

            ),

            $prefix . 'portada_video_provider' => array(
                'name' => 'Tipo de Video',
                'id'   => $prefix . 'portada_video_provider',
                'type' => 'select',
                'desc' => "Elige el tipo de video a utilizar",
                'default' => 'archivo',
                'options'  => array(
                    'archivo' => 'Archivo',
                    'dailymotion'   => 'Daily Motion',
                    'youtube'     => 'YouTube',
                    'embed'     => 'Incrustado',

                ),
                'attributes'    => array(
                    'data-conditional-id'     => $prefix . 'portada_video_enable',
                    'data-conditional-value'  => 'on',
                ),
            ),
            $prefix . 'portada_video_identificador' => array(
                'name' => 'ID del video',
                'id'   => $prefix . 'portada_video_identificador',
                'type' => 'text',
                'desc' => "Indica el ID del video a utilizar",
                'default' => '',
                'attributes'    => array(
                    'data-conditional-id'     => $prefix . 'portada_video_provider',
                    'data-conditional-value'  => wp_json_encode(array('dailymotion', 'youtube')),
                ),
            ),
            $prefix . 'portada_video_embed' => array(
                'name' => 'Código embed',
                'id'   => $prefix . 'portada_video_embed',
                'type' => 'textarea_small',
                'sanitization_cb' => array('Wa_Theme_Manager', 'accept_html_values_sanitize'),
                'desc' => "Introduce el código embed del video",
                'attributes'    => array(
                    'data-conditional-id'     => $prefix . 'portada_video_provider',
                    'data-conditional-value'  => wp_json_encode(array('embed')),
                ),
            ),

            $prefix . 'portada_video' => array(
                'name'    => 'Archivo de video',
                'desc'    => 'Seleccione el video que debe aparecer en lugar de la imagen destacada en la vista del artículo.',
                'id'          => $prefix . 'portada_video',
                'type'    => 'file',
                // Optional:
                'options' => array(
                    'url' => true, // Hide the text input for the url
                ),
                'text'    => array(
                    'add_upload_file_text' => 'Agregar video' // Change upload button text. Default: "Add or Upload File"
                ),
                // query_args are passed to wp.media's library query.
                'query_args' => array(
                    //'type' => 'application/pdf', // Make library only display PDFs.
                    // Or only allow gif, jpg, or png images
                    'type' => array(
                        'video/mp4',
                        'video/mpeg',
                        'video/x-mpeg',
                        'video/webm',
                    ),
                ),
                'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
                'attributes'    => array(
                    'data-conditional-id'     => $prefix . 'portada_video_enable',
                    'data-conditional-value'  => 'on',
                ),
            ),

            $prefix . 'edit_hero' => array(
                'name' => 'Editar banner Hero',
                'id'   => $prefix . 'edit_hero',
                'type' => 'checkbox',
                'desc' => "Marque si desea editar lo que se muestra en el banner Hero",

            ),



            $prefix . 'portada_hero' =>                         array(
                'name'    => 'Banner Hero',
                'desc'    => 'Seleccione la imagen o video que debe aparecer en el hero.',
                'id'          => $prefix . 'portada_hero',
                'type'    => 'file',
                // Optional:
                'options' => array(
                    'url' => true, // Hide the text input for the url
                ),
                'text'    => array(
                    'add_upload_file_text' => 'Agregar imagen' // Change upload button text. Default: "Add or Upload File"
                ),
                // query_args are passed to wp.media's library query.
                'query_args' => array(
                    //'type' => 'application/pdf', // Make library only display PDFs.
                    // Or only allow gif, jpg, or png images
                    'type' => array(
                        'image/gif',
                        'image/jpeg',
                        'image/png',
                        'video/mp4',
                        'video/mpeg',
                        'video/x-mpeg',
                    ),
                ),
                'attributes'    => array(
                    'data-conditional-id'     => $prefix . 'edit_hero',
                    'data-conditional-value'  => 'on',
                ),
                'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
            ),

            $prefix . 'hero_title' => array(
                'name'    => 'Encabezado del banner hero',
                'desc'    => 'Escriba el título que quiere que aparezca en el banner hero. Si se deja en blanco se usará el título del artículo.',
                'id'      => $prefix . 'hero_title',
                'type' => 'text',
                'attributes'    => array(
                    'data-conditional-id'     => $prefix . 'edit_hero',
                    'data-conditional-value'  => 'on',
                ),
            ),
            $prefix . 'hero_desc' => array(
                'name'    => 'Descripción del banner hero',
                'desc'    => 'Escriba la descripción corta que quiere que aparezca en el banner hero. Si se deja en blanco se usará el título del artículo.',
                'id'      => $prefix . 'hero_desc',
                'type' => 'textarea_small',
                'attributes'    => array(
                    'data-conditional-id'     => $prefix . 'edit_hero',
                    'data-conditional-value'  => 'on',
                ),
            ),

        );


        $_portada_metabox = array(
            'id'            => $hero_id,
            'title'         => esc_html__('Opciones de portada', 'cmb2'),
            'object_types'     => array('post'), // Tells CMB2 to use term_meta vs post_meta
            // 'taxonomies'       => get_taxonomies(array('public' => true)), //array('category', 'post_tag'), // Tells CMB2 which taxonomies should have these fields
            'context'    => 'side',
            'priority'   => 'high',
            'wa_metabox_fields' => apply_filters("wa_theme_get_{$hero_id}_fields", $portada_fields),
        );

        $metaboxes[$hero_id] = $_portada_metabox;



        return $metaboxes;
    }

    public function get_thumbnail_attributes($_atts, $post_id)
    {
        $atts = array();

        // Obtén el valor del campo de metadatos que contiene el enlace al video
        $video_enabled = get_post_meta($post_id, 'wa_meta_portada_video_enable', true) ?? false;


        if (!$video_enabled) return $atts;

        $video_provider = get_post_meta($post_id, 'wa_meta_portada_video_provider', true);
        $video_source = "";

        switch ($video_provider) {
            case "archivo":
                $video_source = get_post_meta($post_id, 'wa_meta_portada_video', true);
                // Comprueba si se proporcionó un valor y si es una URL válida
                if (!empty($video_source) && filter_var($video_source, FILTER_VALIDATE_URL)) {
                    // Obtiene la extensión del archivo desde la URL
                    $file_extension = pathinfo($video_source, PATHINFO_EXTENSION);

                    // Comprueba si la extensión es MP4 o WebM
                    if ($file_extension == 'mp4' || $file_extension == 'webm') {
                        // El enlace del video es válido, puedes usarlo
                        $atts['source'] = $video_source;
                    }
                }
                break;
            case "dailymotion":
            case "youtube":
                $video_source = get_post_meta($post_id, 'wa_meta_portada_video_identificador', true);

                if (!trim($video_source) !== "") {
                    $atts['source'] = $video_source;
                }
                break;

            case "embed":
                $video_source = get_post_meta($post_id, 'wa_meta_portada_video_embed', true);

                $video_embed_id = "video-" . uniqid();


                $atts['source'] = $video_embed_id;

                add_action('wa_after_single_article', function () use ($video_source, $video_embed_id) {
                    echo "<template id=\"{$video_embed_id}\">{$video_source}</template>";
                }, 10);

                break;
        }

        $atts['provider'] = $video_provider;




        // Si no se cumple ninguna de las condiciones anteriores, devuelve null
        return $atts;
    }

    public function thumbnail_attributes($_atts = "", $post_id = 0)
    {
        $atts = apply_filters('wa_get_thumbnail_attributes', array(), $post_id);
        $data_attributes = array();

        foreach ($atts as $attribute_key => $attribute_value) {
            $data_attributes[] = "data-video-{$attribute_key}=\"{$attribute_value}\"";
        }

        $playerID = "player-" . uniqid();

        $data_attributes[] = "id=\"{$playerID}\"";

        return implode(" ", $data_attributes);
    }
}
