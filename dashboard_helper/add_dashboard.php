<?php
add_action('wp_dashboard_setup', 'my_dashboard_widgets');
function my_dashboard_widgets() 
{
	wp_add_dashboard_widget('note_widget', 'NOTE', 'widget_function');
}

function widget_function()
{
    //登録したtypeから最新の1件を取得してダッシュボードへ表示
    $args = ['post_type' => 'dashboard_note','numberposts' => 1,];
    $post = get_posts( $args );
    if(!empty($post)){
        $author = get_userdata($post[0]->post_author);
        $author_name = $author ? $author->user_login : '';
        $content = $post[0]->post_content ?? '';
        echo <<<EOM
            <h2>投稿者: $author_name</h2>
            <h3>$content</h3>
        EOM;
    }
}