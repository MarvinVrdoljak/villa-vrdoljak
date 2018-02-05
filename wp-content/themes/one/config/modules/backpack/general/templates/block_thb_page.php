<?php
	// Modal data
	$title = $title;
	$show_excerpt = (int) $show_excerpt;
	$show_featured = (int) $show_featured_image;
	$thb_thumb_size = '';

	// Page data
	$page = get_post( $page_id );
?>

<?php if ( $page ) : ?>
	<?php
		$page_title     = $page->post_title;
		$page_excerpt   = $page->post_excerpt;
		$page_content   = $page->post_content;
		$page_permalink = get_permalink( $page_id );
		$thumbnail_link = isset( $thumbnail_link ) ? $thumbnail_link : false;

		if ( ! empty( $title ) ) {
			$page_title = $title;
		}
	?>

	<div class="thb-section-block-header">
		<?php if ( $page_title != '' ) : ?>
			<h1 class="thb-section-block-title">
				<?php if ( $title_link == 1 ) : ?>
					<a href="<?php echo $page_permalink; ?>" rel="permalink">
				<?php endif; ?>

				<?php echo apply_filters( 'the_title', $page_title ); ?>

				<?php if ( $title_link == 1 ) : ?>
					</a>
				<?php endif; ?>
			</h1>
		<?php endif; ?>
	</div>

	<?php if ( $show_featured == 1 ) : ?>
		<?php
			$config = array();

			if ( $thumbnail_link ) {
				$config = array(
					'link'      => true,
					'link_href' => $page_permalink
				);
			}

			thb_featured_image(
				$thb_thumb_size,
				$config,
				$page_id
			);
		?>
	<?php endif; ?>

	<?php if ( $show_excerpt == 1 ) : ?>
		<div class="thb-text">
			<?php echo apply_filters( 'the_excerpt', $page_excerpt ); ?>

			<a class="thb-btn thb-read-more" href="<?php echo $page_permalink; ?>" rel="permalink">
				<?php _e( 'Read more', 'thb_text_domain' ); ?>
			</a>
		</div>
	<?php endif; ?>

	<?php if ( $page_content != '' && $show_excerpt != 1 ) : ?>
		<div class="thb-text">
			<?php echo apply_filters( 'the_content', $page_content ); ?>
		</div>
	<?php endif; ?>
<?php endif; ?>