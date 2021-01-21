<?php
/*
* Theme Name: @@prettyThemeName
* Author: @@themeAuthor
* Version: @@themeVersion
* Text Domain: @@themeName
* Description: Front page template
*			   @@themeDescription
*/

get_header(); ?>

<?php //------------MAIN CONTENT-----------------------?>

<main itemscope="itemscope" itemtype="http://schema.org/WebPageElement" itemprop="mainContentOfPage">
    
    <!--========== COMPOSANT ACTUALITE DU MOMENT ==========-->
    <?php 
        $image = get_field('home_news_img');
        if( !empty($image) ):

            // thumbnail
            $size = 'current_news';
            $thumb = $image['sizes'][ $size ];

            $bg_slide = "background-image: url('" . $thumb . "');";
    ?>
	<section class="currentNews" style="<?php echo $bg_slide; ?>">
	    <div class="container">
	        
	        <a href="<?php the_permalink(get_field('home_news_item')); ?>" class="currentNews__bloc">
               
                <p class="currentNews__category">
                    <span class="currentNews__category__item currentNews__category__item--white"><?php _e('Actualités', '@@themeName') ?></span>
                    
                    <?php foreach(get_the_category(get_field('home_news_item')) as $cat): ?>
                        <span class="currentNews__category__item"><?php echo $cat->name; ?></span>
                    <?php endforeach; ?>
                </p>
	            
	            <h2 class="currentNews__title">
	                <?php //Si un titre supplémentaire est défini, l'afficher sinon afficher le titre par défaut de l'actualité
                    if(get_field('home_news_title_1') || get_field('home_news_title_2')): ?>
	                    
	                    <?php if(get_field('home_news_title_1')){ ?> <span><?php the_field('home_news_title_1'); ?></span> <?php } ?>
	                    <br>
	                    <?php if(get_field('home_news_title_2')){ ?> <span><?php the_field('home_news_title_2'); ?></span> <?php } ?>
	                    
	                <?php else: ?>
	                    
	                    <span><?php echo get_the_title(get_field('home_news_item')); ?></span>
	                    
	                <?php endif; ?>	                
	            </h2>
	            
	            <?php if(get_field('home_news_intro')): ?>
                    <p class="currentNews__intro"><?php the_field('home_news_intro'); ?></p>
                <?php endif; ?>
                
                <div class="currentNews__button"></div>
	        </a>
	    </div>
	</section>
	<?php endif; ?>
	<!--========== FIN DU COMPOSANT ACTUALITE DU MOMENT ==========-->
	
	
	
	
	<!--========== COMPOSANT IMAGE ACCES RAPIDE & BRUZ EN CLIC ==========--> 
	<section class="usefulClic">
        <div class="container">
	        <h2><?php the_field('home_useful_title'); ?></h2>
	        
	        <?php 
            /* Récupération des groupes de champs "bloc pratique"
            * Pour ensuite les disposer dans différents Row pas possible avec une boucle while(have_rows()) classique
            */
            $list_bloc_useful = array();
            
            if(have_rows('home_useful_repeat')){
            
                while(have_rows('home_useful_repeat')){
                    the_row();
                    
                    $list_bloc_useful[] = get_sub_field('home_useful_bloc');
                }
                
            }
            
            $i=0;            
            ?>
            
            <div class="row usefulClic__row">
                <?php for($i; $i < 3; $i++): ?>
                <div class="col-sm-4 col-xs-12">
                    
                    <a href="<?php echo $list_bloc_useful[$i]['home_useful_bloc_link']; ?>" class="imageQuickAcces">
                        
                        <div class="imageQuickAcces__visual">
                            
                            <picture>
                                <source media="(max-width: 767px)" srcset="<?php echo $list_bloc_useful[$i]['home_useful_bloc_img']['sizes']['quick_access_mobile']; ?>">
                                <source media="(min-width: 768px)" srcset="<?php echo $list_bloc_useful[$i]['home_useful_bloc_img']['sizes']['quick_access_small']; ?>">
                                <img src="<?php echo $list_bloc_useful[$i]['home_useful_bloc_img']['sizes']['quick_access_small']; ?>" alt="<?php echo $list_bloc_useful[$i]['home_useful_bloc_img']['alt']; ?>">
                            </picture>
                            
                            <div class="imageQuickAcces__visual__over"></div>
                        </div>
                        
                        <div class="imageQuickAcces__info">
                            <?php echo $list_bloc_useful[$i]['home_useful_bloc_title']; ?>
                        </div>
                        
                    </a>
                    
                </div>
                <?php endfor; ?>
            </div>
            
            <div class="row usefulClic__row">
                <div class="col-sm-4 col-xs-12">
                    <a href="<?php echo $list_bloc_useful[$i]['home_useful_bloc_link']; ?>" class="imageQuickAcces">
                        
                        <div class="imageQuickAcces__visual">
                            <picture>
                                <source media="(max-width: 767px)" srcset="<?php echo $list_bloc_useful[$i]['home_useful_bloc_img']['sizes']['quick_access_mobile']; ?>">
                                <source media="(min-width: 768px)" srcset="<?php echo $list_bloc_useful[$i]['home_useful_bloc_img']['sizes']['quick_access_tall']; ?>">
                                <img src="<?php echo $list_bloc_useful[$i]['home_useful_bloc_img']['sizes']['quick_access_tall']; ?>" alt="<?php echo $list_bloc_useful[$i]['home_useful_bloc_img']['alt']; ?>">
                            </picture>
                            
                            <div class="imageQuickAcces__visual__over"></div>
                        </div>
                        
                        <div class="imageQuickAcces__info">
                            <?php echo $list_bloc_useful[$i]['home_useful_bloc_title']; $i++; ?>
                        </div>
                        
                    </a>
                </div>
                
                <div class="col-sm-8 col-xs-12">
                    <a href="<?php echo $list_bloc_useful[$i]['home_useful_bloc_link']; ?>" class="imageQuickAcces">
                        <div class="imageQuickAcces__visual">
                           
                            <picture>
                                <source media="(max-width: 767px)" srcset="<?php echo $list_bloc_useful[$i]['home_useful_bloc_img']['sizes']['quick_access_mobile']; ?>">
                                <source media="(min-width: 768px)" srcset="<?php echo $list_bloc_useful[$i]['home_useful_bloc_img']['sizes']['quick_access_large']; ?>">
                                <img src="<?php echo $list_bloc_useful[$i]['home_useful_bloc_img']['sizes']['quick_access_large']; ?>" alt="<?php echo $list_bloc_useful[$i]['home_useful_bloc_img']['alt']; ?>">
                            </picture>
                            
                            <div class="imageQuickAcces__visual__over"></div>
                        </div>
                        
                        <div class="imageQuickAcces__info">
                            <?php echo $list_bloc_useful[$i]['home_useful_bloc_title']; ?>
                        </div>
                    </a>
                    
                    <div class="oneClick">
                        <h3 class="oneClick__title"><?php _e('Bruz en 1 clic !', '@@themeName'); ?></h3>
                        
                        <div class="oneClick__shortcut">
                            <?php
                            if(have_rows('home_oneclick_repeat')):
                                while(have_rows('home_oneclick_repeat')): the_row();
                            
                                $current_bloc = get_sub_field('home_oneclick_bloc');
                            ?>
                            
                            <a href="<?php echo $current_bloc['home_oneclick_bloc_link']; ?>">
                                
                                <div class="icon-container"><?php echo file_get_contents($current_bloc['home_oneclick_bloc_img']); ?></div>
                                
                                <span><?php echo $current_bloc['home_oneclick_bloc_title']; ?></span>
                                
                            </a>
                            
                            <?php endwhile; endif; ?>
                        </div>
                    </div>
                </div>
                
            </div>
	    </div>
	</section>
	<!--========== FIN DU COMPOSANT BRUZ PRATIQUE & BRUZ EN CLIC ==========--> 
	
	
	
	
	
	<!--========== COMPOSANT BLOC DE RECHERCHE ==========--> 
	<section class="serchBloc">
	    <div class="container">
            <form role="search" method="get" action="<?php echo home_url( '/' ); ?>">
                <input type="search" placeholder="<?php _e( 'rechercher sur le site', '@@themeName' ) ?>" name="s" autocomplete="off" />
                
                <input type="submit" value="<?php _e('Rechercher', '@@themeName'); ?>" />
            </form>
            
            <?php if(have_rows('home_search_repeat')): ?>
            <div class="serchBloc__keyword">
                
                <?php while(have_rows('home_search_repeat')): the_row(); ?>
                
                    <a href="<?php echo home_url( '/' ); ?>?s=<?php echo urlencode(get_sub_field('home_search_keyword')); ?>" class="serchBloc__keyword__item">
                        <?php the_sub_field('home_search_keyword'); ?>
                    </a>
                
                <?php endwhile; ?>
                
            </div>
            <?php endif; ?>
	    </div>
	</section>
	<!--========== FIN DU COMPOSANT BLOC DE RECHERCHE ==========--> 
	
	
	
	
	<!--========== COMPOSANT EN CE MOMENT A BRUZ ==========--> 
	<section class="homeEvent">
	    
        <div class="container">
            
            <h2><?php the_field('home_now_title'); ?></h2>
            
            <div class="row">
                
                <div class="col-sm-5 col-xs-12 calendar">
                   
                    <?php echo do_shortcode('[ci_calendar archive-page-id="381" post-types="event" allowed-cpts="event" date-start-field-name="event_begin_date" date-end-field-name="event_end_date"]'); ?>
                    
                    <a href="<?php the_field('home_now_event_link'); ?>" class="calendar__seeAll"><?php _e('Voir tout l\'agenda', '@@themeName'); ?></a>
                    
                </div>
        
                <div class="col-sm-6 col-sm-offset-1 col-xs-12">
                    
                    <div class="event">
                    
                    <?php
                        
                    $total_event = 2;
                        
                    /*===== RECUPERER LES EVENEMENTS AVEC LA DATE DU JOUR EGALE A LA DATE DE DEBUT =======*/
                        
                    $args = array(
                        'post_type' => 'event',
                        'posts_per_page' => $total_event,
                        'post_status' => 'publish',
                        'meta_query'	=> array(
                            'relation'		=> 'AND',
                            array(
                                'key'	 	=> 'event_begin_date',
                                'value'	  	=> date('Ymd'),
                                'compare' 	=> '<=',
                            ),
                            array(
                                'key'	  	=> 'event_end_date',
                                'value'	  	=> null,
                                'compare' 	=> '=',
                            ),
                        ),
                    );

                    $events = new WP_Query($args);

                    if($events->post_count > 0):
                        
                        $total_event -= $events->post_count;
                        
                        while($events->have_posts()): $events->the_post(); 
                    ?>

                            <a href="<?php the_permalink(); ?>" class="event__item event__item--vertical">
                               
                                <?php 
                                    if(get_field('event_list_img')){
                                        $image = get_field('event_list_img');
                                    }else{
                                        $image = get_field('option_img_default_event', 'option');
                                    }
                                    
                                    if( !empty($image) ):

                                        // thumbnail
                                        $size = 'event_mobile';
                                        $thumb_mobile = $image['sizes'][ $size ];
                                        $size = 'home_event_desktop';
                                        $thumb_desktop = $image['sizes'][ $size ];
                                
                                        $alt = $image['alt'];

                                ?>
                                <div class="imgDate">

                                    <picture>
                                        <source media="(max-width: 767px)" srcset="<?php echo $thumb_mobile; ?>">
                                        <source media="(min-width: 768px)" srcset="<?php echo $thumb_desktop; ?>">
                                        <img src="<?php echo $thumb_desktop; ?>" alt="<?php echo $alt; ?>">
                                    </picture>
                                    
                                    <time class="<?php if(get_field('event_end_date')){ echo 'double'; } ?>">
                                        <span><?php echo str_replace(' ', '<small>', get_field('event_begin_date')) . '</small>';  ?></span>
                                        <?php if(get_field('event_end_date')): ?>
                                            <span><?php echo str_replace(' ', '<small>', get_field('event_end_date')) . '</small>';  ?></span>
                                        <?php endif; ?>
                                    </time>
                                    
                                    <div class="imgDate__over"></div>
                                    
                                </div>
                                <?php endif; ?>
                                
                                <div class="content">
                                
                                    <h3><?php the_title(); ?></h3>

                                    <p>&gt; <?php the_field('event_place'); ?></p>
                                    <?php if(get_field('event_time')): ?><p>&gt; <?php the_field('event_time'); ?></p><?php endif; ?>

                                    <div class="plus"></div>

                                </div>
                                
                            </a>

                    <?php endwhile; 
                    endif; 
                        
                    /*===== RECUPERER LES EVENEMENTS AVEC LA DATE DU JOUR COMPRIS ENTRE LA DATE DE DEBUT ET DE FIN =======*/
                    if($total_event > 0):
                        
                    $args = array(
                        'post_type' => 'event',
                        'posts_per_page' => $total_event,
                        'post_status' => 'publish',
                        'meta_query'	=> array(
                            'relation'		=> 'AND',
                            array(
                                'key'	 	=> 'event_begin_date',
                                'value'	  	=> date('Ymd'),
                                'compare' 	=> '<=',
                            ),
                            array(
                                'key'	  	=> 'event_end_date',
                                'value'	  	=> date('Ymd'),
                                'compare' 	=> '>=',
                            ),
                        ),
                    );

                    $events = new WP_Query($args);
                        
                    if($events->post_count > 0):
                        $total_event -= $events->post_count;
                        
                        while($events->have_posts()): $events->the_post(); 
                    ?>

                            <a href="<?php the_permalink(); ?>" class="event__item event__item--vertical">
                               
                                <?php 
                                    if(get_field('event_list_img')){
                                        $image = get_field('event_list_img');
                                    } else{
                                        $image = get_field('option_img_default_event', 'option');
                                    }
                                
                                    if( !empty($image) ):

                                        // thumbnail
                                        $size = 'event_mobile';
                                        $thumb_mobile = $image['sizes'][ $size ];
                                        $size = 'home_event_desktop';
                                        $thumb_desktop = $image['sizes'][ $size ];
                                
                                        $alt = $image['alt'];

                                ?>
                                <div class="imgDate">

                                    <picture>
                                        <source media="(max-width: 767px)" srcset="<?php echo $thumb_mobile; ?>">
                                        <source media="(min-width: 768px)" srcset="<?php echo $thumb_desktop; ?>">
                                        <img src="<?php echo $thumb_desktop; ?>" alt="<?php echo $alt; ?>">
                                    </picture>
                                    
                                    <time class="<?php if(get_field('event_end_date')){ echo 'double'; } ?>">
                                        <span><?php echo str_replace(' ', '<small>', get_field('event_begin_date')) . '</small>';  ?></span>
                                        <?php if(get_field('event_end_date')): ?>
                                            <span><?php echo str_replace(' ', '<small>', get_field('event_end_date')) . '</small>';  ?></span>
                                        <?php endif; ?>
                                    </time>
                                    
                                    <div class="imgDate__over"></div>
                                    
                                </div>
                                <?php endif; ?>
                                
                                <div class="content">
                                
                                    <h3><?php the_title(); ?></h3>

                                    <p>&gt; <?php the_field('event_place'); ?></p>
                                    <?php if(get_field('event_time')): ?><p>&gt; <?php the_field('event_time'); ?></p><?php endif; ?>

                                    <div class="plus"></div>

                                </div>
                                
                            </a>

                    <?php endwhile; 
                    endif;
                        
                    endif;
                        
                    if($total_event > 0):
                    
                    /*========= RECUPERER LES EVENEMENTS AVEC UNE DATE DE DEBUT LA PLUS PROCHE DE LA DATE DU JOUR ===========*/
                    $args = array(
                        'post_type' => 'event',
                        'posts_per_page' => $total_event,
                        'post_status' => 'publish',
                        'orderby' => 'event_begin_date',
                        'order' => 'ASC',
                        'meta_query'	=> array(
                            array(
                                'key'	 	=> 'event_begin_date',
                                'value'	  	=> date('Ymd'),
                                'compare' 	=> '>',
                            ),
                        ),
                    );
                        
                    $events = new WP_Query($args);

                    if($events->post_count > 0):
                        $total_event -= $events->post_count;
                        
                        while($events->have_posts()): $events->the_post();     
                    ?>
                    
                        <a href="<?php the_permalink(); ?>" class="event__item event__item--vertical">
                               
                            <?php 
                                
                                if(get_field('event_list_img')){
                                    $image = get_field('event_list_img');
                                } else{
                                    $image = get_field('option_img_default_event', 'option');
                                }
                                
                            
                                if( !empty($image) ):

                                    // thumbnail
                                    $size = 'event_mobile';
                                    $thumb_mobile = $image['sizes'][ $size ];
                                    $size = 'home_event_desktop';
                                    $thumb_desktop = $image['sizes'][ $size ];

                                    $alt = $image['alt'];
                            ?>
                            <div class="imgDate">

                                <picture>
                                    <source media="(max-width: 767px)" srcset="<?php echo $thumb_mobile; ?>">
                                    <source media="(min-width: 768px)" srcset="<?php echo $thumb_desktop; ?>">
                                    <img src="<?php echo $thumb_desktop; ?>" alt="<?php echo $alt; ?>">
                                </picture>

                                <time class="<?php if(get_field('event_end_date')){ echo 'double'; } ?>">
                                    <span><?php echo str_replace(' ', '<small>', get_field('event_begin_date')) . '</small>';  ?></span>
                                    <?php if(get_field('event_end_date')): ?>
                                        <span><?php echo str_replace(' ', '<small>', get_field('event_end_date')) . '</small>';  ?></span>
                                    <?php endif; ?>
                                </time>
                                
                                <div class="imgDate__over"></div>

                            </div>
                            <?php endif; ?>
                            
                            <div class="content">

                                <h3><?php the_title(); ?></h3>

                                <p>&gt; <?php the_field('event_place'); ?></p>
                                <?php if(get_field('event_time')): ?><p>&gt; <?php the_field('event_time'); ?></p><?php endif; ?>
                                
                                <div class="plus"></div>
                            
                            </div>

                        </a>
                    
                    <?php endwhile; 
                    endif;
                        
                    endif;
                    ?>
                    
                    </div>
                    
                    <?php wp_reset_postdata(); ?>
                    
                    <?php if(have_rows('option_footer_social', 'option')): ?>
                    <div class="social">
                        
                        <p><?php the_field('home_now_social_title'); ?></p>
                        
                        <div class="social__list">
                           
                            <?php 
                            while(have_rows('option_footer_social', 'option')): the_row(); 
                                $social_icon = get_sub_field('option_footer_social_icon', 'option');
                                if($social_icon):
                            ?>
                                <a href="<?php the_sub_field('option_footer_social_link', 'option'); ?>" target="_blank" title="<?php echo $social_icon['alt']; ?>">
                                    <?php echo file_get_contents($social_icon['url']); ?>
                                </a>
                            <?php endif; endwhile; ?>
                        
                        </div>
                        
                    </div>
                    <?php endif; ?>
                    
                </div>
                
            </div>
            
        </div>
	    
	</section>
	
	<!--========== FIN DU COMPOSANT EN CE MOMENT A BRUZ ==========--> 
	
	
	
	
	
	<!--========== COMPOSANT DECOUVRIR BRUZ ==========--> 
    <section class="discover">
       
        <?php if(get_field('home_discover_bg')): 
        
            $image = get_field('home_discover_bg_poster');
            if( !empty($image) ){

                // thumbnail
                $size = 'current_news';
                $thumb = $image['sizes'][ $size ]; 
                
                $poster = 'poster=' . $thumb; 
                
            }else{
                $poster = '';
            }
            ?>
        
            <video class="discover__video" autoplay playsinline loop preload="auto" muted <?php echo $poster; ?> >
                <source src="<?php the_field('home_discover_bg'); ?>" type="video/mp4">
            </video>
        
        <?php endif; ?>   
    
        <div class="container">
            
            <h2 class="discover__title"><?php the_field('home_discover_title'); ?></h2>
            
            <?php if(have_rows('home_discover_repeater_links')): ?>
            
                <div class="discover__list">
            
                    <?php while(have_rows('home_discover_repeater_links')): the_row(); ?>

                    <a href="<?php the_sub_field('home_discover_item_link'); ?>" class="discover__item">
                        <?php the_sub_field('home_discover_item_title'); ?>
                    </a>

                    <?php endwhile; ?>
                
                </div>
            
            <?php endif; ?>
            
            <div class="discover__list">

                <a href="<?php the_field('home_discover_btn_map_link'); ?>" class="discover__item">
                    <?php the_field('home_discover_btn_map_title'); ?>
                </a>

            </div>
            
        </div>
    </section>
	<!--========== FIN DU COMPOSANT DECOUVRIR BRUZ ==========--> 
	
	
	
	<!--========== COMPOSANT TRAVAILLER & ETUDIER A BRUZ ==========--> 
	<section class="workStudy">
        <div class="container">
        
	        <h2><?php the_field('home_workstudy_title'); ?></h2>
	        
	        <?php 
            /* Récupération des groupes de champs "bloc pratique"
            * Pour ensuite les disposer dans différents Row pas possible avec une boucle while(have_rows()) classique
            */
            $list_bloc_workStudy = array();
            
            if(have_rows('home_wordstudy_repeat')){
            
                while(have_rows('home_wordstudy_repeat')){
                    the_row();
                    
                    $list_bloc_workStudy[] = get_sub_field('home_workstudy_bloc');
                }
                
            }
            $i=0;
            ?>
            
            <div class="row workStudy__row">
               
                <div class="col-sm-4 col-xs-12">
                    
                    <a href="<?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_link']; ?>" class="imageQuickAcces">
                        
                        <div class="imageQuickAcces__visual">
                            
                            <picture>
                                <source media="(max-width: 767px)" srcset="<?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_img']['sizes']['quick_access_mobile']; ?>">
                                <source media="(min-width: 768px)" srcset="<?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_img']['sizes']['quick_access_small']; ?>">
                                <img src="<?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_img']['sizes']['quick_access_small']; ?>" alt="<?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_img']['alt']; ?>">
                            </picture>
                            
                            <div class="imageQuickAcces__visual__over"></div>
                        </div>
                        
                        <div class="imageQuickAcces__info">
                            <?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_title']; $i++; ?>
                        </div>
                        
                    </a>
                    
                </div>
                
                <div class="col-sm-8 col-xs-12">
                    
                    <a href="<?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_link']; ?>" class="imageQuickAcces">
                        
                        <div class="imageQuickAcces__visual">
                            
                            <picture>
                                <source media="(max-width: 767px)" srcset="<?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_img']['sizes']['quick_access_mobile']; ?>">
                                <source media="(min-width: 768px)" srcset="<?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_img']['sizes']['quick_access_large']; ?>">
                                <img src="<?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_img']['sizes']['quick_access_large']; ?>" alt="<?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_img']['alt']; ?>">
                            </picture>
                            
                            <div class="imageQuickAcces__visual__over"></div>
                        </div>
                        
                        <div class="imageQuickAcces__info">
                            <?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_title']; $i++; ?>
                        </div>
                        
                    </a>
                    
                </div>
                
            </div>
            
            <div class="row workStudy__row">
                
                <div class="col-sm-4 col-xs-12">
                    
                    <a href="<?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_link']; ?>" class="imageQuickAcces">
                        
                        <div class="imageQuickAcces__visual">
                            
                            <picture>
                                <source media="(max-width: 767px)" srcset="<?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_img']['sizes']['quick_access_mobile']; ?>">
                                <source media="(min-width: 768px)" srcset="<?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_img']['sizes']['quick_access_small']; ?>">
                                <img src="<?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_img']['sizes']['quick_access_small']; ?>" alt="<?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_img']['alt']; ?>">
                            </picture>
                            
                            <div class="imageQuickAcces__visual__over"></div>
                        </div>
                        
                        <div class="imageQuickAcces__info">
                            <?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_title']; $i++; ?>
                        </div>
                        
                    </a>
                    
                </div>
                
                <?php for($i; $i < 5; $i++): ?>
                
                <div class="col-sm-4 col-xs-12">
                    
                    <a href="<?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_link']; ?>" class="imageQuickAcces">
                        
                        <div class="imageQuickAcces__visual">
                            
                            <picture>
                                <source media="(max-width: 767px)" srcset="<?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_img']['sizes']['quick_access_mobile']; ?>">
                                <source media="(min-width: 768px)" srcset="<?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_img']['sizes']['quick_access_tall']; ?>">
                                <img src="<?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_img']['sizes']['quick_access_tall']; ?>" alt="<?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_img']['alt']; ?>">
                            </picture>
                            
                            <div class="imageQuickAcces__visual__over"></div>
                        </div>
                        
                        <div class="imageQuickAcces__info">
                            <?php echo $list_bloc_workStudy[$i]['home_workstudy_bloc_title'];  ?>
                        </div>
                        
                    </a>
                    
                </div>
                
                <?php endfor; ?>
                
            </div>
            
	    </div>
	</section>
	<!--========== COMPOSANT TRAVAILLER & ETUDIER A BRUZ ==========--> 
	
	
</main>

<?php //------------END MAIN CONTENT-------------------?>

<?php get_footer(); ?>