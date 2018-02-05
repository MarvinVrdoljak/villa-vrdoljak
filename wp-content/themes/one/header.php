<?php
/**
 * @package WordPress
 * @subpackage One
 * @since One 1.0
 */
thb_before_doctype();
?>
<!doctype html>
<html <?php language_attributes(); ?> <?php thb_html_class(); ?>>
	<head>
		<?php thb_head_meta(); ?>

		<title><?php thb_title(); ?></title>

		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>

		<?php thb_body_start(); ?>

		<div id="slide-menu-container">
			<a class="thb-trigger-close" href="#"><span>Close</span></a>

			<div class="slide-menu-container-wrapper">
				<nav id="slide-nav" class="slide-navigation primary">
					<?php
						$theme_location = 'mobile';

						if ( thb_is_header_layout_b() ) {
							$theme_location = 'primary';
							$theme_location = apply_filters( 'thb_layout_b_menu_location', $theme_location );
						}
					?>
					<?php wp_nav_menu( array( 'theme_location' => $theme_location ) ); ?>
				</nav>
			</div>
			
		</div>

		<?php if ( thb_is_enabled_search() ) : ?>
			<div id="thb-search-box-container">
				<div class="thb-search-box-wrapper">
					<?php get_template_part( 'searchform' ); ?>
					<a href="#" id="thb-search-exit"><span><?php _e( 'Exit', 'thb_text_domain' ); ?></span></a>
				</div>
			</div>
		<?php endif; ?>

		<div id="thb-external-wrapper">

			<?php thb_header_before(); ?>

				<?php get_template_part( 'partials/partial-header', thb_get_header_layout() ); ?>

			<?php thb_header_after(); ?>