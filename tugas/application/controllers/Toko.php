<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Toko extends RestController {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index_get()
    {
        $toko = $this->db->get('toko')->result();

        $this->response($toko, RestController::HTTP_OK);
    }

    public function index_post()
    {
        $data = array(
            'Kode' => $this->post('Kode'),
            'Nama_barang' => $this->post('Nama_barang'),
            'Jenis' => $this->post('Jenis'),
            'Harga' => $this->post('Harga'),
            'Stok' => $this->post('Stok')
        );

        $this->db->insert('toko', $data);

        $this->response(['Berhasil ditambahkan!'], RestController::HTTP_CREATED);
    }

    public function index_put($kode)
    {
        $data = array(
            'Nama_barang' => $this->put('Nama_barang'),
            'Jenis' => $this->put('Jenis'),
            'Harga' => $this->put('Harga'),
            'Stok' => $this->put('Stok')
        );

        $this->db->where('Kode', $kode);
        $this->db->update('toko', $data);

        $this->response(['Berhasil diperbaharui!'], RestController::HTTP_OK);
    }

    public function index_delete($kode)
    {
        $this->db->where('Kode', $kode);
        $this->db->delete('toko');

        $this->response(['Berhasil dihapus!'], RestController::HTTP_OK);
    }

}
?>