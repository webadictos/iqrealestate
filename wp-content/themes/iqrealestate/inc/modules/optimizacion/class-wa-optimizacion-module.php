<?php

class WA_Optimizacion_Module extends WA_Module
{

    protected $path_to_css;

    public function init()
    {
        // $this->load_config();

        $this->loader->add_filter('oembed_fetch_url', $this, 'ommit_social_scripts', 10, 3);
        $this->loader->add_filter('embed_oembed_html', $this, 'remove_instagram_script', 100, 4);

        $this->loader->add_filter('perfmatters_used_css', $this, 'critical_css', 10, 1);
        $this->loader->add_filter('autoptimize_filter_css_defer_inline', $this, 'critical_css', 10, 1);

        $this->path_to_css = get_stylesheet_directory() . "/assets/critical-css/";

        add_shortcode('instagram', array($this, 'insta_shortcode'));

        if (isset($this->settings['disable_photon_opengraph']) && $this->settings['disable_photon_opengraph'])
            $this->loader->add_filter('wpseo_opengraph_image', $this, 'disable_photon_opengraph_image', 10, 1);
    }

    public function insta_shortcode($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'url' => '',
        ), $atts));

        $instacode = '<div class="wp-block-embed wp-block-embed-instagram instagram-embed-container">';
        $instacode .= '<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="' . $url . '" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:100%; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:16px;"> <a href="' . $url . '" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank"> <div style=" display: flex; flex-direction: row; align-items: center;"> <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div></div></div><div style="padding: 19% 0;"></div> <div style="display:block; height:50px; margin:0 auto 12px; width:50px;"><svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-511.000000, -20.000000)" fill="#000000"><g><path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path></g></g></g></svg></div><div style="padding-top: 8px;"> <div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">Ver esta publicación en Instagram</div></div><div style="padding: 12.5% 0;"></div> <div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;"><div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div> <div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div></div><div style="margin-left: 8px;"> <div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div> <div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div></div><div style="margin-left: auto;"> <div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div> <div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div> <div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div></div></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;"></div></div></a></div></blockquote>';
        $instacode .= '</div>';
        return $instacode;
    }

    public function ommit_social_scripts($provider, $url, $args)
    {
        $social_networks = array(
            'twitter' => array(
                'host' => 'twitter.com',
                'arg' => 'omit_script',
            ),
            'instagram' => array(
                'host' => 'instagram.com',
                'arg' => 'omitscript',
            ),
            'facebook' => array(
                'host' => 'facebook.com',
                'arg' => 'omitscript',
            )
        );
        $host = parse_url($provider, PHP_URL_HOST);

        foreach ($social_networks as $social_network) {
            if (strpos($host, $social_network['host']) !== false) {
                $provider = add_query_arg($social_network['arg'], 'true', $provider);
                break;
            }
        }

        return $provider;
    }

    public function remove_instagram_script($html, $url, $attr, $post_id)
    {

        $regex =    '/<script.*instagram\.com\/embed.js.*\s?script>/U';
        $regex_2 =  '/<script.*platform\.instagram\.com\/.*\/embeds\.js.*script>/U';

        if (preg_match($regex, $html) || preg_match($regex_2, $html)) {
            add_filter('kh_has_instagram_embed', '__return_true');

            $html = preg_replace($regex, '', $html);
            $html = preg_replace($regex_2, '', $html);

            return $html;
        }

        return $html;
    }

    private static function get_url_type()
    {
        global $wp_query;

        $type = '';

        if ($wp_query->is_page) {
            $type = is_front_page() ? 'front' : 'page-' . $wp_query->post->ID;
        } elseif ($wp_query->is_home && !is_front_page()) {
            $type = 'home';
        } elseif ($wp_query->is_single) {
            $type = get_post_type() !== false ? get_post_type() : 'single';
        } elseif ($wp_query->is_category) {
            $type = 'category';
        } elseif ($wp_query->is_tag) {
            $type = 'tag';
        } elseif ($wp_query->is_tax) {
            $type = 'tax';
        } elseif ($wp_query->is_archive) {
            $type = $wp_query->is_day ? 'day' : ($wp_query->is_month ? 'month' : ($wp_query->is_year ? 'year' : ($wp_query->is_author ? 'author' : 'archive')));
        } elseif ($wp_query->is_search) {
            $type = 'search';
        } elseif ($wp_query->is_404) {
            $type = '404';
        }

        return $type;
    }


    public function critical_css($inlined)
    {
        global $wp_query;

        // $slug = $GLOBALS['WA_Theme']->helper('utils')->formatted_slug();

        $filename = "";
        $type = self::get_url_type();


        $filename = $this->path_to_css  . $type . ".css";

        // $fileTmp = $this->path_to_css . $slug . ".css";

        // if (is_front_page() && !is_home()) {

        //     $filename = $this->path_to_css  . "home.css";
        //     $type = "home";
        // } else if (!is_front_page() && is_home()) {

        //     $filename = $this->path_to_css  . "blog.css";
        //     $type = "blog";
        // } else if (file_exists($fileTmp)) {
        //     $filename = $fileTmp;
        //     $type = $slug;
        // } else if (is_single()) {
        //     $filename = $this->path_to_css  . get_post_type() . ".css";
        //     $type = get_post_type();

        //     if (!file_exists($filename)) {
        //         $filename = $this->path_to_css . "single.css";
        //     }
        // } else if (is_page()) {
        //     $filename = $this->path_to_css  . "page.css";
        //     $type = "page";
        // } else if (is_archive()) {

        //     $filename = $this->path_to_css  . "archive.css";
        //     $type = "archive-";


        //     if (is_post_type_archive()) {
        //         $post_type = get_query_var('post_type');
        //         $filenamePostType = $this->path_to_css . "archive-" .    $post_type . ".css";
        //         $type = "post-type-archive-" . $post_type;

        //         if (file_exists($filenamePostType)) {
        //             $filename = $filenamePostType;
        //         }
        //     }
        //     if (is_tax()) {
        //         $term = get_queried_object();
        //         $post_type = $term->taxonomy;
        //         $filenamePostType = $this->path_to_css . "tax-archive-" .    $post_type . ".css";
        //         $type = "tax-archive-" . $post_type;

        //         if (file_exists($filenamePostType)) {
        //             $filename = $filenamePostType;
        //         }
        //     }
        // } else if (is_category()) {
        //     $filename = $this->path_to_css  . "category.css";
        //     $type = "category";
        // } else if (is_tag()) {
        //     $filename = $this->path_to_css  . "tag.css";
        //     $type = "tag";
        // }
        // if (is_search()) {
        //     $filename = $this->path_to_css  . "search.css";
        //     $type = "search";
        // }

        if (file_exists($filename)) {
            $inlined = file_get_contents($filename);
        }

        $inlined = ".test-" . $type . "{--test:'{$type}';}" . $inlined;
        $inlined = str_replace(array("\r", "\n"), '', $inlined);

        return $inlined;
    }

    public function disable_photon_opengraph_image($img)
    {

        global $post;


        if (!is_single()) return $img;

        if (!class_exists('Jetpack_Photon')) return $img;
        $photon_removed = remove_filter('image_downsize', array(Jetpack_Photon::instance(), 'filter_image_downsize'));
        // Call wp_get_attachment_image(), wp_get_attachment_image_src(), or anything else that ultimately calls image_downsize()



        $the_thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "facebook-featured-image");
        $thumbnail_src = $the_thumbnail_src[0];
        //change this to exact WxH of your custom image size
        $check_thumb = strpos($thumbnail_src, '1200x630');
        if ($check_thumb) {
            $img = $thumbnail_src;
        }

        if ($photon_removed) {
            add_filter('image_downsize', array(Jetpack_Photon::instance(), 'filter_image_downsize'), 10, 3);
        }

        return $img;
    }
}
