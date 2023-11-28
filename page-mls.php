<?php 
/**
 * The template for displaying all pages
 *
 * @package Advantage MLS
 * @since 	Advantage MLS 1.0
 * @author  Sesai Cornejo
**/
global $post, $page_bg;
?>

<?php get_header(); ?>
	
	<section class="page-wrap">
        <div class="container">
                <?php
				// Start the loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'content', 'mls' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

					// End the loop.
				endwhile;
				?>
        </div><!-- container -->
    </section><!-- listing-wrap -->

<?php get_footer(); ?>