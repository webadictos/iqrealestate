<?php
do_action('wa_before_footer');

$logo_footer = wa_theme()->setting('general', 'logo_footer') ?? '';

?>
<footer id="footer">

	<div class="footer-container container">


		<div class="footer__logo">
			<a href="<?php echo esc_url(home_url()); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">

				<?php
				if (!empty($logo_footer)) :
				?>
					<img class="footer__logo-img" src="<?php echo esc_url($logo_footer); ?>" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" width="279" height="81" loading="lazy" />
				<?php
				endif;
				?>
			</a>

		</div>


		<?php
		if (has_nav_menu('footer-menu')) : // See function register_nav_menus() in functions.php
			/*
								Loading WordPress Custom Menu (theme_location) ... remove <div> <ul> containers and show only <li> items!!!
								Menu name taken from functions.php!!! ... register_nav_menu( 'footer-menu', 'Footer Menu' );
								!!! IMPORTANT: After adding all pages to the menu, don't forget to assign this menu to the Footer menu of "Theme locations" /wp-admin/nav-menus.php (on left side) ... Otherwise the themes will not know, which menu to use!!!
							*/
			wp_nav_menu(
				array(
					'container'       => 'nav',
					'container_class' => 'footer__menu-uno',
					//'fallback_cb'     => 'WP_Bootstrap4_Navwalker_Footer::fallback',
					'walker'          => new WP_Bootstrap4_Navwalker_Footer(),
					'theme_location'  => 'footer-menu',
					'items_wrap'      => '<ul class="menu nav">%3$s</ul>',
				)
			);
		endif;
		?>


		<div class="footer__social">
			<?php
			if (function_exists('wa_show_social_profiles')) {
			?>
			<?php
				wa_show_social_profiles();
			}
			?>

		</div>

		<?php
		if (is_active_sidebar('fourth_widget_area')) :
		?>

			<div class="footer__contact">
				<?php
				dynamic_sidebar('fourth_widget_area');
				?>
			</div>
		<?php
		endif;
		?>


		<?php
		// if (has_nav_menu('privacy-menu')) : // See function register_nav_menus() in functions.php

		// 	wp_nav_menu(
		// 		array(
		// 			'container'       => 'nav',
		// 			'container_class' => 'footer__menu-tres',
		// 			//'fallback_cb'     => 'WP_Bootstrap4_Navwalker_Footer::fallback',
		// 			'walker'          => new WP_Bootstrap4_Navwalker_Footer(),
		// 			'theme_location'  => 'privacy-menu',
		// 			'items_wrap'      => '<ul class="menu nav">%3$s</ul>',
		// 		)
		// 	);
		// endif;
		?>




		<div class="footer__credits ">

			<?php
			if (has_nav_menu('privacy-menu')) : // See function register_nav_menus() in functions.php

				wp_nav_menu(
					array(
						'container'       => 'nav',
						'container_class' => 'footer__menu-tres2',
						//'fallback_cb'     => 'WP_Bootstrap4_Navwalker_Footer::fallback',
						'walker'          => new WP_Bootstrap4_Navwalker_Footer(),
						'theme_location'  => 'privacy-menu',
						'items_wrap'      => '<ul class="menu nav">%3$s</ul>',
					)
				);
			endif;
			?>

			<?php
			if (is_active_sidebar('third_widget_area')) :
			?>
				<?php
				dynamic_sidebar('third_widget_area');
				?>
			<?php
			endif;
			?>
		</div>
	</div>
</footer><!-- /#footer -->
<?php
do_action('wa_after_footer');
?>
</div><!-- /#wrapper -->
<?php get_template_part('template-parts/overlays', ''); ?>
<?php
wp_footer();
?>
</body>

</html>