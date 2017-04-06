<?php get_header( 'portal' ); ?>

<div class="layer main-layer" role="main">

	<div class="page-width__narrow">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <?php lm_get_template_part( 'lead', 'single' ); ?>

        <?php endwhile; endif; ?>

	</div>

</div>

<?php get_footer( 'portal' ); ?>