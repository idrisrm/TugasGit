<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Waktu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        belumlogin();
        $this->load->model('Models');
        $this->load->model('API/Api_Model', 'ApiModel');
    }

    public function index()
    {
        $this->form_validation->set_rules('waktu', 'Waktu', 'required');

        if ($this->form_validation->run() == false) {
            $data['waktu'] = $this->db->get_where('waktu', ['id' => 1])->row_array();
            $this->load->view('Waktu/edit', $data);
        } else {
            $data = [
                'nilai' => $this->input->post('waktu')
            ];
            $update = $this->Models->update($data, "id", "waktu", 1);
            if ($update) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
                Waktu Pengecekan Berhasil Diupdate!
                </div>');
                redirect('Waktu');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                Waktu Pengecekan Gagal Diupdate!
                </div>');
                redirect('Waktu');
            }
        }
    }
    
}

/* End of file DataBarang.php and path /application/controllers/DataBarang.php */
