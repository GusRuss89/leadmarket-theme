<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">

		<!-- mobile meta (hooray!) -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<!-- wp_head() -->
		<?php wp_head(); ?>
		<!-- end wp_head() -->

		<!--[if lte IE 8]>
			<script src="<?php echo get_template_directory_uri(); ?>/library/js/libs/respond.min.js"></script>
		<![endif]-->

	</head>

	<body <?php body_class(); ?>>

		<div class="site-wrap">
			
			<header class="banner layer" role="banner">

				<a class="banner--logo" href="<?php echo get_page_link( LM_LEADS_PAGE ); ?>" rel="nofollow">
					<?php echo bloginfo(); ?>
				</a>

				<nav role="navigation" class="banner--nav">
					<?php branch_main_menu(); ?>
				</nav>

			</header>

			