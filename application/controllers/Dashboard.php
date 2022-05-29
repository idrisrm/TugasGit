<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        belumlogin();
    }
    public function index()
    {
        $data1 = $this->db->query("SELECT * FROM ph ORDER BY id DESC LIMIT 7")->result_array();

        if ($data1) {
            foreach ($data1 as $data1) {
                $data2['id'][] = $data1['id'];
                $data2['nilai'][] = $data1['nilai'];
                $data2['waktu'][] = $data1['waktu'];
            }
        } else {
                $data2['id'][] = '-';
                $data2['nilai'][] = '-';
                $data2['waktu'][] = '-';
        }


        $data['PH'] = json_encode($data2);


        $dataPPM = $this->db->query("SELECT * FROM ppm ORDER BY id DESC LIMIT 7")->result_array();

        if ($dataPPM) {
            foreach ($dataPPM as $dataPPM) {
                $data3['id'][] = $dataPPM['id'];
                $data3['nilai'][] = $dataPPM['nilai'];
                $data3['waktu'][] = $dataPPM['waktu'];
            }
        } else {
                $data3['id'][] = '-';
                $data3['nilai'][] = '-';
                $data3['waktu'][] = '-';
        }


        $data['PPM'] = json_encode($data3);
        
        $this->load->view('dashboard', $data);
    }

    public function PH(){
        $data = $this->db->query("SELECT * FROM ph ORDER BY id DESC LIMIT 1")->row_array();
        if($data){
            echo $data["nilai"];
        }else{
            $data["nilai"] = 0;
            echo $data["nilai"];
        }
        
    }

    public function PPM(){
        $data = $this->db->query("SELECT * FROM ppm ORDER BY id DESC LIMIT 1")->row_array();
        if($data){
            echo $data["nilai"];
        }else{
            $data["nilai"] = 0;
            echo $data["nilai"];
        }
        
    }
}

/* End of file Dashboard.php and path /application/controllers/Dashboard.php */
