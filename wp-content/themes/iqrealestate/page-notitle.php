<?php

/**
 * Template Name: Page (Sin título con contenedor)
 * Description: Page template with Sidebar on the left side.
 *
 */

get_header();

// the_post();
?>
<main class="site-main container site-page" role="main">

	<div class="page-container container">
		<article id="page-<?php the_ID(); ?>" <?php post_class('page-layout without-title'); ?>>
			<h1 class="visually-hidden"><?php the_title(); ?></h1>

			<div class="page-layout__content">

				<?php
				the_content();
				?>
			</div>
		</article><!-- /#post-<?php the_ID(); ?> -->
	</div>
</main>
<?php
get_footer();
