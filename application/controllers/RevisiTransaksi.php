<?php

defined('BASEPATH') or exit('No direct script access allowed');

class RevisiTransaksi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        belumlogin();
        $this->load->model('Models');
    }
    public function index()
    {
        $data['revisi'] = $this->db->join('otlet', 'otlet.id_otlet = penjualan.id_otlet')->join('user', 'user.id = penjualan.id_penjual')->get_where('penjualan', ['pengajuan' => 'revisi'])->result_array();
        $this->load->view('RevisiTransaksi/index', $data);
    }

    public function DetailRevisi($id)
    {
        $data['detail'] = $this->db->join('barang', 'barang.id_barang = detail_penjualan.id_barang')->get_where('detail_penjualan', ['id_penjualan' => $id])->result_array();
        $data['id'] = $this->db->get_where('detail_penjualan', ['id_penjualan' => $id])->row_array();
        $this->load->view('RevisiTransaksi/detail', $data);
    }

    public function konfirmasi($id)
    {
        $detail = $this->db->get_where('detail_penjualan', ['id_penjualan' => $id])->result_array();

        foreach ($detail as $data) {
            $idbarang = $data['id_barang'];

            $barang = $this->db->get_where('barang', ['id_barang' => $idbarang])->row_array();

            $stok = [
                'stok' => $barang['stok'] + $data['qty']
            ];


            $this->Models->update($stok, "id_barang", "barang", $idbarang);
        }


        $data = [
            'pengajuan' => 'Dihapus'
        ];
        $this->Models->update($data, "id_penjualan", "penjualan", $id);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
                Transaksi Berhasil Dihapus!
                </div>');
        redirect('RevisiTransaksi');
    }
}

/* End of file RevisiTransaksi.php and path /application/controllers/RevisiTransaksi.php */
