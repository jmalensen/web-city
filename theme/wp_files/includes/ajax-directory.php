<?php

add_action( 'wp_ajax_infinite_scroll_directory', 'infinite_scroll_directory' );
add_action( 'wp_ajax_nopriv_infinite_scroll_directory', 'infinite_scroll_directory' );

function infinite_scroll_directory() {

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
        'post_type' => 'directory',
        'posts_per_page' => 4,
        'offset' => $offset,
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
        
    if($directory->post_count > 0){
        $i=0;
        while($directory->have_posts()){ $directory->the_post(); 

            include(locate_template('partials/template-directory.php'));
            $i++;

        }
        
    }else{
        
        echo json_encode(false);
        
    }

	die();
}
