<?php

class WA_Portada_Module extends WA_Module
{

    protected $theme_options_key;
    public $prefix = 'wa_theme_portada_';
    public $editions_prefix = 'wa_editions_portada_';

    protected $settings_key;
    protected $secciones_portada;
    protected $editions_options_key;



    public function init()
    {

        $this->theme_options_key = "wa_theme_portada";
        $this->editions_options_key = "wa_theme_editions";

        $this->settings_key = $this->prefix . "general_page";

        // $this->loader->add_filter('wa_theme_set_options_page', $this, 'add_admin_page', 11, 2);
        $this->loader->add_filter('wa_theme_get_wa_theme_options_page_fields', $this, 'add_settings_page', 10, 2);

        $this->loader->add_action('swcfpc_purge_urls', $this, 'purge_cache_cloudflare', 10, 1);

        $this->loader->add_action("cmb2_save_options-page_fields",  $this, 'purge_home', 10, 2);


        $this->loader->add_filter('wa_theme_set_options_page', $this, 'add_editions_page', 11, 2);

        $this->loader->add_action('admin_menu', $this, 'cmb2_main_options_page', 10, 1);

        //     $this->loader->add_action('init', $this, 'add_sections_to_cover');
        $this->loader->add_action('init', $this, 'add_sections_to_cover_dynamic');
    }

    public function add_sections_to_cover_dynamic()
    {

        $ediciones = get_terms(array(
            'taxonomy' => 'travel_edition',
            'parent'   => 0,
            'hide_empty' => false,

        ));


        if (is_array($ediciones) && count($ediciones) > 0) {

            foreach ($ediciones as $edicion) {
                $edicion_key = "cover_" . $edicion->slug;
                $fields = get_term_meta($edicion->term_id, 'wa_meta_edition_fields', true);


                if (!$fields) continue;

                add_filter(
                    "wa_theme_get_cover_{$edicion->slug}_editions_page_fields",
                    function ($secciones, $prefix) use ($fields, $edicion_key) {
                        // Obtener las secciones y campos correspondientes a esta edición
                        $edition_fields = [];

                        // Recorrer los campos y generar los IDs dinámicamente
                        foreach ($fields as $json) {

                            //$field = (string) $json;

                            $field = json_decode($json, true);


                            if (!isset($field['id'])) continue;

                            $field_name = $field['id'];

                            // Construir el ID del campo concatenando el prefijo y el nombre del campo
                            $id = $prefix . "_" . $field_name;



                            if ($field === null && json_last_error() !== JSON_ERROR_NONE) {
                                continue;
                            }
                            // Generar el tab_id automáticamente concatenando el prefix y un sufijo "-tab"
                            $tab_id = $prefix . "_" . $field_name . '-tab';


                            // print_r($id);

                            // Asignar el ID y el tab_id generados al campo y almacenarlo en el array de campos para esta edición
                            $field['id'] = $id;
                            if (!isset($field['tab_id'])) {
                                $field['tab_id'] = $tab_id;
                            } else {
                                $field['tab_id'] = $prefix . "_" . $field['tab_id'] . "-tab";
                            }


                            $edition_fields[$id] = $field;
                        }

                        // Retornar los campos actualizados para esta edición
                        return $edition_fields;
                    },
                    10,
                    2
                );




                // print_r($fields);

                // $cadena = '{
                //     "id":"hero",
                //     "name": "Banner Principal",
                //     "type": "post_search_ajax",
                //     "desc": "Comienza escribiendo el título de la nota...",
                //     "tab_icon": "dashicons-embed-generic",
                //     "tab_name": "Banner Principal",
                //     "limit": 2,
                //     "maxitems": 1,
                //     "sortable": true,
                //     "query_args": {
                //         "post_type": ["post"],
                //         "post_status": ["publish"],
                //         "posts_per_page": 25
                //     }
                // }';

                // echo $cadena;

                // $resultado = json_decode($cadena, true);

                // print_r($resultado);



                // foreach ($fields as $field) {

                //     print_r($field);

                //     $camposDos = json_decode($field, true);

                //     print_r($camposDos);

                //     // // Construir el ID del campo concatenando el prefijo y el nombre del campo
                //     // $id = $prefix . $field_name;

                //     // // Generar el tab_id automáticamente concatenando el prefix y un sufijo "-tab"
                //     // $tab_id = $prefix . $field_name . '-tab';

                //     // // Asignar el ID y el tab_id generados al campo y almacenarlo en el array de campos para esta edición
                //     // $field_details['id'] = $id;
                //     // $field_details['tab_id'] = $tab_id;

                //     // $edition_fields[$field_name] = $field_details;
                // }
            }
        }
    }


    public function add_sections_to_cover()
    {
        // $ediciones = get_terms(array(
        //     'taxonomy' => 'travel_edition',
        //     'parent'   => 0,
        //     'hide_empty' => false,

        // ));

        /**
         * RESTO DEL MUNDO
         */

        add_filter('wa_theme_get_cover_global_editions_page_fields', function ($secciones, $prefix) {

            $edicion_key = "cover_global";


            $secciones_portada = array(

                $prefix . 'hero' => array(
                    'name'          => __('Banner Principal', 'cmb2'),
                    'id'            => $prefix . '_hero',
                    'type'          => 'post_search_ajax',
                    'desc'            => 'Comienza escribiendo el título de la nota. Si no se selecciona ninguno, el hero se ocultará del home',
                    // Optional :
                    'tab_id' => $edicion_key . '_hero-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Banner Principal',
                    'limit'          => 2,         // Limit selection to X items only (default 1)
                    'maxitems'      => 1,
                    'sortable'          => true,     // Allow selected items to be sortable (default false)
                    'query_args'    => array(
                        'post_type'            => array('post'),
                        'post_status'        => array('publish'),
                        'posts_per_page'    => 25,
                        'tax_query' => array(
                            'relation' => 'OR', // Utilizamos 'OR' para obtener publicaciones que cumplan al menos una de las condiciones
                            array(
                                'taxonomy' => 'travel_edition',
                                'field' => 'slug',
                                'terms' => 'global',
                                'operator' => 'IN', // Queremos las publicaciones que tengan 'mexico' asignado
                            ),
                            array(
                                'taxonomy' => 'travel_edition',
                                'operator' => 'NOT EXISTS', // Queremos las publicaciones que no tengan 'travel_edition' asignado
                            )
                        ),


                        // 'date_query' => array(
                        //     'after' => date('Y-m-d', strtotime('-2 years'))
                        // )
                    )
                ),
                $prefix . 'destacadas' => array(
                    'name'          => __('Notas destacadas', 'cmb2'),
                    'id'            => $prefix . '_destacadas',
                    'type'          => 'post_search_ajax',
                    'desc'            => 'Comienza escribiendo el título de la nota. Debe seleccionar 5 notas para que el layout se distribuya correctamente',
                    // Optional :
                    'is_item' => true,
                    'tab_id' => $edicion_key . '_notas-destacadas-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Notas destacadas',
                    'limit'          => 5,         // Limit selection to X items only (default 1)
                    'maxitems'      => 5,
                    'sortable'          => true,     // Allow selected items to be sortable (default false)
                    'query_args'    => array(
                        'post_type'            => array('post'),
                        'post_status'        => array('publish'),
                        'posts_per_page'    => 25,
                        'tax_query' => array(
                            'relation' => 'OR', // Utilizamos 'OR' para obtener publicaciones que cumplan al menos una de las condiciones
                            array(
                                'taxonomy' => 'travel_edition',
                                'field' => 'slug',
                                'terms' => 'global',
                                'operator' => 'IN', // Queremos las publicaciones que tengan 'mexico' asignado
                            ),
                            array(
                                'taxonomy' => 'travel_edition',
                                'operator' => 'NOT EXISTS', // Queremos las publicaciones que no tengan 'travel_edition' asignado
                            )
                        ),
                        // 'date_query' => array(
                        //     'after' => date('Y-m-d', strtotime('-2 years'))
                        // )
                    )
                ),

                $prefix . 'featured_seccion_uno_title' => array(
                    'name'          => __('Título de la sección', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_uno_title',
                    'type'          => 'text',
                    'desc'            => 'Dejar en blanco si quieres que no aparezca ningún nombre',

                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-uno-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Sección (1)',
                ),

                $prefix . 'featured_seccion_uno_link' => array(
                    'name'          => __('Enlace de la sección', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_uno_link',
                    'type'          => 'text_url',
                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-uno-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Sección',
                ),


                $prefix . 'featured_seccion_uno' => array(
                    'name'          => __('Notas de la sección', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_uno',
                    'type'          => 'post_search_ajax',
                    'desc'            => 'Comienza escribiendo el título de la nota. Debe seleccionar 5 notas para que el layout se distribuya correctamente',
                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-uno-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Notas destacadas',
                    'limit'          => 5,         // Limit selection to X items only (default 1)
                    'maxitems'      => 5,
                    'sortable'          => true,     // Allow selected items to be sortable (default false)
                    'query_args'    => array(
                        'post_type'            => array('post'),
                        'post_status'        => array('publish'),
                        'posts_per_page'    => 25,
                        'tax_query' => array(
                            'relation' => 'OR', // Utilizamos 'OR' para obtener publicaciones que cumplan al menos una de las condiciones
                            array(
                                'taxonomy' => 'travel_edition',
                                'field' => 'slug',
                                'terms' => 'global',
                                'operator' => 'IN', // Queremos las publicaciones que tengan 'mexico' asignado
                            ),
                            array(
                                'taxonomy' => 'travel_edition',
                                'operator' => 'NOT EXISTS', // Queremos las publicaciones que no tengan 'travel_edition' asignado
                            )
                        ),
                        // 'date_query' => array(
                        //     'after' => date('Y-m-d', strtotime('-2 years'))
                        // )
                    )
                ),

                $prefix . 'featured_seccion_dos_title' => array(
                    'name'          => __('Título de la sección', 'cmb2'),
                    'id'            => $prefix . 'featured_seccion_dos_title',
                    'type'          => 'text',
                    'desc'            => 'Dejar en blanco si quieres que no aparezca ningún nombre',

                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-dos-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Sección (2)',
                ),

                $prefix . 'featured_seccion_dos_link' => array(
                    'name'          => __('Enlace de la sección', 'cmb2'),
                    'id'            => $prefix . 'featured_seccion_dos_link',
                    'type'          => 'text_url',
                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-dos-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Sección',
                ),



                $prefix . 'featured_seccion_dos' => array(
                    'name'          => __('Notas destacadas por sección (Viajeros)', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_dos',
                    'type'          => 'post_search_ajax',
                    'desc'            => 'Comienza escribiendo el título de la nota. Debe seleccionar 5 notas para que el layout se distribuya correctamente',
                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-dos-tab',

                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Notas destacadas (Viajeros)',
                    'limit'          => 5,         // Limit selection to X items only (default 1)
                    'maxitems'      => 5,
                    'sortable'          => true,     // Allow selected items to be sortable (default false)
                    'query_args'    => array(
                        'post_type'            => array('post'),
                        'post_status'        => array('publish'),
                        'posts_per_page'    => 25,
                        'tax_query' => array(
                            'relation' => 'OR', // Utilizamos 'OR' para obtener publicaciones que cumplan al menos una de las condiciones
                            array(
                                'taxonomy' => 'travel_edition',
                                'field' => 'slug',
                                'terms' => 'global',
                                'operator' => 'IN', // Queremos las publicaciones que tengan 'mexico' asignado
                            ),
                            array(
                                'taxonomy' => 'travel_edition',
                                'operator' => 'NOT EXISTS', // Queremos las publicaciones que no tengan 'travel_edition' asignado
                            )
                        ),
                        // 'date_query' => array(
                        //     'after' => date('Y-m-d', strtotime('-2 years'))
                        // )
                    )
                ),
                $prefix . 'hero_dos' => array(
                    'name'          => __('Banner secundario', 'cmb2'),
                    'id'            => $prefix . '_hero_dos',
                    'type'          => 'post_search_ajax',
                    'desc'            => 'Comienza escribiendo el título de la nota. Si no se selecciona ninguno, el hero se ocultará del home',
                    // Optional :
                    'tab_id' => $edicion_key . '_hero-dos-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Banner secundario',
                    'limit'          => 2,         // Limit selection to X items only (default 1)
                    'maxitems'      => 1,
                    'sortable'          => true,     // Allow selected items to be sortable (default false)
                    'query_args'    => array(
                        'post_type'            => array('post'),
                        'post_status'        => array('publish'),
                        'posts_per_page'    => 25,
                        'tax_query' => array(
                            'relation' => 'OR', // Utilizamos 'OR' para obtener publicaciones que cumplan al menos una de las condiciones
                            array(
                                'taxonomy' => 'travel_edition',
                                'field' => 'slug',
                                'terms' => 'global',
                                'operator' => 'IN', // Queremos las publicaciones que tengan 'mexico' asignado
                            ),
                            array(
                                'taxonomy' => 'travel_edition',
                                'operator' => 'NOT EXISTS', // Queremos las publicaciones que no tengan 'travel_edition' asignado
                            )
                        ),
                        // 'date_query' => array(
                        //     'after' => date('Y-m-d', strtotime('-2 years'))
                        // )
                    )
                ),
                $prefix . 'featured_seccion_tres_title' => array(
                    'name'          => __('Título de la sección', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_tres_title',
                    'type'          => 'text',
                    'desc'            => 'Dejar en blanco si quieres que no aparezca ningún nombre',

                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-tres-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Sección (3)',
                ),
                $prefix . 'featured_seccion_tres_link' => array(
                    'name'          => __('Enlace de la sección', 'cmb2'),
                    'id'            => $prefix . 'featured_seccion_tres_link',
                    'type'          => 'text_url',
                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-tres-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Sección',
                ),

                $prefix . 'featured_seccion_tres' => array(
                    'name'          => __('Notas destacadas por sección (Lo Último)', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_tres',
                    'type'          => 'post_search_ajax',
                    'desc'            => 'Comienza escribiendo el título de la nota. Máximo 3 elementos',
                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-tres-tab',

                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Notas destacadas (Lo último)',
                    'limit'          => 3,         // Limit selection to X items only (default 1)
                    'maxitems'      => 3,
                    'sortable'          => true,     // Allow selected items to be sortable (default false)
                    'query_args'    => array(
                        'post_type'            => array('post'),
                        'post_status'        => array('publish'),
                        'posts_per_page'    => 25,
                        'tax_query' => array(
                            'relation' => 'OR', // Utilizamos 'OR' para obtener publicaciones que cumplan al menos una de las condiciones
                            array(
                                'taxonomy' => 'travel_edition',
                                'field' => 'slug',
                                'terms' => 'global',
                                'operator' => 'IN', // Queremos las publicaciones que tengan 'mexico' asignado
                            ),
                            array(
                                'taxonomy' => 'travel_edition',
                                'operator' => 'NOT EXISTS', // Queremos las publicaciones que no tengan 'travel_edition' asignado
                            )
                        ),
                        // 'date_query' => array(
                        //     'after' => date('Y-m-d', strtotime('-2 years'))
                        // )
                    )
                ),
            );

            return $secciones_portada;
        }, 10, 2);


        /**
         * ESPAÑA
         */

        add_filter('wa_theme_get_cover_espana_editions_page_fields', function ($secciones, $prefix) {

            $edicion_key = "cover_espana";


            $secciones_portada = array(

                $prefix . 'hero' => array(
                    'name'          => __('Banner Principal', 'cmb2'),
                    'id'            => $prefix . '_hero',
                    'type'          => 'post_search_ajax',
                    'desc'            => 'Comienza escribiendo el título de la nota. Si no se selecciona ninguno, el hero se ocultará del home',
                    // Optional :
                    'tab_id' => $edicion_key . '_hero-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Banner Principal',
                    'limit'          => 2,         // Limit selection to X items only (default 1)
                    'maxitems'      => 1,
                    'sortable'          => true,     // Allow selected items to be sortable (default false)
                    'query_args'    => array(
                        'post_type'            => array('post'),
                        'post_status'        => array('publish'),
                        'posts_per_page'    => 25,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'travel_edition',
                                'field' => 'slug',
                                'terms' => 'espana',
                            )
                        ),

                        // 'date_query' => array(
                        //     'after' => date('Y-m-d', strtotime('-2 years'))
                        // )
                    )
                ),
                $prefix . 'destacadas' => array(
                    'name'          => __('Notas destacadas', 'cmb2'),
                    'id'            => $prefix . '_destacadas',
                    'type'          => 'post_search_ajax',
                    'desc'            => 'Comienza escribiendo el título de la nota. Debe seleccionar 5 notas para que el layout se distribuya correctamente',
                    // Optional :
                    'is_item' => true,
                    'tab_id' => $edicion_key . '_notas-destacadas-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Notas destacadas',
                    'limit'          => 5,         // Limit selection to X items only (default 1)
                    'maxitems'      => 5,
                    'sortable'          => true,     // Allow selected items to be sortable (default false)
                    'query_args'    => array(
                        'post_type'            => array('post'),
                        'post_status'        => array('publish'),
                        'posts_per_page'    => 25,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'travel_edition',
                                'field' => 'slug',
                                'terms' => 'espana',
                            )
                        ),
                        // 'date_query' => array(
                        //     'after' => date('Y-m-d', strtotime('-2 years'))
                        // )
                    )
                ),

                $prefix . 'featured_seccion_uno_title' => array(
                    'name'          => __('Título de la sección', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_uno_title',
                    'type'          => 'text',
                    'desc'            => 'Dejar en blanco si quieres que no aparezca ningún nombre',

                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-uno-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Sección (1)',
                ),

                $prefix . 'featured_seccion_uno_link' => array(
                    'name'          => __('Enlace de la sección', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_uno_link',
                    'type'          => 'text_url',
                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-uno-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Sección',
                ),


                $prefix . 'featured_seccion_uno' => array(
                    'name'          => __('Notas de la sección', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_uno',
                    'type'          => 'post_search_ajax',
                    'desc'            => 'Comienza escribiendo el título de la nota. Debe seleccionar 5 notas para que el layout se distribuya correctamente',
                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-uno-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Notas destacadas',
                    'limit'          => 5,         // Limit selection to X items only (default 1)
                    'maxitems'      => 5,
                    'sortable'          => true,     // Allow selected items to be sortable (default false)
                    'query_args'    => array(
                        'post_type'            => array('post'),
                        'post_status'        => array('publish'),
                        'posts_per_page'    => 25,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'travel_edition',
                                'field' => 'slug',
                                'terms' => 'espana',
                            )
                        ),
                        // 'date_query' => array(
                        //     'after' => date('Y-m-d', strtotime('-2 years'))
                        // )
                    )
                ),

                $prefix . 'featured_seccion_dos_title' => array(
                    'name'          => __('Título de la sección', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_dos_title',
                    'type'          => 'text',
                    'desc'            => 'Dejar en blanco si quieres que no aparezca ningún nombre',

                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-dos-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Sección (2)',
                ),

                $prefix . 'featured_seccion_dos_link' => array(
                    'name'          => __('Enlace de la sección', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_dos_link',
                    'type'          => 'text_url',
                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-dos-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Sección',
                ),



                $prefix . 'featured_seccion_dos' => array(
                    'name'          => __('Notas destacadas por sección (Viajeros)', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_dos',
                    'type'          => 'post_search_ajax',
                    'desc'            => 'Comienza escribiendo el título de la nota. Debe seleccionar 5 notas para que el layout se distribuya correctamente',
                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-dos-tab',

                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Notas destacadas (Viajeros)',
                    'limit'          => 5,         // Limit selection to X items only (default 1)
                    'maxitems'      => 5,
                    'sortable'          => true,     // Allow selected items to be sortable (default false)
                    'query_args'    => array(
                        'post_type'            => array('post'),
                        'post_status'        => array('publish'),
                        'posts_per_page'    => 25,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'travel_edition',
                                'field' => 'slug',
                                'terms' => 'espana',
                            )
                        ),
                        // 'date_query' => array(
                        //     'after' => date('Y-m-d', strtotime('-2 years'))
                        // )
                    )
                ),
                $prefix . 'hero_dos' => array(
                    'name'          => __('Banner secundario', 'cmb2'),
                    'id'            => $prefix . '_hero_dos',
                    'type'          => 'post_search_ajax',
                    'desc'            => 'Comienza escribiendo el título de la nota. Si no se selecciona ninguno, el hero se ocultará del home',
                    // Optional :
                    'tab_id' => $edicion_key . '_hero-dos-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Banner secundario',
                    'limit'          => 2,         // Limit selection to X items only (default 1)
                    'maxitems'      => 1,
                    'sortable'          => true,     // Allow selected items to be sortable (default false)
                    'query_args'    => array(
                        'post_type'            => array('post'),
                        'post_status'        => array('publish'),
                        'posts_per_page'    => 25,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'travel_edition',
                                'field' => 'slug',
                                'terms' => 'espana',
                            )
                        ),
                        // 'date_query' => array(
                        //     'after' => date('Y-m-d', strtotime('-2 years'))
                        // )
                    )
                ),
                $prefix . 'featured_seccion_tres_title' => array(
                    'name'          => __('Título de la sección', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_tres_title',
                    'type'          => 'text',
                    'desc'            => 'Dejar en blanco si quieres que no aparezca ningún nombre',

                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-tres-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Sección (3)',
                ),
                $prefix . 'featured_seccion_tres_link' => array(
                    'name'          => __('Enlace de la sección', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_tres_link',
                    'type'          => 'text_url',
                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-tres-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Sección',
                ),

                $prefix . 'featured_seccion_tres' => array(
                    'name'          => __('Notas destacadas por sección (Lo Último)', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_tres',
                    'type'          => 'post_search_ajax',
                    'desc'            => 'Comienza escribiendo el título de la nota. Máximo 3 elementos',
                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-tres-tab',

                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Notas destacadas (Lo último)',
                    'limit'          => 3,         // Limit selection to X items only (default 1)
                    'maxitems'      => 3,
                    'sortable'          => true,     // Allow selected items to be sortable (default false)
                    'query_args'    => array(
                        'post_type'            => array('post'),
                        'post_status'        => array('publish'),
                        'posts_per_page'    => 25,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'travel_edition',
                                'field' => 'slug',
                                'terms' => 'espana',
                            )
                        ),
                        // 'date_query' => array(
                        //     'after' => date('Y-m-d', strtotime('-2 years'))
                        // )
                    )
                ),
            );

            return $secciones_portada;
        }, 10, 2);



        /**
         * MEXICO
         */

        add_filter('wa_theme_get_cover_mexico_editions_page_fields', function ($secciones, $prefix) {

            $edicion_key = "cover_mexico";


            $secciones_portada = array(

                $prefix . 'hero' => array(
                    'name'          => __('Banner Principal', 'cmb2'),
                    'id'            => $prefix . '_hero',
                    'type'          => 'post_search_ajax',
                    'desc'            => 'Comienza escribiendo el título de la nota. Si no se selecciona ninguno, el hero se ocultará del home',
                    // Optional :
                    'tab_id' => $edicion_key . '_hero-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Banner Principal',
                    'limit'          => 2,         // Limit selection to X items only (default 1)
                    'maxitems'      => 1,
                    'sortable'          => true,     // Allow selected items to be sortable (default false)
                    'query_args'    => array(
                        'post_type'            => array('post'),
                        'post_status'        => array('publish'),
                        'posts_per_page'    => 25,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'travel_edition',
                                'field' => 'slug',
                                'terms' => 'mexico',
                            )
                        ),

                        // 'date_query' => array(
                        //     'after' => date('Y-m-d', strtotime('-2 years'))
                        // )
                    )
                ),
                $prefix . 'destacadas' => array(
                    'name'          => __('Notas destacadas', 'cmb2'),
                    'id'            => $prefix . '_destacadas',
                    'type'          => 'post_search_ajax',
                    'desc'            => 'Comienza escribiendo el título de la nota. Debe seleccionar 5 notas para que el layout se distribuya correctamente',
                    // Optional :
                    'is_item' => true,
                    'tab_id' => $edicion_key . '_notas-destacadas-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Notas destacadas',
                    'limit'          => 5,         // Limit selection to X items only (default 1)
                    'maxitems'      => 5,
                    'sortable'          => true,     // Allow selected items to be sortable (default false)
                    'query_args'    => array(
                        'post_type'            => array('post'),
                        'post_status'        => array('publish'),
                        'posts_per_page'    => 25,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'travel_edition',
                                'field' => 'slug',
                                'terms' => 'mexico',
                            )
                        ),
                        // 'date_query' => array(
                        //     'after' => date('Y-m-d', strtotime('-2 years'))
                        // )
                    )
                ),

                $prefix . 'featured_seccion_uno_title' => array(
                    'name'          => __('Título de la sección', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_uno_title',
                    'type'          => 'text',
                    'desc'            => 'Dejar en blanco si quieres que no aparezca ningún nombre',

                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-uno-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Sección (1)',
                ),

                $prefix . 'featured_seccion_uno_link' => array(
                    'name'          => __('Enlace de la sección', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_uno_link',
                    'type'          => 'text_url',
                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-uno-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Sección',
                ),


                $prefix . 'featured_seccion_uno' => array(
                    'name'          => __('Notas de la sección', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_uno',
                    'type'          => 'post_search_ajax',
                    'desc'            => 'Comienza escribiendo el título de la nota. Debe seleccionar 5 notas para que el layout se distribuya correctamente',
                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-uno-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Notas destacadas',
                    'limit'          => 5,         // Limit selection to X items only (default 1)
                    'maxitems'      => 5,
                    'sortable'          => true,     // Allow selected items to be sortable (default false)
                    'query_args'    => array(
                        'post_type'            => array('post'),
                        'post_status'        => array('publish'),
                        'posts_per_page'    => 25,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'travel_edition',
                                'field' => 'slug',
                                'terms' => 'mexico',
                            )
                        ),
                        // 'date_query' => array(
                        //     'after' => date('Y-m-d', strtotime('-2 years'))
                        // )
                    )
                ),

                $prefix . 'featured_seccion_dos_title' => array(
                    'name'          => __('Título de la sección', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_dos_title',
                    'type'          => 'text',
                    'desc'            => 'Dejar en blanco si quieres que no aparezca ningún nombre',

                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-dos-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Sección (2)',
                ),

                $prefix . 'featured_seccion_dos_link' => array(
                    'name'          => __('Enlace de la sección', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_dos_link',
                    'type'          => 'text_url',
                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-dos-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Sección',
                ),



                $prefix . 'featured_seccion_dos' => array(
                    'name'          => __('Notas destacadas por sección (Viajeros)', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_dos',
                    'type'          => 'post_search_ajax',
                    'desc'            => 'Comienza escribiendo el título de la nota. Debe seleccionar 5 notas para que el layout se distribuya correctamente',
                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-dos-tab',

                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Notas destacadas (Viajeros)',
                    'limit'          => 5,         // Limit selection to X items only (default 1)
                    'maxitems'      => 5,
                    'sortable'          => true,     // Allow selected items to be sortable (default false)
                    'query_args'    => array(
                        'post_type'            => array('post'),
                        'post_status'        => array('publish'),
                        'posts_per_page'    => 25,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'travel_edition',
                                'field' => 'slug',
                                'terms' => 'mexico',
                            )
                        ),
                        // 'date_query' => array(
                        //     'after' => date('Y-m-d', strtotime('-2 years'))
                        // )
                    )
                ),
                $prefix . 'hero_dos' => array(
                    'name'          => __('Banner secundario', 'cmb2'),
                    'id'            => $prefix . '_hero_dos',
                    'type'          => 'post_search_ajax',
                    'desc'            => 'Comienza escribiendo el título de la nota. Si no se selecciona ninguno, el hero se ocultará del home',
                    // Optional :
                    'tab_id' => $edicion_key . '_hero-dos-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Banner secundario',
                    'limit'          => 2,         // Limit selection to X items only (default 1)
                    'maxitems'      => 1,
                    'sortable'          => true,     // Allow selected items to be sortable (default false)
                    'query_args'    => array(
                        'post_type'            => array('post'),
                        'post_status'        => array('publish'),
                        'posts_per_page'    => 25,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'travel_edition',
                                'field' => 'slug',
                                'terms' => 'mexico',
                            )
                        ),
                        // 'date_query' => array(
                        //     'after' => date('Y-m-d', strtotime('-2 years'))
                        // )
                    )
                ),
                $prefix . 'featured_seccion_tres_title' => array(
                    'name'          => __('Título de la sección', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_tres_title',
                    'type'          => 'text',
                    'desc'            => 'Dejar en blanco si quieres que no aparezca ningún nombre',

                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-tres-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Sección (3)',
                ),
                $prefix . 'featured_seccion_tres_link' => array(
                    'name'          => __('Enlace de la sección', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_tres_link',
                    'type'          => 'text_url',
                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-tres-tab',
                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Sección',
                ),

                $prefix . 'featured_seccion_tres' => array(
                    'name'          => __('Notas destacadas por sección (Lo Último)', 'cmb2'),
                    'id'            => $prefix . '_featured_seccion_tres',
                    'type'          => 'post_search_ajax',
                    'desc'            => 'Comienza escribiendo el título de la nota. Máximo 3 elementos',
                    // Optional :
                    'tab_id' => $edicion_key . '_seccion-tres-tab',

                    'tab_icon' => 'dashicons-embed-generic',
                    'tab_name' => 'Notas destacadas (Lo último)',
                    'limit'          => 3,         // Limit selection to X items only (default 1)
                    'maxitems'      => 3,
                    'sortable'          => true,     // Allow selected items to be sortable (default false)
                    'query_args'    => array(
                        'post_type'            => array('post'),
                        'post_status'        => array('publish'),
                        'posts_per_page'    => 25,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'travel_edition',
                                'field' => 'slug',
                                'terms' => 'mexico',
                            )
                        ),
                        // 'date_query' => array(
                        //     'after' => date('Y-m-d', strtotime('-2 years'))
                        // )
                    )
                ),
            );

            return $secciones_portada;
        }, 10, 2);
    }

    public function cmb2_main_options_page()
    {
        add_menu_page(
            'Portadas de T+L',
            'Portadas',
            'edit_others_posts',
            'fw_editions_covers',
            array(__CLASS__, 'covers_callback'),
            get_template_directory_uri() . '/assets/images/dashicon.svg',
            '5'
        );
    }

    public static function covers_callback()
    {
        echo "<h1>Ediciones Food & Wine en Español</h1>";
        echo "<p>En este apartado podrás cambiar las portadas de cada edición del sitio</p>";
    }


    public function add_admin_page($optionsPage, $prefix = "wa_theme_portada_")
    {

        $codeOptionsPage = array(
            'id'           => $this->prefix . 'general_page',
            'title'        => esc_html__('Portada T+L', 'wa-theme'),
            'object_types' => array('options-page'),
            'option_key'   => $this->theme_options_key,
            // 'parent_slug'  => 'wa_theme_options',
            'icon_url' => get_template_directory_uri() . '/assets/images/dashicon.png',
            'capability'      => 'edit_others_posts',
            'position'        => 5, // Menu position. Only applicable if 'parent_slug' is left empty.
            'has_tabs' => true,
            'vertical_tabs' => true,

            'wa_fields' => apply_filters('wa_theme_get_wa_theme_portada_general_page_fields', array(), $this->prefix),
        );

        $optionsPage[$prefix . 'general_page'] = $codeOptionsPage;



        /**
         * Secciones
         */



        $sectionFields = array(
            $this->prefix . 'sections' => array(
                'id'          => $this->prefix . 'sections',
                'type'        => 'group',
                'title' => 'Secciones T+L',
                'desc'       => 'Agrega las secciones que serán administradas en la portada',
                'repeatable'  => true,
                'options'     => array(
                    'group_title'   => 'Sección {#}',
                    'add_button'    => 'Agregar Sección',
                    'remove_button' => 'Quitar Sección',
                    'closed'        => true,
                    'sortable'      => false,
                ),
                'tab_icon' => 'dashicons-editor-code',
                'tab_name' => 'Header',
                'wa_group_fields' => apply_filters('wa_theme_get_' . $this->prefix . 'sections_fields', array(
                    'identificador' => array(
                        'name' => 'Identificador',
                        'desc' => 'Escribe un identificador para la seccion',
                        'id'   => 'identificador',
                        'type' => 'text',
                    ),
                    'field_type' =>  array(
                        'name' => 'Tipo de campo para seleccionar',
                        'desc' => '',
                        'id'   => 'field_type',
                        'type' => 'text',
                    ),
                    'field_params' => array(
                        'name' => 'Parámetros del campo de selección',
                        'desc' => 'Solo llenar si estas seguro de lo que estás haciendo',
                        'id'   => 'field_params',
                        'type' => 'parameters',
                        'repeatable' => true,
                        'options' => array(
                            'add_row_text' => __('Agregar parámetro', 'wa-theme'),
                        ),
                    ),
                    'modulo' =>  array(
                        'name' => 'Módulo',
                        'desc' => '',
                        'id'   => 'modulo',
                        'type' => 'text',
                    ),
                    'module_params' => array(
                        'name' => 'Parámetros del módulo',
                        'desc' => 'Solo llenar si estas seguro de lo que estás haciendo',
                        'id'   => 'module_params',
                        'type' => 'parameters',
                        'repeatable' => true,
                        'options' => array(
                            'add_row_text' => __('Agregar parámetro', 'wa-theme'),
                        ),
                    ),

                    'show_metabox' => array(
                        'name' => 'Habilitar',
                        'id'   => 'enable_metabox',
                        'type' => 'checkbox',
                        'desc' => "Marque si desea que esta sección aparezca en el metabox de cada artículo",
                    ),



                )),

            ),

        );

        $seccionesOptionsPage = array(
            'id'           => $this->prefix . 'secciones_page',
            'title'        => esc_html__('Secciones T+L', 'wa-theme'),
            'object_types' => array('options-page'),
            'option_key'   => $this->prefix . 'secciones',
            'parent_slug'  => $this->theme_options_key,
            // 'icon_url' => get_template_directory_uri() . '/assets/images/dashicon.png',
            'capability'      => 'manage_options',
            'position'        => 5, // Menu position. Only applicable if 'parent_slug' is left empty.
            'has_tabs' => false,
            'wa_fields' => apply_filters('wa_theme_get_wa_theme_portada_secciones_page_fields',  $sectionFields),
        );

        // $optionsPage[$prefix . 'secciones_page'] = $seccionesOptionsPage;



        return $optionsPage;
    }


    public function add_editions_page($optionsPage, $prefix = "wa_editions_portada_")
    {

        $ediciones = get_terms(array(
            'taxonomy' => 'travel_edition',
            'parent'   => 0,
            'hide_empty' => false,

        ));


        if (is_array($ediciones) && count($ediciones) > 0) {
            foreach ($ediciones as $edicion) {
                $edicion_key = "cover_" . $edicion->slug;



                $codeOptionsPage = array(
                    'id'           => $edicion_key . '_page',
                    'title'        => "Portada " . $edicion->name,
                    'object_types' => array('options-page'),
                    'option_key'   => $edicion_key,
                    'menu_title'      => $edicion->name, // Falls back to 'title' (above).

                    'parent_slug'  => 'fw_editions_covers',
                    'icon_url' => get_template_directory_uri() . '/assets/images/dashicon.png',
                    'capability'      => 'edit_others_posts',
                    'position'        => 3, // Menu position. Only applicable if 'parent_slug' is left empty.
                    'has_tabs' => true,
                    'vertical_tabs' => true,
                    'wa_fields' => apply_filters('wa_theme_get_' . $edicion_key . '_editions_page_fields', array(), $edicion_key),
                );

                $optionsPage[$edicion_key . '_page'] = $codeOptionsPage;
            }
        }



        return $optionsPage;
    }


    public function add_settings_page($optionsFields, $prefix = "wa_theme_options_")
    {

        $fieldID = $prefix . "travel";

        $optionsFields["{$fieldID}"] =
            array(
                'id'          => "{$fieldID}",
                'type'        => 'group',
                'description' => 'Configuración de Travel + Leisure',
                'repeatable'  => false, // use false if you want non-repeatable group
                'options'     => array(
                    'group_title'       => __('Configuración de Travel + Leisure', 'cmb2'), // since version 1.1.4, {#} gets replaced by row number
                    // 'add_button'        => __( 'Add Another Entry', 'cmb2' ),
                    // 'remove_button'     => __( 'Remove Entry', 'cmb2' ),
                    'sortable'          => false,
                    'closed'         => false, // true to have the groups closed by default
                    // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
                ),
                'tab_name' => 'Travel + Leisure',
                'tab_icon' => 'dashicons-admin-settings',
                'wa_group_fields' => apply_filters("wa_theme_get_{$fieldID}_fields", array(
                    'link_revista' => array(
                        'name' => 'Link de descarga',
                        'desc' => 'Link de descarga de la revista',
                        'id'   => 'link_revista',
                        'type' => 'text',
                    ),
                    'excluded_from_home' => array(
                        'name' => 'Artículos excluidos del home',
                        'id'            =>  'excluded_from_home',
                        'type'        => 'post_search_text',
                        'post_type'   => array('post'),
                        'desc' => 'Elige los artículos que no deben aparecer en los bloques de orden cronólógico en el home.',
                        // // Optional :
                        // 'limit'          => 50,         // Limit selection to X items only (default 1)
                        // 'maxitems'      => 50,
                        // 'sortable'          => true,     // Allow selected items to be sortable (default false)
                        // 'query_args'    => array(
                        //     'post_type'            => array('post'),
                        //     'post_status'        => array('publish'),
                        //     'posts_per_page'    => 25,
                        // )
                    )
                )),

            );

        return $optionsFields;
    }


    public function load_config()
    {
        $travel_options = array(
            'link_revista' => '',
        );
        if (class_exists('Wa_Theme_Manager')) {
            $social_options_cmb = Wa_Theme_Manager::get_opciones('wa_theme_options', 'wa_theme_options_travel');

            if ($social_options_cmb)
                $travel_options = $social_options_cmb[0];
        }

        $this->module_config = $travel_options;
    }



    public function items($option_key, $prefix = 'wa_theme_portada')
    {
        $items = array();
        if (class_exists('Wa_Theme_Manager')) {
            $items = Wa_Theme_Manager::get_opciones($prefix, $option_key);
        }

        return $items;
    }

    public function secciones()
    {
        return apply_filters('wa_theme_get_wa_theme_portada_general_page_fields', array(), $this->prefix);
    }

    public function purge_home($object_id, $updated)
    {
        global $nginx_purger;

        if (strpos($object_id, "cover_") !== false) {

            $slug = str_replace("cover_", "", $object_id);

            $term = get_term_by('slug', $slug, 'travel_edition');
            $edition_page = "";


            if (is_a($term, 'WP_Term')) {
                $page = get_term_meta($term->term_id, 'wa_meta_edition_page', false);
                $edition_page = get_permalink($page[0][0]);
            }

            if ($edition_page !== "") {


                // do_action("swcfpc_purge_cache");



                if (is_object($nginx_purger) && method_exists($nginx_purger, 'purge_url')) {
                    $nginx_purger->purge_url($edition_page);
                    error_log("1- Se purgó: " . $edition_page);
                }


                // if (is_object($GLOBALS['sw_cloudflare_pagecache']) && method_exists($GLOBALS['sw_cloudflare_pagecache'], 'get_objects')) {

                //     $cloudflare = $GLOBALS['sw_cloudflare_pagecache']->get_objects();
                //     $isPurged = $cloudflare['cache_controller']->purge_urls(array($edition_page), false);

                //     $purga = "NO";
                //     if ($isPurged) $purga = "SI";


                //     // $nginx_purger->purge_url($edition_page);
                //     error_log("2 - Se purgó Cloudflare: " . $purga);
                // }



                do_action("swcfpc_purge_cache", array($edition_page));
            }

            return;
        }

        if ($object_id === $this->theme_options_key && $updated === $this->settings_key) {

            if (is_object($nginx_purger) && method_exists($nginx_purger, 'purge_url')) {

                $homepage_url = trailingslashit(home_url());
                $nginx_purger->purge_url($homepage_url);
            }
        }
    }

    public function purge_cache_cloudflare($args)
    {

        error_log("Se purgó en cloudflare: " . $args);
    }
}
