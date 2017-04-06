<?php get_header(); ?>

<div class="layer main-layer">

	<div class="page-width">
		<div class="grid sidebar-right">

			<?php get_template_part('submenu'); ?>

			<div class="main-col cf" role="main">

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

						<header class="article-header">

							<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
							<!-- <p class="sub-title">Sub title</p> -->
							<?php if ( function_exists('yoast_breadcrumb') ) {
								yoast_breadcrumb('<p id="breadcrumbs">','</p>');
							} ?>

						</header> <!-- end article header -->

						<section class="entry-content cf" itemprop="articleBody">
							
							<?php the_content(); ?>

						</section>

						<?php // comments_template(); ?>

					</article>

				<?php endwhile; else : ?>

					<article id="post-not-found" class="hentry cf">
						<header class="article-header">

							<h1 class="page-title" itemprop="headline">Oops, post not found</h1>

						</header> <!-- end article header -->

						<section class="entry-content cf" itemprop="articleBody">
							
							<p>Something went wrong.</p>

						</section>
					</article>

				<?php endif; ?>

			</div><!-- .main-col -->

			<?php get_sidebar(); ?>

		</div><!-- .grid -->

	</div><!-- .page-width -->

</div><!-- .main-layer -->

<?php get_footer(); ?>
