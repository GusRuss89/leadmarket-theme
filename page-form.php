<?php // Template name: Form page ?>

<?php get_header(); ?>

<?php

$id = get_the_ID();
$img_src = get_the_post_thumbnail_url( $id, 'full' );

?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="layer hero-layer" style="background-image: url(<?php echo $img_src; ?>);">
    <div class="page-width__narrow">
        <h1 class="hero-layer--title"><?php the_title(); ?></h1>
        <p class="hero-layer--subtitle"><?php echo get_post_meta( $id, 'subtitle', true ); ?></p>
        <p class="hero-layer--content"><?php echo get_post_meta( $id, 'hero-content', true ); ?></p>
    </div>
</div>

<div class="layer hiw-layer">
    <div class="page-width__narrow">
        <div class="grid">
            <div class="col m-one-half">
                <div class="hiw-layer--box">
                    <div class="media">
                        <div class="media--img">
                            <i class="hiw-layer--icon icon icon-edit"></i>
                        </div>
                        <div class="media--body">
                            <h3 class="hiw-layer--title">Step 1</h3>
                            <p>Complete the form below and all the major rubbish collection companies in Brisbane will be notified.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col m-one-half">
                <div class="hiw-layer--box">
                    <div class="media">
                        <div class="media--img">
                            <i class="hiw-layer--icon icon icon-coffee"></i>
                        </div>
                        <div class="media--body">
                            <h3 class="hiw-layer--title">Step 2</h3>
                            <p>Grab a coffee, wait for the quotes to roll in and then pick the one that suits you best.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="layer form-layer" role="main">

	<div class="page-width__narrow">

        <div id="post-<?php the_ID(); ?>" <?php post_class('article'); ?>>

            <div class="article--body">
                
                <?php the_content(); ?>

            </div>

        </div>        

	</div>

</div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
