<?php
/*
* Template Name: Page d'archive des News (liste)
* Theme Name: @@prettyThemeName
* Author: @@themeAuthor
* Version: @@themeVersion
* Text Domain: @@themeName
* Description: News archive template
*			   @@themeDescription
*/
$page_url = home_url( $wp->request );

$cat_param = null;
$cat_array = array();
$keyword = null;

//Get cat in parameters
if(isset($_GET['cat']) && !empty($_GET['cat'])){
    $cat_param = htmlspecialchars($_GET['cat']);
    $cat_array = explode(',', $cat_param);
}

//Get key in parameters
if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
    $keyword = htmlspecialchars($_GET['keyword']);
}

get_header(); ?>

<?php //------------MAIN CONTENT-----------------------?>

<main itemscope="itemscope" itemtype="http://schema.org/WebPageElement" itemprop="mainContentOfPage" class="page-news">
    
    <?php get_template_part('partials/page', 'banner'); ?>
    
    <section class="page-news__search">
      
        <div class="container">
            <div class="category">
                <p class="category__title"><?php _e('Rechercher par catégorie :', '@@themeName'); ?></p>
                
                <?php
                    $categories = get_categories( array(
                        'orderby' => 'name',
                        'order'   => 'ASC',
                        'hide_empty' => false,
                        'exclude' => '1'
                    ) );
                    
                    foreach($categories as $cat): 

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
                            }
                            else{

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
                        }
                        else{
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
               
                <input type="search" placeholder="<?php _e( 'Rechercher par mot clé', '@@themeName' ) ?>" name="keyword" autocomplete="off" 
                value="<?php if(isset($keyword)){ echo $keyword; } ?>" />
                
                <input type="submit" value="<?php _e('Rechercher', '@@themeName'); ?>" />
            </form>
        </div>
    </section>
    
    
    <section class="page-news__list news">
        <div class="container contain-news">
            <?php 
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 6,
                'post_status' => 'publish',
                'order' => 'DESC',
            );
            
            if(!is_null($cat_param)){
                $args['category_name'] =  $cat_param;
            }
            
            if(!is_null($keyword)){
                $args['s'] =  $keyword;
            }

            $news = new WP_Query($args);
            
            while($news->have_posts()): $news->the_post(); 
            ?>
                <a href="<?php the_permalink(); ?>" class="news__item">
                               
                    <?php 
                        if(get_field('news_list_img')){
                            $image = get_field('news_list_img');
                        }
                        else{
                            $image = get_field('option_img_default_news', 'option');
                        }

                        if( !empty($image) ):

                            // thumbnail
                            $size = 'quick_access_mobile';
                            $thumb_mobile = $image['sizes'][ $size ];
                            $size = 'quick_access_tall';
                            $thumb_desktop = $image['sizes'][ $size ];

                            $alt = $image['alt'];

                    ?>
                    <div class="imgDate">

                        <picture>
                            <source media="(max-width: 767px)" srcset="<?php echo $thumb_mobile; ?>">
                            <source media="(min-width: 768px)" srcset="<?php echo $thumb_desktop; ?>">
                            <img src="<?php echo $thumb_desktop; ?>" alt="<?php echo $alt; ?>" />
                        </picture>

                        <div class="cat">
                            <?php
                                $i = 0;
                                foreach(get_the_category() as $catNews):
                                    if($i < 2):
                                        $catNews_url = add_query_arg('cat', $catNews->slug, $page_url);
                            ?>
                            
                                <p class="cat__item"><?php echo $catNews->name; ?></p>
                            
                            <?php 
                                    endif;
                                    $i++;
                                endforeach;
                            ?>
                        </div>

                        <div class="imgDate__over"></div>
                    </div>
                    <?php endif; ?>

                    <div class="content">

                        <h3><?php the_title(); ?></h3>

                        <?php $description = get_field('news_list_description');?>
                        <p><?php echo $description;?></p>
                        <div class="plus"></div>
                    </div>
                </a>
                
            <?php endwhile;
            wp_reset_postdata();
            ?>
            
        </div>
    </section>
</main>
<?php //------------END MAIN CONTENT-------------------?>

<?php get_footer(); ?>