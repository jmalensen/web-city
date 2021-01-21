<?php
/*
* Template Name: Page d'archive des événements (liste des événements)
* Theme Name: @@prettyThemeName
* Author: @@themeAuthor
* Version: @@themeVersion
* Text Domain: @@themeName
* Description: Event archive template
*			   @@themeDescription
*/

global $wp;
$page_url = home_url( $wp->request );

$cat_param = null;
$cat_array = array();
$begin_date = null;
$end_date = null;
$keyword = null;

//Récupération des catégories en paramêtre
if(isset($_GET['cat']) && !empty($_GET['cat'])){
    $cat_param = $_GET['cat'];
    $cat_array = explode(',', $cat_param);
}

//Récupération date de début en paramêtre
if(isset($_GET['bdate']) && !empty($_GET['bdate'])){
    $begin_date = $_GET['bdate'];
}

//Récupération date de fin en paramêtre
if(isset($_GET['edate']) && !empty($_GET['edate'])){
    $end_date = $_GET['edate'];
}

//Si on l'utilisateur arrive depuis une date du calendrier
if(isset($_GET['date']) && !empty($_GET['date'])){
    $begin_date = $_GET['date'];
    $end_date = $_GET['date'];
}

//Récupération du mot clé en paramêtre
if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
    $keyword = $_GET['keyword'];
}

get_header();
?>



<?php //------------MAIN CONTENT-----------------------?>

<main itemscope="itemscope" itemtype="http://schema.org/WebPageElement" itemprop="mainContentOfPage" class="archiveEvent">
    
    <?php get_template_part('partials/page', 'banner'); ?>
    
    <section class="archiveEvent__search" id="search-param" data-cat="<?php echo $cat_param; ?>" data-bdate="<?php echo $begin_date; ?>" data-edate="<?php echo $end_date; ?>" data-keyword="<?php echo $keyword; ?>">
      
        <div class="container">
       
            <div class="category">

                <p class="category__title"><?php _e('Rechercher par catégorie :', '@@themeName'); ?></p>
                
                <?php 
                foreach(get_categories() as $cat): 
                
                $cat_url = $page_url;
                
                if(!is_null($begin_date)){
                    $cat_url = add_query_arg('bdate', $begin_date, $cat_url);
                }
                
                if(!is_null($end_date)){
                    $cat_url = add_query_arg('edate', $end_date, $cat_url);
                }
                
                if(!is_null($keyword)){
                    $cat_url = add_query_arg('keyword', $keyword, $cat_url);
                }
                
                $cat_active=false;
                if(!is_null($cat_param)){
                    
                    $final_cat=null;
                    $temp_cat_array = $cat_array;
                    
                    if(in_array($cat->slug, $cat_array)){
                        
                        $cat_active = true;
                        
                        unset($temp_cat_array[array_search($cat->slug, $temp_cat_array)]);
                        
                        $i=0;
                        foreach($temp_cat_array as $temp_cat){
                            
                            if($i==0){
                                $final_cat = $temp_cat;
                            }else{
                                $final_cat = $final_cat . ',' . $temp_cat;
                            }
                            
                            $i++;
                            
                        }
                        
                    }else{
                        
                        $temp_cat_array[] = $cat->slug;
                        
                        $i=0;
                        foreach($temp_cat_array as $temp_cat){
                            
                            if($i==0){
                                $final_cat = $temp_cat;
                            }else{
                                $final_cat = $final_cat . ',' . $temp_cat;
                            }
                            
                            $i++;
                            
                        }
                        
                    }
                    
                    if(!is_null($final_cat)){
                        $cat_url = add_query_arg('cat', $final_cat, $cat_url);
                    }
                    
                }else{
                    
                    $cat_url = add_query_arg('cat', $cat->slug, $cat_url);
                    
                }
                
                ?>
                
                    <a href="<?php echo $cat_url; ?>" class="category__item <?php if($cat_active){ echo 'category__item--active'; } ?>"><?php echo $cat->name; ?></a>
                
                <?php endforeach; ?>

            </div>
            
            <form role="search" method="get" action="<?php echo $page_url; ?>" class="dateSearch">
              
                <?php /*<p class="dateSearch__title"><?php _e('recherche un événement par date', '@@themeName'); ?></p>*/?>
                  
                <?php if(!is_null($keyword)): ?>
                    <input type="hidden" name="keyword" value="<?php echo $keyword; ?>" >
                <?php endif; ?>
                
                <?php if(!is_null($cat_param)): ?>
                    <input type="hidden" name="cat" value="<?php echo $cat_param; ?>" >
                <?php endif; ?>
                
                <div class="fieldGroup">
                    <label>du</label>
                    <input type="date" min="<?php echo date('Y-m-d'); ?>"  name="bdate" autocomplete="off" 
                    value="<?php if(isset($begin_date)){ echo $begin_date; } ?>" />
                </div> 
                
                <div class="fieldGroup fieldGroup--second">
                    <label>au</label>
                    <input type="date" min="<?php echo date('Y-m-d'); ?>" name="edate" autocomplete="off" 
                    value="<?php if(isset($end_date)){ echo $end_date; } ?>" />
                </div>
                
                <input type="submit" value="<?php _e('ok', '@@themeName'); ?>" />
                
            </form>
            
            <form role="search" method="get" action="<?php echo $page_url; ?>" class="keywordSearch">
              
                <?php if(!is_null($begin_date)): ?>
                    <input type="hidden" name="bdate" value="<?php echo $begin_date; ?>" >
                <?php endif; ?>
                
                <?php if(!is_null($end_date)): ?>
                    <input type="hidden" name="edate" value="<?php echo $end_date; ?>" >
                <?php endif; ?>
                
                <?php if(!is_null($cat_param)): ?>
                    <input type="hidden" name="cat" value="<?php echo $cat_param; ?>" >
                <?php endif; ?>
               
                <input type="search" placeholder="<?php _e( 'rechercher par mot clé', '@@themeName' ) ?>" name="keyword" autocomplete="off" 
                value="<?php if(isset($keyword)){ echo $keyword; } ?>" />
                
                <input type="submit" value="<?php _e('Rechercher', '@@themeName'); ?>" />
                
            </form>
        
        </div>
        
    </section>
    
    <section class="archiveEvent__list event">
        
        <div class="container">
          
            <div id="event-list">
           
            <?php 
            $args = array(
                'post_type' => 'event',
                'posts_per_page' => 4,
                'post_status' => 'publish',
                'meta_key' => 'event_begin_date',
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
            );
            
            if(!is_null($cat_param)){
                $args['category_name'] =  $cat_param;
            }
            
            if(!is_null($keyword)){
                $args['s'] =  $keyword;
            }
            
            
            if(is_null($begin_date) && is_null($end_date)){
                
                $meta_query = array(
                    'relation'		=> 'OR',
                    array(
                        'relation'		=> 'AND',
                        array(
                            'key'	 	=> 'event_begin_date',
                            'value'	  	=> date('Ymd'),
                            'compare' 	=> '>=',
                        ),
                        array(
                            'key'	  	=> 'event_end_date',
                            'value'	  	=> '',
                            'compare' 	=> '=',
                        ),
                    ),
                    array(
                        'relation'		=> 'AND',
                        array(
                            'key'	  	=> 'event_end_date',
                            'value'	  	=> date('Ymd'),
                            'compare' 	=> '>=',
                        ),
                        array(
                            'key'	  	=> 'event_end_date',
                            'value'	  	=> '',
                            'compare' 	=> '!=',
                        ),
                    ),
                );
                
            }elseif(!is_null($begin_date) && is_null($end_date)){
                
                $meta_query = array(
                    'relation'		=> 'OR',
                    array(
                        'relation'		=> 'AND',
                        array(
                            'key'	 	=> 'event_begin_date',
                            'value'	  	=> str_replace('-', '', $begin_date),
                            'compare' 	=> '<=',
                        ),
                        array(
                            'key'	  	=> 'event_end_date',
                            'value'	  	=> str_replace('-', '', $begin_date),
                            'compare' 	=> '>=',
                        ),
                        array(
                            'key'	  	=> 'event_end_date',
                            'value'	  	=> '',
                            'compare' 	=> '!=',
                        ),
                    ),
                    array(
                        'relation'		=> 'AND',
                        array(
                            'key'	 	=> 'event_begin_date',
                            'value'	  	=> str_replace('-', '', $begin_date),
                            'compare' 	=> '>=',
                        ),
                        array(
                            'key'	  	=> 'event_end_date',
                            'value'	  	=> '',
                            'compare' 	=> '=',
                        ),
                    ),
                );
                
            }elseif(is_null($begin_date) && !is_null($end_date)){
                
                $meta_query = array(
                    'relation'		=> 'OR',
                    array(
                        array(
                            'key'	  	=> 'event_end_date',
                            'value'	  	=> str_replace('-', '', $end_date),
                            'compare' 	=> '<=',
                        ),
                        array(
                            'key'	  	=> 'event_end_date',
                            'value'	  	=> '',
                            'compare' 	=> '!=',
                        ),
                    ),
                    array(
                        'relation'		=> 'AND',
                        array(
                            'key'	 	=> 'event_begin_date',
                            'value'	  	=> array(date('Ymd'), str_replace('-', '', $end_date)),
                            'compare' 	=> 'BETWEEN',
                        ),
                        array(
                            'key'	  	=> 'event_end_date',
                            'value'	  	=> '',
                            'compare' 	=> '=',
                        ),
                    ),
                );
                
            }else{
                
                $meta_query = array(
                    'relation'		=> 'OR',
                    array(
                        'relation'		=> 'AND',
                        array(
                            'key'	  	=> 'event_end_date',
                            'value'	  	=> array(str_replace('-', '', $begin_date), str_replace('-', '', $end_date)),
                            'compare' 	=> 'BETWEEN',
                        ),
                        array(
                            'key'	  	=> 'event_end_date',
                            'value'	  	=> '',
                            'compare' 	=> '!=',
                        ),
                    ),
                    array(
                        'relation'		=> 'AND',
                        array(
                            'key'	 	=> 'event_begin_date',
                            'value'	  	=> array(str_replace('-', '', $begin_date), str_replace('-', '', $end_date)),
                            'compare' 	=> 'BETWEEN',
                        ),
                        array(
                            'key'	  	=> 'event_end_date',
                            'value'	  	=> '',
                            'compare' 	=> '=',
                        ),
                    ),
                );
                                
            }
            
            $args['meta_query'] =  $meta_query;
            

            $events = new WP_Query($args);
                $i=0;
            while($events->have_posts()){ $events->the_post(); 
                                         
                include(locate_template('partials/template-event.php'));
                $i++;
            }
            wp_reset_postdata();
            ?>
            
            </div>
            
        </div>
        
    </section>
	
</main>

<?php //------------END MAIN CONTENT-------------------?>

<?php get_footer(); ?>