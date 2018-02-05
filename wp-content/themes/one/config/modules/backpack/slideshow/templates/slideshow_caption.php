<?php if ( ! empty( $slide['caption'] ) ) : ?>
	<div class="thb-slide-caption">
		<div class="thb-slide-caption-wrapper">
			<div class="thb-caption-inner-wrapper">

				<?php if ( ! empty( $slide['caption'] ) ) : ?>
					<div class="thb-caption">
						<?php echo apply_filters( 'the_content', $slide['caption'] ); ?>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
<?php endif; ?>