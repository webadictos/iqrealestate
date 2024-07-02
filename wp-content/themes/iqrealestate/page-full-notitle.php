<?php

/**
 * Template Name: Page (Ancho completo sin título)
 * Description: Page template full width without title.
 *
 */

get_header();

// the_post();
?>
<main class="site-main" role="main">

	<section id="page-<?php the_ID(); ?>" <?php post_class('page-layout page-layout-full without-title'); ?>>

		<h1 class="visually-hidden"><?php the_title(); ?></h1>


		<div class="page-layout__content">
			<?php
			the_content();
			?>
		</div>
	</section><!-- /#page-<?php the_ID(); ?> -->
</main>
<?php

get_footer();
