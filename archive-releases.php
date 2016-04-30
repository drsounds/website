<?php get_header();?>
<div class="glass glass-default" style="background-size: cover; background-image: url('<?php echo get_theme_mod('front_image_url')?>')">
    <div class="glass-content">
        <div class="container">
            <h1>Releases</h1>
        </div>
    </div>
</div>
<div class="section section-default">
    <div class="section-content">
        <div class="container">
            <div class="row">
                <?php
                while(have_posts()): the_post();
                get_template_part('template', 'releases');
                endwhile;?>
            </div>
        </div>
    </div>
</div>
<?php get_footer();?>
