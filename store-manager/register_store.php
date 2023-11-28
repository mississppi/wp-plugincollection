<?php

add_action('init', 'create_custom_post_type');
function create_custom_post_type() {
    register_post_type('stores',
        array(
            'labels' => array(
                'name' => 'Stores',
                'singular_name' => 'Store',
            ),
            'public' => true,
            'has_archive' => true,
            'show_in_rest' => true,
        )
    );
}