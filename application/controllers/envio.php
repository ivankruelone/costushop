<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Envio extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->is_logged_in();
    }

	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			redirect('login');
		}		
	}	

///////////////////////////////////////////////////////////  
///////////////////////////////////////////////////////////
     
	public function tabla_envio_facturas()
	{
	   $data = array();
       $data['menu'] = 'envio';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('envio_model');
       
       $data['titulo'] = "ENVIO DE FACTURAS DE FARMABODEGA A CXP";
       $data['contenido'] = "envio/envio_c";
       $data['tabla'] = $this->envio_model->facturas();
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}


//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
     
	public function tabla_envio_pedido()
	{
	   $data = array();
       $data['menu'] = 'envio';
       //$data['sidebar'] = "head/sidebar";
       //$data['widgwet'] = "main/widwets";
       //$data['sidebar'] = "main/dondeestoy";
       $this->load->model('envio_model');
       
       $data['titulo'] = "ENVIO DE PEDIDOS DE FARMABODEGA";
       $data['contenido'] = "envio/envio_c";
       $data['tabla'] = $this->envio_model->pedidos_generar();
       
			
		$this->load->view('header');
		$this->load->view('main', $data);
	}


//////////////////////////////////////////////////////   
//////////////////////////////////////////////////////
 function generar_pedido($nid)
	{
	$this->load->model('envio_model');
    $this->envio_model->create_member($nid);
    redirect('envio/tabla_envio_pedido');
    }
//////////////////////////////////////////////////////   
//////////////////////////////////////////////////////   
}