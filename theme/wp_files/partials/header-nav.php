<div class="logo">
    <div class="mask"></div>
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

<a class="burger-menu not-standard" href="#">
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
</a>

<?php
$args = array (
	'theme_location' => 'main-nav',
	'container' 	 => false,
    'items_wrap'     => '%3$s',
    'walker'         => new Walker_Mobile_Menu() //use our custom walker
);
?>
<nav class="nav-main-menu">
    <div class="contain-menu">
        <ul id="main-menu" class="menu">
            <?php wp_nav_menu( $args ); ?>
        </ul>
        
        <?php //------------SEARCH-----------------------?>
        <div class="search">
            <div class="iconSearch">
                <div></div>
            </div>
            <?php get_search_form(); ?>
        </div>
        <?php //------------END SEARCH-----------------------?>
    </div>
</nav>