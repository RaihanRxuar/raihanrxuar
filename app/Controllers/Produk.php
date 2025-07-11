<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use CodeIgniter\RESTful\ResourceController;

class Produk extends ResourceController
{
    protected $modelName = ProdukModel::class;
    protected $format    = 'json';

    // CREATE (POST /produk)
    public function create()
    {
        $data = $this->request->getJSON(true);

        if (!$this->model->insert($data)) {
            return $this->fail($this->model->errors());
        }

        return $this->respondCreated([
            'message' => 'Produk berhasil ditambahkan'
        ]);
    }

    // READ ALL (GET /produk)
    public function index()
    {
        $produk = $this->model->findAll();
        return $this->respond($produk);
    }

    // READ BY ID (GET /produk/{id})
    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (!$data) {
            return $this->failNotFound("Produk dengan ID $id tidak ditemukan.");
        }
        return $this->respond($data);
    }

    // UPDATE (PUT /produk/{id})
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        if (!$this->model->update($id, $data)) {
            return $this->fail($this->model->errors());
        }

        return $this->respond([
            'message' => 'Produk berhasil diperbarui'
        ]);
    }

    // DELETE (DELETE /produk/{id})
    public function delete($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->failNotFound("Produk dengan ID $id tidak ditemukan.");
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'message' => 'Produk berhasil dihapus'
        ]);
    }
}