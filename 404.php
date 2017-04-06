<?php get_header(); ?>

<div class="layer main-layer">

	<div class="page-width">
		<div class="grid sidebar-right">
			<div class="main-col cf" role="main">

				<article id="post-not-found" class="hentry cf">

					<header class="article-header">

						<h1 class="page-title" itemprop="headline">Error – Page Not Found</h1>
						<p class="sub-title">The page you're looking for doesn't exist.</p>

					</header> <!-- end article header -->

					<section class="entry-content">

						<p>Sorry, we couldn't find the page you're looking for. It's possible you mis-typed the URL, or clicked on a broken link.</p>

						<p>Here are some things you can try:</p>
						<ul>
							<li>Check to make sure you didn't make any spelling mistakes when you typed the URL.</li>
							<li>Try looking for the page by browsing the menus.</li>
							<li>Try using the search function below.</li>
						</ul>

					</section> <!-- end article section -->

					<section class="search">
						<h2>Search</h2>
						<?php get_search_form(); ?>
					</section> <!-- end search section -->

				</article> <!-- end article -->

			</div><!-- .main-col -->

			<?php get_sidebar(); ?>

		</div><!-- .grid -->

	</div><!-- .page-width -->

</div><!-- .main-layer -->

<?php get_footer(); ?>
