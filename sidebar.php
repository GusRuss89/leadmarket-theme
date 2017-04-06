<div id="sidebar1" class="sidebar cf" role="complementary">

	<?php 
	if ( is_active_sidebar( 'sidebar1' ) ) {

		dynamic_sidebar( 'sidebar1' );

	} else {
		?>
		<div class="alert alert-help">
			<p><?php _e("Please activate some Widgets.", "bonestheme");  ?></p>
		</div>
		<?php
	}

	// Show the blog sidebar underneath the main sidebar if it exists and we're on the blog page, an archive page, or a single post
	if ( is_active_sidebar( 'blog-sidebar' ) && ( is_archive() || is_single() || is_home() ) ) {
		dynamic_sidebar( 'blog-sidebar' );
	} ?>

</div>