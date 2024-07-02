<?php

/**
 * The Template for displaying Category Archive pages.
 */

get_header();

$term_banner = get_term_meta(get_queried_object_id(), 'wa_meta_term_banner', true);
$term_banner_id = get_term_meta(get_queried_object_id(), 'wa_meta_term_banner_id', true);

// $queried_object = get_queried_object();
// $categoriaPadre = smart_category_top_parent_id(get_queried_object_id(), true);

$primary_category = apply_filters('get_parent_term', get_queried_object(), get_queried_object_id());
?>
<main class="site-main category-archive container" role="main">

	<?php
	if ($term_banner) :

		if ($term_banner_id) {
			$banner_html = wp_get_attachment_image($term_banner_id, 'full', false, array('class' => 'category-archive__banner-img w-100 d-block', 'title' => wp_get_document_title(), 'alt' => wp_get_document_title()));
		} else {
			$banner_html = '<img  class="category-archive__banner-img w-100 d-block" width="100%" height="auto" src="' . $term_banner  . '" alt="' . wp_get_document_title() . '" title="' . wp_strip_all_tags(wp_get_document_title()) . '">';
		}
	?>

		<figure class="category-archive__banner">
			<?php echo $banner_html; ?>
		</figure>

	<?php endif; ?>

	<?php
	if (have_posts()) :
	?>



		<header class="category-archive__header">


			<h1 class="category-archive__title">
				<?php
				echo single_cat_title('');
				?>
			</h1>
			<?php
			$category_description = category_description();
			if (!empty($category_description)) :
				echo apply_filters('category_archive_meta', '<div class="category-archive__meta">' . $category_description . '</div>');
			endif;
			?>

		</header>


		<?php
		$args = array(
			'orderby' => 'slug',
			'parent' => $primary_category->term_id,
			// 'exclude' => array(535),
			'show_count' => 0,
			'hierarchical' => 1,
			'depth' => 1,
			'hide_empty' => 1,
			'title_li' => '',
			'hide_title_if_empty' => true,
			'walker' => new Custom_Walker_Category(),
			'echo' => 0
		);
		$subcategories = wp_list_categories($args);
		?>


		<?php
		if (strpos($subcategories, "No hay") === false) :
		?>


			<nav class="navbar category-archive__navbar">

				<ul id="navbar-cat" class="navbar-nav category-archive__navbar-menu-list">

					<?php echo $subcategories; ?>

				</ul>
			</nav>

		<?php
		endif;
		?>

		<aside class="archive-social-bar">
			<?php wa_show_sharebar(0, array('css' => 'colored-icons', 'link' => get_term_link(get_queried_object()), 'title' => single_term_title("", false))); ?>
		</aside>


		<section class="archive-articles-container category-archive__items" data-loadmore-layout="grid" data-loadmore-item-layout="archive-item">
			<div class="row"></div>
			<?php
			$_args = array(
				'items_layout_css' => 'archive-item',
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
			get_template_part('template-parts/category/category', 'loop', $_args);
			?>
		</section>
	<?php
	else :
		// 404.
		get_template_part('content', 'none');
	endif;

	wp_reset_postdata(); // End of the loop.
	?>
</main>
<?php
get_footer();
