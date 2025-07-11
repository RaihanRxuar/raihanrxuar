<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return \Config\Services::response()
                ->setStatusCode(401)
                ->setJSON(['error' => 'Token tidak ditemukan atau salah format']);
        }

        $token = explode(' ', $authHeader)[1];

        try {
            $decoded = JWT::decode($token, new Key('rahasia123', 'HS256'));
            // Token valid, bisa lanjut
        } catch (\Exception $e) {
            return \Config\Services::response()
                ->setStatusCode(401)
                ->setJSON(['error' => 'Token tidak valid: ' . $e->getMessage()]);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu digunakan di sini
    }
}