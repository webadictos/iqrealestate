<?php

/**
 * Article Item Part with Arguments
 */

$_itemArgs = array(
    'items_layout_css' => 'article-item',
    'items_swiper' => false,
    'items_config' => array(
        'show_marcas' => true,
        'show_marcas_label' => 'Marcas firmadas:',
        'show_direccion' => true,
        'items_show_main_cat' => false,
        'items_show_parent_cat' => false,
        'items_show_badge_cat' => false,
        'items_show_date' => false,
        'items_show_time' => false,
        'items_show_author' => false,
        'items_show_excerpt' => false,
        'items_show_arrow' => false,
        'items_show_more_btn' => true,
        'items_more_btn_txt' => __('Ver proyecto', 'wa-theme'),
        'image_animation' => true,
        'item_badge_text' => '',
        'items_image_size' => 'large'
    ),
);


$itemArgs = wp_parse_args($args, $_itemArgs);
$seodesc = "";


/**
 * FIX debido a que no siempre se envian todos los parámetros de items_config en el archivo que llama a article-item
 */
try {
    $itemArgs['items_config'] = $GLOBALS['WA_Theme']->helper('utils')->fix_args($_itemArgs['items_config'], $itemArgs['items_config']);
} catch (Throwable $e) {
}


if ($itemArgs['items_config']['items_show_excerpt']) {
    $seodesc = get_the_excerpt();
}


if (has_post_thumbnail()) :
    $thumb = get_the_post_thumbnail(get_the_ID(), $itemArgs['items_config']['items_image_size'], array('title' => wp_strip_all_tags(get_the_title()), 'alt' => wp_strip_all_tags(get_the_title()), 'class' => 'd-block article-item__thumbnail--img'));
else :
    $thumb = '<img  class="d-block article-item__thumbnail--img" width="100%" height="auto" src="' . wa_theme()->setting('general', 'default_image') . '" alt="' . get_the_title() . '" title="' . wp_strip_all_tags(get_the_title()) . '">';
endif;

$primary_category = null;

if ($itemArgs['items_config']['items_show_main_cat'] || $itemArgs['items_config']['items_show_badge_cat']) {

    $primary_category = apply_filters('get_primary_category', $primary_category, get_the_ID());
}

$thumbnail_url = get_the_permalink();
$thumbnail_url_css = "";

?>

<?php if ($itemArgs['items_swiper']) : ?>
    <div class="swiper-slide">
    <?php endif; ?>


    <article <?php post_class("article-item proyecto-item " . $itemArgs['items_layout_css'], get_the_ID()); ?> <?php function_exists('wa_article_item_attributes') ? wa_article_item_attributes() : ''; ?>>

        <figure class="article-item__thumbnail <?php echo get_post_format(); ?> <?php echo (!$itemArgs['items_config']['image_animation']) ? 'unanimated' : ''; ?>">
            <a class="article-item__thumbnail-link <?php echo $thumbnail_url_css; ?>" href="<?php echo $thumbnail_url; ?>" title="<?php echo get_the_title() ?>"><?php echo $thumb; ?></a>
        </figure>

        <header class="article-item__header">

            <div class="article-item__meta">

                <div class="article-item__title-container">
                    <h2 class="article-item__title">
                        <a class="limit-lines" href="<?php the_permalink() ?>" title="<?php echo get_the_title() ?>">
                            <?php echo get_the_title(); ?>
                        </a>

                    </h2>
                </div>
                <?php
                if ($itemArgs['items_config']['show_direccion']) :

                    $direccion = get_post_meta(get_the_ID(), 'iqrealestate_address', true);

                ?>
                    <p class="article-item__meta--direccion">
                        <?php echo $direccion; ?>
                    </p>
                <?php
                endif;
                ?>


                <?php
                if ($itemArgs['items_config']['show_marcas']) :
                    $marcas = get_post_meta(get_the_ID(), 'iqrealestate_brands_logos', true);
                    if (is_array($marcas)) :

                ?>
                        <div class="article-item__meta--marcas">
                            <span><?php echo $itemArgs['items_config']['show_marcas_label']; ?></span>
                            <?php
                            foreach ($marcas as $logo_id => $logo_src) :

                                $logo_image = wp_get_attachment_image($logo_id, 'full', false, array('title' => wp_strip_all_tags(get_the_title()), 'alt' => wp_strip_all_tags(get_the_title()), 'class' => 'article-item__marcas--logo'));

                                echo $logo_image;

                            endforeach;
                            ?>
                        </div>
                <?php
                    endif;
                endif;
                ?>

                <?php if ($itemArgs['items_config']['items_show_more_btn'] || $itemArgs['items_config']['items_show_arrow']) : ?>
                    <div class="article-item__more">
                        <?php
                        if ($itemArgs['items_config']['items_show_more_btn']) :
                        ?>
                            <a class=" btn btn-primary article-item__btn-more" href="<?php the_permalink() ?>" title="<?php echo get_the_title() ?>">
                                <?php echo $itemArgs['items_config']['items_more_btn_txt']; ?>
                            </a>
                        <?php
                        endif;
                        ?>
                    </div>
                <?php endif; ?>

            </div>





        </header>
    </article>

    <?php if ($itemArgs['items_swiper']) : ?>
    </div>
<?php endif; ?>