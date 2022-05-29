<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Privacypolicy extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $this->load->view('Pengaturan/privacy-policy');    
    }
}

/* End of file Privacy-policy.php and path \application\controllers\Privacy-policy.php */
