<?php
$image = get_post_meta($post->ID, 'image', TRUE);

?>
    <div class="col-md-4" >
        <div class="card card-default" style="min-height: 400pt">
            <div class="card-image" style="height: 120pt; background-size: 100%; background-image: url('<?php echo $image?>')"></div>

            <div class="card-content">
                <h3><a href="<?php the_permalink()?>"><?php the_title()?></a></h3>
                <?php the_content()?>
                <small>Frameworks:<br><?php echo get_the_term_list( $post->id, array('platforms'), '', ', ', '' ) ?></small><br> 
                <small>Industry:<br><?php echo get_the_term_list( $post->id, 'industries', '', ', ', '' ) ?></small> 
            </div>
        </div>
    </div>
<?php 