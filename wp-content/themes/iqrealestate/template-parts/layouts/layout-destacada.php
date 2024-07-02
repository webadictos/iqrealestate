<?php

/**
 * Construye el layout dependiendo los parámetrs
 */


$_layoutArgs = array(
    'has_container' => true,
    'exclude_container' => false,
    'grid_layout' => 'grid-container-items',
    'items_layout' => 'article-item',
    'items_layout_css' => '',
    'items_swiper' => false,
    'exclude_ids' => false,
    'dont_exclude' => false,
    'lazyload' => false,
    'items_config' => array(
        'items_show_tags' => false,
        'items_show_main_cat' => false,
        'items_show_badge_cat' => false,
        'items_show_date' => false,
        'items_show_author' => false,
        'items_show_excerpt' => false,
        'items_show_arrow' => false,
        'items_show_more_btn' => false,
        'items_more_btn_txt' => __('Leer más', 'wa-theme'),
        'image_animation' => true,
    ),
    'section_id' => '',
    'section_class' => '',
    'section_name' => '',
    'section_description' => null,
    'section_link' => '',
    'section_show_link' => false,
    'show_section_title' => true,
    'section_title_container_class' => '',
    'section_title_class' => '',
    'show_more_btn' => false,
    'show_more_txt' => 'Ver todas',
    'show_more_link' => '',
    'show_empty' => true,
    'queryArgs' => array(),
    'option_prefix' => 'wa_theme_portada',
    'option_key' => '',
    'title_key' => '',
    'link_key' => '',
    'edition' => '',
    'show_without_edition' => false,
    'sidebar_title' => '',
);


$layoutArgs = wp_parse_args($args, $_layoutArgs);

$_args = array(
    'post_type' => array('post'),
    'posts_per_page' => 5,
    'paged' => 1,
    'no_found_rows' => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
    'post_status' => 'publish',
    'ignore_sticky_posts' => true,
    'suppress_filters' => true,
);

$_args = array_merge($_args, $layoutArgs['queryArgs']);

/**
 * Si se tiene definido un option_key se le da prioridad a esos IDS ya que son elegidos manualente 
 * y no hay que hacer ningún exclude, ni otros argumentos en la consulta.
 */
if (trim($layoutArgs['option_key']) !== "") {
    $itemsIDs = wa_theme()->module('portada')->items($layoutArgs['option_key'], $layoutArgs['option_prefix']);

    if (is_array($itemsIDs) && count($itemsIDs) > 0) {
        $_args['post__in'] = $itemsIDs;
        $_args['orderby'] = 'post__in';
        if (isset($_args['category_name'])) unset($_args['category_name']);
        if (isset($_args['post__not_in'])) unset($_args['post__not_in']);
    }
    $section_title = wa_theme()->module('portada')->items($layoutArgs['option_key'] . "_title", $layoutArgs['option_prefix']) ?? '';
    if (trim($section_title) !== "") {
        $layoutArgs['section_name'] = $section_title ?? $layoutArgs['section_name'];
    }

    $section_link = wa_theme()->module('portada')->items($layoutArgs['option_key'] . "_link", $layoutArgs['option_prefix']) ?? '';

    if (trim($section_link) !== "") {
        $layoutArgs['section_link'] = $section_link ?? $layoutArgs['section_link'];
    }
} else {

    /**
     * Si no es option key entonces se hace un query normal
     * Primero se valida si es front page para obtener los ids que a propósito queremos excluir del home
     * y los agregamos al GLOBALS.
     * En este caso no preguntamos si está definido el exclude_ids ya que es obligatorio no mostrar estas notas en el home
     *  */

    if (is_front_page()) {
        $_homeExcluded = wa_theme()->setting('portada', 'excluded_from_home') ?? '';

        $homeExcluded = explode(',', $_homeExcluded);

        if (is_array($homeExcluded) && count($homeExcluded) > 0) {
            $homeExcluded = array_unique($homeExcluded, SORT_NUMERIC);
            $GLOBALS['exclude_ids'] = array_unique($GLOBALS['exclude_ids'], SORT_NUMERIC);
            $GLOBALS['exclude_ids'] = array_merge($GLOBALS['exclude_ids'], $homeExcluded);
        }
    }
    /**
     * Si se tiene el valor de exclude_ids, primero se valida que los ids no estén elegidos entre las secciones definidas
     * en la portada del sitio en caso de que estemos en el front page y se añaden al GLOBALS.
     * Posteriormente se agrega el argumento post__not_in
     */
    if ($layoutArgs['exclude_ids']) {

        //Solo excluimos a propósito los ids de las secciones de portada si estamos en el front page
        if (is_front_page()) {
            $secciones_portada = wa_theme()->module('portada')->secciones() ?? array();
            // $secciones_portada_ids = array_keys($secciones_portada);
            $_ids = array();


            foreach ($secciones_portada as $seccion_portada => $fields) {
                $seccion_portada_items = wa_theme()->module('portada')->items($seccion_portada);

                if (is_array($seccion_portada_items)) {
                    $_ids = array_merge($_ids, $seccion_portada_items);
                }
            }


            $GLOBALS['exclude_ids'] = array_merge(array_unique($_ids, SORT_NUMERIC), $GLOBALS['exclude_ids']) ?? array();
            //  $GLOBALS['exclude_ids'] = array_unique($_ids, SORT_NUMERIC) ?? array();
        }

        $_args['post__not_in'] = $GLOBALS['exclude_ids'] ?? array();
    }
}


$seccion = isset($layoutArgs['queryArgs']['category_name']) ? get_category_by_slug($layoutArgs['queryArgs']['category_name']) : '';

if ($layoutArgs['lazyload']) {
    if (trim($layoutArgs['section_id']) === "") {
        $layoutArgs['section_id'] = "seccion-" . uniqid();
    }
}

$articlesQuery = new WP_Query();



$articlesQuery->query($_args);



if (!$layoutArgs['show_empty'] && !$articlesQuery->have_posts()) {
    return;
} else {

?>
    <section class="section <?php echo $layoutArgs['section_class']; ?> <?php echo (trim($layoutArgs['section_id']) !== "") ? "seccion-" . $layoutArgs['section_id'] : ''; ?>" <?php if (trim($layoutArgs['section_id']) !== "") : ?>data-section-id="<?php echo trim($layoutArgs['section_id']); ?>" <?php endif; ?> data-wa-lazysection="<?php echo $layoutArgs['lazyload'] ? 'true' : 'false'; ?>">

        <?php
        if ($layoutArgs['lazyload']) :
        ?>
            <template id="template-<?php echo $layoutArgs['section_id']; ?>">
            <?php
        endif;
            ?>

            <?php
            if (!$layoutArgs['exclude_container']) :
            ?>
                <div class="container<?php echo $layoutArgs['has_container'] ? '' : '-fluid'; ?>">
                <?php endif; ?>


                <?php if ($layoutArgs['show_section_title']) : ?>


                    <header class="section__title-container <?php echo $layoutArgs['section_title_container_class']; ?>">



                        <h2 class="section__title <?php echo $layoutArgs['section_title_class']; ?>">
                            <?php if ($layoutArgs['section_show_link']) : ?>

                                <?php
                                if ($layoutArgs['section_link'] !== "") {
                                    $link = $layoutArgs['section_link'];
                                } else {
                                    $link = get_category_link($seccion);
                                }
                                ?>
                                <a href="<?php echo $link; ?>" title="<?php echo $layoutArgs['section_name']; ?>">

                                <?php endif; ?>

                                <span>
                                    <?php if ($layoutArgs['section_name']) : ?>

                                        <?php echo $layoutArgs['section_name']; ?>

                                    <?php else : ?>
                                        <?php echo $seccion->cat_name; ?>

                                    <?php endif; ?>

                                </span>


                                <?php if ($layoutArgs['section_show_link']) : ?>

                                </a>
                            <?php endif; ?>
                        </h2>

                        <?php if (!is_null($layoutArgs['section_description']) && trim($layoutArgs['section_description']) !== "") : ?>
                            <div class="section__description">
                                <?php echo wpautop($layoutArgs['section_description'], false); ?>
                            </div>
                        <?php endif; ?>

                    </header>

                <?php
                endif;
                ?>




                <?php




                // print_r($featuredPostsSlider);
                ?>


                <div class="<?php echo $layoutArgs['grid_layout']; ?>">

                    <?php

                    $i = 0;
                    $numdestacado = 0;

                    //foreach($carrusel as $post):
                    // setup_postdata($post);'items_swiper' => false,

                    $itemArgs = array(
                        'items_swiper' => $layoutArgs['items_swiper'],
                        'items_layout_css' => $layoutArgs['items_layout_css'],
                        'items_config' => $layoutArgs['items_config'],
                    );


                    while ($articlesQuery->have_posts()) : $articlesQuery->the_post();

                        if (!$layoutArgs['dont_exclude']) {
                            $GLOBALS['exclude_ids'][] = get_the_ID();
                        }



                        $_itemLayoutArgs = array(
                            'index' => $i,
                            'post_id' => get_the_ID(),
                            'context' => $layoutArgs['section_id'],
                        );

                        $itemLayout = apply_filters('wa_get_article_item_layout', $layoutArgs['items_layout'], $_itemLayoutArgs);


                        do_action("wa_before_article_item_loop", $_itemLayoutArgs);


                        get_template_part('template-parts/items/' . $itemLayout, null, $itemArgs);


                        do_action("wa_after_article_item_loop", $_itemLayoutArgs);

                        if ($i === 0) {
                            echo "<div class='featured-sidebar'>";
                            if ($layoutArgs['sidebar_title'] !== '') :
                                echo '<h2 class="featured-sidebar__title">' . $layoutArgs['sidebar_title'] . '</h2>';
                            endif;
                        }

                        $numdestacado++;
                        $i++;

                    endwhile;
                    wp_reset_postdata();
                    wp_reset_query();
                    //Cierra Sidebar
                    echo "</div>";
                    ?>
                    <?php //endforeach;
                    ?>
                    <?php remove_filter('term_links-post_tag', 'limit_to_tags'); ?>

                </div>


                <?php if ($layoutArgs['show_more_btn']) : ?>
                    <div class="show-more">
                        <a class="btn btn-primary show-more__btn" href="<?php echo $layoutArgs['show_more_link']; ?>"><?php echo $layoutArgs['show_more_txt']; ?></a>
                    </div>
                <?php endif; ?>


                <?php
                if (!$layoutArgs['exclude_container']) :
                ?>
                </div>

            <?php endif; ?>


            <?php
            if ($layoutArgs['lazyload']) :
            ?>
            </template>
        <?php
            endif;
        ?>

    </section>
<?php
}
?>