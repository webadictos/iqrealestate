<?php

/**
 * Construye el layout dependiendo los parámetrs
 */

$_layoutArgs = array(
    'section_name' => '',
    'section_class' => '',
    'section_id' => '',
    'post_id' => '',
    'option_key' => '',
    'option_prefix' => 'wa_theme_portada',
    'image_url' => '',
    'hero_title' => '',
    'hero_desc' => '',
    'dont_exclude' => false,
    'lazyload' => false,
    'hero_author' => '',
    'items_layout' => 'article-item',
    'items_config' => array(
        'items_show_tags' => false,
        'items_show_main_cat' => true,
        'items_show_badge_cat' => false,
        'items_show_date' => false,
        'items_show_author' => true,
        'items_show_excerpt' => true,
        'items_show_arrow' => false,
        'items_show_more_btn' => false,
        'items_more_btn_txt' => __('Leer más', 'wa-theme'),
        'items_image_size' => 'full'
    ),
);

$layoutArgs = wp_parse_args($args, $_layoutArgs);

$pID = 0;

if (trim($layoutArgs['option_key']) !== "") {
    $heroID = wa_theme()->module('portada')->items($layoutArgs['option_key'], $layoutArgs['option_prefix']);

    // $items = Wa_Theme_Manager::get_opciones($layoutArgs['option_prefix'], $layoutArgs['option_key']);


    // print_r($items);
    if (is_array($heroID) && count($heroID) > 0) {
        $pID = $heroID[0];
    }
} else if (intval($layoutArgs['post_id']) > 0) {
    $pID = intval($layoutArgs['post_id']);
}

if ($layoutArgs['lazyload']) {
    if (trim($layoutArgs['section_id']) === "") {
        $layoutArgs['section_id'] = "seccion-" . uniqid();
    }
}


if ($pID > 0) :

    $post = get_post($pID);

    setup_postdata($post);

    if (!$layoutArgs['dont_exclude']) {
        $GLOBALS['exclude_ids'][] = get_the_ID();
    }


    $banner_hero = trim(get_post_meta(get_the_ID(), 'wa_meta_portada_hero', true));
    $banner_hero_id = trim(get_post_meta(get_the_ID(), 'wa_meta_portada_hero_id', true));

    $banner_title = trim(get_post_meta(get_the_ID(), 'wa_meta_hero_title', true));
    $banner_desc = trim(get_post_meta(get_the_ID(), 'wa_meta_hero_desc', true));

    if ($banner_hero !== "") {
        $layoutArgs['image_url'] = $banner_hero;
    }
    if ($banner_title !== "") $layoutArgs['hero_title'] = $banner_title;
    if ($banner_desc !== "") $layoutArgs['hero_desc'] = $banner_desc;

?>
    <section class="section section--hero-article <?php echo $layoutArgs['section_class']; ?> <?php echo (trim($layoutArgs['section_id']) !== "") ? "seccion-" . $layoutArgs['section_id'] : ''; ?>" <?php if (trim($layoutArgs['section_id']) !== "") : ?>data-section-id="<?php echo trim($layoutArgs['section_id']); ?>" <?php endif; ?> data-wa-lazysection="<?php echo $layoutArgs['lazyload'] ? 'true' : 'false'; ?>">

        <?php
        if ($layoutArgs['lazyload']) :
        ?>
            <template id="template-<?php echo $layoutArgs['section_id']; ?>">
            <?php
        endif;
            ?>

            <?php

            if (trim($layoutArgs['hero_desc']) !== "") {
                $hero_desc = trim($layoutArgs['hero_desc']);
            } else {
                $hero_desc = get_the_excerpt();
            }

            if (trim($layoutArgs['hero_title']) !== "") {
                $hero_title = trim($layoutArgs['hero_title']);
            } else {
                $hero_title = get_the_title();
            }

            if (trim($layoutArgs['image_url']) !== "") {

                if ($banner_hero_id) {


                    $atts['title'] = wp_strip_all_tags($hero_title);
                    $atts['alt'] = wp_strip_all_tags($hero_title);
                    $atts['class'] = 'd-block article-item__thumbnail--img';
                    $atts['srcset'] = wp_get_attachment_image_url($banner_hero_id, array(450, 450)) . ' 800w, ' .
                        wp_get_attachment_image_url($banner_hero_id, 'full') . ' 1512w';
                    $atts['sizes'] = "80vw";

                    $thumb  = wp_get_attachment_image($banner_hero_id, 'full', false, $atts);
                } else {
                    $thumb = '<img  class="article-item__thumbnail--img" width="100%" height="auto" src="' . trim($layoutArgs['image_url']) . '" alt="' . $hero_title . '" title="' . wp_strip_all_tags($hero_title) . '">';
                }
            } else {


                if (has_post_thumbnail()) :
                    $thumbnail_id = get_post_thumbnail_id(get_the_ID());
                    $atts = array();


                    $atts['title'] = wp_strip_all_tags($hero_title);
                    $atts['alt'] = wp_strip_all_tags($hero_title);
                    $atts['class'] = 'd-block article-item__thumbnail--img';
                    $atts['srcset'] = wp_get_attachment_image_url($thumbnail_id, array(450, 450)) . ' 800w, ' .
                        wp_get_attachment_image_url($thumbnail_id, 'full') . ' 1512w';
                    $atts['sizes'] = "80vw";

                    $thumb  = wp_get_attachment_image($thumbnail_id, 'full', false, $atts);

                //$thumb = get_the_post_thumbnail(get_the_ID(), 'full', array('title' => wp_strip_all_tags($hero_title), 'alt' => wp_strip_all_tags($hero_title), 'class' => 'd-block article-item__thumbnail--img'));
                else :
                    $thumb = '<img  class="article-item__thumbnail--img" width="100%" height="auto" src="' . wa_theme()->setting('general', 'default_image') . '" alt="' . $hero_title . '" title="' . wp_strip_all_tags($hero_title) . '">';
                endif;
            }

            $primary_category = null;

            if ($layoutArgs['items_config']['items_show_main_cat'] || $layoutArgs['items_config']['items_show_badge_cat']) {

                $primary_category = apply_filters('get_primary_category', $primary_category, get_the_ID());
            }


            ?>
            <article class="article-item article-item--hero">

                <figure class="article-item__thumbnail">
                    <a class="article-item__thumbnail-link" href="<?php the_permalink() ?>" title="<?php echo $hero_title; ?>"><?php echo $thumb; ?></a>
                </figure>

                <header class="article-item__header container">

                    <div class="article-item__meta">

                        <?php if ($layoutArgs['items_config']['items_show_main_cat']) : ?>
                            <a class="article-item__cat post-category" href="<?php echo get_category_link($primary_category['parent_category']->term_id); ?>"><?php echo $primary_category['parent_category']->name; ?></a>
                        <?php endif; ?>

                        <div class="article-item__title-container">
                            <h2 class="article-item__title">
                                <a class="limit-lines" href="<?php the_permalink() ?>" title="<?php echo $hero_title; ?>">
                                    <?php echo $hero_title; ?>
                                </a>
                            </h2>
                        </div>

                        <?php if ($layoutArgs['items_config']['items_show_excerpt']) : ?>
                            <div class="article-item__excerpt limit-lines">
                                <?php echo $hero_desc; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($layoutArgs['items_config']['items_show_author']) : ?>

                            <div class="article-item_author" itemprop="author" itemscope itemtype="http://schema.org/Person">
                                <?php echo __('Por: ', 'wa-theme'); ?>
                                <span itemprop="name">
                                    <?php the_author_posts_link(); ?>
                                </span>
                            </div>

                        <?php endif; ?>

                    </div>

                </header>

            </article>
            <?php
            wp_reset_postdata();
            wp_reset_query();
            ?>

            <?php
            if ($layoutArgs['lazyload']) :
            ?>
            </template>
        <?php
            endif;
        ?>
    </section>
<?php
endif;
?>