    <?php
/** 
 * Template Name: Front
 */
get_header();
//drsounds_glass(get_theme_mod('front_image_url'));

?>
        <link href="https://file.myfontastic.com/n6vo44Re5QaWo8oCKShBs7/icons.css" rel="stylesheet">
<?php if (get_theme_mod('front_video_url')):?>
    <iframe id="player" style="-webkit-filter: sepia(100%) hue-rotate(140deg) brightness(150%); left: 0px; top: 0px;" frameborder="0" allowfullscreen="1" title="YouTube video player" src="<?php echo get_theme_mod('front_video_url')?>?autoplay=1&amp;controls=0&amp;volume=0&amp;showinfo=0&amp;modestbranding=1&amp;wmode=transparent&amp;enablejsapi=1&amp;autoplay=<?php echo wp_is_mobile() ? '0' : '0';?>&amp; origin=http%3A%2F%2Fanebrun.com"></iframe>
    <div style="position: absolute; z-index:1000; top: 0px; left:0px; width:100%; text-align:center; padding-top: 30%; color: white ">

        <div class="container">
            <div style="background-color: rgba(0, 0, 0, .5); padding: 10pt">
                <h1>Find me on</h1>
                <ul class="iconbar">
                    <?php $services = array('spotify', 'itunes', 'deezer', 'jamendo', 'soundcloud', 'linkedin', 'facebook', 'github', 'jamendo');
                        foreach($services as $service):
                        $class = "socicon-" . $service;
                        if ($service == 'spotify') {
                            $class = "fa fa-spotify";
                        }   
                        ?>
                        <li><a class="<?php echo  $class ?> " style="font-size:55pt" target="__blank" href="<?php echo get_theme_mod($service)?>?utm_source=dr-sounds.com_release_page"></a></li>
                        <?php endforeach;?>
                </ul>   
            </div>  
        </div>
    </div>
    <script>
    window.addEventListener('resize', function (event) {
        var innerWidth = window.innerWidth;
        var player = document.querySelector('#player');
        player.style.width = '100%';
        player.style.height = (player.getBoundingClientRect().width * 0.56) + 'px'; 
    });
       var innerWidth = window.innerWidth;
        var player = document.querySelector('#player');
        player.style.width = '100%';
        player.style.height = (player.getBoundingClientRect().width * 0.56) + 'px'; 
   // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          height: '100%',
          width: '100%',
          playerVars: {
                    autoplay: 1,
                    loop: 1,
                    controls: 0,
                    showinfo: 0,
                    autohide: 1,
                    modestbranding: 1,
                    vq: 'hd1080'},
          videoId: 'JW5meKfy3fY',
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        event.target.playVideo();
        player.mute();
      }

      var done = false;
      function onPlayerStateChange(event) {
        
      }
      function stopVideo() {
        player.stopVideo();
      }
</script>
<?php endif;?>
<div class="section section-default">
    <div class="section-content">
        <div class="container">
            <h1>Latest releases <a href="/releases" class="btn btn-primary pull-right">See more releases</a></h1>
            <br>
            <div class="row">
            <?php
            $q = new WP_Query();
            $q->query(array('post_type' => 'releases'));

            while($q->have_posts()): $q->the_post();
                $year = get_post_meta($q->post->ID, 'release_date', TRUE);
                $cover = get_post_meta($q->post->ID, 'cover', TRUE);
                $labels = wp_get_post_terms($q->post->ID, array('labels'));
                $spotify_uri = get_post_meta($q->post->ID, 'spotify_uri', TRUE);
            ?>
                <div class="col-md-3">
                    <div class="card card-default">
                        <div class="card-content">
                            <img src="<?php echo @get_the_featured_image_url()?>" width="100%">
                            <h3><?php the_title()?></h3>
                        </div>
                    </div>
                </div>
            <?php endwhile;?>
            </div>
        </div>
    </div>
</div>
<div class="glass glass-default" style="text-align: center; width:100%; background-size: cover; background-attachment: fixed; display: block; height:300pt; background-color: #333; background-image: url('<?php echo get_theme_mod('tertiary_image_url')?>')">

<?php /* if (!empty(get_theme_mod('front_video_url'))):?>
    <iframe id="tungevaag-player" style="width: 1920px; height: 1080px; left: 0px; top: 0px;" frameborder="0" allowfullscreen="1" title="YouTube video player" width="1920" height="1080" src="<?php echo get_theme_mod('front_video_url')?>?controls=0&amp;showinfo=0&amp;modestbranding=1&amp;wmode=transparent&amp;enablejsapi=1&amp;autoplay=<?php echo wp_is_mobile() ? '0' : '0';?>&amp; origin=http%3A%2F%2Fanebrun.com"></iframe>
<?php endif; */?>
    
    

</div>
<div class="section section-default">
    <div class="section-content">
        <div class="container">
            <hr>
            <h1>Videos featuring Dr. Sounds <a href="/videos" class="btn btn-primary pull-right">See more</a></h1>
            <br>
            <div class="row">
                <?php
                $q = new WP_Query();
                $q->query(array('post_type' => 'videos', 'posts_per_page' => 6));
                $num_posts = $q->found_posts;
                while($q->have_posts()): $q->the_post();
                    $url = get_post_meta($q->post->ID, 'url', TRUE);
                ?>
                <div class="col-md-4">
                    <div class="card card-default">
                        <div class="card-image" style="height: 150pt">
                            <iframe frameborder="0" src="<?php echo str_replace('watch?v=', 'embed/', $url)?>" style="width: 100%; height:100%"></iframe>
                        </div>

                        <div class="card-content">
                            <h3><a href="<?php the_permalink()?>"><?php the_title()?></a></h3>
                           
                        </div>
                    </div>
                </div>
            <?php endwhile;?>
            </div>
        </div>
    </div>
</div>
<div class="glass glass-default" style="text-align: center; width:100%; background-size: cover; background-attachment: fixed; display: block; height:300pt; background-color: #333; background-image: url('<?php echo get_theme_mod('tertiary_image_url')?>')">

<?php /* if (!empty(get_theme_mod('front_video_url'))):?>
    <iframe id="tungevaag-player" style="width: 1920px; height: 1080px; left: 0px; top: 0px;" frameborder="0" allowfullscreen="1" title="YouTube video player" width="1920" height="1080" src="<?php echo get_theme_mod('front_video_url')?>?controls=0&amp;showinfo=0&amp;modestbranding=1&amp;wmode=transparent&amp;enablejsapi=1&amp;autoplay=<?php echo wp_is_mobile() ? '0' : '0';?>&amp; origin=http%3A%2F%2Fanebrun.com"></iframe>
<?php endif; */?>
    
    

</div>
<div class="section section-default">
    <div class="section-content">
        <div class="container">
            <h1>Latest events <a href="/events" class="btn btn-primary pull-right">See more</a></h1>
            <br>
            <div class="row">
                <?php
                $q = new WP_Query();
                $q->query(array('post_type' => 'events', 'posts_per_page' => 3));
                $num_posts = $q->found_posts;
                while($q->have_posts()): $q->the_post();
                    $image = get_post_meta($q->post->ID, 'image', TRUE);
                ?>
                <div class="col-md-4">
                    <div class="card card-default">
                        <div class="card-image" style="height: 100pt; background-size: 100%; background-image: url('<?php echo $image?>')"></div>

                        <div class="card-content">
                            <h3><a href="<?php the_permalink()?>"><?php the_title()?></a></h3>
                           
                        </div>
                    </div>
                </div>
            <?php endwhile;?>
            </div>
        </div>
    </div>
</div>
<div class="section section-default">
    <div class="section-content">
        <div class="container">
            <h1>Work portfolio <a href="/releases" class="btn btn-primary pull-right">See more</a></h1>
            <br>
            <div class="row">
                <?php
                $q = new WP_Query();
                $q->query(array('post_type' => 'portfolio', 'posts_per_page' => 3));
                $num_posts = $q->found_posts;
                while($q->have_posts()): $q->the_post();
                    $image = get_post_meta($q->post->ID, 'image', TRUE);
                ?>
                <div class="col-md-4">
                    <div class="card card-default">
                        <div class="card-image" style="height: 100pt; background-size: 100%; background-image: url('<?php echo $image?>')"></div>

                        <div class="card-content">
                            <h3><a href="<?php the_permalink()?>"><?php the_title()?></a></h3>
                           
                        </div>
                    </div>
                </div>
            <?php endwhile;?>
            </div>
        </div>
    </div>
</div>
<?php get_footer();?>
