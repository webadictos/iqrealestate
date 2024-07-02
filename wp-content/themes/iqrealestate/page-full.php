<?php

/**
 * Template Name: Page (Ancho completo)
 * Description: Page template full width.
 *
 */

get_header();

// the_post();
?>
<main class="site-main" role="main">

	<section id="page-<?php the_ID(); ?>" <?php post_class('page-layout page-layout-full'); ?>>


		<header class="page-layout__header">

			<div class="page-layout__meta">
				<h1 class="page-layout__title entry-title"><?php the_title(); ?></h1>
			</div>

		</header><!-- /.entry-header -->

		<div class="page-layout__content">
			<?php
			the_content();
			?>
		</div>
	</section><!-- /#page-<?php the_ID(); ?> -->
</main>
<?php

get_footer();
