<?php
add_action('init', 'craete_custom_post_type', 15);

/**
 * 投稿タイプ "task" を登録します。
 *
 * 管理画面でタスクを管理するために使用されます。
 *
 * @return void
 */
function craete_custom_post_type()
{
    register_post_type('task', [
        'labels' => [
            'name' => 'Tasks',
            'singular_name' => 'Task',
        ],
        'public' => true,
        'has_archive' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
    ]);
}