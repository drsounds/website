<?php 

/** 
 * Template Name: About
 */

get_header();
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
                <div class="col-md-12">
                    <p><?php the_content();?></p>
                </div>
                <div class="col-md-12">
                    <h3>Some of my clients</h3>
                    <div class="row">
                        <?php
                        $q = new WP_Query();
                        $q->query(array('post_type' => 'portfolio', 'posts_per_page' => 4));

                        while($q->have_posts()): $q->the_post();
                            $image = get_post_meta($q->post->ID, 'image', TRUE);
                        ?>
                       <div class="col-md-3">
                            <div class="card card-default">
                                <div class="card-image" style="height: 100pt; background-size: 100%; background-image: url('<?php echo $image?>')"></div>

                                <div class="card-content">
                                    <h3><?php the_title()?></h3>
                                </div>
                            </div>
                        </div>   
                        <?php endwhile;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endwhile;

get_footer();?>
