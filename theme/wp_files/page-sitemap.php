<?php
/*
* Template Name: Page plan du site
* Theme Name: @@prettyThemeName
* Author: @@themeAuthor
* Version: @@themeVersion
* Text Domain: @@themeName
* Description: Event archive template
*			   @@themeDescription
*/


get_header();
?>

<?php //------------MAIN CONTENT-----------------------?>

<main itemscope="itemscope" itemtype="http://schema.org/WebPageElement" itemprop="mainContentOfPage" class="siteMap">
    
    <?php get_template_part('partials/page', 'banner'); ?>
    
    <div class="container siteMap__container">
        
        <?php echo  do_shortcode('[wp_sitemap_page only="page"]'); ?> 
        
    </div>
    
</main>

<?php //------------END MAIN CONTENT-------------------?>

<?php get_footer(); ?>