<?php

add_action('after_setup_theme', 'extend_search', 16);

function extend_search() {

    // TMP Search

    /**
     * Extend WordPress search to include custom fields
     *
     * http://adambalee.com
     */

    /**
     * Join posts and postmeta tables
     *
     * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
     */
    function cf_search_join( $join ) {
        global $wpdb;
        
        if(!is_admin()){
            $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
        }

        return $join;
    }
    add_filter('posts_join', 'cf_search_join' );

    /**
     * Modify the search query with posts_where
     *
     * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
     */
    function cf_search_where( $where ) {
        global $pagenow, $wpdb;

        if(!is_admin()){
            $where = preg_replace(
                "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
                "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
        }

        return $where;
    }
    add_filter( 'posts_where', 'cf_search_where' );

    /**
     * Prevent duplicates
     *
     * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
     */
    function cf_search_distinct( $where ) {
        global $wpdb;
        
        if(!is_admin()){
            return "DISTINCT";
        }

        return $where;
    }
    add_filter( 'posts_distinct', 'cf_search_distinct' );


    /**
     * Custom queries for home and categories pagination
     * https://codex.wordpress.org/Pagination
     */
    function custom_queries( $query ) {
        // do not alter the query on wp-admin pages and only alter it if it's the main query
        if (!is_admin() && $query->is_main_query()){

            $starred_post = get_field('post_star', get_option( 'page_for_posts' ));
        }
    }
    add_action( 'pre_get_posts', 'custom_queries' );
}