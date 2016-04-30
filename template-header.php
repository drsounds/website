<div class="glass glass-default" style="overflow: hidden;padding-top: 10%;text-align: center; width:100%; background-size: cover; display: block; height:700pt; background-color: #333; background-image: url('<?php echo get_theme_mod('front_image_url')?>')">
    <div class="glass-content">
        <img src="<?php echo get_theme_mod('overlay_image_url')?>" style="top: 53pt; position:absolute">
        <div class="container">
            
            <?php
            $q = new WP_Query();
            $q->query(array('post_type' => 'page', 'pagename' => 'about'));
            while($q->have_posts()): $q->the_post();?>
            <div class="row">
                
                <div class="col-md-6" style="font-size: 20pt">
                    <h1>Welcome</h1>
                    <p><?php the_excerpt();?></p>
                </div>
            </div>
        <?php endwhile;?>
<?php /* if (!empty(get_theme_mod('front_video_url'))):?>
    <iframe id="tungevaag-player" style="width: 1920px; height: 1080px; left: 0px; top: 0px;" frameborder="0" allowfullscreen="1" title="YouTube video player" width="1920" height="1080" src="<?php echo get_theme_mod('front_video_url')?>?controls=0&amp;showinfo=0&amp;modestbranding=1&amp;wmode=transparent&amp;enablejsapi=1&amp;autoplay=<?php echo wp_is_mobile() ? '0' : '0';?>&amp; origin=http%3A%2F%2Fanebrun.com"></iframe>
<?php endif; */?>
        </div>
    </div>
    

</div>