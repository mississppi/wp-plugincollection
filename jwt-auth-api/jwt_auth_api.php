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

        register_rest_route('wp/v2', '/news', array(
            'methods' => 'GET',
            'callback' => [$this,'request_api'],
            'permission_callback' => [$this,'check'],
        ));
    }

    public function request_api($request)
    {

    }

    public function check($request)
    {
        $headers = getallheaders();
        if ( ! $headers ) {
			return new WP_Error(
				'jwt_auth_no_auth_header',
				'Authorization header not found.',
				[
					'status' => 403,
				]
			);
		}
        
        if(isset($headers["Authorization"])){
            $authorizationHeader = $headers['Authorization'];
            $token = str_replace('Bearer ', '', $authorizationHeader);

            if ( ! $token ) {
                return new WP_Error(
                    'jwt_auth_bad_auth_header',
                    'Authorization header malformed.',
                    [
                        'status' => 403,
                    ]
                );
            }

            $secret_key = defined( 'JWT_AUTH_SECRET_KEY' ) ? JWT_AUTH_SECRET_KEY : false;

            try {
                $token = $this->decode($token, $secret_key);
                if (!isset($token->data->user->id)) {
                    return new WP_Error(
                        'jwt_auth_bad_request',
                        'User ID not found in the token',
                        [
                            'status' => 403,
                        ]
                    );
                }
                return true;
            } catch(Exception $e){
                return false;
            }
        } else {
            return false;
        }
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
        $current_time = time();
        $expiration_time = $current_time + 3600;
        $token = [
            'data' => [
				'user' => [
					'id' => $user_id,
				],
            ],
            'iat' => $current_time,
            'exp' => $expiration_time
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

    public function decode($jwt, $key)
    {
        $timestamp = time();
        $tks = \explode('.', $jwt);
        list($headb64, $bodyb64, $cryptob64) = $tks;
        $headerRaw = $this->urlsafeB64Decode($headb64);
        $payloadRaw = $this->urlsafeB64Decode($bodyb64);
        $payload = $this->jsonDecode($payloadRaw);
        if (\is_array($payload)) {
            $payload = (object) $payload;
        }
        
        if ($timestamp >= $payload->exp){
            throw new ExpiredException('Expired token');
        }
        return $payload;
    }

    public function urlsafeB64Encode($input)
    {
        return \str_replace('=', '', \strtr(\base64_encode($input), '+/', '-_'));
    }

    public function jsonEncode($input)
    {
        return \json_encode($input, \JSON_UNESCAPED_SLASHES);
    }

    public function jsonDecode($input)
    {
        return \json_decode($input, false, 512, JSON_BIGINT_AS_STRING);
    }

    public function urlsafeB64Decode($input)
    {
        $remainder = \strlen($input) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $input .= \str_repeat('=', $padlen);
        }
        return \base64_decode(\strtr($input, '-_', '+/'));
    }

}

new jwtAuth();