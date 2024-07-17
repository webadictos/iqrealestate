<?php

/**
 * Construye el layout dependiendo los parámetrs
 */


$_layoutArgs = array(
    'max-width' => '',
    'classname' => '',
    'title' => '¿Te interesa rentar un local comercial?',
    'text' => 'Si estás interesado en algunos de nuestros proyectos y necesitas mayor <br>información, haz clic en el enlace.',
    'link' => '',
    'link_text' => 'Pedir Informes'
);


$layoutArgs = wp_parse_args($args, $_layoutArgs);
?>


<div <?php echo $layoutArgs['max-width'] !== '' ? 'style="--wa-callout-container-max-width:' . $layoutArgs['max-width'] . '"' : '' ?> class="wp-block-wa-blocks-core-callout <?php echo $layoutArgs['classname']; ?>">
    <h3 class="wp-block-heading is-style-heading-light"><?php echo $layoutArgs['title']; ?></h3>
    <p><?php echo $layoutArgs['text']; ?></p>
    <?php if ($layoutArgs['link']) : ?>
        <div class="wp-block-wa-blocks-core-callout__cta-button"><a href="<?php echo $layoutArgs['link']; ?>"><?php echo $layoutArgs['link_text']; ?></a></div>
    <?php endif; ?>
</div>