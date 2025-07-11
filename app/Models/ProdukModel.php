<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk'; // nama tabel di database
    protected $primaryKey = 'id'; // primary key-nya
    protected $allowedFields = ['nama_produk', 'harga', 'stok']; // kolom yang boleh diisi
}
