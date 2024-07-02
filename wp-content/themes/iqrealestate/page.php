<?php

/**
 * Template Name: Page (Default)
 * Description: Page template with Sidebar on the left side.
 *
 */

get_header();

// the_post();
?>
<main class="site-main container site-page" role="main">

	<?php
	$thumb = "";
	if (has_post_thumbnail()) :

		$thumb = get_the_post_thumbnail(get_the_ID(), 'full', array('title' => get_the_title(), 'alt' => get_the_title(), 'class' => "img-fluid w-100"));

	endif;
	?>
	<div class="page-container container">
		<article id="page-<?php the_ID(); ?>" <?php post_class('page-layout'); ?>>
			<header class="page-layout__header">



				<?php
				if ($thumb !== "") :
				?>
					<figure class="page-layout__thumbnail "><?php echo $thumb; ?></figure>
				<?php
				endif;
				?>


				<div class="page-layout__meta">
					<h1 class="page-layout__title"><?php the_title(); ?></h1>
				</div>

			</header><!-- /.entry-header -->
			<div class="page-layout__content">

				<?php
				the_content();

				wp_link_pages(
					array(
						'before'   => '<nav class="page-links" aria-label="' . esc_attr__('Page', 'wa-theme') . '">',
						'after'    => '</nav>',
						'pagelink' => esc_html__('Page %', 'wa-theme'),
					)
				);
				edit_post_link(
					esc_attr__('Edit', 'wa-theme'),
					'<span class="edit-link">',
					'</span>'
				);
				?>
			</div>
		</article><!-- /#post-<?php the_ID(); ?> -->
	</div>
</main>
<?php
get_footer();
