<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Catalogo extends CI_Controller
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

    public function importar()
    {
        if (!file_exists("./uploads")) {
            mkdir("./uploads");
        }
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";

        $data['titulo'] = "SASTRERIA";
        $data['contenido'] = "catalogo/importar";

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    function do_upload()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'mdb';
        $config['max_size'] = '0';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());

            $this->importar();
        } else {
            $data = array('upload_data' => $this->upload->data());
            $this->subir_datos($data['upload_data']['full_path']);
            $this->importar();
        }

    }


    function do_upload_csv()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '0';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            $this->importar();
        } else {
            $data = array('upload_data' => $this->upload->data());
            $this->subir_csv($data['upload_data']['file_name']);
            $this->importar();
        }

    }

    private function subir_csv($file)
    {
        $filePath = './uploads/' . $file;

        $row = 1;
        if (($handle = fopen($filePath, "r")) !== false) {

            $a = array();
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $num = count($data);
                //echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                for ($c = 0; $c < $num; $c++) {
                    //echo $data[$c] . "<br />\n";
                }

                $b = array(
                    'idprenda' => $data[0],
                    'prenda' => $data[1],
                    'servicio' => $data[3],
                    'precio' => $data[4]);

                array_push($a, $b);

            }
            fclose($handle);
            $this->db->truncate('cs_precios');
            $this->db->truncate('prendas');
            $this->db->truncate('servicios');
            $this->db->insert_batch('cs_precios', $a);

            $this->db->query("insert into prendas(SELECT idprenda, prenda, 1 FROM cs_precios group by idprenda);");
            $this->db->query("insert into servicios (SELECT id, servicio, precio, idprenda, now(), 1 FROM cs_precios c);");
        }

    }

    private function subir_datos($base)
    {
        $dbName = $base;

        if (!file_exists($dbName)) {
            die("Could not find database file.");
        }
        $db = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$dbName; Uid=; Pwd=;");

        //Prendas

        $sql = "select * from CatPrendas;";
        $result = $db->query($sql);

        $a = array();

        while ($row = $result->fetch()) {
            array_push($a, array('id' => $row['IdPrenda'], 'prenda' => utf8_encode($row['Descripcion'])));
        }
        $this->db->truncate('cs_prendas');
        $this->db->insert_batch('cs_prendas', $a);

        //Servicios
        $sql = "select * from CatServicios;";
        $result = $db->query($sql);

        $a = array();

        while ($row = $result->fetch()) {
            array_push($a, array(
                'id' => $row['IdServicio'],
                'nombre' => utf8_encode($row['Descripcion']),
                'precio' => $row['Precio'],
                'prenda' => $row['IdPrenda']));
        }
        $this->db->truncate('cs_servicios');
        $this->db->insert_batch('cs_servicios', $a);

        //Ordenes
        $sql = "select * from Ordenes;";
        $result = $db->query($sql);

        $a = array();

        //id, id_cliente, fecha_alta, fecha_entrega, hora_entrega, importe, descu, descuentox, total, abono, pendiente, no_prendas, observacion, id_status, id_user, fecha_captura
        while ($row = $result->fetch()) {
            array_push($a, array(
                'id' => $row['IdOrden'],
                'id_cliente' => $row['IdCliente'],
                'fecha_alta' => $row['FechaAlta'],
                'fecha_entrega' => $row['FechaEntrega'],
                'hora_entrega' => $row['HoraEntrega'],
                'importe' => $row['Importe'],
                'descu' => $row['Descuento'],
                'descuentox' => $row['DescPorciento'],
                'total' => $row['Total'],
                'abono' => $row['Abono'],
                'pendiente' => $row['Pendiente'],
                'no_prendas' => $row['NoPrendas'],
                'observacion' => utf8_encode($row['Observaciones']),
                'id_status' => $row['IdStatus'],
                'id_user' => $row['IdUsuario'],
                'fecha_captura' => $row['FechaActualiza']));
        }
        $this->db->truncate('cs_ordenes');
        $this->db->insert_batch('cs_ordenes', $a);


        //Ordenes Detalle
        $sql = "select * from OrdenesDetalle;";
        $result = $db->query($sql);

        $a = array();

        //id, ordenid, prendaid, servicioid, precio, cantidad, idservicio2
        while ($row = $result->fetch()) {
            array_push($a, array(
                'ordenid' => $row['IdOrden'],
                'prendaid' => $row['IdPrenda'],
                'servicioid' => $row['IdServicio'],
                'precio' => $row['PUnitario'],
                'cantidad' => $row['Cantidad']));
        }
        $this->db->truncate('cs_ordendetalle');
        $this->db->insert_batch('cs_ordendetalle', $a);
        $this->db->query("update cs_ordendetalle o, cs_servicios s set idservicio2 = id2 where o.prendaid = s.prenda and o.servicioid = s.id;");


        //Pagos
        $sql = "select * from Pagos;";
        $result = $db->query($sql);

        $a = array();

        //id, ordenid, pago, referencia, abono, fecha, user_id
        while ($row = $result->fetch()) {
            array_push($a, array(
                'ordenid' => $row['IdOrden'],
                'pago' => $row['IdFormaPago'],
                'referencia' => $row['Referencia'],
                'abono' => $row['Monto'],
                'fecha' => $row['Fecha'],
                'user_id' => $row['IdUsuario']));
        }
        $this->db->truncate('cs_pagos');
        $this->db->insert_batch('cs_pagos', $a);


        //Clientes
        $sql = "select * from CatClientes;";
        $result = $db->query($sql);

        $a = array();

        //id, nombre, dire, correo, telcasa, teltra, telcel
        while ($row = $result->fetch()) {
            array_push($a, array(
                'id' => $row['IdCliente'],
                'nombre' => utf8_encode($row['Nombre']),
                'dire' => utf8_encode($row['Direccion']),
                'correo' => utf8_encode($row['Mail']),
                'telcasa' => $row['TelCasa'],
                'teltra' => $row['TelOficina'],
                'telcel' => $row['TelCelular']));
        }
        $this->db->truncate('cs_clientes');
        $this->db->insert_batch('cs_clientes', $a);


        //Formas de Pago

        $sql = "select * from CatFormaPagos;";
        $result = $db->query($sql);

        $a = array();

        while ($row = $result->fetch()) {
            array_push($a, array('id' => $row['IdFormaPago'], 'nombre' => utf8_encode($row['Descripcion'])));
        }
        $this->db->truncate('cs_formas_pago');
        $this->db->insert_batch('cs_formas_pago', $a);


        //Status

        $sql = "select * from CatStatus;";
        $result = $db->query($sql);

        $a = array();

        while ($row = $result->fetch()) {
            array_push($a, array('id' => $row['IdStatus'], 'nombre' => utf8_encode($row['Descripcion'])));
        }
        $this->db->truncate('cs_estatus');
        $this->db->insert_batch('cs_estatus', $a);


        //Usuarios
        $sql = "select * from CatUsuarios;";
        $result = $db->query($sql);

        $a = array();

        //id, username, password, nivel, nombre
        while ($row = $result->fetch()) {
            array_push($a, array(
                'id' => $row['IdUsuario'],
                'username' => utf8_encode($row['Usuario']),
                'password' => utf8_encode($row['clave']),
                'nivel' => $row['Nivel'],
                'nombre' => utf8_encode(trim($row['Nombre']) . " " . trim($row['APaterno']) .
                    " " . trim($row['AMaterno']))));
        }
        $this->db->truncate('cs_usuarios');
        $this->db->insert_batch('cs_usuarios', $a);

        $this->db->query("update estatus e, cs_estatus c, cs_ordenes o set o.id_status = e.id where e.nombre = c.nombre and o.id_status = c.id;");

        $this->db->query("insert into clientes
(id, nombre, dire, correo, telcasa, teltra, telcel)
(select id, nombre, dire, correo, telcasa, teltra, telcel from cs_clientes);");

        $this->db->query("insert into orden_c (id, id_cliente, fecha_alta, fecha_entrega, hora_entrega, importe, descu, descuentox, total, abono, pendiente, no_prendas, observacion, id_status, id_user, fecha_captura)
(SELECT id, id_cliente, fecha_alta, fecha_entrega, hora_entrega, importe, descu, descuentox, total, abono, pendiente, no_prendas, observacion, id_status, id_user, fecha_captura FROM cs_ordenes);");

        $this->db->query("insert into orden_d (id, c_id, s_id, precio, cantidad, id_user)
(SELECT id, ordenid, idservicio2, precio, cantidad, null FROM cs_ordendetalle);");

        $this->db->query("insert into orden_p (id, c_id, pago, referencia, abono, fecha, user_id)
(SELECT id, ordenid, pago, referencia, abono, fecha, user_id FROM cs_pagos);");

        $this->db->query("insert into prendas (id, nombre)
(SELECT * FROM cs_prendas);");

        $this->db->query("insert into servicios (id, nombre, precio, prenda, fecha)
(SELECT id2, nombre, precio, prenda, now() FROM cs_servicios);");

        $this->db->query("insert into usuarios (id, username, password, nivel, nombre, puesto)
(SELECT id, username, password, nivel, nombre, case when nivel = 1 then 'SUPERVISOR DE TIENDA' else 'ENCARGADO' end FROM cs_usuarios where id not in(0, 1));");

    }

    public function index($campo = 'id', $orden = 'ASC')
    {
        $this->load->model('catalogo_model');
        $this->load->library('pagination');
        $config['uri_segment'] = 5;
        $config['base_url'] = site_url() . '/catalogo/index/' . $campo . '/' . $orden .
            '/';
        $config['total_rows'] = $this->catalogo_model->get_num_clientes();
        $config['per_page'] = '50';
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


        $data['titulo'] = "SASTRERIA";
        $data['contenido'] = "catalogo/limpio";
        $data['tabla'] = $this->catalogo_model->clientes($campo, $orden, $config['per_page'],
            $this->uri->segment(5));

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    function busca_clientes()
    {
        $busca = $this->input->post('busca');
        $this->load->model('catalogo_model');
        echo $this->catalogo_model->busqueda_clientes($busca);
    }

    public function tabla_clientes()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $this->load->model('catalogo_model');

        $data['titulo'] = "CATALOGO DE CLIENTES";
        $data['contenido'] = "catalogo/clientes_c_form_agrega";

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    function insert_cliente()
    {
        $nom = $this->input->post('nom');
        $dir = $this->input->post('dir');
        $col = $this->input->post('col');
        $pob = $this->input->post('pob');
        $cp = $this->input->post('cp');
        $correo = $this->input->post('correo');
        $rfc = $this->input->post('rfc');
        $tcas = $this->input->post('tcas');
        $ttra = $this->input->post('ttra');
        $tcel = $this->input->post('tcel');
        $num = $this->input->post('num');
        $int = $this->input->post('int');

        $this->load->model('catalogo_model');
        $this->catalogo_model->create_member_cliente($nom, $dir, $col, $pob, $cp, $correo,
            $rfc, $tcas, $ttra, $tcel, $num, $int);
        redirect('catalogo');

    }

    function insert_cliente_recepcion()
    {
        $nom = $this->input->post('nom');
        $dir = $this->input->post('dir');
        $col = $this->input->post('col');
        $pob = $this->input->post('pob');
        $cp = $this->input->post('cp');
        $correo = $this->input->post('correo');
        $rfc = $this->input->post('rfc');
        $tcas = $this->input->post('tcas');
        $ttra = $this->input->post('ttra');
        $tcel = $this->input->post('tcel');
        $num = $this->input->post('num');
        $int = $this->input->post('inte');

        $this->load->model('catalogo_model');
        echo $this->catalogo_model->create_member_cliente($nom, $dir, $col, $pob, $cp, $correo,
            $rfc, $tcas, $ttra, $tcel, $num, $int);
    }

    public function cambia_cliente($id)
    {

        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        //$data['dondeestoy'] = "main/dondeestoy";
        $this->load->model('catalogo_model');
        $trae = $this->catalogo_model->trae_datos_cliente($id);
        $row = $trae->row();
        $data['id'] = $id;
        $data['nom'] = $row->nombre;
        $data['dir'] = $row->dire;
        $data['num'] = $row->num;
        $data['int'] = $row->int;
        $data['col'] = $row->col;
        $data['pob'] = $row->pob;
        $data['cp'] = $row->cp;
        $data['rfc'] = $row->rfc;
        $data['correo'] = $row->correo;
        $data['tcas'] = $row->telcasa;
        $data['ttra'] = $row->teltra;
        $data['tcel'] = $row->telcel;
        $data['tipo'] = $row->tipo;
        $data['observacion'] = $row->obser_cli;

        $data['titulo'] = "CAMBIAR DATOS DE CLIENTE";
        $data['contenido'] = "catalogo/clientes_c_form_cambia";
        $data['tabla'] = '';

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    function cambia_cliente_datos()
    {
        $id = $this->input->post('id');
        $nom = $this->input->post('nom');
        $dir = $this->input->post('dir');
        $col = $this->input->post('col');
        $pob = $this->input->post('pob');
        $cp = $this->input->post('cp');
        $correo = $this->input->post('correo');
        $rfc = $this->input->post('rfc');
        $tcas = $this->input->post('tcas');
        $ttra = $this->input->post('ttra');
        $tcel = $this->input->post('tcel');
        $num = $this->input->post('num');
        $int = $this->input->post('int');
        $tipo = $this->input->post('tipo');
        $observacion = $this->input->post('observacion');

        $this->load->model('catalogo_model');
        $this->catalogo_model->update_member_cliente($id, $nom, $dir, $col, $pob, $cp, $correo,
            $rfc, $tcas, $ttra, $tcel, $num, $int, $tipo, $observacion);
        redirect('catalogo');
    }

    public function tabla_prendas()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $this->load->model('catalogo_model');

        $data['titulo'] = "CATALOGO DE PRENDAS";
        $data['contenido'] = "catalogo/prendas_c_form_agrega";
        $data['tabla'] = $this->catalogo_model->prendas();

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    function insert_prenda()
    {
        $nom = $this->input->post('nom');

        $this->load->model('catalogo_model');
        $this->catalogo_model->create_member_prenda($nom);
        redirect('catalogo/tabla_prendas');

    }

    public function cambia_prendas($id)
    {

        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $this->load->model('catalogo_model');
        $trae = $this->catalogo_model->trae_datos_prendas($id);
        $row = $trae->row();
        $data['id'] = $id;
        $data['nom'] = $row->nombre;
        $data['tipo'] = $row->tipo;


        $data['titulo'] = "CAMBIAR DATOS DE PRENDAS";
        $data['contenido'] = "catalogo/prendas_c_form_cambia";
        $data['tabla'] = '';

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    function cambia_prenda_datos()
    {
        $id = $this->input->post('id');
        $nom = $this->input->post('nom');
        $tipo = $this->input->post('tipo');

        $this->load->model('catalogo_model');
        $this->catalogo_model->update_member_prendas($id, $nom, $tipo);
        redirect('catalogo/tabla_prendas');
    }

    public function tabla_pagos()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $this->load->model('catalogo_model');

        $data['titulo'] = "CATALOGO DE PAGOS";
        $data['contenido'] = "catalogo/pagos_c_form_agrega";
        $data['tabla'] = $this->catalogo_model->pagos();

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    function insert_pagos()
    {
        $nom = $this->input->post('nom');

        $this->load->model('catalogo_model');
        $this->catalogo_model->create_member_pagos($nom);
        redirect('catalogo/tabla_pagos');

    }

    public function cambia_pagos($id)
    {

        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $this->load->model('catalogo_model');
        $trae = $this->catalogo_model->trae_datos_pagos($id);
        $row = $trae->row();
        $data['id'] = $id;
        $data['nom'] = $row->nombre;
        $data['tipo'] = $row->tipo;


        $data['titulo'] = "CAMBIAR DATOS DE PAGOS";
        $data['contenido'] = "catalogo/pagos_c_form_cambia";
        $data['tabla'] = '';

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    function cambia_pagos_datos()
    {
        $id = $this->input->post('id');
        $nom = $this->input->post('nom');
        $tipo = $this->input->post('tipo');

        $this->load->model('catalogo_model');
        $this->catalogo_model->update_member_pagos($id, $nom, $tipo);
        redirect('catalogo/tabla_pagos');
    }

    public function tabla_horarios()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $this->load->model('catalogo_model');

        $data['titulo'] = "CATALOGO DE HORARIOS";
        $data['contenido'] = "catalogo/limpio";
        $data['tabla'] = $this->catalogo_model->horarios();

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    public function tabla_estatus()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $this->load->model('catalogo_model');

        $data['titulo'] = "CATALOGO DE STATUS";
        $data['contenido'] = "catalogo/limpio";
        $data['tabla'] = $this->catalogo_model->estatus();

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    public function tabla_servicios()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $this->load->model('catalogo_model');
        $data['prex'] = $this->catalogo_model->busca_prenda();
        $data['titulo'] = "CATALOGO DE SERVICIOS";
        $data['contenido'] = "catalogo/servicios_c_form_agrega";
        $data['tabla'] = $this->catalogo_model->servicios();

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    function insert_servicios()
    {
        $nom = $this->input->post('nom');
        $pre = $this->input->post('pre');
        $precio = $this->input->post('precio');

        $this->load->model('catalogo_model');
        $this->catalogo_model->create_member_servicios($nom, $pre, $precio);
        redirect('catalogo/tabla_servicios');

    }

    function recepcion_insert_servicios()
    {
        $nom = $this->input->post('nom');
        $pre = $this->input->post('pre');
        $precio = $this->input->post('precio');

        $this->load->model('catalogo_model');
        echo $this->catalogo_model->create_member_servicios($nom, $pre, $precio);

    }

    public function cambia_servicios($id)
    {

        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $this->load->model('catalogo_model');
        $trae = $this->catalogo_model->trae_datos_servicios($id);
        $row = $trae->row();
        $data['id'] = $id;
        $data['pre'] = $row->prenda;
        $data['prendax'] = $row->prendax;
        $data['nom'] = $row->nombre;
        $data['precio'] = $row->precio;
        $data['tipo'] = $row->tipo;


        $data['titulo'] = "CAMBIAR DATOS DE SERVICIOS";
        $data['contenido'] = "catalogo/servicios_c_form_cambia";
        $data['tabla'] = '';

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    function cambia_servicios_datos()
    {
        $id = $this->input->post('id');
        $nom = $this->input->post('nombre');
        $pre = $this->input->post('pre');
        $precio = $this->input->post('precio');
        $tipo = $this->input->post('tipo');

        $this->load->model('catalogo_model');
        $this->catalogo_model->update_member_servicios($id, $nom, $pre, $precio, $tipo);
        redirect('catalogo/tabla_servicios');
    }

    public function usuarios()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $this->load->model('catalogo_model');

        $data['titulo'] = "CATALOGO DE USUARIOS";
        $data['contenido'] = "catalogo/usuarios";
        $this->load->model('catalogo_model');
        $data['tabla'] = $this->catalogo_model->usuarios();

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    public function nuevo_usuario()
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $this->load->model('catalogo_model');

        $data['titulo'] = "AGREGA UN NUEVO USUARIO";
        $data['contenido'] = "catalogo/nuevo_usuario";

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    public function nuevo_usuario_submit()
    {
        //id, username, password, nivel, tipo, nombre, puesto, email, avatar
        $data->username = $this->input->post('username');
        $data->password = $this->input->post('password');
        $data->nivel = 2;
        $data->tipo = 1;
        $data->nombre = $this->input->post('nombre');
        $data->puesto = 'CAJERO';
        $data->email = $this->input->post('email');
        $data->avatar = 'sample_user.png';

        $this->db->insert('usuarios', $data);
        echo $this->db->insert_id();
    }

    public function cambia_usuario($id)
    {
        $data = array();
        $data['menu'] = 'inicio';
        $data['submenu'] = 'completo';
        //$data['sidebar'] = "head/sidebar";
        //$data['widgets'] = "main/widgets";
        $data['dondeestoy'] = "main/dondeestoy";
        $this->load->model('catalogo_model');

        $data['titulo'] = "MODIFICA USUARIO";
        $data['contenido'] = "catalogo/cambia_usuario";
        $this->load->model('catalogo_model');
        $data['query'] = $this->catalogo_model->usuario($id);

        $this->load->view('header');
        $this->load->view('main', $data);
    }

    public function cambia_usuario_submit()
    {
        //id, username, password, nivel, tipo, nombre, puesto, email, avatar
        $data->username = $this->input->post('username');
        $data->password = $this->input->post('password');
        $data->tipo = $this->input->post('tipo');
        ;
        $data->nombre = $this->input->post('nombre');
        $data->email = $this->input->post('email');

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('usuarios', $data);
        echo $this->db->affected_rows();
    }
    

}

/* End of file catalogo.php */
/* Location: ./application/controllers/catalogo.php */
