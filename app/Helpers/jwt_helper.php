<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (!function_exists('createJWT')) {
    function createJWT(array $data): string
    {
        $issuedAt = time();
        $expire = $issuedAt + 3600;

        $payload = array_merge($data, [
            'iat' => $issuedAt,
            'exp' => $expire,
        ]);

        $key = getenv('JWT_SECRET');
        return JWT::encode($payload, $key, 'HS256');
    }
}

if (!function_exists('verifyJWT')) {
    function verifyJWT(string $token)
    {
        $key = getenv('JWT_SECRET');
        return JWT::decode($token, new Key($key, 'HS256'));
    }
}
