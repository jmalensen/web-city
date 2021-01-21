<?php
/*
* Theme Name: @@prettyThemeName
* Author: @@themeAuthor
* Version: @@themeVersion
* Text Domain: @@themeName
* Description: Page template
*			   @@themeDescription
*/

get_header();?>

<?php //------------MAIN CONTENT-----------------------?>
<main>
    <?php get_template_part('partials/page-banner'); ?>
	<section class="main-content">
        <div class="container">
            <?php get_template_part('partials/aside', 'page'); ?>

            <article class="standard-content items">
                <?php get_template_part('partials/standard-content'); ?>
            </article>
        </div>
	</section>

</main>
<?php //------------END MAIN CONTENT-------------------?>

<?php get_footer(); ?>
