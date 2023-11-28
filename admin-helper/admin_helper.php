<?php

class AdminHelper
{
    public function __construct()
    {
        //メニュー非表示
        add_action('admin_init', [$this, 'handle_register_custom_admin'], 200);

        //ダッシュボード > アップデート通知の非表示
        add_action('admin_init', [$this, 'hide_update_mag'] , 300);

        add_action('admin_menu', [$this, 'custom_leftnavi']);

        add_action('admin_init', [$this, 'my_admin_add_help_tab']);

        add_action('admin_print_styles', [$this,'admin_print_styles'], 21);

        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);

        //レフトナビ
        // add_action('admin_init', [$this, 'hide_leftnavi'], 10);
        
    }

    function enqueue_scripts(){
        wp_enqueue_script('my_admin_script', get_template_directory_uri() . '/js/wp_editr.js', '', '', true);
    }

    function admin_print_styles(){
        echo '<style type="text/css">';
        echo '#contextual-help-link-wrap,';
        echo '#wpfooter';
        echo '{display:none !important;}';
        echo '</style>';
    }

    // ヘルプタブのコンテンツを追加します。
    function my_admin_add_help_tab () {
        // $title = 'ダッシュボードにヘルプを追加してみた①';
        // $content = '<p>追加した説明文</p>';
    
        // get_current_screen()->add_help_tab( array(
        //     'id'    => 'my_help_tab',
        //     'title' => __('My Help Tab'),
        //     'content'   => '<p>' . __( 'Descriptive content that will show in My Help Tab-body goes here.' ) . '</p>',
        // ) );
        // $WP_Screen = new WP_Screen();
        // var_dump($WP_Screen); exit;
        // global $current_screen;
        // var_dump($current_screen); exit;
    }

    function custom_leftnavi(){
        global $menu;
        global $submenu;
        // var_dump($submenu); exit;

        // メニュー
        // unset($menu[2]); // ダッシュボード
        // unset($menu[5]); // 投稿
        // unset($menu[10]); // メディア
        // unset($menu[20]); // 固定ページ
        // unset($menu[25]); // コメント
        // unset($menu[60]); // 外観
        // unset($menu[65]); // プラグイン
        // unset($menu[70]); // ユーザー
        // unset($menu[75]); // ツール
        // unset($menu[80]); // 設定

        // サブメニュー
        remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );//「投稿」の「タグ」
        remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' );//「投稿」の カテゴリ
        remove_submenu_page( 'update-core.php', 'edit-tags.php?taxonomy=category' );//「投稿」の カテゴリ



    }

    public function handle_register_custom_admin()
    {
        //ヘッダーメニュー
        include_once("remove_admin_bar_menu.php");

        //ダッシュボード
        include_once("remove_dashboard_menu.php");
    }

    public function hide_update_mag()
    {
        remove_action( 'admin_notices',         'update_nag', 3 );
		remove_action( 'network_admin_notices', 'update_nag', 3 );
    }
}

new AdminHelper();