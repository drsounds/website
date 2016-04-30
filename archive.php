<?php
get_header();
?>
<div class="glass glass-default" style="background-position: fixed; background-size: cover; background-image: url('<?php echo get_theme_mod('front_image_url')?>'); height:200pt;">
    <div class="glass-content">
        <div class="container">
            <h1>Blog</h1>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php
            while (have_posts()): the_post();?>
            <article>  
                <h3><a href="<?php the_permalink()?>"><?php the_title();?></a></h3>
                <p><?php the_excerpt();?></p>
            </article><hr><?php
            endwhile;?> 
        </div>
    </div>
</div><?php
get_footer();