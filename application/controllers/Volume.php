<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Volume extends CI_Controller
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
        $this->form_validation->set_rules('volume', 'Volume', 'required');

        if ($this->form_validation->run() == false) {
            $data['volume'] = $this->db->get_where('v', ['id' => 1])->row_array();
            $this->load->view('Volume/edit', $data);
        } else {
            $data = [
                'nilai' => $this->input->post('volume')
            ];
            $update = $this->Models->update($data, "id", "v", 1);
            if ($update) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
                Volume Air Berhasil Diupdate!
                </div>');
                redirect('Volume');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                Volume Air Gagal Diupdate!
                </div>');
                redirect('Volume');
            }
        }
    }
    
}

/* End of file DataBarang.php and path /application/controllers/DataBarang.php */
