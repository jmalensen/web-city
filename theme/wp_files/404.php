<?php
/*
* Theme Name: @@prettyThemeName
* Author: @@themeAuthor
* Version: @@themeVersion
* Text Domain: @@themeName
* Description: 404 template
*			   @@themeDescription
*/

get_header(); ?>

<main class="page404" itemscope="itemscope" itemtype="http://schema.org/WebPageElement" itemprop="mainContentOfPage">
   
    <section class="page404__container">
           
        <h1><span>4</span><span>0</span><span>4</span></h1>

        <p>
            <?php _e('Cette page n\'existe pas', '@@themeName'); ?>.
        </p>
        
        <br>
        
        <p>
            <?php _e('Nous sommes désolé pour cette erreur', '@@themeName'); ?>.
        </p>
        
        <br>

        <p>
            <?php _e('Nous vous invitons à retourner sur la ', '@@themeName'); ?>
            <a href="<?php echo home_url() ?>"><?php _e('page d\'accueil', '@@themeName'); ?></a>	<?php _e('de notre site', '@@themeName'); ?>.
        </p>
            
    </section>
    
</main>

<?php get_footer(); ?>