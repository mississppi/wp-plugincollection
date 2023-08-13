<?php

class AdminHelper
{
    public function __construct()
    {
        //メニュー非表示
        add_action('admin_init', [$this, 'handle_register_custom_admin'], 200);

        //ダッシュボード > アップデート通知の非表示
        add_action('admin_init', [$this, 'hide_update_mag'] , 300);
        
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