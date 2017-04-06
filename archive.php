<?php get_header(); ?>

<?php // Page Title Logic
// A default title
$pagetitle = 'Posts Archive';
$subtitle = '';
if (is_category()) {
	$current_category = single_cat_title('', false);
	$pagetitle = 'Posts Categorised: ' . $current_category;
	$subtitle = 'An archive of posts filed under "' . $current_category . '"';

} elseif (is_tag()) {
	$current_tag = single_tag_title('', false);
	$pagetitle = 'Posts Tagged: ' . $current_tag;
	$subtitle = 'An archive of posts tagged "' . $current_tag . '"';

} elseif (is_author()) {
	global $post;
	$author_id = $post->post_author;
	$pagetitle = 'Posts By: ' . get_the_author_meta('display_name', $author_id);
	$subtitle = 'An archive of posts written by ' . get_the_author_meta('display_name', $author_id);

} elseif (is_day()) {
	$pagetitle = 'Daily Archives: ' . get_the_time('l, F j, Y');
	$subtitle = 'Posts published on ' . get_the_time('l, F j, Y');

} elseif (is_month()) {
	$pagetitle = 'Monthly Archives: ' . get_the_time('F Y');
	$subtitle = 'All posts published in ' . get_the_time('F Y');

} elseif (is_year()) {
	$pagetitle = 'Yearly Archives: ' . get_the_time('Y');
	$subtitle = 'All posts published in ' . get_the_time('Y');
}
?>

<div class="layer main-layer">

	<div class="page-width">
		<div class="grid sidebar-right">
			<div class="main-col cf" role="main">

				<header class="article-header">

					<h1 class="page-title" itemprop="headline"><?php echo $pagetitle; ?></h1>
					<?php if( $subtitle != '' ) {
						echo '<p class="sub-title">' . $subtitle . '</p>';
					} ?>
					<?php if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb('<p id="breadcrumbs">','</p>');
					} ?>

				</header> <!-- end article header -->

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('cf entry-item spaced'); ?> role="article">

						<header class="article-header">

							<h1 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
							<p class="byline vcard"><?php
								printf('Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> in %3$s.', get_the_time('Y-m-j'), get_the_time(get_option('date_format')), get_the_category_list(', '));
							?></p>

						</header> <!-- end article header -->

						<section class="entry-content clearfix">
							<?php the_content(); ?>
						</section> <!-- end article section -->

						<footer class="article-footer">
							<!--
							<p class="tags"><?php the_tags('<span class="tags-title">' . __('Tags:', 'bonestheme') . '</span> ', ', ', ''); ?></p>
							-->
						</footer> <!-- end article footer -->

						<?php // comments_template(); // uncomment if you want to use them ?>

					</article> <!-- end article -->

				<?php endwhile; ?>

						<?php if (function_exists('branch_page_nav')) { ?>
								<?php branch_page_nav(); ?>
						<?php } else { ?>
								<nav class="wp-prev-next">
										<ul class="clearfix">
											<li class="prev-link"><?php next_posts_link('&laquo; Older Entries') ?></li>
											<li class="next-link"><?php previous_posts_link('Newer Entries &raquo;') ?></li>
										</ul>
								</nav>
						<?php } ?>

				<?php else : ?>

						<article id="post-not-found" class="hentry clearfix">
							<header class="article-header">
								<h1><?php _e("Oops, Post Not Found!", "bonestheme"); ?></h1>
							</header>
							<section class="entry-content">
								<p><?php _e("Uh Oh. Something is missing. Try double checking things.", "bonestheme"); ?></p>
							</section>
							<footer class="article-footer">
									<p><?php _e("This is the error message in the archive.php template.", "bonestheme"); ?></p>
							</footer>
						</article>

				<?php endif; ?>

				</div><!-- .main-col -->

			<?php get_sidebar(); ?>

		</div><!-- .grid -->

	</div><!-- .page-width -->

</div><!-- .main-layer -->

<?php get_footer(); ?>