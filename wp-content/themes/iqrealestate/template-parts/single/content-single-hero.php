<?php

/**
 * The template for displaying content in the single.php template
 */
?>
<?php
$esInfinito = (isset($_REQUEST['action']) &&  $_REQUEST['action'] == "loadmore") ? true : false;

$primary_category = null;
$primary_category = apply_filters('get_primary_category', $primary_category, get_the_ID());


?>
<?php
do_action('wa_before_single_article');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post single-entry single-hero'); ?> <?php function_exists('wa_article_attributes') ? wa_article_attributes() : ''; ?>>
    <header class="entry-header single-entry__header">

        <?php

        $thumb = "";
        $caption = "";

        if (has_post_thumbnail()) :
            $thumb = get_the_post_thumbnail(get_the_ID(), 'full', array('title' => get_the_title(), 'alt' => get_the_title(), 'class' => "w-100"));

            $caption = get_the_post_thumbnail_caption();

        // else :
        //     $thumb = '<img src="' . $GLOBALS['default_image'] . '" alt="' . get_the_title() . '" title="' . get_the_title() . '" class="w-100">';
        endif;
        ?>

        <?php if ($thumb !== "") : ?>
            <figure class="post-thumbnail single-entry__thumbnail" <?php echo apply_filters('wa_thumbnail_attributes', "", get_the_ID()); ?>>
                <?php echo $thumb; ?>
                <?php if ($caption !== "") : ?>
                    <figcaption class="single-entry__thumbnail-caption"><?php echo $caption; ?></figcaption>
                <?php endif; ?>
            </figure>
        <?php endif; ?>



        <ul id="breadcrumbs" class="breadcrumb-list">

            <?php

            $ancestors = get_ancestors($primary_category['primary_category']->term_id, 'category');

            $ancestors[] = $primary_category['primary_category']->term_id;

            foreach ($ancestors as $breadrumb_item) {
            ?>
                <li class="breadcrumb-list__item">
                    <a class="breadcrumb-list__item-link" href="<?php echo get_category_link($breadrumb_item); ?>"><?php echo get_cat_name($breadrumb_item); ?></a>
                </li>
            <?php
            }
            ?>
        </ul>



        <div class="entry-info single-entry__header-info">

            <h1 class="entry-title single-entry__header-title"><?php the_title(); ?></h1>

            <?php
            $excerpt = get_the_excerpt();
            ?>
            <div class="entry-excerpt">
                <?php echo wpautop($excerpt); ?>
            </div>

            <div class="entry-meta single-entry__header-meta">

                <div class="article-autor single-entry__header-meta--author" itemprop="author" itemscope itemtype="http://schema.org/Person"><span><?php echo __('Por ', 'guia-gastronomica'); ?></span> <span itemprop="name">
                        <?php the_author_posts_link(); ?></span>
                </div>

                <time class="post-meta-date single-entry__header-meta--date" content="<?php echo get_the_date('Y-m-d'); ?>"><?php the_date(); ?></time>

                <?php
                if (function_exists('wa_show_sharebar')) {
                    wa_show_sharebar(get_the_ID(), array('css' => 'colored-icons', 'networks' => array('facebook', 'twitter', 'whatsapp', 'email')));
                }
                ?>


            </div><!-- /.entry-meta -->
        </div>

    </header><!-- /.entry-header -->


    <div class="entry-content entry-grid">


        <div class="entry-grid__main-text entry-main-text" data-bs-spy="scroll" data-bs-target="#toc" data-bs-smooth-scroll="true">



            <?php
            do_action('wa_before_single_entry');
            ?>

            <?php

            the_content();

            wp_link_pages(array('before' => '<div class="page-link"><span>' . __('Pages:', 'hotbook-theme-v2') . '</span>', 'after' => '</div>'));
            ?>

            <?php
            do_action('wa_after_single_entry');
            ?>
        </div>


    </div><!-- /.entry-content -->
    <footer class="single-entry__footer wide-container">
        <?php
        do_action('wa_after_single_footer');
        ?>
    </footer>
</article><!-- /#post-<?php the_ID(); ?> -->

<?php
do_action('wa_after_single_article');
?>