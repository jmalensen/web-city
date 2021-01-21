<?php

add_action( 'wp_ajax_infinite_scroll_event', 'infinite_scroll_event' );
add_action( 'wp_ajax_nopriv_infinite_scroll_event', 'infinite_scroll_event' );

function infinite_scroll_event() {

	global $post; 
    
    $cat_param = null;
    $cat_array = array();
    $begin_date = null;
    $end_date = null;
    $keyword = null;

    //Récupération des catégories en paramêtre
    if(isset($_POST['cat']) && !empty($_POST['cat'])){
        $cat_param = $_POST['cat'];
        $cat_array = explode(',', $cat_param);
    }

    //Récupération date de début en paramêtre
    if(isset($_POST['bdate']) && !empty($_POST['bdate'])){
        $begin_date = $_POST['bdate'];
    }

    //Récupération date de fin en paramêtre
    if(isset($_POST['edate']) && !empty($_POST['edate'])){
        $end_date = $_POST['edate'];
    }

    //Récupération du mot clé en paramêtre
    if(isset($_POST['keyword']) && !empty($_POST['keyword'])){
        $keyword = $_POST['keyword'];
    }

	$offset = $_POST['offset'];

	$args = array(
        'post_type' => 'event',
        'posts_per_page' => 4,
        'offset' => $offset,
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
        
    if($events->post_count > 0){
        $i=0;
        while($events->have_posts()){ $events->the_post(); 

            include(locate_template('partials/template-event.php'));
            $i++;

        }
        
    }else{
        
        echo json_encode(false);
        
    }

	die();
}
