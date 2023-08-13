<?php

// ダッシュボード
add_action('wp_dashboard_setup', 'remove_dashboard_widget');
function remove_dashboard_widget() {
    remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' ); //サイトヘルスステータス
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); //概要
    remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' ); //アクティビティ
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); //クイックドラフト
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' ); //WordPressニュース
    remove_action( 'welcome_panel', 'wp_welcome_panel' ); //ようこそ
}

// フッターテキスト
add_filter('admin_footer_text', 'custom_admin_footer');
function custom_admin_footer() {
	echo '';
}

// フッターアップデート通知
add_filter('update_footer', 'custom_update_footer');
function custom_update_footer() {
    echo '';
}