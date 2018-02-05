<?php
	$show_caption = ! empty( $slide['caption'] ) || ! empty( $slide['heading'] ) || !empty( $slide['call_to_label'] );
?>

<?php if ( $show_caption ) : ?>
	<div class="thb-slide-caption <?php echo $slide['caption_alignment']; ?>">
		<div class="thb-slide-caption-wrapper">
			<div class="thb-caption-inner-wrapper">

				<?php if ( $slide['caption_position'] == 'caption-top' ) : ?>

					<?php if ( ! empty( $slide['caption'] ) ) : ?>
						<div class="thb-caption">
							<?php echo apply_filters( 'the_content', $slide['caption'] ); ?>
						</div>
					<?php endif; ?>

				<?php endif; ?>

				<?php if ( ! empty( $slide['heading'] ) ) : ?>
					<div class="thb-heading">
						<h1><?php echo nl2br( wptexturize( $slide['heading'] ) ); ?></h1>
					</div>
				<?php endif; ?>

				<?php if ( $slide['caption_position'] == 'caption-bottom' ) : ?>

					<?php if ( ! empty( $slide['caption'] ) ) : ?>
						<div class="thb-caption">
							<?php echo apply_filters( 'the_content', $slide['caption'] ); ?>
						</div>
					<?php endif; ?>

				<?php endif; ?>

				<?php if ( !empty( $slide['call_to_label'] ) ) : ?>
					<?php
						$call_to_url = '';
						$target = '';

						if ( isset( $slide['call_to_url_target_blank'] ) && $slide['call_to_url_target_blank'] == '1' ) {
							$target = 'target="_blank"';
						}

						if ( !empty( $slide['call_to_url'] ) && is_numeric( $slide['call_to_url'] ) ) {
							$call_to_url = get_permalink( $slide['call_to_url'] );
						} else {
							$call_to_url = $slide['call_to_url'];
						}
					?>
					<div class="thb-call-to">
						<a class="thb-btn" href="<?php echo $call_to_url; ?>" <?php echo $target; ?>><?php echo $slide['call_to_label']; ?></a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>