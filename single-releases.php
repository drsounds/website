<!DOCTYPE html>
<html>
	<?php while(have_posts()): the_post();?>
	
	<head>
		<title><?php the_title()?></title>
		<meta property="og:title" content="<?php the_title()?>" />
		<meta property="og:type" content="music.album" />
		<meta property="og:url" content="<?php the_permalink()?>" />
		<meta property="og:image" content="<?php echo get_the_featured_image_url()?>" />
		<meta property="og:determiner" content="the" />
		<meta property="og:site_name" content="Dr. Sounds" />

        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
        <link href="https://file.myfontastic.com/n6vo44Re5QaWo8oCKShBs7/icons.css" rel="stylesheet">
		<script src="js/lights.js"></script>
	</head>
	<body style="background-image: url('<?php echo get_the_featured_image_url()?>'); background-size: cover;">
		<sp-lights style="z-index: 100; width: 100%; height: 100%"></sp-lights>
		<div style="position: fixed; left: 50%; top: 50%; -webkit-transform: translate(-50%, -50%)">
			<div class="cover" style="position: relative; background-image: url('<?php echo get_the_featured_image_url()?>'); width:320px; height: 320px; background-size: cover"><br>

			</div>
			<div class="bar">
				<small>Find it on</small>
				<ul class="iconbar">

					<?php $services = array('spotify', 'itunes', 'deezer', 'jamendo');
					foreach($services as $service):
					$class = "socicon-" . $service;
					if ($service == 'spotify') {
						$class = "fa fa-spotify";
					} 	
					?>
					<li><a class="<?php echo  $class ?> " style="font-size:2	5pt" href="<?php echo get_post_meta($post->ID, $service, TRUE)?>?utm_source=dr-sounds.com_release_page"></a></li>
					<?php endforeach;?>
				</ul>
			</div>
		</div>


	</body>
<?php endwhile;?>
</html>
