<?php

/**
 * What to Read Next
 */

?>
<?php
/**
 * Sección sin sidebar
 * Beauty
 * Layout Sección 2
 */

$primary_category = null;
$primary_category = apply_filters('get_primary_category', $primary_category, get_the_ID());

//$cats = wp_get_post_categories(get_the_ID(), array('fields' => 'ids'));

$_layoutArgs = array(
    'section_id' => is_object($primary_category['parent_category']) ? 'seccion-' . $primary_category['parent_category']->slug : "",
    'section_class' => is_object($primary_category['parent_category']) ? 'section-related main-category-' . $primary_category['parent_category']->slug : 'section-related',
    'section_name' => 'Artículos relacionados',
    'grid_layout' => 'archive-articles-container',
    'section_show_link' => false,
    'section_show_more_link' => false,
    'exclude_container' => false,
    'items_layout_css' => 'article-item archive-item',
    'has_container' => true,
    'lazyload' => true,
    'items_config' => array(
        'items_show_tags' => false,
        'items_show_main_cat' => true,
        'items_show_badge_cat' => false,
        'items_show_date' => false,
        'items_show_author' => true,
        'items_show_excerpt' => false,
        'items_show_arrow' => false,
        'items_show_more_btn' => false,
    ),    'show_empty' => false,
    'queryArgs' => array(
        'posts_per_page' => 8,
        'category_name' => is_object($primary_category['parent_category']) ?  $primary_category['parent_category']->slug : null,
        'post__not_in' => array(get_the_ID()),
    )
);

$layoutArgs = wp_parse_args($args, $_layoutArgs);

//get_template_part( 'template-parts/layouts/layout','without-sidebar',$layoutArgs);
get_template_part('template-parts/layouts/layout', '', $layoutArgs);
?>
