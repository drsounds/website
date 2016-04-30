<?php
$release_date = get_post_meta($post->ID, 'release_date', TRUE);
$cover = get_post_meta($post->ID, 'cover', TRUE);
$labels = wp_get_post_terms($post->ID, array('labels'));
$spotify_uri = get_post_meta($post->ID, 'spotify_uri', TRUE);
?>
<article class="row">
        <div class="col-md-3">
            <img src="<?php echo $cover?>" width="100%">
        </div>
       <div class="col-md-5">
        <h3><?php the_title();?> (<?php echo date('Y', strtotime($release_date))?>)</h3>
        <small><?php echo $labels[0]->name?></small>
       </div>
       
           
        <div class="col-md-4">
            <?php if (!empty($spotify_uri)):?>
            <iframe src="https://embed.spotify.com/?uri=<?php echo $spotify_uri?>" width="300" height="380" frameborder="0" allowtransparency="true"></iframe>
            <?php else:?>
            <div style="height:84px"></div>
        <?php endif;?>
       </div>
</article>
<hr>
<?php 