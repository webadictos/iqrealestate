<?php

/**
 * Boton para mostrar las ediciones en el sitio
 */


$_layoutArgs = array(
    'classname' => '',
);


$layoutArgs = wp_parse_args($args, $_layoutArgs);


$ediciones = wa_theme()->modules()->is_active('editions') ? wa_theme()->module('editions')->get_editions() : array();


if (is_array($ediciones) && count($ediciones) > 0) :
?>
    <div class="dropdown menu-editions <?php echo $layoutArgs['classname'] !== "" ? $layoutArgs['classname'] : ''; ?>">
        <button class="btn menu-editions__btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">

        </button>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
            <?php
            foreach ($ediciones as $edicion) :

                foreach ($edicion as $key => $value) :

            ?>
                    <li><a class="dropdown-item menu-editions__item" href="<?php echo $value['link']; ?>?edicion=<?php echo $value['slug']; ?>"><?php echo $value['name']; ?></a></li>
                <?php
                endforeach;
                //endif;


                ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>