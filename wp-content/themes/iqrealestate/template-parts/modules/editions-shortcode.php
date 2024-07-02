<?php

/**
 * Construye el layout dependiendo los parámetrs
 */

$_layoutArgs = array(
    'section_name' => '',
    'section_class' => '',
    'section_id' => '',
    'edition' => 'Resto del mundo',
);

$layoutArgs = wp_parse_args($args, $_layoutArgs);


$ediciones = get_terms(array(
    'taxonomy' => 'travel_edition',
    'parent'   => 0,
    'hide_empty' => false,

));

$edicionesDos = wa_theme()->modules()->is_active('editions') ? wa_theme()->module('editions')->get_editions() : array();

if (is_array($ediciones) && count($ediciones) > 0) :
?>
    <section class="section section--editions <?php echo $layoutArgs['section_class']; ?>">
        <div class="container">
            <div class="dropdown menu-editions">
                <button class="btn menu-editions__btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo $layoutArgs['edition']; ?>
                </button>
                <ul class="dropdown-menu">
                    <?php
                    foreach ($ediciones as $edicion) :

                        $edition_page = get_term_meta($edicion->term_id, 'wa_meta_edition_page', true);

                        if (is_array($edition_page) && count($edition_page) > 0) {
                            $edition_url = get_permalink($edition_page[0]);

                            if ($edition_url) :
                    ?>
                                <li><a class="dropdown-item menu-editions__item" href="<?php echo $edition_url; ?>"><?php echo $edicion->name; ?></a></li>
                        <?php
                            endif;
                        }

                        ?>
                    <?php endforeach; ?>
                    <!-- <li><a class="dropdown-item menu-editions__item" href="/mexico/">México</a></li>
                    <li><a class="dropdown-item menu-editions__item" href="/espana/">España</a></li>
                    <li><a class="dropdown-item menu-editions__item" href="/">Resto del mundo</a></li> -->
                </ul>
            </div>
        </div>
    </section>
<?php
endif;
?>