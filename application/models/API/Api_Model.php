<?php defined('BASEPATH') or exit('No direct script access allowed');

class Api_Model extends CI_Model
{

    public function insert($tabel, $arr)
    {
        $cek = $this->db->insert($tabel, $arr);
        return $cek;
    }
    public function hapus($id, $column, $tb)
    {
        $this->load->database();
        $this->db->where($column, $id);
        return $this->db->delete($tb);
    }
    public function ubah($data = array(), $id, $column, $tb)
    {
        $this->load->database();
        $this->db->where($column, $id);
        return $this->db->update($tb, $data);
    }
    public function detail($id)
    {
        return $this->db->get_where('user', ['id_otlet' => $id])->result_array();
    }
    public function bagian($id)
    {
        return $this->db->get_where('user', ['bagian' => $id])->row_array();
    }
    public function otletnotif($id)
    {
        return $this->db->get_where('notifikasi', ['id_notif' => $id])->row_array();
    }
    public function otletuser($id)
    {
        return $this->db->get_where('user', ['id_otlet' => $id])->row_array();
    }
    public function getpenghutangdetail($id)
    {
        return $this->db->get_where('hutang', ['no_ktp' => $id])->row_array();
    }
    public function ktphutang()
    {
        return $this->db->get('hutang')->row_array();
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
}
