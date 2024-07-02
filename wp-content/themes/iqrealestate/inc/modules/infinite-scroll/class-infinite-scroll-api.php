<?php



class WA_InfiniteScroll_API extends WP_REST_Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->namespace = 'wa-theme/v1';
        $this->rest_base_posts = 'post/(?P<id>\d+)';
        $this->rest_base_archive = 'archive';

        $this->register_routes();
    }

    /**
     * Register the component routes.
     */
    public function register_routes()
    {
        //region added
        register_rest_route($this->namespace, '/' . $this->rest_base_posts, array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array($this, 'get_post'),
                'permission_callback' => array($this, 'permissions_check'),
                'args'     => array(
                    'id'     => array(
                        'description'       => 'Post ID.',
                        'type'              => 'integer',
                        'sanitize_callback' => 'absint',
                    ),
                )
            )
        ));

        //region added
        register_rest_route($this->namespace, '/' . $this->rest_base_archive, array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array($this, 'get_archive'),
                'permission_callback' => array($this, 'permissions_check'),
                'args'                => $this->get_collection_params(),
            )
        ));
    }


    public function get_post($request)
    {

        global $wpdb, $post;

        $article_id = $request['id'];

        $post = get_post($article_id);


        setup_postdata($post);

        if (is_a($post, 'WP_Post')) :

            $GLOBALS['pID'] = $request['id'];


            $template = get_page_template_slug($article_id);

            //$template = get_post_meta($article_id, '_wp_page_template', true);



            $templatePath = "";

            if ($template) {
                $filename = pathinfo(basename($template), PATHINFO_FILENAME);
                $templatePath = get_template_directory() . '/template-parts/single/content-' . $filename . '.php';
                if (!file_exists($templatePath)) {
                    //      echo "NO EXISTE " . $templatePath;
                    $filename = "single";
                }
            } else {
                $filename = "single";
            }

            // var_dump($template);

            // Obtener los bloques Gutenberg del contenido del artículo
            $blocks = parse_blocks($post->post_content);

            // Crear un array para almacenar los nombres de los bloques
            $blockNames = array();

            // Recorrer los bloques y extraer los nombres
            foreach ($blocks as $block) {
                if (!empty($block['blockName'])) {
                    $blockNames[] = $block['blockName'];
                }
            }
            // Eliminar los nombres de bloque duplicados
            $uniqueBlockNames = array_filter(array_unique($blockNames));


            if (class_exists('Jetpack_Lazy_Images')) {
                $instance = Jetpack_Lazy_Images::instance();
                $instance->setup_filters();
            }




            ob_start();

            get_template_part('template-parts/single/content', $filename);

            $post = ob_get_clean();

            $data = array(
                'id' => $article_id,
                'title' => get_the_title($article_id),
                'content_rendered' => $post,
                'blocks' => $uniqueBlockNames,
                'template' => $filename,
                // 'path' => $templatePath,
            );


            return rest_ensure_response($data);

        endif;
    }

    public function get_archive($request)
    {
        // prepare our arguments for the query
        $args = json_decode(stripslashes($request['query']), true);
        $args['paged'] = $request['page'] + 1; // we need next page to be loaded
        $args['posts_per_page'] = get_option('posts_per_page');
        $args['post_status'] = 'publish';
        $itemLayout = (isset($request['item_layout']) &&  trim($request['item_layout']) !== "") ? trim($request['item_layout']) : 'article-item-nota col-12 col-md-6 col-md-4 mb-3 mb-md-0';
        $layout = (isset($request['layout']) &&  trim($request['layout']) !== "") ? trim($request['layout']) : 'flex';
        // it is always better to use WP_Query but not here
        query_posts($args);

        $_layoutArgs = array(
            'items_layout_css' => $itemLayout,
            'items_config' => array(
                'items_show_tags' => false,
                'items_show_main_cat' => true,
                'items_show_badge_cat' => false,
                'items_show_date' => false,
                'items_show_author' => true,
                'items_show_excerpt' => false,
                'items_show_arrow' => false,
                'items_show_more_btn' => false,
            ),
        );

        if (have_posts()) :

            global $wp_query;

            $total_posts = $wp_query->found_posts;
            // Obtén el número de página actual
            $current_page = max(1, get_query_var('paged'));

            // Calcula el número total de páginas
            $total_pages = $wp_query->max_num_pages;

            // Calcula cuántos posts se mostrarán en la página actual
            $posts_per_page = get_option('posts_per_page');
            $posts_to_show = min($total_posts - (($current_page - 1) * $posts_per_page), $posts_per_page);

            $_loop_args = array(
                'total' => $total_posts,
                'current_page' => $current_page,
                'posts_to_show' => $posts_to_show,
            );




            ob_start();
            // run the loop
            $i = 0;

            echo '<div class="row g-0" data-page="' . $args['paged'] . '">';

            if ($layout === "grid") {
                echo "</div>";
            }

            do_action('wa_before_category_loop', $_loop_args);

            while (have_posts()) : the_post();

                $_loop_args['current_item'] = $i;


                do_action("wa_before_category_item_loop", $_loop_args);


                get_template_part('template-parts/items/article', 'item', $_layoutArgs); // Post format: content-index.php

                do_action("wa_after_category_item_loop", $_loop_args);
                $i++;

            endwhile;

            do_action('wa_after_category_loop', $_loop_args);

            if ($layout === "flex") {
                echo "</div>";
            }

            $articles = ob_get_clean();

            $data = array(
                'page' => $args['paged'],
                'content_rendered' => $articles,
            );


            return rest_ensure_response($data);
        endif;
    }


    /**
     * Check if a given request has access to post items.
     */
    public function permissions_check($request)
    {
        return true;
    }

    /**
     * Get the query params for collections
     */
    public function get_collection_params()
    {
        return array(
            'page'     => array(
                'description'       => 'Current page of the collection.',
                'type'              => 'integer',
                'default'           => 1,
                'sanitize_callback' => 'absint',
            ),
            'per_page' => array(
                'description'       => 'Maximum number of items to be returned in result set.',
                'type'              => 'integer',
                'default'           => 6,
                'sanitize_callback' => 'absint',
            ),
        );
    }
}
