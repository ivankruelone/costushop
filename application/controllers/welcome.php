<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->is_logged_in();
    }

    function is_logged_in()
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!isset($is_logged_in) || $is_logged_in != true) {
            redirect('login');
        }
    }

    public function index()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $this->load->model('catalogo_model');

        $data['titulo'] = "SASTRERIA";
        $data['contenido'] = "inicio/portada";
        $data['tabla'] = '';

        $this->load->view('header');
        $this->load->view('main', $data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
