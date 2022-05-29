<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DataPenghutang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        belumlogin();
        $this->load->model('API/Api_Model', 'ApiModel');
        $this->load->model('Models');
    }
    public function index()
    {
        $data['penghutang'] = $this->db->join('otlet', 'otlet.id_otlet = hutang.id_otlet')->get_where('hutang', ['status !=' => 0])->result_array();
        $this->load->view('DataPenghutang/index', $data);
    }

    public function detail($id)
    {
        $data['hutang'] = $this->db->join('otlet', 'otlet.id_otlet = hutang.id_otlet')->get_where('hutang', ['no_ktp' => $id])->row_array();
        $this->load->view('DataPenghutang/detail', $data);
    }

    public function foto($id)
    {
        $data['id'] = $id;
        $this->load->view('DataPenghutang/foto', $data);
    }
    
    public function uploadfoto()
    {

        $id = $this->input->post('id');
        $key = $this->ApiModel->randomkode(4);

        $config['allowed_types'] = 'jpg|png|gif|jpeg';
        $config['max_size'] = '5000';
        $config['upload_path'] = FCPATH . 'uploads/ktp';
        $newName = "uploads/ktp/" . $key . $_FILES['foto']['name'];
        $config['file_name'] = $key . $_FILES['foto']['name'];
        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($this->upload->do_upload('foto')) {
            $data = [
                'foto_ktp' => $newName
            ];
            $update = $this->Models->update($data, "no_ktp", "hutang", $id);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
                Berhasil Merubah Foto KTP !
                </div>');
                redirect('DataPenghutang');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                Gagal Mengupload Foto, Silahkan Coba lagi !
                </div>');
                redirect('DataPenghutang');
        }
    }

    public function edit($id)
    {
        $data = $this->db->get_where('hutang', ['no_ktp' => $id])->row_array();
        $this->form_validation->set_rules('noktp', 'Nomer KTP', 'required|numeric');
        $this->form_validation->set_rules('nama', 'Nama Kustomer Kredit', 'required');
        $this->form_validation->set_rules('limit', 'Limit Kredit', 'required|numeric');
        if ($this->form_validation->run() == false) {
        $data['data'] = $this->db->get_where('hutang', ['no_ktp' => $id])->row_array();
        $this->load->view('DataPenghutang/edit', $data);
        }else{

            $limit = $this->input->post('limit');
            if($limit < $data['total_hutang']){
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                Limit Tidak Boleh Kurang Dari Jumlah Hutang Sekarang, Rp. ' . $data['total_hutang'] . '
                </div>');
                redirect('DataPenghutang/edit/' . $id);
            }else{

            $data = [
                'no_ktp' => $this->input->post('noktp'),
                'nama_penghutang' => $this->input->post('nama'),
                'limit_hutang' => $this->input->post('limit'),
            ];
            $update = $this->Models->update($data, "no_ktp", "hutang", $id);
            if ($update) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
                Data Kustomer Kredit Berhasil Diupdate!
                </div>');
                redirect('DataPenghutang');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                Data Kustomer Kredit Gagal Diupdate!
                </div>');
                redirect('DataPenghutang');
            }
            }

        }
    }

    public function konfirmasi()
    {
        $no_ktp = $this->input->post('no_ktp');
        $id_notif = $this->input->post('id_notif');
        $tanggal = $this->input->post('tanggal');
        $limit = $this->input->post('limit');
        $id_otlet = $this->input->post('id_otlet');
        $nama_penghutang = $this->input->post('nama');
        $now = date('Y-m-d H:i:s');
        if ($id_otlet == '1') {
            $otletnya = 'Jember';
        } elseif ($id_otlet == '2') {
            $otletnya = 'Situbondo';
        } elseif ($id_otlet == '3') {
            $otletnya = 'Bali';
        }
        $data = [
            'limit_hutang' => $limit,
            'limit_tanggal' => $tanggal,
            'status' => 1,
        ];
        $datanotif = [
            'status' => 1,
            'updated_at' => $now
        ];

        $update = $this->Models->update($data, "no_ktp", "hutang", $no_ktp);
        $updatenotif = $this->Models->update($datanotif, "id_notif", "notifikasi", $id_notif);
        if ($update && $updatenotif) {
            $this->sendNotification("/topics/$id_otlet", "Verifikasi penghutang baru", "Penghutang baru dengan nama $nama_penghutang telah di vefirikasi oleh admin di otlet $otletnya");
            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
            Penghutang Berhasil Dikonfirmasi 
            </div>');
            redirect('DataPenghutang/PengajuanHutang');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
            Penghutang Gagal Dikonfirmasi
            </div>');
            redirect('DataPenghutang/PengajuanHutang');
        }
    }

    public function PengajuanHutang()
    {
        $data['penghutang'] = $this->db->join('otlet', 'otlet.id_otlet = hutang.id_otlet')->get_where('hutang', ['status' => 0])->result_array();
        $this->load->view('DataPenghutang/pengajuan', $data);
    }
    public function DetailPembelian($id)
    {
        $data['id'] = $id;
        $data['pembelian'] = $this->db->join('otlet', 'otlet.id_otlet = penjualan.id_otlet')->get_where('penjualan', ['ktp_penghutang' => $id])->result_array();
        $this->load->view('DataPenghutang/detailPembelian', $data);
    }
    public function DetailPembayaran($id)
    {
        $data['id'] = $id;
        $data['bayar'] = $this->db->get_where('bayar_hutang', ['no_ktp' => $id])->result_array();
        $this->load->view('DataPenghutang/detailPembayaran', $data);
    }
    public function Barang($id)
    {
        $data['barang'] = $this->db->join('barang', 'barang.id_barang = detail_penjualan.id_barang')->get_where('detail_penjualan', ['id_penjualan' => $id])->result_array();
        $this->load->view('DataPenghutang/barang', $data);
    }

    public function DetailPengajuan($id)
    {
        $data['hutang'] = $this->db->join('otlet', 'otlet.id_otlet = hutang.id_otlet')->get_where('hutang', ['no_ktp' => $id])->row_array();
        $data['notif'] = $this->db->query("SELECT * FROM notifikasi WHERE no_ktp = '$id'")->row_array();
        $this->load->view('DataPenghutang/detailpengajuan', $data);
    }

    public function sendNotification($id, $title, $pesan)
    {
        $arguments = array(
            'message'   => $pesan,
            'title'     => $title,
        );

        $fields = array(
            'to'  => $id,
            'notification' => array(
                'title' => $title,
                'body' => $pesan,
            ),
            'data' => $arguments,
            'android' => array(
                'priority' => 'high',
            ),
        );

        $headers = array(
            'Authorization: key=AAAA1kSN8j0:APA91bG6wK18M-0ejs11mAOzaAue-1hiBrKOJkIzNqSa_QPIO8UrRJ34Gdu3BrMidGbzo5rsESdNqYbU2dmHdByO_gW9m5bLrcyXzyna3NrGqsbC-9dzLFGMuvxpafrwMMg54zH_3I1e',
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        // echo $result;
    }
}

/* End of file DataPenghutang.php and path /application/controllers/DataPenghutang.php */
