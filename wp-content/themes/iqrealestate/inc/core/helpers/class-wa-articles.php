<?php

/**
 * Funciones útiles para obtener la categoría principal de una entrada
 */


class WA_Articles extends WA_Module
{

    public function init()
    {
        $this->loader->add_filter('reading_time', $this, 'reading_time', 10, 1);
    }

    public function article_item_attributes($_atts = array(), $post_id = 0)
    {
        global $post;

        if (!$post_id) $post_id = get_the_ID();

        $atts = array(
            'post-id' => $post_id,
        );

        $atts = array_merge($atts, $_atts);

        $attributes = apply_filters('wa_article_item_attributes', $atts, $post_id);

        $data_attributes = array();

        foreach ($attributes as $attribute_key => $attribute_value) {
            $data_attributes[] = "data-{$attribute_key}=\"{$attribute_value}\"";
        }

        echo implode(" ", $data_attributes);
    }

    public function article_attributes($_atts = array(), $post_id = 0)
    {
        if (!$post_id) $post_id = get_the_ID();

        $slug = str_replace(get_home_url(), "", get_the_permalink($post_id));

        $atts = array(
            'post-id' => $post_id,
            'slug' => $slug,
        );

        $atts = array_merge($atts, $_atts);

        $article_config = $this->get_article_config($post_id) ?? array();

        if (count($article_config) > 0) {
            $atts['meta'] = htmlentities(json_encode($article_config));
        }

        $attributes = apply_filters('wa_article_attributes', $atts, $post_id);

        $data_attributes = array();

        foreach ($attributes as $attribute_key => $attribute_value) {
            $data_attributes[] = "data-{$attribute_key}=\"{$attribute_value}\"";
        }

        echo implode(" ", $data_attributes);
    }

    public function get_article_config($post_id = 0)
    {
        if (!$post_id) $post_id = get_the_ID();

        $article_config = array();


        if (function_exists('YoastSEO')) {
            $title = YoastSEO()->meta->for_post($post_id)->title; //YoastSEO()->meta->for_current_page()->title;

            $article_config['title'] = $title;
        } else {
            $article_config['title'] = get_the_title($post_id);
        }


        $post_tags = get_the_tags($post_id);

        $tagsTmp = array();

        if ($post_tags) {
            foreach ($post_tags as $t) {
                //echo $t->name;
                //$tag_name = preg_replace('/[^A-Za-zÀ-ú0-9 ]/', '', $t->name);
                //echo trim($t->slug);
                $tagsTmp[] = strtolower($t->slug);
            }
        }

        $article_config['tags'] = $tagsTmp;


        $canales = get_the_category($post_id);

        $canalTmp = array();

        foreach ($canales as $c) {
            // $cat_name = preg_replace('/[^A-Za-zÀ-ú0-9 ]/', '', $c->slug);

            $canalTmp[] = strtolower($c->slug);
        }

        $article_config['canal'] = $canalTmp;

        $author_id = get_post_field('post_author', $post_id);
        $author_name = get_the_author_meta('display_name', $author_id);

        $article_config['author'] = $author_name;

        // $disable_ads = get_post_meta($post_id, 'wa_theme_options_disable_ads', true);
        // $hide_ads = get_post_meta($post_id, 'wa_post_hide_adunits', true);
        // $inread_paragraph = get_post_meta($post_id, 'wa_post_inread_paragraph', true);
        // $disable_scroll = get_post_meta($post_id, 'wa_post_disable_scroll', true);
        // $posts_scroll = get_post_meta($post_id, 'wa_post_posts_scroll', true);

        return apply_filters('wa_article_config', $article_config, $post_id);
    }

    public function reading_time($post_id = 0)
    {
        if (!$post_id) $post_id = get_the_ID();

        $content = get_post_field('post_content', $post_id);
        $word_count = str_word_count(strip_tags($content));
        $readingtime = ceil($word_count / 200);
        if ($readingtime == 1) {
            $timer = " min.";
        } else {
            $timer = " mins.";
        }
        $totalreadingtime = $readingtime . $timer;

        return $totalreadingtime;
    }


    public function get_table_of_contents($content)
    {
        // Buscar todos los encabezados <h2> en el contenido
        preg_match_all('/<h2(.*?)>(.*?)<\/h2>/', $content, $matches);

        // Verificar si se encontraron encabezados <h2>
        if (!empty($matches[0])) {

            $table_of_contents = "<ul>";

            // Iterar a través de los encabezados encontrados
            foreach ($matches[0] as $index => $heading) {
                // Obtener el contenido del encabezado <h2>
                $heading_text = $matches[2][$index];

                // Obtener el ID del encabezado <h2>
                preg_match('/id=["\'](.*?)["\']/', $matches[1][$index], $id_matches);
                if (!empty($id_matches) && trim($id_matches[1]) !== "") {
                    $heading_id = $id_matches[1];
                } else {
                    // Si no hay ID, generar uno único para el encabezado
                    //   $heading_id = preg_replace('/[^a-z0-9]+/', '-', strtolower($heading_text)) . "-" . $index;
                    continue;
                }

                // Agregar el enlace a la tabla de contenidos
                $table_of_contents .= '<li><a href="#' . $heading_id . '">' . strip_tags($heading_text) . '</a></li>';
            }

            $table_of_contents .= '</ul>';

            // Devolver la tabla de contenidos como una cadena de texto
            return $table_of_contents;
        }

        // Si no se encontraron encabezados <h2>, devolver cadena vacía
        return "";
    }
}

function wa_article_item_attributes($atts = array(), $post_id = 0)
{
    if (is_a($GLOBALS['WA_Theme'], 'WA_Theme')) {

        global $post;

        if (!$post_id) $post_id = get_the_ID();

        WA_Theme()->helper('articles')->article_item_attributes($atts, $post_id);
    }
}



function wa_article_attributes($atts = array(), $post_id = 0)
{
    if (is_a($GLOBALS['WA_Theme'], 'WA_Theme')) {

        global $post;

        if (!$post_id) $post_id = get_the_ID();

        WA_Theme()->helper('articles')->article_attributes($atts, $post_id);
    }
}
