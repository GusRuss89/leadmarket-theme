<?php
/* 
This is the core Branch file where the framework is initiated. 

Custom functions should go in the functions.php file,
or in the appropriate file within /library/includes

Developed by: Angus Russell
URL: http://angusrussell.me/branch
Based on branch by Eddie Machado
*/

/*********************
LAUNCH BRANCH
Let's fire off all the functions and tools.
We do this here so it's right up top and clean.
*********************/

// we're firing all out initial functions at the start
add_action('after_setup_theme','branch_init', 16);

function branch_init() {

    // launching operation cleanup
    add_action('init', 'branch_head_cleanup');
    // remove WP version from RSS
    add_filter('the_generator', 'branch_rss_version');
    // remove pesky injected css for recent comments widget
    add_filter( 'wp_head', 'branch_remove_wp_widget_recent_comments_style', 1 );
    // clean up comment styles in the head
    add_action('wp_head', 'branch_remove_recent_comments_style', 1);
    // clean up gallery output in wp
    add_filter('gallery_style', 'branch_gallery_style');

    // enqueue base scripts and styles
    add_action('wp_enqueue_scripts', 'branch_scripts_and_styles', 999);
    add_action('wp_head', 'branch_google_analytics' );
	add_action('wp_footer', 'branch_adwords_conversion_tracking' );

    // launching this stuff after theme setup
    branch_theme_support();

    // ACF
    branch_setup_acf();

    // adding sidebars to Wordpress (these are created in functions.php)
    add_action( 'widgets_init', 'branch_register_sidebars' );
    // adding the branch search form (created in branch-functions.php)
    add_filter( 'get_search_form', 'branch_wpsearch' );

    // cleaning up random code around images
    add_filter('the_content', 'branch_filter_ptags_on_images');
    // cleaning up excerpt
    add_filter('excerpt_more', 'branch_excerpt_more');
    add_filter( 'excerpt_length', 'branch_custom_excerpt_length', 999 );

    // Move Wordpress SEO metabox to the bottom
    add_filter( 'wpseo_metabox_prio', function() { return 'low';});

} /* end branch ahoy */

/*********************
WP_HEAD GOODNESS
The default wordpress head is
a mess. Let's clean it up by
removing all the junk we don't
need.
*********************/

function branch_head_cleanup() {
	// category feeds
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// index link
	remove_action( 'wp_head', 'index_rel_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
  // remove WP version from css
  add_filter( 'style_loader_src', 'branch_remove_wp_ver_css_js', 9999 );
  // remove Wp version from scripts
  add_filter( 'script_loader_src', 'branch_remove_wp_ver_css_js', 9999 );

} /* end branch head cleanup */

function branch_google_analytics() {
	?>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-96985497-1', 'auto');
		ga('send', 'pageview');

	</script>
	<?php
}

function branch_adwords_conversion_tracking() {
	// Brisbane rubbish collection quote request thank-you page
	if( is_page( 2 ) ) { ?>
		<!-- Google Code for Quotes Requested Conversion Page -->
		<script type="text/javascript">
		/* <![CDATA[ */
		var google_conversion_id = 855676952;
		var google_conversion_language = "en";
		var google_conversion_format = "3";
		var google_conversion_color = "ffffff";
		var google_conversion_label = "jOEJCLzcjXAQmLCCmAM";
		var google_remarketing_only = false;
		/* ]]> */
		</script>
		<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
		</script>
		<noscript>
		<div style="display:inline;">
		<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/855676952/?label=jOEJCLzcjXAQmLCCmAM&amp;guid=ON&amp;script=0"/>
		</div>
		</noscript>

	<?php }
}

// remove WP version from RSS
function branch_rss_version() { return ''; }

// remove WP version from scripts
function branch_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}

// remove injected CSS for recent comments widget
function branch_remove_wp_widget_recent_comments_style() {
   if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
      remove_filter('wp_head', 'wp_widget_recent_comments_style' );
   }
}

// remove injected CSS from recent comments widget
function branch_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

// remove injected CSS from gallery
function branch_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}


/*********************
SCRIPTS & ENQUEUEING
*********************/

// loading modernizr and jquery, and reply script
function branch_scripts_and_styles() {
  global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
  if (!is_admin()) {

    // modernizr (without media query polyfill)
    wp_register_script( 'branch-modernizr', get_template_directory_uri() . '/library/js/libs/modernizr.custom.min.js', array(), '2.5.3', false );

    // fitvids.js
    wp_register_script( 'fitvids', get_template_directory_uri() . '/library/js/libs/jquery.fitvids.js', array( 'jquery' ), '', true);

    // register main stylesheet
    wp_register_style( 'branch-stylesheet', get_stylesheet_directory_uri() . '/library/css/style.css', array(), '', 'all' );

    // ie-only style sheet
    //wp_register_style( 'branch-ie-only', get_stylesheet_directory_uri() . '/library/css/ie.css', array(), '' );

    // comment reply script for threaded comments
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }

    //adding scripts file in the footer
    wp_register_script( 'branch-js', get_stylesheet_directory_uri() . '/library/js/scripts.js', array( 'jquery' ), '', true );
    // concatenated scripts
    wp_register_script( 'branch-all-scripts', get_stylesheet_directory_uri() . '/library/js/all-theme-scripts.min.js', array( 'jquery' ), '', true );

    // enqueue scripts
    $concatenate_scripts = true;
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'branch-modernizr' );

    // maybe concatenate
    if( $concatenate_scripts ) {
	    wp_enqueue_script( 'branch-all-scripts' );
	} else {
		wp_enqueue_script( 'fitvids' );
	    wp_enqueue_script( 'branch-js' );
	}

	// enqueue styles
    wp_enqueue_style( 'branch-stylesheet' );
    //wp_enqueue_style('branch-ie-only');

    //$wp_styles->add_data( 'branch-ie-only', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet

  }
}

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function branch_theme_support() {

	// wp thumbnails (sizes handled in functions.php)
	add_theme_support('post-thumbnails');

	// default thumb size
	set_post_thumbnail_size(125, 125, true);

	// rss thingy
	add_theme_support('automatic-feed-links');

	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/

	// adding post format support
	/*
	add_theme_support( 'post-formats',
		array(
			//'aside',             // title less blurb
			//'gallery',           // gallery of images
			//'link',              // quick link to other site
			//'image',             // an image
			//'quote',             // a quick quote
			//'status',            // a Facebook like status update
			//'video',             // video
			//'audio',             // audio
			//'chat'               // chat transcript
		)
	); */

	// wp menus
	add_theme_support( 'menus' );

	// title tag
	add_theme_support( 'title-tag' );

	// registering wp3+ menus
	register_nav_menus(
		array(
			'main-nav' => 'Main Menu',
			'footer-menu' => 'Footer Menu',
			'top-nav' => 'Top Menu',
			'social-nav' => 'Social Media Menu'
		)
	);
} /* end branch theme support */


/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function branch_page_navi($before = '', $after = '') {
	global $wpdb, $wp_query;
	$request = $wp_query->request;
	$posts_per_page = intval(get_query_var('posts_per_page'));
	$paged = intval(get_query_var('paged'));
	$numposts = $wp_query->found_posts;
	$max_page = $wp_query->max_num_pages;
	if ( $numposts <= $posts_per_page ) { return; }
	if(empty($paged) || $paged == 0) {
		$paged = 1;
	}
	$pages_to_show = 7;
	$pages_to_show_minus_1 = $pages_to_show-1;
	$half_page_start = floor($pages_to_show_minus_1/2);
	$half_page_end = ceil($pages_to_show_minus_1/2);
	$start_page = $paged - $half_page_start;
	if($start_page <= 0) {
		$start_page = 1;
	}
	$end_page = $paged + $half_page_end;
	if(($end_page - $start_page) != $pages_to_show_minus_1) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
	if($end_page > $max_page) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = $max_page;
	}
	if($start_page <= 0) {
		$start_page = 1;
	}
	echo $before.'<nav class="page-navigation"><ol class="branch_page_navi clearfix">'."";
	if ($start_page >= 2 && $pages_to_show < $max_page) {
		$first_page_text = __( "First", 'branchtheme' );
		echo '<li class="bpn-first-page-link"><a href="'.get_pagenum_link().'" title="'.$first_page_text.'">'.$first_page_text.'</a></li>';
	}
	echo '<li class="bpn-prev-link">';
	previous_posts_link('<<');
	echo '</li>';
	for($i = $start_page; $i  <= $end_page; $i++) {
		if($i == $paged) {
			echo '<li class="bpn-current">'.$i.'</li>';
		} else {
			echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
		}
	}
	echo '<li class="bpn-next-link">';
	next_posts_link('>>');
	echo '</li>';
	if ($end_page < $max_page) {
		$last_page_text = __( "Last", 'branchtheme' );
		echo '<li class="bpn-last-page-link"><a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'">'.$last_page_text.'</a></li>';
	}
	echo '</ol></nav>'.$after."";
} /* end page navi */

/*********************
RANDOM CLEANUP ITEMS
*********************/

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function branch_filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// This removes the annoying […] to a Read More link
function branch_excerpt_more($more) {
	global $post;
	// edit here if you like
return '...  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __('Read', 'branchtheme') . get_the_title($post->ID).'">'. __('Read more &raquo;', 'branchtheme') .'</a>';
}

/*
 * This is a modified the_author_posts_link() which just returns the link.
 *
 * This is necessary to allow usage of the usual l10n process with printf().
 */
function branch_get_the_author_posts_link() {
	global $authordata;
	if ( !is_object( $authordata ) )
		return false;
	$link = sprintf(
		'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
		esc_attr( sprintf( __( 'Posts by %s' ), get_the_author() ) ), // No further l10n needed, core will take care of this one
		get_the_author()
	);
	return $link;
}

/*
 * Setup ACF
 */
function branch_setup_acf() {
	if( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page();
	}
}

// Excerpt length
function branch_custom_excerpt_length( $length ) {
	return 15;
}

?>
