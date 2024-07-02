<?php

class WA_Ad_Slot
{

    protected $ads;
    protected $slot;
    protected $size_mappings;
    protected $insertion;

    public function __construct($slot, $insertion = array())
    {
        // $this->ads = $ads;
        $this->slot = $slot;

        $this->insertion = $insertion;

        $this->size_mappings = wa_theme()->module('ads')->process_size_mappings();

        $this->slot['refresh'] = filter_var($this->slot['refresh'], FILTER_VALIDATE_BOOLEAN) ?? false;

        $this->parse_slots_params();
    }

    public function render_slot()
    {

        if (!$this->is_active()) return;

        $slot_code = $this->get_slot_layout();

        echo "<!--//Slot: {$this->slot['id']} -->";
        echo $slot_code;
    }

    private function  is_active()
    {
        $key = "wa_meta_adunits";
        $hide_key = "wa_meta_hide_adunits";
        $disable_key = "wa_meta_disable_ads";


        $adunits = array();

        $hide_adunits = "";
        $disable_ads = "";


        if (is_singular()) {
            $adunits = get_post_meta(get_the_ID(), $key, true) ?? array();
            $hide_adunits = get_post_meta(get_the_ID(), $hide_key, true) ?? "";
            $disable_ads = get_post_meta(get_the_ID(), $disable_key, true) ?? "";
        } else {
            $term = get_queried_object();
            if ($term) {
                $hide_adunits = get_term_meta($term->term_id, $key, true) ?? "";
                $adunits = get_term_meta($term->term_id, $key, true) ?? array();
                $disable_ads = get_term_meta($term->term_id, $key, true) ?? "";
            }
        }

        if ($disable_ads === "on") return false;

        if ($hide_adunits === "on") {
            if (!is_array($adunits)) $adunits = array();


            if (in_array($this->slot['id'], $adunits)) {
                return false;
            }
        }



        return true;
    }

    private function generate_classnames_from_sizes($sizes)
    {
        $class_names = array();
        $class_prefix = "ad-size-";

        $class_names[] = "ad-size-{$this->slot['size_mapping']}";

        foreach ($sizes as $size) {

            $class_name = $class_prefix;

            $class_name .= $size[0] ?? "";

            $class_name .= isset($size[1]) ? "x{$size[1]}" : "";

            $class_names[] = $class_name;
        }


        return implode(" ", $class_names);
    }

    private function get_slot_layout()
    {

        $class_names = isset($this->size_mappings['sizes'][$this->slot['size_mapping']]) ? $this->generate_classnames_from_sizes($this->size_mappings['sizes'][$this->slot['size_mapping']]) : "";

        $class_from_insertion = $this->insertion['class'] ?? '';

        $class_names .= !empty($class_from_insertion) ? ' ' . $class_from_insertion : '';

        $ad_container_attributes = array();

        if (isset($this->insertion['custom_params'])) {
            foreach ($this->insertion['custom_params'] as $param) {
                $ad_container_attributes[] = $param['key'] . "='" . $param['value'] . "'";
            }
        }

        $uid = uniqid();

        $uuid = $this->slot['id'] . "-" . $uid;

        $infinitescroll = WA_Utils::is_infinite_scroll();

        $ad_setup = array(
            'canRefresh' => $this->slot['refresh'],
            'infinitescroll' => $infinitescroll,
        );


        if (is_single()) {
            $ad_setup['postID'] = get_the_ID();
        }

        if (isset($this->slot['custom_params']) && is_array($this->slot['custom_params'])) {
            foreach ($this->slot['custom_params'] as $key => $value) {
                $ad_setup[$key] = $value;
            }
        }

        $_attributes = array(
            'id' => $uuid,
            'class' => "dfp-ad-unit ad-" . $this->slot['size_mapping'],
            'data-ad-type' => $this->slot['size_mapping'],
            'data-ad-slot' => $this->slot['code'],
            'data-ad-setup' => htmlentities(json_encode($ad_setup)),
            'data-ad-loaded' => 0,
        );

        $_slot_attributes = apply_filters("wa_ad_slot_{$this->slot['id']}_attributes", $_attributes);


        $_slot_attributes_html = array();

        foreach ($_slot_attributes as $attribute => $value) {
            $_slot_attributes_html[] = $attribute . "='" . $value . "'";
        }


        $ad_layout = "<div id=\"{$uuid}-wrapper\" class=\"ad-wrapper ad-container {$class_names}\" " . implode(" ", $ad_container_attributes) . "><div " . implode(" ", $_slot_attributes_html) . "></div></div>";


        return apply_filters("wa_ad_slot_{$this->slot['id']}_layout", $ad_layout, $this->slot);
    }



    private function parse_slots_params()
    {

        $parsed_params = array();

        if (isset($this->slot['custom_params']) && count($this->slot['custom_params']) > 0) {
            foreach ($this->slot['custom_params'] as $param) {
                $parsed_params[$param['key']] = $param['value'];
            }

            $this->slot['custom_params'] = $parsed_params;
        }

        return $parsed_params;
    }
}


if (!function_exists('wa_create_ad_slot')) :

    /*

 $slot_tmp = array(
    'id' => "slot_prueba",
    'code' => "box_a",
    'refresh' => true,
    'size_mapping' => 'boxbanner',
    //  'custom_params' => array('class' => 'test'),
);

wa_create_ad_slot($slot_tmp);

 */

    function wa_create_ad_slot($params, $insertion = array())
    {
        if (!$params['id'] && !$params['code'] && !$params['size_mapping']) {

            if (current_user_can('administrator')) :
                echo "Necesitas especificar el ID, code y el size mapping para poder crear el slot";
            endif;

            return;
        }

        $slot = new WA_Ad_Slot($params, $insertion);

        $slot->render_slot();
    }



endif;
