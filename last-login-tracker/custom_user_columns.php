<?php

class CustomUserColumns
{
    public function __construct()
    {
        //カラム追加
        add_filter('manage_users_columns', [$this, 'custom_add_last_login_column']);
        add_action('manage_users_custom_column', [$this, 'custom_display_last_login_column'], 10, 3);

    }

    public function custom_add_last_login_column($columns)
    {
        $columns['last_login'] = '最終ログイン日時';
        return $columns;
    }

    public function custom_display_last_login_column($value, $column_name, $user_id)
    {
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