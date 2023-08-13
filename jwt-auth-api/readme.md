#apacheの設定は以下

```
RewriteEngine On

# /wp-json/ へのリクエストに対する制御
RewriteCond %{REQUEST_URI} ^/wp-json/wp/ [NC]
RewriteCond %{HTTP:Authorization} !^Bearer [NC]
RewriteRule ^ - [F]

# /wp-json/auth/v1/data へのPOSTメソッドを許可
RewriteCond %{REQUEST_URI} ^/auth/v1/data [NC]
RewriteCond %{REQUEST_METHOD} POST
RewriteRule ^ - [L]

# Authorizationヘッダーを環境変数にセット
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]

SetEnv JWT_SECRET_KEY "hogehoge"
# END WordPress
```