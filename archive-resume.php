<?php get_header();?>
<div class="glass glass-default" style="background-size: 100%; background-image: url('<?php echo get_theme_mod('front_image_url')?>')">
    <div class="glass-content">
        <div class="container">
            <h1>Resumé</h1>
        </div>
    </div>
</div>
<div class="section section-default">
    <div class="section-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <?php
                    while(have_posts()): the_post();
                    get_template_part('template', 'resume');
                    endwhile;?>
                </div>
                <div class="col-md-4">
                    <h3>Skills</h3>
                    <?php wp_tag_cloud('taxonomy=technologies&smallest=8&largest=22');?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer();?>
