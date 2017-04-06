<?php get_header(); ?>

<div class="layer main-layer">

	<div class="page-width">
		<div class="grid sidebar-right">
			<div class="main-col cf" role="main">

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

						<header class="article-header">

							<h1 class="page-title entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
							<p class="sub-title byline vcard"><?php
								printf('Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> in %3$s.', get_the_time('Y-m-j'), get_the_time(get_option('date_format')), get_the_category_list(', '));
							?></p>
							<?php if ( function_exists('yoast_breadcrumb') ) {
								yoast_breadcrumb('<p id="breadcrumbs">','</p>');
							} ?>

						</header> <!-- end article header -->

						<section class="entry-content clearfix" itemprop="articleBody">
							<?php the_content(); ?>
						</section> <!-- end article section -->

						<footer class="article-footer">
							<?php the_tags('<p class="tags"><span class="tags-title">' . __('Tags:', 'bonestheme') . '</span> ', ', ', '</p>'); ?>

						</footer> <!-- end article footer -->

						<?php // comments_template(); ?>

					</article> <!-- end article -->

				<?php endwhile; ?>

				<?php else : ?>

					<article id="post-not-found" class="hentry cf">
							<header class="article-header">
								<h1><?php _e("Oops, Post Not Found!", "bonestheme"); ?></h1>
							</header>
							<section class="entry-content">
								<p><?php _e("Uh Oh. Something is missing. Try double checking things.", "bonestheme"); ?></p>
							</section>
							<footer class="article-footer">
									<p><?php _e("This is the error message in the single.php template.", "bonestheme"); ?></p>
							</footer>
					</article>

				<?php endif; ?>

				</div><!-- .main-col -->

			<?php get_sidebar(); ?>

		</div><!-- .grid -->

	</div><!-- .page-width -->

</div><!-- .main-layer -->

<?php get_footer(); ?>