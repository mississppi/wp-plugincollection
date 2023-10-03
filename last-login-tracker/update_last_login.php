<?php

class updateLastLogin
{
    public function __construct()
    {
        // ユーザーがログインしたときに最終ログイン日時を更新するためのアクションフックを登録
        add_action('wp_login', [$this, 'custom_update_last_login'], 10, 2);
    }

    public function custom_update_last_login($user_login, $user) {
        // ユーザーの最終ログイン日時を更新するカスタム関数

        // ユーザーの最終ログイン日時を更新
        update_user_meta($user->ID, 'last_login', current_time('timestamp'));
    }
}

new updateLastLogin(); // updateLastLoginクラスのインスタンスを作成し、ユーザーがログインするたびに最終ログイン日時を更新します。