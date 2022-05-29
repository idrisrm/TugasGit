<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function index()
    {
        if ($this->session->userdata('id')) {
            redirect("Dashboard");
        }
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('login');
        } else {
            $username = $this->input->post('username');
            $password = md5($this->input->post('password'));

            //lakukan pengecekan apakah email dari user ada
            $user = $this->db->get_where('user', ['username' => $username])->row_array();

            if ($user) { //jika user ada
                if ($password === $user['password']) {
                        $data = [
                            'id' => $user['id'],
                            'username' => $user['username'],
                        ];
                        $this->session->set_userdata($data);
                        redirect('Dashboard');
                } else {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger mb-3" role="alert">
							Password salah!
					</div>');
                    redirect('Auth');

                    // redirect('');
                }
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger mb-3" role="alert">
					Username Salah!
				</div>');
                redirect('Auth');
            }
        }
    }

    public function logout()
	{
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('username');
		$this->session->set_flashdata(
			'pesan',
			'<div class="alert alert-success" role="alert">Berhasil Keluar!</div>'
		);
		redirect('Auth');
	}
}

/* End of file Auth.php and path /application/controllers/Auth.php */
