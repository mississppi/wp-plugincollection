<?php

class CustomContentApi{

    public function __construct()
    {
        //各サイトごとの最新記事1件を返却
        add_action('rest_api_init', [$this, 'register_parameter'], 20);

        //独自のargsをカスタマイズできる
        // add_filter('rest_information_collection_params', [$this, 'add_param'],  25 ,2 );

        //独自のクエリをカスタマイズできる
        // add_filter('rest_information_query', [$this, 'add_query'], 25, 2);
    }

    // public function add_param($query_params, $post_type)
    // {
    //     $query_params['site'] = [
    //         'type'        => 'string',
    //     ];
    //     return $query_params;
    // }

    // public function add_query($args, $request)
    // {
    //     $param_value = filter_input(INPUT_GET, 'site');
    //     if(!empty($param_value)){
    //         $params = explode(',', $param_value);
    //         $args['site'] = $params;
    //         return $args;
    //     } else {
    //         return $args;
    //     }
    // }

    public function register_parameter()
    {
        register_rest_route( 
            'wp/v2',
            '/allinfo',
            [
                'methods' => 'GET', 
                'callback' => [$this, 'get_information_by_site'],
                'permission_callback' => [$this,'rest_permission'],
            ] 
        );
    }

    public function get_information_by_site($request)
    {
        $parameters = $request->get_query_params();
        $number = isset( $parameters['number'] ) ? (int) $parameters['number'] : 10;
        if( $number > 30 ) {
            $number = 30;
        }

        $items = [];
        $i = 0;
    
        $blogs = get_sites( [
            'orderby' => 'last_updated',
            'order'   => 'DESC',
            'number'  => (int) $number         
        ] );

        foreach ( $blogs as $blog ) {
            switch_to_blog( $blog->blog_id );
            // Site info
            $details =  get_blog_details( $blog->blog_id );
            $items[$i]['sitename'] = esc_html( $details->blogname );
            $items[$i]['siteid']   = (int) $blog->blog_id;
            $items[$i]['homeurl']  = esc_url( $details->home );

            // Latest post
            $args = [
                'orderby'                 => 'post_date',
                'order'                   => 'DESC',
                'posts_per_page'          => 1,
                'post_type'               => 'information',
                'post_status'             => 'publish',
                'ignore_sticky_posts'     => true,
                'no_found_rows'           => true,
                'update_post_term_cache'  => false,
                'update_post_meta_cache'  => false,
            ];

            $query = new WP_Query( $args );
            if( $query->have_posts() ) {
                while( $query->have_posts() ) {
                    $query->the_post();
                    // Title
                    $items[$i]['title']   = esc_html( get_the_title( get_the_ID() ) );

                    // Date
                    $items[$i]['date']    = esc_html( get_the_date( 'Y-m-d H:i:s', get_the_ID() ) );

                    // Unix time
                    $items[$i]['utime']   = esc_html( get_the_date( 'U', get_the_ID() ) );
                    
                    // Permalink
                    $items[$i]['url']    = esc_url( get_permalink( get_the_ID() ) );

                }
                wp_reset_postdata();
            }
            $i++;
            restore_current_blog();
        }
        
        // Sort by utime.
        $items = wp_list_sort( $items, 'utime', 'DESC' );
        $data = [
            'success' => true,
            'count'   => count( $items ),
            'items'   => $items,
        ];
        
        return $data;
    }

    public function rest_permission()
    {
        return true;
    }
}

new CustomContentApi();