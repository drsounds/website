<!DOCTYPE html>
<html>
    <head>
        <title><?php echo bloginfo('title'); ?></title>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <script src="<?php echo bloginfo('stylesheet_directory')?>/js/jquery-1.11.2.js"></script>
        <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />

        <script src="<?php echo bloginfo('stylesheet_directory')?>/js/bootstrap.js"></script>
        <script src="<?php echo bloginfo('stylesheet_directory')?>/js/bootstrap3-typeahead.js"></script>
        <script src="<?php echo bloginfo('stylesheet_directory')?>/js/main.js"></script>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
        * {
          card-sizing: border-card !important;
        }
        .icon {
            font-size: 55pt;
        }
        .section-sm .icon {
            font-size: 50pt;
        }
        .card-event {
            min-height: 350pt;
        }
        body {
          font-size: 12pt;
        }
        .menu-item {
          text-transform: uppercase;
        }
        .navbar-transparent .nav li a, .navbar-transparent .navbar-brand {
          color: white;
        }
        .navbar-transparent .nav li a:hover {
          background-color: none !important;
        }
        .navbar-transparent .nav li a:hover {
          font-weight: bold !important;
        }
        .navbar {
          transition: background-color 1s, color 1s;
        }
        </style>
        <?php wp_head();?>
    </head>
    <body>
      <?php if (is_admin_bar_showing()):?>
      <div style="height: 0pt"></div>
    <?php endif;?>
        <nav class="navbar navbar-transparent navbar-fixed-top" style="<?php if (is_admin_bar_showing()):?>top:20pt<?php endif?>">
          <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                  <?php 
                  $logo_url = get_theme_mod('logo_url');
                  if (!empty($logo_url)):?>
                <img alt="Brand" src="<?php echo get_theme_mod('logo_url')?>">
                <?php else: echo bloginfo('title'); endif; ?>

              </a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              
                <?php wp_nav_menu( array(
                  'menu' => 'header-menu',
                  'depth' => 2,
                  'container' => false,
                  'menu_class' => 'nav navbar-nav navbar-right',
                  //Process nav menu using our custom nav walker
                  'walker' => new wp_bootstrap_navwalker())
                );?>                
            </div><!-- /.navbar-collapse -->
          </div>
        </nav>
        <script>
          (function($) {
            $(document).ready(function(){
                $(window).scroll(function () {
                    var scrollY = jQuery(window).scrollTop();
                    if (scrollY > 0) {
                      $('.navbar').removeClass('navbar-transparent');
                      $('.navbar').addClass('navbar-white');
                    } else {
                      $('.navbar').addClass('navbar-transparent');
                      $('.navbar').removeClass('navbar-white');

                    }
                })
              });
          })(jQuery);
        </script><?php ?>