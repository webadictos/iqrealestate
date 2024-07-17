<?php

/**
 * The Template for displaying Archive pages.
 */

get_header();
?>
<main class="site-main archive-projects container" role="main">



    <section class="archive-projects__header wide-container">

        <figure class="archive-projects__header-image">


            <img src="https://iqrealestate.tmphost.net/wp-content/uploads/2024/06/sc3-scaled.jpg" title="Sascabera, Quintana Roo" width="100%" height="auto" />

            <figcaption>Sascabera, Quintana Roo</figcaption>

        </figure>
        <h1 class="visually-hidden">
            Proyectos
        </h1>
    </section>



    <?php
    /*$args = array(
        'orderby' => 'order',
        'order' => 'ASC',
        'show_count' => 0,
        'hierarchical' => 1,
        'depth' => 1,
        'hide_empty' => 0,
        'title_li' => '',
        'hide_title_if_empty' => true,
        'taxonomy' => 'iq_type',
        'walker' => new Custom_Walker_Category(),
        'echo' => 0
    );
    $subcategories = wp_list_categories($args);
    ?>

    <?php if ($subcategories !== '<li class="cat-item-none">No hay categorías</li>') : ?>

        <ul id="navbar-tipo-proyecto" class="tipo-proyecto__menu">

            <?php echo $subcategories; ?>

        </ul>

    <?php endif; */ ?>




    <?php
    $archive_link = get_post_type_archive_link('iq_realestate');
    $tipos = get_terms(array(
        'taxonomy'   => 'iq_type',
        'hide_empty' => false,
        'orderby' => 'order',
        'order' => 'ASC'
    ));
    ?>
    <ul id="navbar-tipo-proyectos" class="tipo-proyecto__menu">

        <?php
        if (is_array($tipos) && count($tipos) > 0) :
        ?>
            <?php foreach ($tipos as $tipo) : ?>
                <li><a class="dropdown-item" href="<?php echo $archive_link; ?>?iq_type=<?php echo $tipo->slug; ?>"><?php echo $tipo->name; ?></a></li>
            <?php endforeach; ?>

        <?php endif; ?>
    </ul>

    <?php
    get_template_part('template-parts/modules/filters');
    ?>

    <h2 class="project-type__title">Proyectos</h2>


    <?php
    if (have_posts()) :
    ?>

        <section class="section p-0">
            <div class="archive-articles-container">
                <div class="row"></div>
                <?php
                $_args = array(
                    'items_layout_css' => 'archive-item project-archive-item',
                    'items_config' => array(
                        'items_show_tags' => false,
                        'items_show_main_cat' => false,
                        'items_show_badge_cat' => false,
                        'items_show_date' => false,
                        'items_show_author' => false,
                        'items_show_excerpt' => false,
                        'items_show_arrow' => false,
                        'items_show_more_btn' => false,
                    ),
                );
                get_template_part('template-parts/archive', 'loop', $_args);
                ?>
            </div>
        </section>


    <?php
    else :
    ?>
        <p class="fs-4 text-danger text-center">No se encontraron proyectos bajo esos criterios.</p>
    <?php
    endif;

    wp_reset_postdata(); // End of the loop.
    ?>

    <?php
    $_args = array(
        'max-width' => '',
        'classname' => '',
        'link' => 'mailto:contacto@iqr.mx',
    );
    get_template_part('template-parts/modules/callout', '', $_args);
    ?>
</main>
<?php
get_footer();
