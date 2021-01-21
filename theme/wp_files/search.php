<?php
/*
* Theme Name: @@prettyThemeName
* Author: @@themeAuthor
* Version: @@themeVersion
* Text Domain: @@themeName
* Description: Search template
*			   @@themeDescription
*/

get_header(); ?>

<main class="searchresults" itemscope="itemscope" itemtype="http://schema.org/WebPageElement" itemprop="mainContentOfPage">
    <section class="container">
        <div class="resultsSearch col-xs-12">
            
            <div class="contentR">
                <?php $s = isset($_GET['s']) ? htmlspecialchars($_GET['s'], ENT_QUOTES, "UTF-8") : false; ?>
                <h1 class="resultsSearch__title"><?php _e('Résultats de recherche pour', '@@themeName') ?> "<?php if($s){echo $s;} ?>"</h1>

                <?php if(!$s): ?>
                    <p class="resultsSearch__no-result"><?php _e('Veuillez saisir une recherche', '@@themeName') ?></p>
                <?php else: ?>
                
                <?php //------------RESULTS DIRECTORY-----------------------?>
                <section class="resultsSearch__type">
                    <h2 class="resultsSearch__type__title">
                        <span class="cursor"></span>
                        <span class="innerText"><?php _e('Entrée d\'annuaire', '@@themeName') ?></span>
                    </h2>

                    <?php  
                    global $the_page_query;
                    $the_page_query = new WP_Query(
                        array(
                            'post_type'       => 'directory',
                            's'               => $s,
                            'posts_per_page'  => -1,
                            'post_status'     => 'publish',
                            'orderby'         => 'name',
                        )
                    );

                    if($the_page_query->found_posts <= 0):
                    ?>
                    
                        <p class="resultsSearch__type__no-result"><?php _e('Pas de résultats', '@@themeName'); ?></p>
                        
                    <?php
                    else:
                        while ($the_page_query->have_posts()) : $the_page_query->the_post();
                    ?>
                        <a href="<?php echo home_url(); ?>/annuaire/?keyword=<?php echo urlencode(get_field('directory_name')); ?>" title="<?php _e('Lire plus', '@@themeName'); ?>" class="resultsSearch__type__item">
                            <h3 class="title"><?php the_field('directory_name'); ?></h3>
                            <div class="excerpt"><?php the_field('directory_description'); ?></div>
                        </a>
                    <?php 
                        endwhile; 
                    endif; ?>
                </section>
                <?php //------------END RESULTS DIRECTORY-----------------------?>
                
                <?php //------------RESULTS NEWS-----------------------?>
                <section class="resultsSearch__type">
                    <h2 class="resultsSearch__type__title">
                        <span class="cursor"></span>
                        <span class="innerText"><?php _e('Actualités', '@@themeName') ?></span>
                    </h2>

                    <?php  
                    global $the_page_query;
                    $the_page_query = new WP_Query(
                        array(
                            'post_type'       => 'post',
                            's'               => $s,
                            'posts_per_page'  => -1,
                            'post_status'     => 'publish',
                            'orderby'         => 'name',
                        )
                    );

                    if($the_page_query->found_posts <= 0):
                    ?>
                    
                        <p class="resultsSearch__type__no-result"><?php _e('Pas de résultats', '@@themeName'); ?></p>
                        
                    <?php
                    else:
                        while ($the_page_query->have_posts()) : $the_page_query->the_post();
                    ?>
                        <a href="<?php the_permalink(); ?>" title="<?php _e('Lire plus', '@@themeName'); ?>" class="resultsSearch__type__item">
                            <h3 class="title"><?php the_title(); ?></h3>
                            <div class="excerpt"><?php the_excerpt(); ?></div>
                        </a>
                    <?php 
                        endwhile; 
                    endif; ?>
                </section>
                <?php //------------END RESULTS NEWS-----------------------?>
                
                <?php //------------RESULTS EVENTS-----------------------?>
                <section class="resultsSearch__type">
                    <h2 class="resultsSearch__type__title">
                        <span class="cursor"></span>
                        <span class="innerText"><?php _e('Évènements', '@@themeName') ?></span>
                    </h2>

                    <?php  
                    global $the_page_query;
                    $the_page_query = new WP_Query(
                        array(
                            'post_type'       => 'event',
                            's'               => $s,
                            'posts_per_page'  => -1,
                            'post_status'     => 'publish',
                            'orderby'         => 'name',
                        )
                    );

                    if($the_page_query->found_posts <= 0):
                    ?>
                    
                        <p class="resultsSearch__type__no-result"><?php _e('Pas de résultats', '@@themeName'); ?></p>
                        
                    <?php
                    else:
                        while ($the_page_query->have_posts()) : $the_page_query->the_post();
                    ?>
                        <a href="<?php the_permalink(); ?>" title="<?php _e('Lire plus', '@@themeName'); ?>" class="resultsSearch__type__item">
                            <h3 class="title"><?php the_title(); ?></h3>
                            <div class="excerpt"><?php the_excerpt(); ?></div>
                        </a>
                    <?php 
                        endwhile; 
                    endif; ?>
                </section>
                <?php //------------END RESULTS EVENTS-----------------------?>
                
                    
                <?php //------------RESULTS PAGES-----------------------?>
                <section class="resultsSearch__type">
                    <h2 class="resultsSearch__type__title">
                        <span class="cursor"></span>
                        <span class="innerText"><?php _e('Pages', '@@themeName') ?></span>
                    </h2>

                    <?php  
                    global $the_page_query;
                    $the_page_query = new WP_Query(
                        array(
                            'post_type'       => 'page',
                            's'               => $s,
                            'posts_per_page'  => -1,
                            'post_status'     => 'publish',
                            'orderby'         => 'name',
                        )
                    );

                    if($the_page_query->found_posts<=0):
                    ?>

                        <p class="resultsSearch__no-result"><?php _e('Pas de résultats', '@@themeName'); ?></p>

                    <?php 
                    else:
                        while ($the_page_query->have_posts()) : $the_page_query->the_post();
                    ?>
                        <a href="<?php the_permalink(); ?>" title="<?php _e('Lire plus', '@@themeName'); ?>" class="resultsSearch__type__item">
                            <h3 class="title"><?php the_title(); ?></h3>
                            
                            <?php
                            if(get_field('content_excerpt')):
                            ?>
                                <div class="excerpt">
                                    <?php the_field('content_excerpt'); ?>
                                </div>
                            <?php
                            endif;
                            ?>
                        </a>
                    <?php 
                        endwhile; 
                    endif; ?>
                </section>
                <?php //------------END RESULTS PAGES-----------------------?>
                <?php endif; ?>
            </div>
            
        </div>
        <div class="clearfix"></div>
    </section>
    
    <div class="clearfix"></div>
</main>

<?php get_footer(); ?>
