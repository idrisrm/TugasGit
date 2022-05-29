<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Peringkat extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        belumlogin();
        $this->load->model('Models');
    }
    public function index()
    {
        $data['peringkat'] = $this->db->query("SELECT detail_penjualan.id_barang, barang.nama_barang, barang.satuan, SUM(detail_penjualan.qty) as qty FROM detail_penjualan, barang WHERE barang.id_barang = detail_penjualan.id_barang GROUP BY id_barang ORDER BY qty DESC")->result_array();
        
        $this->load->view('DataBarang/peringkat', $data);
    }
}

/* End of file Peringkat.php and path /application/controllers/Peringkat.php */
