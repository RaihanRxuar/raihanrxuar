<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class User extends ResourceController
{
    public function profile()
    {
        $authHeader = $this->request->getHeaderLine('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return $this->failUnauthorized('Token tidak ditemukan atau format salah');
        }

        $token = explode(' ', $authHeader)[1];

        try {
            $decoded = JWT::decode($token, new Key('rahasia123', 'HS256'));

            // Token valid ✅
            return $this->respond([
                'message' => 'Selamat datang, ' . $decoded->username,
                'data' => [
                    'username' => $decoded->username,
                    'expires' => date('Y-m-d H:i:s', $decoded->exp),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->failUnauthorized('Token tidak valid: ' . $e->getMessage());
        }
    }
}
