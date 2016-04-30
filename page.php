<?php get_header();
while(have_posts()): the_post();
$image = get_post_meta($post->ID, 'image', TRUE);

?>
<div class="glass glass-default" style="overflow: hidden; background-size: cover;background-image: url('<?php echo $image?>')">
    <div class="glass-content">
       
        <div class="container">
            <h1><?php the_title();?></h1>
        </div>
    </div>
</div>
<div class="section section-default">
    <div class="section-content">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p><?php the_content();?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endwhile;

get_footer();?>
