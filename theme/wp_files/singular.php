<?php
/*
* Theme Name: @@prettyThemeName
* Author: @@themeAuthor
* Version: @@themeVersion
* Text Domain: @@themeName
* Description: Singular template
*			   @@themeDescription
*/

get_header(); ?>

<?php //------------MAIN CONTENT-----------------------?>
<main>
    <?php get_template_part('partials/page-banner'); ?>
	<section class="main-content container">

        <article class="standard-content standard-content--onecol items">
            <?php get_template_part('partials/standard-content'); ?>
        </article>
    
	</section>
</main>
<?php //------------END MAIN CONTENT-------------------?>

<?php get_footer(); ?>
