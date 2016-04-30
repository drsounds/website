<?php get_header();?>
<div class="glass glass-default" style="background-image: url('<?php echo get_theme_mod('front_image_url')?>')">
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
                $release_date = get_post_meta($post->ID, 'release_date', TRUE);
                $cover = get_post_meta($post->ID, 'cover', TRUE);
                $labels = wp_get_post_terms($post->ID, array('labels'));
                $spotify_uri = get_post_meta($post->ID, 'spotify_uri', TRUE);
                ?>
                <article class="row">
                        <div class="col-md-4">
                            <img src="<?php echo $cover?>" width="100%">
                        </div>
                       
                       
                           
                        <div class="col-md-12">
                            <?php if (!empty($spotify_uri)):?>
                            <iframe src="https://embed.spotify.com/?uri=<?php echo $spotify_uri?>" width="300" height="80" frameborder="0" allowtransparency="true"></iframe>
                            <?php else:?>
                            <div style="height:84px"></div>
                        <?php endif;?>
                       </div>
                    </div>
                </article>
            <?php endwhile;?>
            </div>
        </div>
    </div>
</div>
<?php get_footer();?>
