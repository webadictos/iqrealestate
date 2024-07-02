<?php

/**
 * The template for displaying the archive loop.
 */

$_layoutArgs = array(
	'items_layout_css' => 'article-item col-12 col-md-6 col-md-4 mb-3 mb-md-0',
	'items_swiper' => false,
	'sidebar' => false,
	'change_item_layout' => false,
	'show_ads' => true,
	'items_config' => array(
		'items_show_tags' => false,
		'items_show_main_cat' => true,
		'items_show_badge_cat' => false,
		'items_show_date' => false,
		'items_show_author' => true,
		'items_show_excerpt' => false,
		'items_show_arrow' => true,
		'items_show_more_btn' => false,
		'image_animation' => true,
	),
);


$layoutArgs = wp_parse_args($args, $_layoutArgs);
$GLOBALS['showed_ids'] = array();

if (have_posts()) :

	// Obtén el número total de publicaciones en la consulta
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

?>
		<?php
		$counter_articles = 0;

		do_action('wa_before_category_loop', $_loop_args);

		while (have_posts()) :
			the_post();
			$GLOBALS['showed_ids'][] = get_the_ID();

			$_loop_args['current_item'] = $counter_articles;

			do_action("wa_before_category_item_loop", $_loop_args);


			/**
			 * Include the Post-Format-specific template for the content.
			 * If you want to overload this in a child theme then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			if ($layoutArgs['change_item_layout']) {
				$layoutArgs['items_layout_css'] = "archive-item";
			}


			if ($counter_articles < 2 && $layoutArgs['change_item_layout']) {
				$layoutArgs['items_layout_css'] = "article-item-tres";
			}

			if ($counter_articles == 2 && $layoutArgs['sidebar']) :
				get_template_part('template-parts/category/category', 'sidebar'); // Post format: content-index.php
			endif;

			$postType = get_post_type();
			$postTypeItem = get_template_directory() . '/template-parts/items/article-item-' . $postType . '.php';


			if (is_readable($postTypeItem)) {
				get_template_part('template-parts/items/article-item', $postType, $layoutArgs); // Post format: content-index.php

			} else {
				get_template_part('template-parts/items/article', 'item', $layoutArgs); // Post format: content-index.php
			}

			do_action("wa_after_category_item_loop", $_loop_args);

			$counter_articles++;
		endwhile;
		do_action('wa_after_category_loop', $_loop_args);
		?>
<?php
endif;

wp_reset_postdata();
