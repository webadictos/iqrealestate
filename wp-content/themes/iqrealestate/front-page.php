<?php

/**
 * Template Name: Homepage
 * Description: Home Page
 *
 */

get_header();

//the_post();
?>

<main <?php post_class('site-main container'); ?> role="main">

    <h1 class="visually-hidden"><?php the_title(); ?></h1>
    <?php
    the_content();
    ?>


</main>

<?php
get_footer();
