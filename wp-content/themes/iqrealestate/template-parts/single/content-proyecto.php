<?php

/**
 * The template for displaying content in the single.php template
 */
?>
<?php
$esInfinito = (isset($_REQUEST['action']) &&  $_REQUEST['action'] == "loadmore") ? true : false;

$primary_category = null;
$primary_category = apply_filters('get_primary_category', $primary_category, get_the_ID());

$info = array();
$address = get_post_meta(get_the_ID(), 'iqrealestate_address', true);
$logos = get_post_meta(get_the_ID(), 'iqrealestate_brands_logos', true);
$info['desarrollador'] = get_post_meta(get_the_ID(), 'iqrealestate_desarrollador', true);
$info['gla'] = get_post_meta(get_the_ID(), 'iqrealestate_gla', true);
$info['gla_oficinas'] = get_post_meta(get_the_ID(), 'iqrealestate_gla_oficinas', true);
$info['estacionamiento'] = get_post_meta(get_the_ID(), 'iqrealestate_estacionamiento', true);
$info['arquitectura'] = get_post_meta(get_the_ID(), 'iqrealestate_arquitectura', true);
$info['comercializacion'] = get_post_meta(get_the_ID(), 'iqrealestate_comercializacion', true);
$info['locales'] = get_post_meta(get_the_ID(), 'iqrealestate_locales', true);
$info['residencial'] = get_post_meta(get_the_ID(), 'iqrealestate_residencial', true);
$geolocation = get_post_meta(get_the_ID(), 'iqrealestate_geolocation', true);
$gallery = get_post_meta(get_the_ID(), 'iqrealestate_images', true);
$telefonos = get_post_meta(get_the_ID(), 'iqrealestate_phone_numbers', true);
$email = get_post_meta(get_the_ID(), 'iqrealestate_email', true) ?? '';
$brochure_type = get_post_meta(get_the_ID(), 'iqrealestate_brochure_type', true);
$brochure_file = get_post_meta(get_the_ID(), 'iqrealestate_brochure_file', true);
$tour_embed = get_post_meta(get_the_ID(), 'iqrealestate_tour_embed', true);

$categoria = get_the_terms(get_the_ID(), 'iq_category');
$ubicacion = get_the_terms(get_the_ID(), 'iq_location');
$tipo = get_the_terms(get_the_ID(), 'iq_type');

?>
<?php
do_action('wa_before_single_article');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post single-project'); ?> <?php function_exists('wa_article_attributes') ? wa_article_attributes() : ''; ?>>
    <header class="entry-header single-entry__header wide-container">

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
                <?php if (has_term('en-renta', 'iq_type')) : ?>
                    <figcaption class="single-entry__thumbnail-caption">Espacios Comerciales Disponibles</figcaption>
                <?php endif; ?>
            </figure>
        <?php endif; ?>

        <div class="entry-info single-entry__header-info container">

            <h1 class="entry-title single-entry__header-title"><?php the_title(); ?></h1>

        </div>

    </header><!-- /.entry-header -->


    <div class="single-project__info wide-container">
        <div class="single-project__info-wrapper container">
            <div class="single-project__info__meta">
                <h2 class="single-project__info-subtitle"><?php the_title(); ?></h2>
                <div class="single-project__info-address d-flex align-items-center">
                    <img class="icon-location" src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/location.svg" width="24" height="24" alt="Dirección" /><span class="address"><?php echo $address; ?></span>
                </div>
            </div>

            <div class="single-project__icons-wrapper">

                <div class="single-project__icons">
                    <?php
                    if (!empty($info['desarrollador'])) :
                    ?>
                        <div class="single-project__icon icon-desarrolla">
                            <p class="single-project__icon-title">Desarrolla</p>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/icon-desarrolla.svg" width="32" height="32" alt="Desarrolla" />
                            <p class="single-project__icon-label"><?php echo $info['desarrollador']; ?></p>
                        </div>
                    <?php endif; ?>

                    <?php
                    if (is_array($categoria) && count($categoria) > 0) :
                    ?>
                        <div class="single-project__icon icon-categoria">
                            <p class="single-project__icon-title">Categoría</p>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/icon-categoria.svg" width="32" height="32" alt="Categoría" />
                            <p class="single-project__icon-label">
                                <?php
                                echo $categoria[0]->name;
                                ?>
                            </p>
                        </div>
                    <?php endif; ?>
                    <?php
                    if (!empty($info['gla'])) :
                    ?>
                        <div class="single-project__icon icon-gla">
                            <p class="single-project__icon-title">GLA Centro Comercial</p>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/icon-gla.svg" width="32" height="32" alt="GLA Centro Comercial" />
                            <p class="single-project__icon-label"><?php echo $info['gla']; ?></p>
                        </div>
                    <?php endif; ?>
                    <?php
                    if (!empty($info['gla_oficinas'])) :
                    ?>
                        <div class="single-project__icon icon-gla-oficinas">
                            <p class="single-project__icon-title">GLA Oficinas</p>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/icon-gla.svg" width="32" height="32" alt="GLA Centro Comercial" />
                            <p class="single-project__icon-label"><?php echo $info['gla_oficinas']; ?></p>
                        </div>
                    <?php endif; ?>

                    <?php
                    if (!empty($info['estacionamiento'])) :
                    ?>
                        <div class="single-project__icon icon-gla-estacionamiento">
                            <p class="single-project__icon-title">Estacionamiento</p>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/icon-estacionamiento.svg" width="32" height="32" alt="Estacionamiento" />
                            <p class="single-project__icon-label"><?php echo $info['estacionamiento']; ?></p>
                        </div>
                    <?php endif; ?>
                    <?php
                    if (!empty($info['arquitectura'])) :
                    ?>
                        <div class="single-project__icon icon-arquitectura">
                            <p class="single-project__icon-title">Arquitectura</p>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/icon-arquitectura.svg" width="32" height="32" alt="Arquitectura" />
                            <p class="single-project__icon-label"><?php echo $info['arquitectura']; ?></p>
                        </div>
                    <?php endif; ?>
                    <?php
                    if (!empty($info['comercializacion'])) :
                    ?>
                        <div class="single-project__icon icon-comercializacion">
                            <p class="single-project__icon-title">Comercialización</p>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/icon-comercializa.svg" width="32" height="32" alt="Comercialización" />
                            <p class="single-project__icon-label"><?php echo $info['comercializacion']; ?></p>
                        </div>
                    <?php endif; ?>
                    <?php
                    if (!empty($info['locales'])) :
                    ?>
                        <div class="single-project__icon icon-locales">
                            <p class="single-project__icon-title">Locales</p>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/icon-locales.svg" width="32" height="32" alt="Locales" />
                            <p class="single-project__icon-label"><?php echo $info['locales']; ?></p>
                        </div>
                    <?php endif; ?>
                    <?php
                    if (!empty($info['residencial'])) :
                    ?>
                        <div class="single-project__icon icon-residencial">
                            <p class="single-project__icon-title">Residenciales</p>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/icon-residencial.svg" width="32" height="32" alt="Residenciales" />
                            <p class="single-project__icon-label"><?php echo $info['residencial']; ?></p>
                        </div>
                    <?php endif; ?>
                    <?php
                    if (is_array($tipo) && count($tipo) > 0) :
                    ?>
                        <div class="single-project__icon icon-etapa">
                            <p class="single-project__icon-title">Etapa</p>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/icon-residencial.svg" width="32" height="32" alt="Etapa" />
                            <p class="single-project__icon-label">
                                <?php
                                echo $tipo[0]->name;
                                ?>
                            </p>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="single-project__gallery">
                    <?php
                    $carouselID = uniqid();

                    $_argsSwiper = array(
                        'direction' => 'horizontal',
                        'loop' => false,
                        'items_gap' => 10,
                        'autoheight' => false,
                        'items_visible' => 1,
                        'items_visible_movil' => 1,
                        'items_visible_tablet' => 1,
                        'mousewheel' => false,
                        'pagination' => false,
                        'navigation' => false,
                        'autoplay' => false,
                        'centered' => false,
                    );

                    $carruselConfig = htmlentities(json_encode($_argsSwiper));


                    ?>
                    <?php if (is_array($gallery) && count($gallery) > 0) : ?>

                        <div class="swiper wa-swiper-component" data-carrusel-config="<?php echo $carruselConfig; ?>" data-carousel-id="<?php echo $carouselID; ?>">


                            <div class="swiper-wrapper">


                                <?php foreach ($gallery as $img_id => $img) : ?>

                                    <div class="swiper-slide">
                                        <figure class="single-project__gallery-figure">
                                            <button class="wa-gallery-lightbox" data-src="<?php echo $img; ?>" data-caption="<?php echo get_the_title(); ?>" title="Expandir" aria-title="Expandir"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrows-fullscreen" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M5.828 10.172a.5.5 0 0 0-.707 0l-4.096 4.096V11.5a.5.5 0 0 0-1 0v3.975a.5.5 0 0 0 .5.5H4.5a.5.5 0 0 0 0-1H1.732l4.096-4.096a.5.5 0 0 0 0-.707m4.344 0a.5.5 0 0 1 .707 0l4.096 4.096V11.5a.5.5 0 1 1 1 0v3.975a.5.5 0 0 1-.5.5H11.5a.5.5 0 0 1 0-1h2.768l-4.096-4.096a.5.5 0 0 1 0-.707m0-4.344a.5.5 0 0 0 .707 0l4.096-4.096V4.5a.5.5 0 1 0 1 0V.525a.5.5 0 0 0-.5-.5H11.5a.5.5 0 0 0 0 1h2.768l-4.096 4.096a.5.5 0 0 0 0 .707m-4.344 0a.5.5 0 0 1-.707 0L1.025 1.732V4.5a.5.5 0 0 1-1 0V.525a.5.5 0 0 1 .5-.5H4.5a.5.5 0 0 1 0 1H1.732l4.096 4.096a.5.5 0 0 1 0 .707" />
                                                </svg></button>
                                            <?php
                                            echo wp_get_attachment_image($img_id, "full");
                                            ?>
                                        </figure>


                                    </div>


                                <?php endforeach; ?>

                            </div>

                        </div>

                    <?php endif; ?>

                    <?php if ($email !== "") : ?>
                        <a class="btn btn-primary" href="mailto:<?php echo $email; ?>">Pedir informes</a>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>


    <?php
    do_action('wa_before_single_entry');
    ?>


    <?php if (is_array($logos) && count($logos) > 0) : ?>

        <section class="section single-project__comercios">

            <header class="section__title-container">



                <h2 class="section__title">

                    <span>
                        Principales Comercios
                    </span>



                </h2>

            </header>


            <?php
            $carouselID = uniqid();

            $_argsSwiper = array(
                'direction' => 'horizontal',
                'loop' => false,
                'items_gap' => 10,
                'autoheight' => true,
                'items_visible' => 5,
                'items_visible_movil' => 3,
                'items_visible_tablet' => 3,
                'mousewheel' => false,
                'pagination' => true,
                'navigation' => false,
                'autoplay' => false,
                'centered' => false,
            );

            $carruselConfig = htmlentities(json_encode($_argsSwiper));


            ?>

            <div class="swiper wa-swiper-component" data-carrusel-config="<?php echo $carruselConfig; ?>" data-carousel-id="<?php echo $carouselID; ?>">


                <div class="swiper-wrapper">


                    <?php foreach ($logos as $img_id => $img) : ?>

                        <div class="swiper-slide">
                            <figure class="single-project__logo-figure">
                                <?php
                                echo wp_get_attachment_image($img_id, "full");
                                ?>
                            </figure>


                        </div>


                    <?php endforeach; ?>

                </div>

            </div>


        </section>

    <?php endif; ?>

    <?php


    if ($brochure_type === "file" && $brochure_file !== "") :

        $brochureId = uniqid();

    ?>
        <div class="_df_book df-lite single-project__brochure" id="df_<?php echo $brochureId; ?>" _slug="brochure-<?php echo get_post_field('post_name', get_post()); ?>" data-title="brochure-<?php echo get_post_field('post_name', get_post()); ?>" wpoptions="true" thumbtype=""></div>
        <script class="df-shortcode-script">
            window.option_df_<?php echo $brochureId; ?> = {
                "outline": [],
                "autoEnableOutline": "false",
                "autoEnableThumbnail": "false",
                "overwritePDFOutline": "false",
                "direction": "1",
                "pageSize": "0",
                "source": "<?php echo esc_html($brochure_file); ?>",
                "wpOptions": "true"
            };
            if (window.DFLIP && window.DFLIP.parseBooks) {
                window.DFLIP.parseBooks();
            }
        </script>
    <?php
    endif;
    ?>

    <section class="section single-project__contacto wide-container">

        <div class="single-project__contacto-inner">
            <div class="single-project__contacto--info">

                <h3 class="single-project__contacto--title"><?php the_title(); ?></h3>
                <div class="single-project__contacto--address d-flex align-items-center">
                    <img class="icon-location" src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/location.svg" width="24" height="24" alt="Dirección" /><span class="address"><?php echo $address; ?></span>
                </div>

                <?php
                if (is_array($telefonos) && count($telefonos) > 0) :
                ?>
                    <ul class="single-project__contacto--telefonos">
                        <?php foreach ($telefonos as $telefono) : ?>

                            <li><a href="tel:<?php echo $telefono; ?>"><?php echo $telefono; ?></a></li>

                        <?php endforeach; ?>

                    </ul>
                <?php endif; ?>

                <?php if ($email !== "") : ?>
                    <a class="btn btn-primary" href="mailto:<?php echo $email; ?>">Pedir informes</a>
                <?php endif; ?>

            </div>
            <div class="single-project__contacto--location">
                <div id="project-map-<?php echo get_the_ID(); ?>" class="single-project__map" data-latitude="<?php echo $geolocation['latitude']; ?>" data-longitude="<?php echo $geolocation['longitude']; ?>">

                </div>
            </div>
        </div>

    </section>

    <?php
    $_args = array(
        'max-width' => '',
        'classname' => '',
        'link' => 'mailto:contacto@iqr.mx',
    );
    get_template_part('template-parts/modules/callout', '', $_args);
    ?>

    <?php
    do_action('wa_after_single_entry');
    ?>
    <footer class="single-entry__footer">
        <?php
        do_action('wa_after_single_footer');
        ?>
    </footer>
</article><!-- /#post-<?php the_ID(); ?> -->

<?php
do_action('wa_after_single_article');
?>