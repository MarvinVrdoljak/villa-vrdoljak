<?php
/**
 * @package WordPress
 * @subpackage One
 * @since One 1.0
 */

$thb_page_id = get_the_ID();

$slides = thb_get_portfolio_item_slides( thb_get_page_ID() );

$slides_config = $featured_image_config = array(
	'overlay'    => true,
	'link'       => true,
	'link_class' => 'item-thumb'
);

if ( thb_get_disable_work_image_link() == 1 ) {
	$slides_config = array(
		'overlay'    => false,
		'link'       => false
	);

	$featured_image_config = array(
		'link'       => false,
		'overlay'    => false
	);
}

$image_size = 'large';

$prj_info = thb_duplicable_get('prj_info', $thb_page_id);
$has_prj_info = !empty($prj_info);

$work_categories = wp_get_object_terms($thb_page_id, 'portfolio_categories');
$cats = array();
foreach( $work_categories as $cat ) {
	$cats[] = $cat->name;
}
get_header(); ?>
	<?php thb_post_before(); ?>

		<section id="page-content">

		<?php thb_post_start(); ?>

			<div class="thb-section-container <?php echo thb_pagecontent_skin(); ?>">

				<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

					<div id="main-content">

						<article id="single-work-container" <?php post_class(); ?>>

							<div class="work-data">

								<div class="single-work-main-data">

									<div class="main-data-wrapper">
										<h1 class="work-title" <?php thb_livestyle_element( 'single_work_title' ); ?>><?php the_title(); ?></h1>

										<?php if ( thb_get_project_short_description() != '' ) : ?>
											<h3 class="work-subtitle" <?php thb_livestyle_element( 'single_work_subtitle' ); ?>>
												<?php echo thb_get_project_short_description(); ?>
											</h3>
										<?php endif; ?>
									</div>

								</div>

								<?php if ( thb_is_single_work_layout_a() ) : ?>
									<?php thb_get_template_part( 'partials/partial-single-work-slides', array(
										'slides'                => $slides,
										'image_size'            => $image_size,
										'featured_image_config' => $featured_image_config,
										'slides_config'         => $slides_config
									) ); ?>
								<?php endif; ?>

								<div class="single-work-secondary-data">

									<?php if ( get_the_content() != '' ) : ?>
										<div class="thb-text">
											<?php the_content(); ?>
										</div>
									<?php endif; ?>

									<aside class="thb-project-info">
										<?php if( $has_prj_info ) : ?>
											<?php foreach( $prj_info as $info ) : ?>
												<p>
													<?php if ( thb_text_startsWith( $info['value']['value'], 'http://' ) ) : ?>
														<a href="<?php echo $info['value']['value']; ?>"><?php echo $info['value']['key']; ?></a>
													<?php else : ?>
														<span class="thb-project-label"><?php echo $info['value']['key']; ?></span>
														<?php echo $info['value']['value']; ?>
													<?php endif; ?>
												</p>
											<?php endforeach; ?>
										<?php endif; ?>

										<?php if( ! empty($cats) ) : ?>
											<p><span class="thb-project-label"><?php _e( 'Project categories', 'thb_text_domain' ); ?>: </span><?php echo implode(', ', $cats); ?></p>
										<?php endif; ?>

										<?php if ( thb_portfolio_item_get_external_url() != '' ) : ?>
											<?php $external_url = thb_portfolio_item_get_external_url(); ?>
											<p><span class="thb-project-label"><?php _e( 'External URL', 'thb_text_domain' ); ?>: </span><a href="<?php echo $external_url; ?>"><?php echo $external_url; ?></a></p>
										<?php endif; ?>
									</aside>

									<aside class="meta social-actions">
										<?php if ( thb_is_enable_social_share() ) : ?>
											<?php thb_get_template_part('partials/partial-share'); ?>
										<?php endif; ?>

										<?php if ( thb_is_portfolio_likes_active() ) : ?>
											<?php thb_like(); ?>
										<?php endif; ?>
									</aside>

								</div>

							</div>

							<?php if ( ! thb_is_single_work_layout_a() ) : ?>
								<?php thb_get_template_part( 'partials/partial-single-work-slides', array(
									'slides'                => $slides,
									'image_size'            => $image_size,
									'featured_image_config' => $featured_image_config,
									'slides_config'         => $slides_config
								) ); ?>
							<?php endif; ?>

						</article>

						<?php
							if( thb_show_pagination() ) {
								add_action( 'thb_between_navigation', 'thb_portfolio_index' );

								thb_pagination(
									array(
										'single_prev'     => __( 'Previous', 'thb_text_domain' ),
										'single_next'     => __( 'Next', 'thb_text_domain' )
									)
								);
							}
						?>

						<?php if( thb_show_comments() ) : ?>
							<section class="secondary">
								<?php thb_comments( array('title_reply' => '<span>' . __('Leave a reply', 'thb_text_domain') . '</span>' )); ?>
							</section>
						<?php endif; ?>

					</div>

				<?php endwhile; endif; ?>

				<?php thb_page_sidebar(); ?>

			</div>

		<?php thb_post_end(); ?>

		</section>

	<?php thb_post_after(); ?>

<?php get_footer(); ?>