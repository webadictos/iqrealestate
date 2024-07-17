<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

 ob_start();

$project_ids = wp_list_pluck( $attributes['selectedProjects'], 'value' );

$classes = array( 'section','section-en-renta ' );

?>
<?php
if(is_array($project_ids) && count($project_ids)>0):
?>
<section <?php echo get_block_wrapper_attributes(array( 'class' => implode( ' ', $classes ) )); ?>>

	<?php
		if ( ! empty( $attributes['blockTitle'] ) ):
			$title = esc_html( $attributes['blockTitle'] );
	?>

		<header class="section__title-container with-more-link">
			<h2 class="section__title ">
				<span>
				<?php echo $title;?>
				</span>
			</h2>
			<?php
			if ( ! empty( $attributes['blockLink'] ) ):
				$link = esc_html( $attributes['blockLink'] );
			?>
				<a class="section__title-more" href="<?php echo $link;?>" title="Ver todos">Ver todos</a>
			<?php
			endif;
			?>
		</header>

	<?php
		endif;
	?>

	<?php
		// Crear una nueva consulta
		$query = new WP_Query( array(
			'post_type' => 'iq_realestate',
			'post__in' => $project_ids,
			'orderby' => 'post__in', // Mantener el orden de los IDs
			'posts_per_page' => -1, // Obtener todos los proyectos seleccionados
		));

		if ( $query->have_posts() ) :
			// Iterar sobre los resultados de la consulta
			?>
			<div class="grid-container-items--block">
				<?php
				while ( $query->have_posts() ) {
					$query->the_post();

					get_template_part('template-parts/items/iq_realestate-item', null, array());

				}
				// Restablecer los datos de la consulta
				wp_reset_postdata();
				?>
			</div>
			<?php
		endif;

	?>
</section>
<?php else: ?>
	<h2 class="error">No hay ningún proyecto seleccionado</h2>
<?php endif;?>
<?php

$render = ob_get_clean();


$render = str_replace(array("\r", "\n", "<p></p>"), '', $render);

echo $render;
?>