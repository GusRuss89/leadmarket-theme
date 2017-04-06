<?php get_header(); ?>

<div class="layer main-layer">

	<div class="page-width">
		<div class="grid sidebar-right">
			<div class="main-col cf" role="main">

				<header class="article-header">

					<h1 class="page-title" itemprop="headline">Search: "<?php the_search_query(); ?>"</h1>
					<?php if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb('<p id="breadcrumbs">','</p>');
					} ?>

				</header> <!-- end article header -->

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('cf entry-item spaced'); ?> role="article">

						<header class="article-header">

							<h3 class="search-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

						</header> <!-- end article header -->

						<section class="entry-content">
							<?php if( function_exists('the_advanced_excerpt') ) {
								the_advanced_excerpt();
							} else {
								the_excerpt();
							} ?>
						</section> <!-- end article section -->

						<footer class="article-footer">
							<p><a href="<?php the_permalink(); ?>">Continue Reading &rarr;</a></p>
						</footer> <!-- end article footer -->

					</article> <!-- end article -->

				<?php endwhile; ?>

				<?php if (function_exists('bones_page_navi')) { ?>
						<?php bones_page_navi(); ?>
				<?php } else { ?>
						<nav class="wp-prev-next">
								<ul class="clearfix">
									<li class="prev-link"><?php next_posts_link(__('&laquo; Older Entries', "bonestheme")) ?></li>
									<li class="next-link"><?php previous_posts_link(__('Newer Entries &raquo;', "bonestheme")) ?></li>
								</ul>
						</nav>
				<?php } ?>

				<?php else : ?>

					<article id="post-not-found" class="hentry clearfix">
						<header class="article-header">
							<h1><?php _e("Sorry, No Results.", "bonestheme"); ?></h1>
						</header>
						<section class="entry-content">
							<p><?php _e("Try your search again.", "bonestheme"); ?></p>
						</section>
						<footer class="article-footer">
								<p><?php _e("This is the error message in the search.php template.", "bonestheme"); ?></p>
						</footer>
					</article>

				<?php endif; ?>

			</div><!-- .main-col -->

			<?php get_sidebar(); ?>

		</div><!-- .grid -->

	</div><!-- .page-width -->

</div><!-- .main-layer -->

<?php get_footer(); ?>