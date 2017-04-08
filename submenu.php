<?php

$main_menu_id = 2;
$in_menu = '';

// Check what menu the page is in, if any
if( branch_is_in_menu( $main_menu_id ) ) {
    $in_menu = 'main-nav';
}

// If the page is in a menu...
if( $in_menu != '' ) {

	// Capture submenu as a variable
	// Give it no wrapper (we provide that below) so that we 
	// can check if it exists with if( $submenu != '' )
	$args = array( 
	            'theme_location' => $in_menu,
	            'echo'           => '0',
	            'sub_menu'       => true,
	            'items_wrap'     => '%3$s',
	            'container'      => false
		);
	$submenu = wp_nav_menu( $args );


	// If the menu exists
	if( $submenu != '' ) {
		?>
		<nav class="article--subnav">
			<?php echo '<ul class="article--submenu">' . $submenu . '</ul>'; ?>
		</nav>
		<?php
	}
}

?>