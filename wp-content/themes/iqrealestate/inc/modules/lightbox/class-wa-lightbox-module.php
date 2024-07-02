<?php

class WA_Lightbox_Module extends WA_Module
{

    protected $theme_options_key;
    public $prefix = 'wa_theme_options_';



    public function init()
    {

        $this->loader->add_filter('wp_content_img_tag',  $this, 'add_full_image_attr', 10, 3);
    }

    public function add_full_image_attr($filtered_image, $context, $attachment_id)
    {

        $fullImg = wp_get_attachment_image_url($attachment_id, 'full') ?? '';

        $caption = wp_get_attachment_caption($attachment_id) ?? '';



        if (!empty($fullImg)) {
            $filtered_image = str_replace('<img ', '<img data-full-image="' . $fullImg . '" data-lightboxcaption="' . $caption . '" ', $filtered_image);
        }


        return $filtered_image;
    }
}
