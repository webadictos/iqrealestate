<?php
$GLOBALS['exclude_ids'] = array();

function wa_themeSetupScript()
{

    if (is_single() && get_post_type() === 'post') {


        $breadcrumb = '<script type="application/ld+json">';
        $breadcrumb .= '{';
        $breadcrumb .= '"@context": "https://schema.org","@type": "BreadcrumbList",';
        $breadcrumb .= '"itemListElement": [';
        $position = 1;
        $breadcrumb .= '{
            "@type": "ListItem",
            "position": ' . $position . ',
            "name": "' . get_bloginfo('name') . '",   
            "item": "' . get_home_url() . '"
        }';
        $primary = get_post_primary_category(get_the_ID());

        $parents = get_ancestors($primary['primary_category']->term_id, 'category');

        array_unshift($parents, $primary['primary_category']->term_id);
        $parents_reverse = array_reverse($parents);

        foreach ($parents_reverse as $cat) {
            $position++;

            $catname = get_cat_name($cat);
            $breadcrumb .= ",";
            $breadcrumb .= '{
                "@type": "ListItem",
                "position": ' . $position . ',
                "name": "' . $catname . '", 
                "item": "' . get_category_link($cat) . '"
            }';
        }


        $breadcrumb .= ']';
        $breadcrumb .= '}';
        $breadcrumb .= '</script>';

        echo $breadcrumb;
    }
}

add_filter('wa_get_ads_insertion_positions', function ($positions) {

    $new_positions = array(
        'wa_before_header'   => __('Antes del &lt;header&gt; principal', 'cmb2'),
        'wa_after_header'   => __('Después del &lt;/header&gt; principal', 'cmb2'),
        'wa_before_footer'   => __('Antes del  &lt;footer&gt;', 'cmb2'),
        'wa_after_footer'   => __('Después del  &lt;/footer&gt;', 'cmb2'),
        'wa_before_single_article'   => __('Antesl del artículo', 'cmb2'),
        'wa_after_single_article'   => __('Al final del artículo', 'cmb2'),
        'wa_after_single_footer'   => __('En el footer del artículo', 'cmb2'),
        'wa_before_single_entry'   => __('Antesl del texto de la nota', 'cmb2'),
        'wa_after_single_entry'   => __('Después del texto de la nota', 'cmb2'),

        // 'wa_before_single_header'   => __('Antes del <header> de la nota', 'cmb2'),
        // 'wa_after_single_header'   => __('Después del </header> de la nota', 'cmb2'),
        // 'wa_single_header'   => __('Dentro del <header></header> de la nota', 'cmb2'),
        // 'wa_single_footer'   => __('Dentro del <footer></footer> de la nota', 'cmb2'),
        // 'wa_before_single_footer'   => __('Antes del <footer> de la nota', 'cmb2'),
        // 'wa_after_single_footer'   => __('Después del </footer> de la nota', 'cmb2'),
        // 'wa_before_single_entry'   => __('Antesl del texto de la nota', 'cmb2'),
        // 'wa_after_single_entry'   => __('Después del texto de la nota', 'cmb2'),
        // 'wa_single_entry'   => __('Dentro del texto de la nota (Al principio)', 'cmb2'),
    );

    $positions = array_merge($positions, $new_positions);

    $positions = array_unique($positions, SORT_REGULAR);

    return $positions;
});

add_filter('wa_get_codes_positions', function ($positions) {

    $new_positions = array(
        'wa_before_header'   => __('Antes del  &lt;header&gt; principal', 'cmb2'),
        'wa_after_header'   => __('Después del  &lt;/header&gt; principal', 'cmb2'),
        'wa_before_footer'   => __('Antes del  &lt;footer&gt;', 'cmb2'),
        'wa_after_footer'   => __('Después del  &lt;/footer&gt;', 'cmb2'),

        // 'wa_before_single_header'   => __('Antes del <header> de la nota', 'cmb2'),
        // 'wa_after_single_header'   => __('Después del </header> de la nota', 'cmb2'),
        // 'wa_single_header'   => __('Dentro del <header></header> de la nota', 'cmb2'),
        // 'wa_single_footer'   => __('Dentro del <footer></footer> de la nota', 'cmb2'),
        // 'wa_before_single_footer'   => __('Antes del <footer> de la nota', 'cmb2'),
        // 'wa_after_single_footer'   => __('Después del </footer> de la nota', 'cmb2'),
        // 'wa_before_single_entry'   => __('Antesl del texto de la nota', 'cmb2'),
        // 'wa_after_single_entry'   => __('Después del texto de la nota', 'cmb2'),
        // 'wa_single_entry'   => __('Dentro del texto de la nota (Al principio)', 'cmb2'),
    );

    $positions = array_merge($positions, $new_positions);

    $positions = array_unique($positions, SORT_REGULAR);

    return $positions;
});

// add_action('pre_get_posts', function ($query) {
//     if ($query->is_category() && $query->is_main_query()) {
//         $posts_per_page = 13; // Número de elementos para la primera página
//         $query->set('posts_per_page', $posts_per_page);
//     }
// });


// Remove the current page from the Yoast breadcrumb trail, rendering the parent crumb in plain text.
// add_filter(
//     'wpseo_breadcrumb_links',
//     function ($links) {
//         if (sizeof($links) > 1) {
//             array_pop($links);
//         }
//         return $links;
//     }
// );

function custom_yoast_breadcrumb_separator($separator_output)
{
    // Reemplaza 'ruta/al/ico.svg' con la ubicación real de tu archivo SVG.
    $separator = '<span class="breadcrumb__separator"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
  </svg></span>
  ';
    return $separator;
}
add_filter('wpseo_breadcrumb_separator', 'custom_yoast_breadcrumb_separator');


function wa_post_time_ago()
{
    //return sprintf(esc_html__('Hace %s', 'textdomain'), human_time_diff(get_the_time('U'), current_time('timestamp')));
    return (get_the_time('U') >= strtotime('-1 week')) ? sprintf(esc_html__('Hace %s', 'textdomain'), human_time_diff(get_the_time('U'), current_time('timestamp'))) : get_the_date();
}
add_filter('the_time', 'wa_post_time_ago');


function wa_show_last_updated($date)
{
    $u_time = get_the_time('U');
    $u_modified_time = get_the_modified_time('U');
    if ($u_modified_time >= $u_time + 86400) {
        $updated_date = get_the_modified_time('j \d\e F \d\e Y');
        // $updated_time = get_the_modified_time('h:i a');
        $date = __('Actualizado el ', 'wa-theme') . $updated_date;
    } else {
        $date = __('Publicado el ', 'wa-theme') . $date;
    }

    return $date;
}
add_filter('the_date', 'wa_show_last_updated');


add_filter('block_editor_settings_all', function ($editor_settings, $editor_context) {
    $editor_settings['generateAnchors'] = true;
    return $editor_settings;
}, 10, 2);

add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
    if (isset($atts['href']) && $atts['href'] === '#newsletter') {
        // Agregar el atributo data-modal="true" al enlace
        $atts['data-bs-toggle'] = 'modal';
        $atts['data-bs-target'] = '#newsletter';
    }
    return $atts;
}, 10, 3);

/**
 * Secciones para administrar en la portada
 */


add_filter('wa_theme_get_wa_theme_portada_general_page_fields', function ($secciones, $prefix) {

    $secciones_portada = array(

        $prefix . 'hero' => array(
            'name'          => __('Banner Principal', 'cmb2'),
            'id'            => $prefix . 'hero',
            'type'          => 'post_search_ajax',
            'desc'            => 'Comienza escribiendo el título de la nota. Si no se selecciona ninguno, el hero se ocultará del home',
            // Optional :
            'tab_icon' => 'dashicons-embed-generic',
            'tab_name' => 'Banner Principal',
            'limit'          => 2,         // Limit selection to X items only (default 1)
            'maxitems'      => 1,
            'sortable'          => true,     // Allow selected items to be sortable (default false)
            'query_args'    => array(
                'post_type'            => array('post'),
                'post_status'        => array('publish'),
                'posts_per_page'    => 25,
                // 'date_query' => array(
                //     'after' => date('Y-m-d', strtotime('-2 years'))
                // )
            )
        ),
        $prefix . 'destacadas' => array(
            'name'          => __('Notas destacadas', 'cmb2'),
            'id'            => $prefix . 'destacadas',
            'type'          => 'post_search_ajax',
            'desc'            => 'Comienza escribiendo el título de la nota. Debe seleccionar 5 notas para que el layout se distribuya correctamente',
            // Optional :
            'is_item' => true,
            'tab_icon' => 'dashicons-embed-generic',
            'tab_name' => 'Notas destacadas',
            'limit'          => 5,         // Limit selection to X items only (default 1)
            'maxitems'      => 5,
            'sortable'     => true,     // Allow selected items to be sortable (default false)
            'query_args'    => array(
                'post_type'            => array('post'),
                'post_status'        => array('publish'),
                'posts_per_page'    => 25,
                // 'date_query' => array(
                //     'after' => date('Y-m-d', strtotime('-2 years'))
                // )
            )
        ),

        $prefix . 'featured_seccion_uno_title' => array(
            'name'          => __('Título de la sección', 'cmb2'),
            'id'            => $prefix . 'featured_seccion_uno_title',
            'type'          => 'text',
            'desc'            => 'Dejar en blanco si quieres que no aparezca ningún nombre',

            // Optional :
            'tab_id' => 'seccion-uno',
            'tab_icon' => 'dashicons-embed-generic',
            'tab_name' => 'Sección (1)',
        ),

        $prefix . 'featured_seccion_uno_link' => array(
            'name'          => __('Enlace de la sección', 'cmb2'),
            'id'            => $prefix . 'featured_seccion_uno_link',
            'type'          => 'text_url',
            // Optional :
            'tab_id' => 'seccion-uno',
            'tab_icon' => 'dashicons-embed-generic',
            'tab_name' => 'Sección',
        ),


        $prefix . 'featured_seccion_uno' => array(
            'name'          => __('Notas de la sección', 'cmb2'),
            'id'            => $prefix . 'featured_seccion_uno',
            'type'          => 'post_search_ajax',
            'desc'            => 'Comienza escribiendo el título de la nota. Debe seleccionar 5 notas para que el layout se distribuya correctamente',
            // Optional :
            'tab_id' => 'seccion-uno',
            'tab_icon' => 'dashicons-embed-generic',
            'tab_name' => 'Notas destacadas',
            'limit'          => 5,         // Limit selection to X items only (default 1)
            'maxitems'      => 5,
            'sortable'          => true,     // Allow selected items to be sortable (default false)
            'query_args'    => array(
                'post_type'            => array('post'),
                'post_status'        => array('publish'),
                'posts_per_page'    => 25,
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
            'tab_id' => 'seccion-dos',
            'tab_icon' => 'dashicons-embed-generic',
            'tab_name' => 'Sección (2)',
        ),

        $prefix . 'featured_seccion_dos_link' => array(
            'name'          => __('Enlace de la sección', 'cmb2'),
            'id'            => $prefix . 'featured_seccion_dos_link',
            'type'          => 'text_url',
            // Optional :
            'tab_id' => 'seccion-dos',
            'tab_icon' => 'dashicons-embed-generic',
            'tab_name' => 'Sección',
        ),



        $prefix . 'featured_seccion_dos' => array(
            'name'          => __('Notas destacadas por sección (Viajeros)', 'cmb2'),
            'id'            => $prefix . 'featured_seccion_dos',
            'type'          => 'post_search_ajax',
            'desc'            => 'Comienza escribiendo el título de la nota. Debe seleccionar 5 notas para que el layout se distribuya correctamente',
            // Optional :
            'tab_id' => 'seccion-dos',

            'tab_icon' => 'dashicons-embed-generic',
            'tab_name' => 'Notas destacadas (Viajeros)',
            'limit'          => 5,         // Limit selection to X items only (default 1)
            'maxitems'      => 5,
            'sortable'          => true,     // Allow selected items to be sortable (default false)
            'query_args'    => array(
                'post_type'            => array('post'),
                'post_status'        => array('publish'),
                'posts_per_page'    => 25,
                // 'date_query' => array(
                //     'after' => date('Y-m-d', strtotime('-2 years'))
                // )
            )
        ),
        $prefix . 'hero_dos' => array(
            'name'          => __('Banner secundario', 'cmb2'),
            'id'            => $prefix . 'hero_dos',
            'type'          => 'post_search_ajax',
            'desc'            => 'Comienza escribiendo el título de la nota. Si no se selecciona ninguno, el hero se ocultará del home',
            // Optional :
            'tab_icon' => 'dashicons-embed-generic',
            'tab_name' => 'Banner secundario',
            'limit'          => 2,         // Limit selection to X items only (default 1)
            'maxitems'      => 1,
            'sortable'          => true,     // Allow selected items to be sortable (default false)
            'query_args'    => array(
                'post_type'            => array('post'),
                'post_status'        => array('publish'),
                'posts_per_page'    => 25,
                // 'date_query' => array(
                //     'after' => date('Y-m-d', strtotime('-2 years'))
                // )
            )
        ),
        $prefix . 'featured_seccion_tres_title' => array(
            'name'          => __('Título de la sección', 'cmb2'),
            'id'            => $prefix . 'featured_seccion_tres_title',
            'type'          => 'text',
            'desc'            => 'Dejar en blanco si quieres que no aparezca ningún nombre',

            // Optional :
            'tab_id' => 'seccion-tres',
            'tab_icon' => 'dashicons-embed-generic',
            'tab_name' => 'Sección (3)',
        ),
        $prefix . 'featured_seccion_tres_link' => array(
            'name'          => __('Enlace de la sección', 'cmb2'),
            'id'            => $prefix . 'featured_seccion_tres_link',
            'type'          => 'text_url',
            // Optional :
            'tab_id' => 'seccion-tres',
            'tab_icon' => 'dashicons-embed-generic',
            'tab_name' => 'Sección',
        ),

        $prefix . 'featured_seccion_tres' => array(
            'name'          => __('Notas destacadas por sección (Lo Último)', 'cmb2'),
            'id'            => $prefix . 'featured_seccion_tres',
            'type'          => 'post_search_ajax',
            'desc'            => 'Comienza escribiendo el título de la nota. Máximo 3 elementos',
            // Optional :
            'tab_id' => 'seccion-tres',

            'tab_icon' => 'dashicons-embed-generic',
            'tab_name' => 'Notas destacadas (Lo último)',
            'limit'          => 3,         // Limit selection to X items only (default 1)
            'maxitems'      => 3,
            'sortable'          => true,     // Allow selected items to be sortable (default false)
            'query_args'    => array(
                'post_type'            => array('post'),
                'post_status'        => array('publish'),
                'posts_per_page'    => 25,
                // 'date_query' => array(
                //     'after' => date('Y-m-d', strtotime('-2 years'))
                // )
            )
        ),
    );

    return $secciones_portada;
}, 10, 2);


/**
 * Temporary fix jetpack cdn
 */
add_filter('jetpack_photon_skip_for_url', function ($allow) {
    return false;
}, 10, 1);


function wa_add_border_theme_support($editor_settings, $editor_context)
{
    if (!empty($editor_context->post)) {
        $editor_settings["enableCustomSpacing"] = true;
        $editor_settings["__experimentalFeatures"]["spacing"]["margin"] = true;

        $editor_settings["__experimentalFeatures"]["border"]["color"] = true;
        $editor_settings["__experimentalFeatures"]["border"]["style"] = true;
        $editor_settings["__experimentalFeatures"]["border"]["width"] = false;
        $editor_settings["__experimentalFeatures"]["border"]["radius"] = true;
    }
    return $editor_settings;
}

add_filter('block_editor_settings_all', 'wa_add_border_theme_support', 10, 2);



add_action('wa_before_category_item_loop', function ($args) {

    if ($args['current_page'] === 1 && $args['current_item'] === 3) {
        echo "<div class='aside'>";

        $slot_tmp = array(
            'id' => "travelrostopa",
            'code' => "travel-ros-t-a",
            'refresh' => true,
            'size_mapping' => 'billboard',
            //  'custom_params' => array('class' => 'test'),
        );

        wa_create_ad_slot($slot_tmp);

        echo "</div>";
    }
}, 10, 1);

add_action('wa_after_category_loop', function ($args) {

    echo "<div class='aside'>";

    $slot_tmp = array(
        'id' => "travelrostopb",
        'code' => "travel-ros-t-b",
        'refresh' => true,
        'size_mapping' => 'billboard',
        //  'custom_params' => array('class' => 'test'),
    );

    wa_create_ad_slot($slot_tmp);

    echo "</div>";
}, 10, 1);

add_filter('wa_theme_setup_script_current', function ($current) {
    $currentEdition = array();

    if (is_single()) {
        $ediciones = get_the_terms(get_the_ID(), 'travel_edition');
        if (is_array($ediciones)) {

            foreach ($ediciones as $edicion) {
                $currentEdition[] = $edicion->slug;
            }
        }
    }

    $current['edicion'] = $currentEdition;

    return $current;
}, 10, 1);


add_filter('wa_theme_infinitescroll_args', function ($args) {
    $currentEdition = array();

    if (is_single()) {
        $ediciones = get_the_terms(get_the_ID(), 'travel_edition');

        if (is_array($ediciones)) {
            foreach ($ediciones as $edicion) {
                $currentEdition[] = $edicion->slug;
            }
        }
    }

    if (count($currentEdition) > 0) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'travel_edition',
                'field' => 'slug',
                'terms' => $currentEdition,
            )
        );
    }

    return $args;
}, 10, 1);


// add_filter('wa_theme_layouts/layout_args', function ($args) {

//     print_r($args); wa_before_article_item_loop

//     return $args;
// }, 10, 1);

// add_action('wa_before_article_item_loop', function ($args) {

//     print_r($args);

//     // if ($args['current_page'] === 1 && $args['current_item'] === 3) {
//     //     echo "<div class='aside'>";

//     //     $slot_tmp = array(
//     //         'id' => "travelrostopa",
//     //         'code' => "travel-ros-t-a",
//     //         'refresh' => true,
//     //         'size_mapping' => 'billboard',
//     //         //  'custom_params' => array('class' => 'test'),
//     //     );

//     //     wa_create_ad_slot($slot_tmp);

//     //     echo "</div>";
//     // }
// }, 10, 1);


add_action('enqueue_block_assets', 'enqueue_block_variations');

function enqueue_block_variations()
{
    $script_asset = include get_parent_theme_file_path('blocks-variations/public/js/editor.asset.php');
    $style_asset  = include get_parent_theme_file_path('blocks-variations/public/css/editor.asset.php');

    wp_enqueue_style(
        'block-variations',
        get_parent_theme_file_uri('blocks-variations/public/css/screen.css'),
        $style_asset['dependencies'],
        $style_asset['version']
    );
}


add_action('enqueue_block_assets', 'themeslug_editor_assets');

function themeslug_editor_assets()
{
    $script_asset = include get_parent_theme_file_path('blocks-variations/public/js/editor.asset.php');
    $style_asset  = include get_parent_theme_file_path('blocks-variations/public/css/editor.asset.php');

    if (is_admin()) {
        wp_enqueue_script(
            'themeslug-editor',
            get_parent_theme_file_uri('blocks-variations/public/js/editor.js'),
            $script_asset['dependencies'],
            $script_asset['version'],
            true
        );

        wp_enqueue_style(
            'themeslug-editor',
            get_parent_theme_file_uri('blocks-variations/public/css/editor.css'),
            $style_asset['dependencies'],
            $style_asset['version']
        );
    }
}


function enqueue_project_scripts()
{
    if (is_single() && get_post_type() === "iq_realestate") {
        wp_enqueue_script('dflip');
        wp_enqueue_style('dflip');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_project_scripts');


function wa_active_filters()
{

    $_chosen_attributes = wa_get_filters_in_url();
    $base_link          = home_url($_SERVER['REQUEST_URI']);
    if (is_single()) {
        $base_link = get_post_type_archive_link('iq_realestate');
    }

    if (0 < count($_chosen_attributes)) {


        echo '<ul class="wa-filter">';

        // Attributes.
        if (!empty($_chosen_attributes)) {

            $grouped_atts = array();

            foreach ($_chosen_attributes as $taxonomy => $data) {

                $tax = get_taxonomy($taxonomy);


                foreach ($data['terms'] as $term_slug) {
                    $term = get_term_by('slug', $term_slug, $taxonomy);
                    if (!$term) {
                        continue;
                    }

                    $filter_name    = $taxonomy;
                    $current_filter = isset($_GET[$filter_name]) ? explode(',', (wp_unslash($_GET[$filter_name]))) : array(); // WPCS: input var ok, CSRF ok.
                    $current_filter = array_map('sanitize_title', $current_filter);
                    $new_filter     = array_diff($current_filter, array($term_slug));

                    $link = remove_query_arg(array($filter_name), $base_link);

                    if (count($new_filter) > 0) {
                        $link = add_query_arg($filter_name, implode(',', $new_filter), $link);
                    }
                    //<button type="button" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="propio en un radio limitado" >Delivery</button>
                    $grouped_atts[$tax->labels->singular_name][] = '<a class="btn btn-primary wa-filters__check--btn active" rel="nofollow" role="button" aria-label="' . esc_attr__('Quitar filtro', 'iqrealestate') . '" href="' . esc_url($link) . '" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="' . sprintf('%1$s : %2$s', $tax->labels->singular_name, esc_html($term->name)) . '" >' . esc_html($term->name) . ' </a>';
                }
            }
        }

        if (count($grouped_atts) > 0) {


            foreach ($grouped_atts as $key => $atts) {
                //<span class="wa-filter__label">' . $key . ':</span> 
                // echo '<li class="wa-filter__chosen chosen">';
                $before = "<li>";
                $after = "</li>";
                $separator = " ";

                $items = $before . implode("{$after}{$separator}{$before}", $atts) . $after;

                echo $items;
                //echo '<span class="wa-filter__term">' . implode(" ", $atts) . '</span>';

                // echo "</li>";
            }

            echo '<li><a class="btn btn-clear" href="' . get_post_type_archive_link('iq_realestate') . '">Limpiar filtros</a></li>';
        }


        echo '</ul>';
    }
}


function wa_get_filters_in_url()
{


    $chosen_attributes = array();

    if (!empty($_GET)) {
        foreach ($_GET as $key => $value) {
            if (0 === strpos($key, 'iq_')) {
                $taxonomy     = $key;
                $filter_terms = !empty($value) ? explode(',', (wp_unslash($value))) : array();

                if (empty($filter_terms) || !taxonomy_exists($taxonomy)) {
                    continue;
                }

                $chosen_attributes[$taxonomy]['terms'] = array_map('sanitize_title', $filter_terms); // Ensures correct encoding.
            }
        }
    }

    return $chosen_attributes;
}
