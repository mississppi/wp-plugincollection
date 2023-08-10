<?php
require_once __DIR__ . '/vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\OCHINTKO;

class jwtAuth
{
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_endpoints']);
    }

    public function register_endpoints()
    {
        register_rest_route('auth/v1', '/data', [
                'methods' => 'POST',
                'callback' => [$this,'auth'],
                'permission_callback' => [$this,'permission_check'],
        ]);
    }

    public function auth($request)
    {
        $secret = getenv('JWT_SECRET_KEY');
        $data = $request->get_json_params();
        if(is_null($data)){
            return new WP_Error('invalid_json', 'Invalid JSON data.', array('status' => 400));
        }
        $name = isset($data['username']) ? sanitize_text_field($data['username']) : '';
        $pass = isset($data['password']) ? sanitize_text_field($data['password']) : '';
        if(empty($name) || empty($pass)){
            return new WP_Error('invalid_data', 'Username and password are required.', array('status' => 400));
        }
        $user = wp_authenticate($name, $pass);
        if (is_wp_error($user)){
            return new WP_Error('authentication_failed', 'Authentication failed.', array('status' => 401));
        } else {
            $token = $this->generate_jwt_token($name, $secret);
            return ['token' => $token];
        }
    }

    public function permission_check()
    {
        return true;
    }

    public function generate_jwt_token($name, $secret)
    {
        $token = [
            'username' => $name,
            'exp' => time() + 3600,
        ];
        return JWT::encode($token, $secret, 'HS256');
    }

}

new jwtAuth();