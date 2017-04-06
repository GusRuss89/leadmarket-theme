<?php // Template name: Portal page ?>

<?php get_header( 'portal' ); ?>

<div class="layer main-layer" role="main">

	<div class="page-width__narrow">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <div id="post-<?php the_ID(); ?>" <?php post_class('article'); ?>>

                <header class="article--header">

                    <h1 class="article--title"><?php the_title(); ?></h1>

                    <?php get_template_part('submenu'); ?>

                </header>

                <div class="article--body">
                    
                    <?php the_content(); ?>

                </div>

            </div>

        <?php endwhile; endif; ?>

	</div>

</div>

<?php get_footer( 'portal' ); ?>
