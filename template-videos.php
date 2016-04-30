<?php
$url = get_post_meta($post->ID, 'url', TRUE);
?>
<div class="col-md-4">
    <div class="card card-default">
        <div class="card-image" style="height: 250pt">
            <iframe frameborder="0" src="<?php echo str_replace('watch?v=', 'embed/', $url)?>" style="width: 100%; height:100%"></iframe>
        </div>

        <div class="card-content" style="min-height: 250pt; max-height: 250pt">
            <h3><a href="<?php the_permalink()?>"><?php the_title()?></a></h3>
            <p><?php the_excerpt()?></p>
           
        </div>
    </div>
</div>
<?php 