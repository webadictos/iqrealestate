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
    'option_key' => '',
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


if ($layoutArgs['exclude_ids']) {
    $_args['post__not_in'] = array_unique($GLOBALS['exclude_ids']) ?? array();
}


// print_r(array_unique($GLOBALS['exclude_ids']));

// print_r(count(array_unique($GLOBALS['exclude_ids'])));

$_args = array_merge($_args, $layoutArgs['queryArgs']);

if (trim($layoutArgs['option_key']) !== "") {
    $itemsIDs = wa_theme()->module('portada')->items($layoutArgs['option_key']);

    if (is_array($itemsIDs) && count($itemsIDs) > 0) {
        $_args['post__in'] = $itemsIDs;
        $_args['orderby'] = 'post__in';
        if (isset($_args['category_name'])) unset($_args['category_name']);
    }
}

$seccion = isset($layoutArgs['queryArgs']['category_name']) ? get_category_by_slug($layoutArgs['queryArgs']['category_name']) : '';




?>
<section class="section <?php echo $layoutArgs['section_class']; ?> <?php echo (trim($layoutArgs['section_id']) !== "") ? "seccion-" . $layoutArgs['section_id'] : ''; ?>" <?php if (trim($layoutArgs['section_id']) !== "") : ?>data-section-id="<?php echo trim($layoutArgs['section_id']); ?>" <?php endif; ?>>

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
            $count = 0;

            echo $wp_query->post_count;

            global $wpdb;

            // Print last SQL query string
            echo $wpdb->last_query;

            while (have_posts() && $count < 5) : the_post();



                add_filter('term_links-post_tag', 'limit_to_tags');



                get_template_part('template-parts/items/' . $layoutArgs['items_layout'], null, $itemArgs);


                $numdestacado++;
                $i++;

                $count++;


            endwhile;
            wp_reset_postdata();
            wp_reset_query();
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
</section>