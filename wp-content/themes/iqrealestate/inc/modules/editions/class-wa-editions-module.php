<?php

class WA_Editions_Module extends WA_Module
{
    protected $editions = array();

    public function init()
    {

        $this->load_editions();

        // $this->loader->add_filter('wa_theme_get_wa_theme_options_page_fields', $this, 'add_settings', 10, 2);
        // $this->loader->add_filter('wa_theme_get_wa_meta_article_metabox_fields', $this, 'add_metabox_fields', 10, 2);
        // $this->loader->add_action('rest_api_init', $this, 'register_api', 10, 2);
        // $this->loader->add_filter('article_config', $this, 'article_config_filter', 10, 2);
        //$this->loader->add_action('init', $this, 'load_editions');
    }

    public function load_config()
    {
        $editions_options = array(
            'editions' => true,
        );
        $this->module_config = $editions_options;
    }


    public function get_front_settings($settings)
    {

        $this->load_editions();


        return apply_filters("wa_edition_front_settings", $this->editions);
    }

    public function load_editions()
    {
        $ediciones = get_terms(array(
            'taxonomy' => 'travel_edition',
            'parent'   => 0,
            'hide_empty' => false,
        ));


        if (is_array($ediciones) && count($ediciones) > 0) {
            foreach ($ediciones as $edicion) {

                $edition_page = get_term_meta($edicion->term_id, 'wa_meta_edition_page', true);
                $edition_country_codes = get_term_meta($edicion->term_id, 'wa_meta_country_codes', true);

                if (is_array($edition_page) && count($edition_page) > 0) {
                    $edition_url = get_permalink($edition_page[0]);
                    $country_codes = array();
                    if ($edition_url) :

                        if (is_array($edition_country_codes) && count($edition_country_codes) > 0) {
                            foreach ($edition_country_codes as $country_code) {
                                $country_codes[] = $country_code['key'];
                            }
                        }

                        $this->editions[] = array(
                            $edicion->slug => array(
                                'id' => $edicion->term_id,
                                'name' => $edicion->name,
                                'link' => $edition_url,
                                'slug' => $edicion->slug,
                                'country_codes' => $country_codes
                            )
                        );

                    endif;
                }
            }
        }

        //  print_r($this->editions);
    }

    public function get_editions()
    {

        return $this->editions;
    }
}
