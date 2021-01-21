<?php
/*
* Template Name: Page d'archive annuaire
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
$keyword = null;

//Récupération des catégories en paramêtre
if(isset($_GET['cat']) && !empty($_GET['cat'])){
    $cat_param = $_GET['cat'];
    $cat_array = explode(',', $cat_param);
}

//Récupération du mot clé en paramêtre
if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
    $keyword = $_GET['keyword'];
}

get_header();
?>



<?php //------------MAIN CONTENT-----------------------?>

<main itemscope="itemscope" itemtype="http://schema.org/WebPageElement" itemprop="mainContentOfPage" class="archiveDirectory">
    
    <?php get_template_part('partials/page', 'banner'); ?>
    
    <section class="archiveDirectory__search" id="search-param" data-cat="<?php echo $cat_param; ?>" data-keyword="<?php echo $keyword; ?>">
      
        <div class="container">
       
            <div class="category">

                <p class="category__title"><?php _e('Rechercher par catégorie :', '@@themeName'); ?></p>
                
                <?php 
                
                foreach(get_terms( array('taxonomy' => 'directory_category', 'hide_empty' => false,) ) as $cat): 
                
                $cat_url = $page_url;
                
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
            
            <form role="search" method="get" action="<?php echo $page_url; ?>" class="keywordSearch">
              
                <?php if(!is_null($cat_param)): ?>
                    <input type="hidden" name="cat" value="<?php echo $cat_param; ?>" >
                <?php endif; ?>
               
                <input type="search" placeholder="<?php _e( 'rechercher par mot clé', '@@themeName' ) ?>" name="keyword" autocomplete="off" 
                value="<?php if(isset($keyword)){ echo $keyword; } ?>" />
                
                <input type="submit" value="<?php _e('Rechercher', '@@themeName'); ?>" />
                
            </form>
        
        </div>
        
    </section>
    
    <section class="archiveDirectory__list directory">
        
        <div class="container">
          
            <div id="directory-list">
           
            <?php 
            $args = array(
                'post_type' => 'directory',
                'posts_per_page' => 4,
                'post_status' => 'publish',
                'meta_key' => 'directory_name',
                'orderby' => 'meta_value',
                'order' => 'ASC',
            );
            
            if(!is_null($cat_param)){
                $args['tax_query'] =  array(
                                    array(
                                        'taxonomy' => 'directory_category',
                                        'field' => 'slug',
                                        'terms' => $cat_array,
                                    )
                                );
            }
            
            if(!is_null($keyword)){
                $args['s'] =  $keyword;
            }
                    
            $directory = new WP_Query($args);
            
            $i=0;
            while($directory->have_posts()){ $directory->the_post(); 
                
                include(locate_template('partials/template-directory.php'));
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