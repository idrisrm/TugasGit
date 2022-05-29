<?php

defined('BASEPATH') or exit('No direct script access allowed');

class post extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        // $PH = $this->input->post("PH");
        // $PPM = $this->input->post("PPM");

        // $this->db->insert('ph', ['nilai' => $PH, 'waktu' => date('h:i:s A')]);
        // $this->db->insert('ppm', ['nilai' => $PPM, 'waktu' => date('h:i:s A')]);

        // $data = $this->db->get('v')->row_array();

        // echo $data['nilai'];
        echo 'idris';
    }

    public function waktu()
    {
        $id = $this->input->post("id");
        $data = $this->db->get('waktu')->row_array();

        echo $data['nilai'];
    }

}

/* End of file DataKategori.php and path /application/controllers/DataKategori.php */
