<?php get_header();
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            ?>
<div class="glass glass-default" style="background-position: fixed; background-size: cover; background-image: url('<?php echo get_theme_mod('front_image_url')?>'); height:200pt;">
    <div class="glass-content">
        <div class="container">
            <h1><?php  echo $term->name;?></h1>
        </div>
    </div>
</div>
<div class="section">
    <div class="section-content">
    <div class="container">
        <div class="row">
            <?php
           
            while(have_posts()): the_post();
            $type = get_post_type($post->ID);
            if ($type == 'portfolio')
            get_template_part('template', 'portfolio');
            endwhile;?>
            </div>
        </div>
    </div>
</div>
<?php get_footer();?>
