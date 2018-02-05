<?php
/**
 * @package WordPress
 * @subpackage One
 * @since One 1.0
 * Template name: Photogallery
 */
get_header(); ?>

	<?php thb_page_before(); ?>

		<section id="page-content">

			<?php thb_page_start(); ?>

			<?php get_template_part('partials/partial-pageheader' ); ?>

			<?php thb_page_content_start(); ?>

			<div class="thb-section-container <?php echo thb_pagecontent_skin(); ?>">

				<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

					<?php if ( get_the_content() != '') : ?>
						<div id="main-content">

							<div class="thb-text">
								<?php the_content(); ?>
							</div>

						</div>
					<?php endif; ?>

				<?php endwhile; endif; ?>

				<?php thb_photogallery(); ?>

			</div>

			<?php thb_page_end(); ?>

		</section>

	<?php thb_page_after(); ?>

<?php get_footer(); ?>