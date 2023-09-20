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
        register_rest_route('jwt-auth/v1', '/token', [
                'methods' => 'POST',
                'callback' => [$this,'auth'],
                'permission_callback' => [$this,'permission_check'],
        ]);
    }

    public function auth($request)
    {
        $username   = $request->get_param( 'username' );
		$password   = $request->get_param( 'password' );
        if(empty($username) || empty($password)){
            return new WP_Error('invalid_data', 'Username and password are required.', array('status' => 400));
        }
        $user = wp_authenticate($username, $password);
        if (is_wp_error($user)){
            return new WP_Error('authentication_failed', 'Authentication failed.', array('status' => 401));
        } else {
            $token = $this->generate_jwt_token($user->data->ID, $user);
            return ['token' => $token];
        }
    }

    public function permission_check()
    {
        return true;
    }

    public function generate_jwt_token($user_id, $user)
    {
        $secret = defined( 'JWT_AUTH_SECRET_KEY' ) ? JWT_AUTH_SECRET_KEY : false;

        $token = [
            'data' => [
				'user' => [
					'id' => $user_id,
				],
            ],
            'exp' => time() + 3600,
        ]; 

        $alg = 'SHA256';
        return $this->encode($token, $user, $secret, $alg);
    }

    public function encode($payload, $user, $secret, $alg)
    {
        $segments = [];
        $header = ['typ' => 'JWT', 'alg' => 'SHA256'];
        $segments[] = $this->urlsafeB64Encode((string) $this->jsonEncode($header));
        $segments[] = $this->urlsafeB64Encode((string) $this->jsonEncode($payload));
        $signing_input = \implode('.', $segments);
        $signature = \hash_hmac($alg, $signing_input, $secret, true);
        $segments[] = $this->urlsafeB64Encode($signature);
        return \implode('.', $segments);
    }

    public function urlsafeB64Encode($input)
    {
        return \str_replace('=', '', \strtr(\base64_encode($input), '+/', '-_'));
    }

    public function jsonEncode($input)
    {
        return \json_encode($input, \JSON_UNESCAPED_SLASHES);
    }

}

new jwtAuth();