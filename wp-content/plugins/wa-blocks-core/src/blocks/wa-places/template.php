<?php
$place = $attributes['selectedContent'];


$direccion = get_post_meta($place['id'], 'fp_location_direccion', true) ?? '';
$telefono = get_post_meta($place['id'], 'fp_location_telefono', true) ?? '';
$web = get_post_meta($place['id'], 'fp_location_web', true) ?? '';
$whatsapp = get_post_meta($place['id'], 'fp_location_whatsapp', true) ?? '';
$redes = get_post_meta($place['id'], 'fp_location_social_networks', true) ?? array();
$geo = get_post_meta($place['id'], 'fp_location_geolocalizacion', true) ?? array();
$title = get_the_title($place['id']);

$extraAttributes = array(
    'data-place-id' => $place['id'] ?? 0,
    'data-place-latitude' => $place['cmb2']['fp_location_fields']['fp_location_geolocalizacion']['latitude'] ?? 0,
    'data-place-longitude' => $place['cmb2']['fp_location_fields']['fp_location_geolocalizacion']['longitude'] ?? 0,
    'data-place-title' => $title ?? '',
);



ob_start();

?>

<div <?php echo get_block_wrapper_attributes($extraAttributes); ?>>

    <div class="wa-place-item">
        <h3 class="wa-place-item__item--title"><?php echo $title; ?></h3>

        <ul class="wa-place-item__info">
            <?php if (!empty($direccion)) : ?>
                <li>
                    <span class="wa-place-item__info--label"><?php echo __('Dirección:', 'wa-theme'); ?></span> <span class="wa-place-item__info--value"><?php echo $direccion; ?></span>
                </li>
            <?php endif; ?>

            <?php if (!empty($telefono)) : ?>
                <li class="wa-place-item__telefonos">
                    <span class="wa-place-item__info--label"><?php echo __('Teléfono:', 'wa-theme'); ?></span> <span class="wa-place-item_info--value"> <a href="tel:<?php echo $telefono; ?>" target="_blank" rel="noopener"><?php echo $telefono; ?></a></span>

                    <?php if (!empty($whatsapp)) : ?>
                        <a class="wa-place-item__whatsapp" href="https://wa.me/<?php echo $whatsapp; ?>" target="_blank" rel="noopener"><?php echo $whatsapp; ?></a>
                    <?php endif; ?>

                </li>
            <?php endif; ?>
            <?php
            if (!empty($web)) :
                $url = wp_parse_url($web);
            ?>
                <li>
                    <span class="wa-place-item__info--label"><?php echo __('Sitio web:', 'wa-theme'); ?></span> <span class="wa-place-item__info--value"><a href="<?php echo $web; ?>" target="_blank" rel="noopener"><?php echo $url['host']; ?></a></span>
                </li>
            <?php endif; ?>

            <?php if (is_array($redes) && count($redes) > 0) : ?>
                <li class="wa-place-item__social-networks">
                    <span class="wa-place-item__info--label">Redes sociales:</span>
                    <?php
                    foreach ($redes as $network) :
                        $url = wp_parse_url($network['url']);

                        $social = str_replace("/", "", $url['path']);

                    ?>
                        <a class="wa-place-item__info--value wa-place-item__social--<?php echo $network['social']; ?>" href="<?php echo $network['url']; ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo $social; ?>
                        </a>
                    <?php endforeach; ?>
                </li>
            <?php endif; ?>

        </ul>
    </div>
    <div class="wa-place-item--button">
        <a href="https://www.google.com/maps/dir/Current+Location/<?php echo  $extraAttributes['data-place-latitude']; ?>,<?php echo  $extraAttributes['data-place-longitude']; ?>" class="btn btn-map" rel="nofollow noopener noreferrer" target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sign-merge-left" viewBox="0 0 16 16">
                <path d="M7.25 6v1c-.14.301-.338.617-.588.95-.537.716-1.259 1.44-2.016 2.196l.708.708.015-.016c.652-.652 1.33-1.33 1.881-2.015V12h1.5V6h1.216a.25.25 0 0 0 .192-.41L8.192 3.23a.25.25 0 0 0-.384 0L5.842 5.59a.25.25 0 0 0 .192.41H7.25Z" />
                <path d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098L9.05.435Zm-1.4.7a.495.495 0 0 1 .7 0l6.516 6.515a.495.495 0 0 1 0 .7L8.35 14.866a.495.495 0 0 1-.7 0L1.134 8.35a.495.495 0 0 1 0-.7L7.65 1.134Z" />
            </svg> <?php echo __('Indicaciones', 'wa-theme'); ?></a>
    </div>
</div>
<?php

$render = ob_get_clean();


$render = str_replace(array("\r", "\n", "<p></p>"), '', $render);

echo $render;
?>