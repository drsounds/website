<?php get_header();
?>
<div class="glass glass-default" style="background-position: fixed; background-size: cover; background-image: url('<?php echo get_theme_mod('front_image_url')?>'); height:200pt;">
    <div class="glass-content">
        <div class="container">
            <h1>Videos</h1>
        </div>
    </div>
</div><?php
while(have_posts()): the_post();
$image = get_post_meta($post->ID, 'image', TRUE);
$url = get_post_meta($post->ID, 'url', TRUE);
?>

<div class="section section-default">
    <div class="section-content">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1><?php the_title();?></h1>
                    <p><?php the_content();?></p>
                    <a href="<?php echo $url?>" class="btn btn-primary">Visit site</a>
                </div>
                <div class="col-md-6">
                    <iframe frameborder="0" src="<?php echo str_replace('watch?v=', 'embed/', $url)?>" style="width: 100%; height:250pt"></iframe>
                        
                </div>
            </div>
        </div>
    </div>
</div>
<?php endwhile;

get_footer();?>
