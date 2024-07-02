<?php

/**
 * Funciones útiles para obtener la categoría principal de una entrada
 */


class WA_Layouts extends WA_Module
{

    public function init()
    {
    }

    public function layout_attributes($_atts = array(), $post_id = 0)
    {

        $atts = array(
            'post-id' =>  $post_id,
        );

        $atts = array_merge($atts, $_atts);

        $attributes = apply_filters('wa_layout_attributes', $atts, $post_id);

        $data_attributes = array();

        foreach ($attributes as $attribute_key => $attribute_value) {
            $data_attributes[] = "data-{$attribute_key}=\"{$attribute_value}\"";
        }

        echo implode(" ", $data_attributes);
    }
}
