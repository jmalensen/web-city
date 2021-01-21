<?php
/*
* Template Name: Page carte intéractive
* Theme Name: @@prettyThemeName
* Author: @@themeAuthor
* Version: @@themeVersion
* Text Domain: @@themeName
* Description: Event archive template
*			   @@themeDescription
*/

global $wp;
$page_url = home_url( $wp->request ).'#gmap';

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

<main itemscope="itemscope" itemtype="http://schema.org/WebPageElement" itemprop="mainContentOfPage" class="interactiveMap">
    
    <?php get_template_part('partials/page', 'banner'); ?>
    
    <section class="interactiveMap__search">
      
        <div class="container">
       
            <div class="category">

                <p class="category__title"><?php _e('Rechercher par catégorie :', '@@themeName'); ?></p>
                
                <?php 
                
                foreach(get_terms( array('taxonomy' => 'interest_point_category', 'hide_empty' => false,) ) as $cat): 
                
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
    
    <?php 
    $args = array(
        'post_type' => 'interest_point',
        'posts_per_page' => 6,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC',
    );

    if(!is_null($cat_param)){
        $args['tax_query'] =  array(
                            array(
                                'taxonomy' => 'interest_point_category',
                                'field' => 'slug',
                                'terms' => $cat_array,
                            )
                        );
    }

    if(!is_null($keyword)){
        $args['s'] =  $keyword;
    }

    $markers = array();

    $points = new WP_Query($args);
    if($points->post_count > 0){
        while($points->have_posts()){ $points->the_post(); 

            $post_id = get_the_id();

            $location = get_field('interest_point_loc', $post_id);
            $icon = get_template_directory_uri() . '/images/marker.png';

            $category = '<div class="infoWindow__category">';
            foreach(get_the_terms($post_id, 'interest_point_category') as $cat){

                $category = $category . '<span>' . $cat->name . '</span>';

            }
            $category = $category . '</div>';

            if(get_field('interest_point_website')){
                $link = '<a class="infoWindow__link" target="_blank" href="' . get_field('interest_point_website') . '">&gt; ' . __('lien vers le site', '@@themeName') . '</a>';
            }else{
                $link = '';
            }

            $infowindow_content = '<div class="infoWindow">

            ' . $category . '

            <h2 class="infoWindow__title">' . get_the_title() . '</h2>

            <div class="infoWindow__description">' . get_field('interest_point_description') . '</div>' .

            $link

            . '</div>';


            if( $location ) { 

                $markers[] = array(
                    'lat' => $location['lat'],
                    'lng' => $location['lng'],
                    'icon' => $icon,
                    'infoWindow' => array(
                        'ID' => $post_id,
                        'content' => $infowindow_content, 
                        'maxWidth' => 300,
                    ),
                );

            }

        }
    }else{
        $class_no_marker = 'no_marker';
    }
    wp_reset_postdata();
    ?>

    <script>
        //<![CDATA[
        CI_MARKERS = <?php echo json_encode($markers); ?>;
        //]]
    </script>
    
    <section class="interactiveMap__map <?php if(isset($class_no_marker)){ echo $class_no_marker; } ?>" id="gmap">
                  
        <div id="bruz-map"></div>
                   
        <?php if(isset($class_no_marker)): ?>
                  
            <p class="interactiveMap__map__message"><?php _e('Aucun point d\'intérêt trouvé pour cette recherche', '@@themeName'); ?></p>
                   
        <?php endif; ?>
                    
    </section>
	
</main>

<?php //------------END MAIN CONTENT-------------------?>

<?php get_footer(); ?>