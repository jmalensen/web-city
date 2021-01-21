<?php
/*
* Theme Name: @@prettyThemeName
* Author: @@themeAuthor
* Version: @@themeVersion
* Text Domain: @@themeName
* Description: Home template
*			   @@themeDescription
*/
get_header(); ?>

<?php //------------MAIN CONTENT-----------------------?>

<main itemscope="itemscope" itemtype="http://schema.org/WebPageElement" itemprop="mainContentOfPage">
    
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('partials/list', 'loop'); ?>
        <?php endwhile; ?>

        <?php if(function_exists('wp_pagenavi')) : ?>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <?php wp_pagenavi(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    <?php else : ?>
        <article class="list-item container">
            <div class="row">
                <div class="col-xs-12">
                    <?php _e('No content find', '@@themeName'); ?>
                </div>
            </div>
        </article>
    <?php endif;?>
</main>
<?php //------------END MAIN CONTENT-------------------?>

<?php get_footer(); ?>