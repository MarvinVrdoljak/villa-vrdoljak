<?php
	$navPreviousOpen = '<span class="nav-previous">';
	$navNextOpen = '<span class="nav-next">';
	$navPreviousClose = $navNextClose = '</span>';
	$html = '';
?>

<nav role="navigation" class="thb-navigation">
	<?php
		if ( is_single() ) {
			if ( $show_always || thb_post_has_previous( $in_same_cat ) ) {
				echo $navPreviousOpen;
				previous_post_link( $single_format, $single_prev, $in_same_cat );
				echo $navPreviousClose;
			}

			echo apply_filters( 'thb_between_navigation', $html );

			if ( $show_always || thb_post_has_next( $in_same_cat ) ) {
				echo $navNextOpen;
				next_post_link( $single_format, $single_next, $in_same_cat );
				echo $navNextClose;
			}
		}
		else {
			if ( thb_page_has_previous() ) {
				echo $navPreviousOpen;
				previous_posts_link($page_prev);
				echo $navPreviousClose;
			}

			if ( thb_page_has_next() ) {
				echo $navNextOpen;
				next_posts_link($page_next);
				echo $navNextClose;
			}
		}
	?>
</nav>