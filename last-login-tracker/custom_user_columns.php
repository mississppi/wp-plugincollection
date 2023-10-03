<?php

class CustomUserColumns
{
    public function __construct()
    {
        // カラムの追加と表示方法を設定するためのアクションフックとフィルターフックを登録
        
        // カラムを追加するフィルターフック
        add_filter('manage_users_columns', [$this, 'custom_add_last_login_column']);
        
        // カラムの内容を表示するアクションフック
        add_action('manage_users_custom_column', [$this, 'custom_display_last_login_column'], 10, 3);

    }

    public function custom_add_last_login_column($columns)
    {
        // ユーザー一覧のカラムに「最終ログイン日時」を追加
        $columns['last_login'] = '最終ログイン日時';
        return $columns;
    }

    public function custom_display_last_login_column($value, $column_name, $user_id)
    {
        // 最終ログイン日時カラムの内容を表示

        if($column_name === 'last_login'){
            $last_login = get_user_meta($user_id, 'last_login', true);
            if($last_login){
                $formatted_date = date('Y-m-d H:i:s', $last_login);
                return $formatted_date;
            } else {
                return 'ログインなし';
            }
        }
    }
}

new CustomUserColumns();