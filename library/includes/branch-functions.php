<?php
/**************************************\
CONTENTS
Try to keep this somewhat up-to-date
THUMBNAILS
SIDEBARS
MENUS & NAVIGATION
PAGINATION
LAYOUT
SEARCH FORM
COMMENT LAYOUT
FACEBOOK SDK
OPTIONS PAGE
MISCELANNEOUS
***************************************/
/*********************
MENUS & NAVIGATION
*********************/

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
/*
add_image_size( $name, $width, $height, $crop );
*/
add_image_size( 'thumb-600', 600, 300, true );
add_image_size( 'thumb-300', 300, 150, true );


/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function branch_register_sidebars() {
    register_sidebar(array(
        'id' => 'sidebar1',
        'name' => 'Primary Sidebar',
        'description' => 'The first (primary) sidebar.',
        'before_widget' => '<div id="%1$s" class="widget cf %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'id' => 'blog-sidebar',
        'name' => 'Blog Sidebar',
        'description' => 'Gets displayed under the primary sidebar on blog and archive pages.',
        'before_widget' => '<div id="%1$s" class="widget cf %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    /*
    To call a sidebar in the theme, use: dynamic_sidebar( $id );
    */
}

// the main menu
function branch_main_menu() {
	// display the wp3 menu if available
    wp_nav_menu(array(
    	'container' => false,                           // remove nav container
    	'container_class' => 'menu cf',                // class of container (should you choose to use it)
    	'menu' => 'The Main Menu',                     // nav name
    	'menu_class' => 'nav main-menu cf',             // adding custom nav class
    	'theme_location' => 'main-nav',                 // where it's located in the theme
    	'before' => '',                                 // before the menu
        'after' => '',                                  // after the menu
        'link_before' => '',                            // before each link
        'link_after' => '',                             // after each link
        'depth' => 0,                                   // limit the depth of the nav
    	'fallback_cb' => 'branch_main_nav_fallback'      // fallback function
	));
} /* end branch main nav */

// the top menu
function branch_top_menu() {
    // display the wp3 menu if available
    wp_nav_menu(array(
        'container' => false,                           // remove nav container
        'container_class' => 'menu cf',           // class of container (should you choose to use it)
        'menu' => 'The Top Menu',                         // nav name
        'menu_class' => 'nav top-menu cf',             // adding custom nav class
        'theme_location' => 'top-nav',                 // where it's located in the theme
        'before' => '',                                 // before the menu
        'after' => '',                                  // after the menu
        'link_before' => '',                            // before each link
        'link_after' => '',                             // after each link
        'depth' => 0,                                   // limit the depth of the nav
        'fallback_cb' => false                          // fallback function
    ));
} /* end branch main nav */

// the footer menu (should you choose to use one)
function branch_footer_links() {
    // display the wp3 menu if available
    wp_nav_menu(array(
        'container' => '',                              // remove nav container
        'container_class' => 'footer-links clearfix',   // class of container (should you choose to use it)
        'menu' => 'Footer Links',                       // nav name
        'menu_class' => 'nav footer-nav clearfix',      // adding custom nav class
        'theme_location' => 'footer-menu',             // where it's located in the theme
        'before' => '',                                 // before the menu
        'after' => '',                                  // after the menu
        'link_before' => '',                            // before each link
        'link_after' => '',                             // after each link
        'depth' => 0,                                   // limit the depth of the nav
        'fallback_cb' => false                          // fallback function
    ));
} /* end branch footer link */

// this is the fallback for header menu
function branch_main_nav_fallback() {
    wp_page_menu( array(
        'show_home' => true,
        'menu_class' => 'nav main-menu cf',      // adding custom nav class
        'include'     => '',
        'exclude'     => '',
        'echo'        => true,
        'link_before' => '',                            // before each link
        'link_after' => ''                             // after each link
    ) );
}

// Submenus - takes the current menu and returns just the current branch
function branch_submenu( $sorted_menu_items, $args ) {

      if ( isset( $args->sub_menu ) ) {
        $root_id = 0;

        /**
         * This whole section needs to be refactored by a more competent developer
         */

        // find the current menu item
        foreach ( $sorted_menu_items as $menu_item ) {
          if ( $menu_item->current ) {

            // set the root id based on whether the current menu item has a parent or not
            $root_id = ( $menu_item->menu_item_parent ) ? $menu_item->menu_item_parent : $menu_item->ID;

            // if the current menu item has a parent
            if( $menu_item->menu_item_parent ) {

                // start with the immediate parent of the current menu item
                $immediate_parent_id = $menu_item->menu_item_parent;

                // get the immediate parent object based on it's id
                foreach ( $sorted_menu_items as $item ) {
                    if( $item->ID == $immediate_parent_id ) {
                        $immediate_parent_object = $item;
                        break;
                    }
                }

                // for max 3 levels (we've already gone one level with the above)
                for( $i = 0; $i <= 1; $i++ ) {

                    // if the immediate parent object has a parent, we'll continue
                    if( $immediate_parent_object->menu_item_parent ) {

                        // travel another level up the tree...
                        $immediate_parent_id = $immediate_parent_object->menu_item_parent;

                        // get the immediate parent object based on it's id
                        foreach ( $sorted_menu_items as $item ) {
                            if( $item->ID == $immediate_parent_id ) {
                                $immediate_parent_object = $item;
                                break;
                            }
                        }
                    } else {
                        break;
                    }
                }
                $root_id = $immediate_parent_id;
            }
          }
        }
     
        $menu_item_parents = array();
        
        foreach ( $sorted_menu_items as $key => $item ) {
          // init menu_item_parents
          if ( $item->ID == $root_id ) {
            $menu_item_parents[] = $item->ID;
          }
          // if the menu item is a child of the root item, or if it is the root item
          if ( in_array( $item->menu_item_parent, $menu_item_parents ) || $item->ID == $root_id ) {
            // part of sub-tree: keep!
            $menu_item_parents[] = $item->ID;
          } else {
            // not part of sub-tree: away with it!
            unset( $sorted_menu_items[$key] );
          }
        }
        //print('<pre>' . print_r($sorted_menu_items, true) . '</pre>');
        if( count( $sorted_menu_items) >= 2 ) {
            return $sorted_menu_items;
        } else {
            return;
        }
      } else {
        return $sorted_menu_items;
      }
}
// filter_hook function to react on sub_menu flag
add_filter( 'wp_nav_menu_objects', 'branch_submenu', 10, 2 );

/*********************
PAGINATION
*********************/

// Numeric Pagination (built into the theme by default)
function branch_page_nav($before = '', $after = '') {
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
        $first_page_text = '<i class="icon-step-backward"></i>';
        echo '<li class="branch-first-page-link"><a href="'.get_pagenum_link().'" title="First">'.$first_page_text.'</a></li>';
    }
    echo '<li class="branch-prev-link">';
    previous_posts_link('<i class="icon-backward"></i>');
    echo '</li>';
    for($i = $start_page; $i  <= $end_page; $i++) {
        if($i == $paged) {
            echo '<li class="branch-current">'.$i.'</li>';
        } else {
            echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
        }
    }
    echo '<li class="branch-next-link">';
    next_posts_link('<i class="icon-forward"></i>');
    echo '</li>';
    if ($end_page < $max_page) {
        $last_page_text = '<i class="icon-step-forward"></i>';
        echo '<li class="branch-last-page-link"><a href="'.get_pagenum_link($max_page).'" title="Last">'.$last_page_text.'</a></li>';
    }
    echo '</ol></nav>'.$after."";
}

/*********************
SEARCH FORM
*********************/
if( !function_exists('branch_wpsearch') ) {
    function branch_wpsearch($form) {
        $form = '<form role="search" method="get" class="search-form" action="' . home_url( '/' ) . '" >
        <label class="screen-reader-text" for="s">' . __('Search:', 'branchtheme') . '</label>
        <input type="text" value="' . get_search_query() . '" name="s" class="s" placeholder="Search..." />
        <button type="submit" class="search-submit">
            <i class="icon-search"></i>
            <span class="screen-reader-text">Search</span>
        </button>
        </form>';
        return $form;
    }
}

/*********************
FACEBOOK SDK
*********************/
function branch_facebook_sdk() {
    $appId = false;
    if( $appId ) {
echo <<<END
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=$appId";
  fjs.parentNode.insertBefore(js, fjs);
}(document, "script", "facebook-jssdk"));</script>
END;
    }
}
add_action('wp_footer', 'branch_facebook_sdk');

/*********************
COMMENT LAYOUT
*********************/
if( !function_exists('branch_comments') ) {
    function branch_comments($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment; ?>
        <li <?php comment_class(); ?>>
            <article id="comment-<?php comment_ID(); ?>" class="clearfix">
                <header class="comment-author vcard">
                    <?php
                    /*
                        this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
                        echo get_avatar($comment,$size='32',$default='<path_to_url>' );
                    */
                    ?>
                    <!-- custom gravatar call -->
                    <?php
                        // create variable
                        $bgauthemail = get_comment_author_email();
                    ?>
                    <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
                    <!-- end custom gravatar call -->
                    <?php printf(__('<cite class="fn">%s</cite>', 'branchtheme'), get_comment_author_link()) ?>
                    <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__('F jS, Y', 'branchtheme')); ?> </a></time>
                    <?php edit_comment_link(__('(Edit)', 'branchtheme'),'  ','') ?>
                </header>
                <?php if ($comment->comment_approved == '0') : ?>
                    <div class="alert alert-info">
                        <p><?php _e('Your comment is awaiting moderation.', 'branchtheme') ?></p>
                    </div>
                <?php endif; ?>
                <section class="comment_content clearfix">
                    <?php comment_text() ?>
                </section>
                <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
            </article>
        <!-- </li> is added by WordPress automatically -->
    <?php
    }
}

/*********************
MISCELANNEOUS
*********************/
// Allow shortcodes in widgets
add_filter('widget_text', 'do_shortcode');

// Add editor stylesheet
add_editor_style( 'library/css/editor-style.css' );

/**
 * Check if post is in a menu (used in submenus)
 *
 * @param $menu menu name, id, or slug
 * @param $object_id int post object id of page
 * @return bool true if object is in menu
 */
function branch_is_in_menu( $menu = null, $object_id = null ) {

    // get menu object
    $menu_object = wp_get_nav_menu_items( esc_attr( $menu ) );

    // stop if there isn't a menu
    if( ! $menu_object )
        return false;

    // get the object_id field out of the menu object
    $menu_items = wp_list_pluck( $menu_object, 'object_id' );

    // use the current post if object_id is not specified
    if( !$object_id ) {
        global $post;
        $object_id = get_queried_object_id();
    }

    // test if the specified page is in the menu or not. return true or false.
    return in_array( (int) $object_id, $menu_items );

}

// Debugging function
function print_pre( $array ) {
    echo '<pre>' . print_r( $array, true ) . '</pre>';
}

?>