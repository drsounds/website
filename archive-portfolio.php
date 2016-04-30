<?php get_header();?>
<div class="glass glass-default" style="background-position: fixed; background-size: cover; background-image: url('<?php echo get_theme_mod('front_image_url')?>'); height:200pt;">
    <div class="glass-content">
        <div class="container">
            <h1>Portfolio</h1>
        </div>
    </div>
</div>
<div class="section">
    <div class="section-content">
    <div class="container">
        <div class="row">
            <?php
            while(have_posts()): the_post();
            get_template_part('template', 'portfolio');
            endwhile;?>
            </div>
        </div>
    </div>
</div>
<?php get_footer();?>
