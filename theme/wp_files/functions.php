<?php

require_once('includes/useful-functions.php');
require_once('includes/wp-bootstrap-navwalker.php');
require_once('includes/boostrap_gravity_form.php');
require_once('includes/render-content-block-standard.php');
//require_once('includes/extend-search.php');
require_once('includes/ajax-event.php');
require_once('includes/ajax-directory.php');
require_once('includes/ajax-news.php');


add_action('after_setup_theme', 'setup_theme', 16);

function setup_theme() {

	/**
	 * Assets
	 */
	add_action('wp_enqueue_scripts', 'assets');
	function assets() {
		$css = array (
			'@@themeName_lib_css' => array('url' => get_template_directory_uri() . '/css/lib.css', 'deps' => array()),
			'@@themeName_main_css' => array('url' => get_template_directory_uri() . '/css/main.css', 'deps' => array('@@themeName_lib_css'))
		);

		foreach ($css as $css_name => $css){
			wp_enqueue_style($css_name, $css['url']);
		}
		
		$js = array (
			'@@themeName_lib' => array('url' => get_template_directory_uri() . '/js/lib.js', 'deps' => array('jquery')),
			'@@themeName_main' => array('url' => get_template_directory_uri() . '/js/main.js', 'deps' => array('@@themeName_lib'))
		);

		wp_enqueue_script('jquery');

		foreach ($js as $js_name => $js){
			wp_enqueue_script($js_name, $js['url'], $js['deps'], false, true);
		}
        
        // pass Ajax Url to main.js
        wp_localize_script('@@themeName_main', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
        
	}

	
	/**
	 * Handles JavaScript detection.
	 *
	 * Adds a js class to the root <html> element when JavaScript is detected.
	 *
	 * @since Twenty Sixteen 1.0
	 */
	add_action( 'wp_head', 'javascript_detection', 0 );
	function javascript_detection() {
		echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
	}

	
	/**
	 * I18n
	 */
	load_theme_textdomain('@@themeName', get_template_directory() . '/lang');

	
	/**
	 * Menus
	 */
	add_theme_support('menus');
	register_nav_menus(array(
		'main-nav' 	=> __('Menu principal', '@@themeName'),
		'footer-main-nav'  => __('Menu footer principal', '@@themeName'),
		'footer-secondary-nav'  => __('Menu footer secondaire', '@@themeName'),
	));
    
	/**
	 * Thumbnails
	 */
	add_theme_support('post-thumbnails');
    
    $hd_ratio = 1.2;
    
    add_image_size('current_news', 1920, 700, true);
    add_image_size('banner', 1920, 450, true);
    add_image_size('quick_access_small', 300*$hd_ratio, 180*$hd_ratio, true);
    add_image_size('quick_access_tall', 300*$hd_ratio, 300*$hd_ratio, true);
    add_image_size('quick_access_large', 620*$hd_ratio, 180*$hd_ratio, true);
    add_image_size('quick_access_mobile', 770, 380, true);
    add_image_size('home_event_desktop', 300, 300, true);
    add_image_size('event_mobile', 500, 400, true);
    add_image_size('event_list', 400, 250, true);
    add_image_size('news_list', 400, 250, true);
    

	/* Half retina == Full */
	add_image_size('content_full_desktop', 970, 0, true);
	add_image_size('content_full_desktop_retina', 1940, 0, true);
	add_image_size('content_half_desktop', 485, 0, true);
	add_image_size('content_full_tablet', 750, 0, true);
	add_image_size('content_full_tablet_retina', 1500, 0, true);
	add_image_size('content_half_tablet', 375, 0, true);
	add_image_size('content_full_mobile', 500, 0, true);
	add_image_size('content_full_mobile_retina', 1000, 0, true);
	add_image_size('content_half_mobile', 250, 0, true);

	
	/**
	 * Images
	 */
	add_filter('upload_mimes', 'allow_svg_mime_types');
	function allow_svg_mime_types( $mimes ){

		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
	
	/**
	 * Excerpt length
	 */
	add_filter('excerpt_length', 'custom_excerpt_length', 999);
	function custom_excerpt_length($length) {
		return 45;
	}

	/**
	 * Radio button taxonomy : disable default taxonomy
	 */
	//add_filter( 'radio-buttons-for-taxonomies-no-term-actor_category', '__return_FALSE' );
	//add_filter( 'radio-buttons-for-taxonomies-no-term-news_category', '__return_FALSE' );
	
	/**
	 * Theme setting
	 */
	if( function_exists('acf_add_options_page') ) {
	 
		acf_add_options_page(array(
			'page_title' 	=> __('Options Concept Image', '@@themeName'),
			'menu_title' 	=> __('Options Concept Image', '@@themeName'),
			'menu_slug' 	=> 'general-options',
		));
	}

	/**
	 * Admin : TinyMCE
	 */
	// Load front css into editor
	//add_editor_style('css/main.css');

	//== Add button format
	add_filter('tiny_mce_before_init', 'mce_add_btn_format');
	function mce_add_btn_format($init_array) {  

		$init_array['style_formats'] = json_encode(array(  
			array(  
				'title' => __('button', '@@themeName'),  
				'classes' => 'button',
				'selector' => 'a'
			)
		));
		return $init_array;
	}

    // Move Yoast to bottom
	add_filter( 'wpseo_metabox_prio', 'yoasttobottom');
	function yoasttobottom() {
		return 'low';
	}
    
    function my_acf_init() {
	
        acf_update_setting('google_api_key', 'AIzaSyCUTuYmfWspz_GDkwGmDPN8CLmzfYIjlAw');
    }

    add_action('acf/init', 'my_acf_init');
    
    
    // To show only this message in case, you have bad password ou bad username
    add_filter('login_errors', create_function('$no_login_error', "return 'Mauvais identifiants';"));
    
    
    // Remove comments of plugins in code
    function remove_html_comments_buffer_callback($buffer) {
        $buffer = preg_replace('/<!--[^\[\>\<](.|\s)*?-->/', '', $buffer);
        return $buffer;
    }
    function remove_html_comments_buffer_start() {
        ob_start("remove_html_comments_buffer_callback");
    }
    function remove_html_comments_buffer_end() {
        ob_end_flush();
    }
    add_action('template_redirect', 'remove_html_comments_buffer_start', -1);
    add_action('get_header', 'remove_html_comments_buffer_start'); 
    add_action('wp_footer', 'remove_html_comments_buffer_end', 999);
    
    
    class Walker_Mobile_Menu extends Walker_Nav_Menu {
        function start_lvl( &$output, $depth = 0, $args = array() ) {
            // $output correspond à la variable retournée en fin de walker
            // $depth correspond à la profondeur du niveau
            // $arg aux variable supplémentaires
            if($depth < 1){
                if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
                    $t = '';
                    $n = '';
                }
                else {
                    $t = "\t";
                    $n = "\n";
                }
                $indent = str_repeat( $t, $depth );

                // Default class.
                $classes = array( 'sub-menu' );

                /**
                 * Filters the CSS class(es) applied to a menu list element.
                 *
                 * @since 4.8.0
                 *
                 * @param array    $classes The CSS classes that are applied to the menu `<ul>` element.
                 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
                 * @param int      $depth   Depth of menu item. Used for padding.
                 */
                $class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
                $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

                $output .= "{$n}{$indent}<ul$class_names>{$n}";
            }
        }
        function end_lvl( &$output, $depth = 0, $args = array() ) {
            // $output correspond à la variable retournée en fin de walker
            // $depth correspond à la profondeur du niveau
            // $arg aux variable supplémentaires
            if($depth < 1){
                if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
                    $t = '';
                    $n = '';
                } else {
                    $t = "\t";
                    $n = "\n";
                }
                $indent = str_repeat( $t, $depth );

                $output .= "$indent</ul>{$n}";
            }
        }
        function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
            // $output correspond à la variable retournée en fin de walker
            // $item correspond aux information sur l'item en cours
            // $depth correspond à la profondeur du niveau
            // $arg aux variable supplémentaires
            
            $indent = ($depth) ? str_repeat( "\t", $depth ) : '';
            
            //Handle classes
            $class_names = $value = '';

            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-'.$item->ID;
            
            //Ajouter classe pour menu n2?
            if($depth == 1){
                $classes[] = 'subelement';
            }

            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
            
            //Handle ids
            $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
            $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
            
            
            //Prepare output
            $output .= $indent.'<li'.$id . $value . $class_names .'>';

            // MODIF 1
            // si le lien est vide...
            // ou s'il comment par '#' (ancre)...
            // alors la balise sera un 'span' ou lieu d'un 'a'
            $balise = ( ! empty( $item->url ) && substr( $item->url, 0, 1 ) != '#') ? 'a' : 'span';

            $atts = array();
            $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
            $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
            $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';

            // MODIF 2 : on ajoute l'URL seulement si c'est un lien
            if( 'a' == $balise )
                $atts['href']   = ! empty( $item->url ) ? $item->url : '';

            $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( ! empty( $value ) ) {
                    $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            // MODIF 3 : on remplace 'a' par $balise
            $item_output = $args->before;
            $item_output .= '<' . $balise . ''. $attributes .'>';
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            $item_output .= '</' . $balise . '>';
            
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
        function end_el( &$output, $item, $depth = 0, $args = array() ) {
            // $output correspond à la variable retournée en fin de walker
            // $item correspond aux information sur l'item en cours
            // $depth correspond à la profondeur du niveau
            // $arg aux variable supplémentaires
//            $output .= "\n";

//            $indent = ($depth) ? str_repeat( "\t", $depth ) : '';
            
//            var_dump($this->last_depth);
            
//            //Prepare output
//            if($depth == 0){
//                $output .= $indent.'</li>';
//            }
//            elseif($depth == 1){
//                $output .= $indent.'</li></ul>';
//            }
//            elseif($depth == 2){
//                $output .= $indent.'</li>';
//            }
            
//            var_dump($output);
        }
    }
    
    
    
    
}