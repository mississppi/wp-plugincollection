<?php

add_action('admin_bar_menu', 'remove_bar_menus', 201);
function remove_bar_menus( $wp_admin_bar ) {
    $wp_admin_bar->remove_menu('wp-logo'); // WordPress ロゴ
    $wp_admin_bar->remove_menu('comments'); // コメント
    $wp_admin_bar->remove_menu('new-content'); // 新規
    $wp_admin_bar->remove_menu('new-post'); // 新規 -> 投稿
    $wp_admin_bar->remove_menu('new-media'); // 新規 -> メディア
    $wp_admin_bar->remove_menu('new-link'); // 新規 -> リンク
    $wp_admin_bar->remove_menu('new-page'); // 新規 -> 固定ページ
    $wp_admin_bar->remove_menu('new-user'); // 新規 -> ユーザー
    $wp_admin_bar->remove_menu('updates'); // 更新
}