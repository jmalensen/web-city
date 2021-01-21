<?php

add_action( 'wp_ajax_infinite_scroll_news', 'infinite_scroll_news' );
add_action( 'wp_ajax_nopriv_infinite_scroll_news', 'infinite_scroll_news' );

function infinite_scroll_news() {

	global $post; 
    
    $cat_param = null;
    $cat_array = array();
    $keyword = null;

    //Récupération des catégories en paramêtre
    if(isset($_POST['cat']) && !empty($_POST['cat'])){
        $cat_param = $_POST['cat'];
        $cat_array = explode(',', $cat_param);
    }

    //Récupération du mot clé en paramêtre
    if(isset($_POST['keyword']) && !empty($_POST['keyword'])){
        $keyword = $_POST['keyword'];
    }

	$offset = $_POST['offset'];

	$args = array(
        'post_type' => 'post',
        'posts_per_page' => 4,
        'offset' => $offset,
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
        
    if($news->post_count > 0){
        $i=0;
        while($news->have_posts()){ $news->the_post(); 

            include(locate_template('partials/template-news.php'));
            $i++;

        }
    }
    else{
        echo json_encode(false);
    }

	die();
}
