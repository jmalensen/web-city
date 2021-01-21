<?php
/*
* Theme Name: @@prettyThemeName
* Author: @@themeAuthor
* Version: @@themeVersion
* Text Domain: @@themeName
* Description: Header template
*			   @@themeDescription
*/

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">

	<title><?php 
    if(!is_search()){
        wp_title( '|', true, 'right' );
    }
    else{
        _e('Votre recherche pour ', '@@themeName');
    }
    ?></title>

	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon.png">
	
	<?php wp_head(); ?>
	
	<?php if(is_page_template('page-interactive-map.php')): ?>
        <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo acf_get_setting('google_api_key'); ?>"></script>
    <?php endif; ?>
    
	
	<?php if(get_field('tracker_ga', 'options')) : ?>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', '<?php the_field('tracker_ga', 'options'); ?>', 'auto');
		  ga('send', 'pageview');

		</script>
	<?php endif; ?>
</head>

<body <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">
	<div class="contain-overflow">
        <header class="main">
            <div class="container">
                <?php get_template_part('partials/header-nav'); ?>
            </div>
        </header>
        
        <div class="beforeContent container">
            <div class="logo">
                <?php if(!is_front_page()) : ?>
                    <a class="contain-logo not-standard" href="<?php echo home_url(); ?>">
                <?php endif; ?>
                <picture <?php if(is_front_page()){ echo 'class="contain-logo"';} ?>>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/logo_bruz.svg" alt="logo Ville de Bruz">
                </picture>
                <?php if(!is_front_page()) : ?>
                    </a>
                <?php endif; ?>
            </div>
            <h2><?php _e('Ville de Bruz', '@@themeName');?></h2>
        </div>