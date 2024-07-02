<?php

/**
 * The Template for displaying Author pages.
 */

get_header();

$authorId = get_queried_object_id();


$authorData = array();

$authorData['description'] = get_the_author_meta("description", $authorId);
$authorData['redes'] = get_user_meta($authorId, "wa_meta_user_social_networks", true);
?>
<main class="site-main author-archive section-archive" role="main">
	<div class="container">
		<?php
		if (have_posts()) :
			/**
			 * Queue the first post, that way we know
			 * what author we're dealing with (if that is the case).
			 *
			 * We reset this later so we can run the loop
			 * properly with a call to rewind_posts().
			 */
			//the_post();
		?>
			<section class="section-archive__header author-archive__header">

				<header class="section-archive__title-container container">

					<figure class="author-archive__avatar">
						<?php echo get_avatar($authorId, 300); ?>
					</figure>

					<div class="author-archive__meta">
						<h1 class="section-archive__title">
							<?php
							echo  get_the_author();
							?>
						</h1>

						<?php
						if (count($authorData['redes']) > 0) {
							wa_show_user_profiles(array('css' => 'colored-icons', 'networks' => $authorData['redes']));
						}
						?>
					</div>
				</header>


				<?php
				if (isset($authorData['description']) && trim($authorData['description']) !== "") :
				?>
					<div class="author-archive__meta--description">
						<?php echo wpautop($authorData['description']); ?>
					</div>
				<?php
				endif;
				?>
			</section>


			<section class="section p-0">
				<div class="archive-articles-container archive-mobile-list" data-loadmore-layout="grid" data-loadmore-item-layout="archive-item">
					<div class="row"></div>
					<?php
					$_args = array(
						'items_layout_css' => 'archive-item',
						'items_config' => array(
							'items_show_tags' => false,
							'items_show_main_cat' => true,
							'items_show_badge_cat' => false,
							'items_show_date' => false,
							'items_show_author' => false,
							'items_show_excerpt' => false,
							'items_show_arrow' => false,
							'items_show_more_btn' => false,
						),
					);
					get_template_part('template-parts/archive', 'loop', $_args);
					?>
				</div>
			</section>

		<?php
			//	get_template_part('author', 'bio');

			/**
			 * Since we called the_post() above, we need to
			 * rewind the loop back to the beginning that way
			 * we can run the loop properly, in full.
			 */
			rewind_posts();

		else :
			// 404.
			get_template_part('content', 'none');
		endif;

		wp_reset_postdata(); // End of the loop.
		?>
	</div>
</main>
<?php
get_footer();
