<?php
$companies = wp_get_post_terms($post->ID, array('companies'));
$roles = wp_get_post_terms($post->ID, array('roles'));
$duration = (float)get_post_meta($post->ID, 'duration', TRUE);
?>
<article class="col-md-12">
    <div class="card card-default">
        <div class="card-header">
            <h3><?php the_title()?></h3>
            <small><?php echo $companies[0]->name?></small><br>
            <small><?php the_date('M Y')?> - <?php echo date('M Y', strtotime(get_the_date() . ' + ' . $duration . 'months'))?> </small>
        </div>
        <div class="card-content">
            
            <p><?php the_content();?></p>

            <p>Worked with: <?php echo get_the_term_list( $post->id, array('platforms'), '', ', ', '' ) ?></p>
        </div>
    </div>
</article><br>  
<?php 