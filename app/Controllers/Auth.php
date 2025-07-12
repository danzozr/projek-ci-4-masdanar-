<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
    public function login()
{
    try {
        $json = $this->request->getJSON();

        if (!$json) {
            return $this->fail('Data JSON tidak ditemukan');
        }

        if ($json->username === 'masdanar' && $json->password === 'Danar123') {
            $token = createJWT([
                'uid' => 1,
                'nama' => 'Masdanar'
            ]);

            return $this->respond([
                'status' => true,
                'token' => $token
            ]);
        }

        return $this->failUnauthorized('Username atau password salah');
    } catch (\Throwable $e) {
        return $this->respond([
            'status' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
}

    public function profile()
    {
        $authHeader = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $authHeader);

        try {
            $decoded = verifyJWT($token);
            return $this->respond([
                'status' => true,
                'data' => $decoded
            ]);
        } catch (\Exception $e) {
            return $this->failUnauthorized('Token tidak valid 💔');
        }
    }
}
