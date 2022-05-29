<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Models extends CI_Model
{
    public function update($data = array(), $column, $tb, $id)
    {
        $this->load->database();
        $this->db->where($column, $id);
        return $this->db->update($tb, $data);
    }
    public function hapus($id, $column, $tb)
    {
        $this->load->database();
        $this->db->where($column, $id);
        return $this->db->delete($tb);
    }
    function randomkode($maxlength)
    {
        $chary = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",
            "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
            "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"
        );
        $return_str = "";
        for ($x = 0; $x < $maxlength; $x++) {
            $return_str .= $chary[rand(0, count($chary) - 1)];
        }
        return $return_str;
    }
    public function insert($tabel, $arr)
    {
        $cek = $this->db->insert($tabel, $arr);
        return $cek;
    }

    // public function get($tb, $id)
    // {
    //     $this->load->database();
    //     $this->db->where($id);
    //     return $this->db->get($tb);
    // }   

}


/* End of file Models_model.php and path /application/models/Models_model.php */
