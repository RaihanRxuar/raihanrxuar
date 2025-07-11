<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;

class Auth extends ResourceController
{
    public function login()
    {
        // Ambil input JSON dari request
        $json = $this->request->getJSON();

        // Jika tidak ada data JSON dikirim, kembalikan error
        if (!$json) {
            return $this->fail('Request tidak valid (harus JSON)', 400);
        }

        // Ambil username & password dari input
        $username = $json->username ?? '';
        $password = $json->password ?? '';

        // Validasi login (contoh hardcode)
        if ($username === 'admin' && $password === '123456') {
            // Secret key untuk enkripsi token
            $key = 'rahasia123';

            // Data yang akan disimpan di token
            $payload = [
                'iat' => time(),                   // waktu dibuat
                'exp' => time() + 3600,            // waktu kadaluarsa (1 jam)
                'username' => $username
            ];

            // Generate token
            $token = JWT::encode($payload, $key, 'HS256');

            // Beri token ke user
            return $this->respond(['token' => $token], 200);
        }

        // Jika login gagal
        return $this->failUnauthorized('Username atau password salah');
    }
}
