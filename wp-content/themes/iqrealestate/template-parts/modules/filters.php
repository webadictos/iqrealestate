<?php

/**
 * Construye el layout dependiendo los parámetrs
 */


$_layoutArgs = array(
    'terms' => array(
        'iq_location' => 'Ubicación',
        'iq_type' => 'Tipo de proyecto',
        'iq_area' => 'Área total rentable',
    ),
);


$layoutArgs = wp_parse_args($args, $_layoutArgs);

?>

<div class="archive-project__filters-wrapper">

    <div class="archive-project__filters-title">
        Filtrar por:
    </div>

    <div class="archive-project__filters-items">

        <?php
        $hasActiveFilters = wa_get_filters_in_url();
        ?>



        <?php

        $current_slug = "/" . add_query_arg(array(), $wp->request) . "/";

        $current_slug = $_SERVER['REQUEST_URI'];

        $parse = parse_url($current_slug);


        if (isset($parse['query'])) {
            parse_str($parse['query'], $params);
        } else {
            $params = array();
        }

        ?>



        <?php
        foreach ($layoutArgs['terms'] as $filter => $filterName) :
        ?>

            <div class="dropdown">
                <button class="btn btn-filter dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,0">
                    <?php echo $filterName; ?>
                </button>
                <ul class="dropdown-menu">

                    <?php
                    $filterArgs = get_terms(array(
                        'taxonomy' => $filter,
                        'hide_empty' => false,
                        'parent'   => 0,
                        'orderby' => 'order',
                        'order' => 'ASC'
                    ));




                    $activeFilters = array();



                    foreach ($filterArgs as $filterItem) {

                        if (!isset($params[$filter])) $categoryFilters = array();
                        else $categoryFilters = explode(',', (wp_unslash($params[$filter])));


                        $base_link = "";
                        if (is_single()) {
                            $base_link = get_post_type_archive_link('iq_realestate');
                        }
                        if ($base_link !== "") {
                            $link = remove_query_arg($filter_name, $base_link);
                        } else {
                            $link = remove_query_arg($filter);
                        }

                        //$link = remove_query_arg($filter);



                        $active = false;

                        if (!in_array($filterItem->slug, $categoryFilters)) {
                            $categoryFilters[] = $filterItem->slug;
                        } else {
                            $active = true;
                            unset($categoryFilters[$filterItem->slug]);

                            if (($key = array_search($filterItem->slug, $categoryFilters)) !== false) {
                                unset($categoryFilters[$key]);
                            }
                        }

                        if (!empty($categoryFilters)) {
                            asort($categoryFilters);
                            $link = add_query_arg($filter, implode(',', $categoryFilters), $link);
                            $link = str_replace('%2C', ',', $link);
                        }

                    ?>

                        <li><a class="dropdown-item" href="<?php echo esc_url($link); ?>" rel="nofollow"><?php echo esc_html($filterItem->name); ?></a></li>

                    <?php
                    }
                    ?>


                </ul>
            </div>



        <?php endforeach; ?>

    </div>


    <?php wa_active_filters(); ?>

</div>