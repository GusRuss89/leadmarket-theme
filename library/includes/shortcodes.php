<?php

// Global variable used to add instructions to the contextual help menu for each shortcode
global $shortcodes_help;

/* A starting point for a custom shortcode
**************************************************************
/* Shortcode: [shortcode-name]
 * This is what the shortcode does
 * @param attribute - This is what attribute does
 * / <- delete the space and this sentence
function shortcode_function($atts) {
	extract( shortcode_atts( array(
		'attribute' => null
	), $atts ) );	
	
	ob_start();
		
	$return = ob_get_contents();
	ob_end_clean();

	return $return;
}
add_shortcode( 'shortcode-name', 'shortcode_function' );
**************************************************************/

// Start an unordered list for shortcode help
$shortcodes_help .= '<h2>Available Shortcodes</h2><ul>';

// Replace WP autop formatting
function branch_remove_wpautop( $content ) {
	$content = do_shortcode( shortcode_unautop( $content ) );
	$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );
	return $content;
}

/* Shortcode: [well][/well]
 * Puts the enclosed content in a well
 * @param class - adds custom classes to the well
 */
function output_in_well( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'class' => null
	), $atts ) );
	
	return '<div class="well ' . esc_attr( $class ) . '">' . branch_remove_wpautop( $content ) . '</div><!-- .well -->';
}
add_shortcode( 'well', 'output_in_well' );
$shortcodes_help .= <<<END
<li>
	<code>[well]</code>Content<code>[/well]</code> - Output content in a well/box (on a background).
</li>
END;

/* Shortcode: [alert][/alert]
 * Outputs the enclosed content as an alert
 * @param type - adds a class of info, warning, error, success
 */
function output_as_alert( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'type' => null
	), $atts ) );
	
	return '<div class="alert ' . esc_attr( $type ) . '">' . branch_remove_wpautop( $content ) . '</div><!-- .alert -->';
}
add_shortcode( 'alert', 'output_as_alert' );
$shortcodes_help .= <<<END
<li>
	<code>[alert type="type"]</code>Content<code>[/alert]</code> - Output content as an alert. <strong>Types:</strong> info, warning, error, success
</li>
END;

/* Shortcode: [grid][/grid]
 * Necessary for outside columns shortcodes
 */
function output_in_grid( $atts, $content = null ) {
	return '<div class="grid"><!-- Open first comment to remove whitespace' . branch_remove_wpautop( $content ) . 'End last comment --></div><!-- .grid -->';
}
add_shortcode( 'grid', 'output_in_grid' );
$shortcodes_help .= <<<END
<li>
	<code>[grid]</code>Content<code>[/grid]</code> - Necessary to wrap column shortcodes.
</li>
END;

/* Shortcode: [col][/col]
 * Puts the enclosed content in a column
 * @param size - adds extra sizing classes
 */
function output_in_column( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'size' => null
	), $atts ) );
	
	return '--><div class="grid-item ' . esc_attr( $size ) . '">' . branch_remove_wpautop( $content ) . '</div><!-- Reopen comment';
}
add_shortcode( 'col', 'output_in_column' );
$shortcodes_help .= <<<END
<li>
	<code>[col size="one-half"]</code>Content<code>[/col]</code> - Output content in a column. This shortcode <strong>MUST</strong> be used inside <code>[grid][/grid]</code> wrappers.<br />
	<strong>Bonus:</strong> add a breakpoint size prefix to make the column take that width only above the breakpoint. Prefixes: <code>xs- s- m- l- xl-</code><br />
	E.g. <code>[col size="m-one-half l-one-quarter"]</code>This content will appear at full-width on mobiles, half-width on medium-sized screens, and quarter width on full-sized screens.<code>[/col]</code>.<br />
	<strong>Available widths:</strong> use any width unit of anything up to twelve units. E.g. <code>one-third two-thirds four-fifths eleven-twelfths</code>.
</li>
END;

/* Shortcode: [button][/button]
 * Creates a button from the enclosed content
 * @param size - adds extra sizing classes
 * @param cta - adds the call-to-action class
 * @param link - where should the button link
 * @param icon - adds an icon to the start of the button
 */
function output_as_button( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'size' => null,
		'cta' => null,
		'link' => null,
		'icon' => null
	), $atts ) );

	$btn_classes = '';
	$icon_html = '';
	if( $size )
		$btn_classes .= ' btn-' . $size;
	if( $cta )
		$btn_classes .= ' btn-cta';
	if( $icon ) {
		$icon = str_replace( 'icon-', '', $icon );
		$icon_html = '<i class="icon-' . $icon . '"></i> ';
	}
	
	$btn = '<a href="' . $link . '" class="btn' . $btn_classes . '">' . $icon_html . branch_remove_wpautop( $content ) . '</a>';

	return $btn;
}
add_shortcode( 'button', 'output_as_button' );
$shortcodes_help .= <<<END
<li>
	<code>[button size="large" link="http://google.com" cta="1"]</code>Button Text<code>[/button]</code> - Output content as a button.<br />
	<strong>Parameters:</strong><br />
	<code>link="link-here"</code> (required)<br />
	<code>size="small|large"</code> (optional) small or large (no capitals), leave off for default size.<br />
	<code>cta="1"</code> (optional) Call-to-action, changes the colour and adds an arrow.<br />
	<code>icon="icon-name"</code> (optional) <a href="#">Available icons</a>. No capitals.
</li>
END;

/* Shortcode: [search-form]
 * Outputs the search form
 */
function output_search_form() {	
	return get_search_form( false );
}
add_shortcode( 'search-form', 'output_search_form' );
$shortcodes_help .= <<<END
<li>
	<code>[search-form]</code> - Output the search form.
</li>
END;

// End of normal shortcodes
$shortcodes_help .= '</ul>';