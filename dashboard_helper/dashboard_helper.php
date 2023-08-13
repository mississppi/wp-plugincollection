<?php

class DashBoardHelper
{
    public function __construct()
    {
        //posttype追加
        add_action('init', [$this, 'create_type'], 20);

        //ダッシュボードウィジェットへ登録
        add_action('admin_init', [$this, 'register_widget']);
    }

    public function create_type()
    {
        register_post_type(
            'dashboard_note',
            [
                'label' => 'ノート',
                'public' => true,
                'has_archive' => true,
                'show_in_rest' => true,
                'menu_position' => 20,
                'supports' => ['title','editor','thumbnail','revisions',],
            ]
        );
    }

    public function register_widget()
    {
        include_once("add_dashboard.php");
    }
}

new DashBoardHelper();