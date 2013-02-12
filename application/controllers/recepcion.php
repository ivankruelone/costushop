<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Recepcion extends CI_Controller
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
        $this->load->model('recepcion_model');

        $data['titulo'] = "SASTRERIA";
        $data['contenido'] = "recepcion/limpio";
        $data['tabla'] = $this->recepcion_model->control();

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    function nueva_recepcion()
    {
        $this->load->model('recepcion_model');
        $id = $this->recepcion_model->create_member_orden_c();
        redirect('recepcion/tabla_recepcion/' . $id);
    }

    public function tabla_recepcion($id)
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $this->load->model('catalogo_model');
        $data['hora'] = $this->catalogo_model->busca_hora();
        $data['prenda'] = $this->catalogo_model->busca_prenda();
        $data['id'] = $id;
        $this->load->model('recepcion_model');
        $data['orden'] = $this->recepcion_model->get_orden($id);
        $data['pagos_en_orden'] = $this->recepcion_model->abonos_sin_accion($id);

        $data['titulo'] = "RECEPCION";
        $data['contenido'] = "recepcion/recepcion_c_form_agrega";

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    public function pagos($id)
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $this->load->model('catalogo_model');
        $data['hora'] = $this->catalogo_model->busca_hora();
        $data['prenda'] = $this->catalogo_model->busca_prenda();
        $data['id'] = $id;
        $this->load->model('recepcion_model');
        $data['orden'] = $this->recepcion_model->get_orden($id);
        $data['tipo_pago'] = $this->recepcion_model->busca_tipo_pago();
        $data['titulo'] = "PAGOS";
        $data['contenido'] = "recepcion/pagos";

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    public function ordenes($estatus)
    {
        $this->load->model('recepcion_model');
        $this->load->library('pagination');
        $config['uri_segment'] = 4;
        $config['base_url'] = site_url() . '/recepcion/ordenes/' . $estatus . '/';
        $config['total_rows'] = $this->recepcion_model->get_num_ordenes($estatus);
        $config['per_page'] = '100';
        $config['first_link'] = '<font size="+1">Primero</font>';
        $config['last_link'] = '<font size="+1">Ultimo</font>';
        $config['next_link'] = '<font size="+1">Siguiente</font>';
        $config['prev_link'] = '<font size="+1">Anterior</font>';
        $config['cur_tag_open'] = '<font size="+1" color="#2340CF"><b> ';
        $config['cur_tag_close'] = ' </b></font>';
        $config['num_tag_open'] = '<font size="+1" color="#000000"> ';
        $config['num_tag_close'] = ' </font>';

        $this->pagination->initialize($config);

        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";

        $data['ordenes'] = $this->recepcion_model->ordenes($estatus, $config['per_page'],
            $this->uri->segment(4));
        $data['titulo'] = "ORDENES";
        $data['contenido'] = "recepcion/ordenes";

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    public function entregas()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $this->load->model('recepcion_model');
        $data['titulo'] = "ENTREGAS";
        $data['contenido'] = "recepcion/entregas";

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    function cambia_cliente()
    {
        $data->id_cliente = $this->input->post('cliente');
        $this->db->where('id', $this->input->post('id'));

        $this->db->update('orden_c', $data);
    }

    function cambia_fecha_entrega()
    {
        $data->fecha_entrega = $this->input->post('fecha_entrega');
        $this->db->where('id', $this->input->post('id'));

        $this->db->update('orden_c', $data);
    }

    function cambia_hora_entrega()
    {
        $data->hora_entrega = $this->input->post('hora_entrega');
        $this->db->where('id', $this->input->post('id'));

        $this->db->update('orden_c', $data);
    }

    function cambia_noprendas()
    {
        $data->no_prendas = $this->input->post('noprendas');
        $this->db->where('id', $this->input->post('id'));

        $this->db->update('orden_c', $data);
    }

    function cambia_observacion()
    {
        $data->observacion = $this->input->post('obser');
        $this->db->where('id', $this->input->post('id'));

        $this->db->update('orden_c', $data);
    }

    function cambia_descuento()
    {
        $data->descuentox = $this->input->post('descuento');
        $this->db->where('id', $this->input->post('id'));

        $this->db->update('orden_c', $data);
    }

    function busca_clientes_autocomplete()
    {
        $this->load->model('catalogo_model');
        $query = $this->catalogo_model->autocomplete($this->input->get_post('term'));
        $json = '[';

        foreach ($query as $row) {
            $json .= '{"id":"' . $row->id . '","value":"' . $row->nombre . '"},';
        }
        if (count($query) >= 1) {
            $json = substr($json, 0, -1);
        } else {
            $json .= '{"id":"0","value":"No hay coincidencias."}';
        }
        $json .= ']';
        echo $json;
    }

    function busca_orden_autocomplete()
    {
        $this->load->model('catalogo_model');
        $query = $this->catalogo_model->autocomplete_orden($this->input->get_post('term'));
        $json = '[';

        foreach ($query as $row) {
            $json .= '{"id":"' . $row->id . '","value":"' . $row->id . '"},';
        }
        if (count($query) >= 1) {
            $json = substr($json, 0, -1);
        } else {
            $json .= '{"id":"0","value":"No hay coincidencias."}';
        }
        $json .= ']';
        echo $json;
    }

    function servicios_de_prenda()
    {
        $this->load->model('catalogo_model');
        echo $this->catalogo_model->servicios_de_prenda($this->input->get_post('prenda'));

    }

    function detalle_sin_orden()
    {
        $this->load->model('recepcion_model');
        echo $this->recepcion_model->detalle_sin_orden($this->input->post('id'), $this->
            input->post('descuento'));
    }

    function agrega_servicio()
    {
        $this->load->model('recepcion_model');
        echo $this->recepcion_model->agrega_servicio($this->input->post('id'), $this->
            input->get_post('servicio'), $this->input->get_post('cantidad'), $this->input->
            post('descuento'));

    }

    function borra_detalle_sin_orden()
    {
        $this->load->model('recepcion_model');
        echo $this->recepcion_model->borra_servicio_sin_orden($this->input->get_post('id'),
            $this->input->post('descuento'), $this->input->get_post('id_orden'));

    }

    function cerrar_orden($id)
    {
        $this->load->model('recepcion_model');
        $this->recepcion_model->cierra_orden($id);

        redirect('recepcion/tabla_recepcion/' . $id);
    }

    function cancela_orden()
    {
        $this->load->model('recepcion_model');
        echo $this->recepcion_model->cancela_orden();
    }

    function abonos()
    {
        $this->load->model('recepcion_model');
        echo $this->recepcion_model->abonos($this->input->post('id'));
    }

    function agrega_abono()
    {
        $this->load->model('recepcion_model');
        echo $this->recepcion_model->agrega_abono($this->input->post('id'), $this->
            input->get_post('tipo_pago'), $this->input->post('abono'));

    }

    function entregar($id)
    {
        $this->load->model('recepcion_model');
        $this->recepcion_model->entregar($id);

        redirect('recepcion/tabla_recepcion/' . $id);
    }

    function busca_orden_cliente()
    {
        $this->load->model('recepcion_model');
        echo $this->recepcion_model->busca_orden_cliente($this->input->post('id_cliente'));
    }

    function busca_orden_id()
    {
        $this->load->model('recepcion_model');
        echo $this->recepcion_model->busca_orden_id($this->input->post('orden'));
    }

    function entregas_pendientes()
    {
        $this->load->model('recepcion_model');
        echo $this->recepcion_model->entregas_pendientes();
    }

    function entregas_hoy()
    {
        $this->load->model('recepcion_model');
        echo $this->recepcion_model->entregas_hoy();
    }

    function comprobante($id)
    {
        $this->load->model('recepcion_model');
        $data['datos'] = $this->recepcion_model->get_parametros();
        $data['row'] = $this->recepcion_model->get_orden($id);
        $data['query2'] = $this->recepcion_model->detalle($id);
        $this->load->view('recepcion/comprobante', $data);
    }

    function ticket($id)
    {
        $this->load->model('recepcion_model');
        $data['datos'] = $this->recepcion_model->get_parametros();
        $data['row'] = $this->recepcion_model->get_orden($id);
        $data['query2'] = $this->recepcion_model->detalle($id);
        $this->load->view('recepcion/ticket', $data);
    }

    function talon($id)
    {
        $this->load->model('recepcion_model');
        $data['datos'] = $this->recepcion_model->get_parametros();
        $data['row'] = $this->recepcion_model->get_orden($id);
        $data['query2'] = $this->recepcion_model->detalle($id);
        $this->load->view('recepcion/talon', $data);
    }

    public function caja()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $data['titulo'] = "Reporte de Caja";
        $data['contenido'] = "recepcion/caja";

        $this->load->view('header');
        $this->load->view('main', $data);
    }


    public function caja_submit()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        $this->load->model('recepcion_model');
        $data['tabla'] = $this->recepcion_model->caja();
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $data['titulo'] = "Reporte de Caja";
        $data['contenido'] = "recepcion/caja";

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    public function caja_excel($fecha_inicial, $fecha_final)
    {
        $data = array();
        $this->load->model('recepcion_model');
        $data['query'] = $this->recepcion_model->caja_excel($fecha_inicial, $fecha_final);
        $data['venta'] = $this->recepcion_model->venta($fecha_inicial, $fecha_final);
        $data['titulo'] = "Reporte de Caja";
        $data['f1'] = $fecha_inicial;
        $data['f2'] = $fecha_final;
        $this->load->view('excel/caja', $data);
    }

    public function ventas()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $data['titulo'] = "Reporte de Ventas";
        $data['contenido'] = "recepcion/ventas";

        $this->load->model('recepcion_model');
        $data['estatus'] = $this->recepcion_model->estatus_combo();

        $this->load->view('header');
        $this->load->view('main', $data);
    }


    public function ventas_submit()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        $this->load->model('recepcion_model');
        $data['tabla'] = $this->recepcion_model->ventas();
        $data['estatus'] = $this->recepcion_model->estatus_combo();
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $data['titulo'] = "Reporte de Ventas";
        $data['contenido'] = "recepcion/ventas";

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    public function ventas_excel($fecha_inicial, $fecha_final, $estatus)
    {
        $data = array();
        $this->load->model('recepcion_model');
        $data['query'] = $this->recepcion_model->ventas_excel($fecha_inicial, $fecha_final,
            $estatus);
        $data['titulo'] = "Reporte de Ventas";
        $data['f1'] = $fecha_inicial;
        $data['f2'] = $fecha_final;
        $this->load->view('excel/ventas', $data);
    }

    public function auditoria()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $data['titulo'] = "Reporte de Auditoria de Pagos";
        $data['contenido'] = "recepcion/auditoria";

        $this->load->model('recepcion_model');
        $data['estatus'] = $this->recepcion_model->estatus_combo();
        $data['usuarios'] = $this->recepcion_model->usuarios_combo();

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    public function auditoria_submit()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        $this->load->model('recepcion_model');
        $data['tabla'] = $this->recepcion_model->auditoria();
        $data['estatus'] = $this->recepcion_model->estatus_combo();
        $data['usuarios'] = $this->recepcion_model->usuarios_combo();
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $data['titulo'] = "Reporte de Auditoria de Pagos";
        $data['contenido'] = "recepcion/auditoria";

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    public function auditoria_excel($fecha_inicial, $fecha_final, $estatus, $usuario)
    {
        $data = array();
        $this->load->model('recepcion_model');
        $data['query'] = $this->recepcion_model->auditoria_excel($fecha_inicial, $fecha_final,
            $estatus, $usuario);
        $data['titulo'] = "Reporte de Auditoria";
        $data['f1'] = $fecha_inicial;
        $data['f2'] = $fecha_final;
        $this->load->view('excel/auditoria', $data);
    }

    public function clientes()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        $this->load->model('recepcion_model');
        $data['tabla'] = $this->recepcion_model->clientes();
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $data['titulo'] = "Reporte de Clientes";
        $data['contenido'] = "recepcion/clientes";

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    public function clientes_excel()
    {
        $data = array();
        $this->load->model('recepcion_model');
        $data['query'] = $this->recepcion_model->clientes_excel();
        $data['titulo'] = "Reporte de Clientes";
        $this->load->view('excel/clientes', $data);
    }

    public function canceladas()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $data['titulo'] = "Reporte de Ordenes Canceladas";
        $data['contenido'] = "recepcion/canceladas";

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    public function canceladas_submit()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        $this->load->model('recepcion_model');
        $data['tabla'] = $this->recepcion_model->canceladas();
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $data['titulo'] = "Reporte de Ordenes Canceladas";
        $data['contenido'] = "recepcion/canceladas";

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    public function canceladas_excel($fecha_inicial, $fecha_final)
    {
        $data = array();
        $this->load->model('recepcion_model');
        $data['query'] = $this->recepcion_model->canceladas_excel($fecha_inicial, $fecha_final);
        $data['titulo'] = "Reporte de Ordenes Canceladas";
        $data['f1'] = $fecha_inicial;
        $data['f2'] = $fecha_final;
        $this->load->view('excel/canceladas', $data);
    }

    public function servicios()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $data['titulo'] = "Reporte de Auditoria de Servicios";
        $data['contenido'] = "recepcion/servicios";

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    public function servicios_submit()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        $this->load->model('recepcion_model');
        $data['tabla'] = $this->recepcion_model->servicios1();
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $data['titulo'] = "Reporte de Auditoria de Servicios";
        $data['contenido'] = "recepcion/servicios";

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    public function servicios_excel($fecha_inicial, $fecha_final)
    {
        $data = array();
        $this->load->model('recepcion_model');
        $data['query'] = $this->recepcion_model->servicios1_excel($fecha_inicial, $fecha_final);
        $data['titulo'] = "Reporte de Auditoria de Servicios";
        $data['f1'] = $fecha_inicial;
        $data['f2'] = $fecha_final;
        $this->load->view('excel/servicios', $data);
    }

    public function cat_clientes()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        $this->load->model('recepcion_model');
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $data['titulo'] = "Buscador de Clientes";
        $data['contenido'] = "recepcion/cat_clientes";

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    public function configuracion()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $this->load->model('recepcion_model');

        $data['titulo'] = "Configuracion";
        $data['contenido'] = "recepcion/configuracion";
        //$data['tabla'] = $this->recepcion_model->control();

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    public function cambia_configuracion()
    {
        $this->db->set($this->input->post('variable'), $this->input->post('valor'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('parametros');
        echo $this->db->affected_rows();
    }
    
    public function observacion_cliente($id)
    {
        $this->load->model('catalogo_model');
        echo $this->catalogo_model->observacion_cliente($id);
    }

    public function observacion_cliente2($id)
    {
        $this->load->model('catalogo_model');
        echo "<h2>Observaci&oacute;n sobre el cliente</h2>";
        echo $this->catalogo_model->observacion_cliente($id);
    }
}

/* End of file recepcion.php */
/* Location: ./application/controllers/recepcion.php */
