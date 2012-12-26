<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));

    }

    function index($error = null)
    {
        $data['error'] = $error;
        $this->load->view('login/login', $data);
    }

    function validate_credentials()
    {
        $this->load->model('miembros_model');
        $query = $this->miembros_model->validate();

        if ($query->num_rows == 1) // if the user's credentials validated...
            {

            $row = $query->row();

            $data = array(
                'username' => $row->username,
                'is_logged_in' => true,
                'nivel' => $row->nivel,
                'nombre' => $row->nombre,
                'id' => $row->id,
                'tipo' => $row->tipo,
                'puesto' => $row->puesto,
                'email' => $row->email,
                'avatar' => $row->avatar);
            $this->session->set_userdata($data);
            redirect('welcome');
        } else // incorrect username or password
        {
            redirect('login/index/1');
        }
    }

    public function perfil()
    {
        $data = array();
        //$data['sidebar'] = "head/sidebar";
        //$data['widgwet'] = "main/widwets";
        //$data['sidebar'] = "main/dondeestoy";
        $this->load->model('miembros_model');

        $data_c['extraheader'] = "
        <script type=\"text/javascript\" src=\"" . base_url() .
            "js/AjaxUpload.2.0.min.js\"></script>
        ";

        $data['titulo'] = "Perfil del Usuario";
        $data['contenido'] = "login/perfil";
        $data['query'] = $this->miembros_model->datos_usuario($this->session->userdata('id'));

        $this->load->view('header', $data_c);
        $this->load->view('main', $data);
    }

    public function submit_perfil()
    {
        $this->load->model('miembros_model');
        $this->miembros_model->update_usuario();
        redirect('welcome', 'refresh');
    }

    function upload_avatar()
    {
        $uploaddir = './img/avatar/';
        $file = basename($_FILES['userfile']['name']);
        $uploadfile = $uploaddir . $file;

        $config['image_library'] = 'gd2';
        $config['source_image'] = $uploadfile;
        $config['create_thumb'] = false;
        $config['maintain_ratio'] = true;
        $config['width'] = 45;
        $config['height'] = 45;
        $config['master_dim'] = 'auto';


        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {

            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $this->load->model('miembros_model');

            echo $this->miembros_model->update_avatar($file);
        } else {
            echo "error";
        }

    }

    function inicializar()
    {
        $sql = "CREATE TABLE `audita_servicios` (
  `id` int(10) unsigned NOT NULL,
  `nombre_anterior` varchar(255) default NULL,
  `nombre_nuevo` varchar(255) default NULL,
  `precio_anterior` decimal(11,2) default NULL,
  `precio_nuevo` decimal(11,2) default NULL,
  `prenda_anterior` int(9) unsigned default NULL,
  `prenda_nueva` int(9) unsigned default NULL,
  `fecha` datetime default NULL,
  `consecutivo` int(10) unsigned NOT NULL auto_increment,
  `activo_antes` tinyint(3) unsigned default NULL,
  `activo_despues` tinyint(3) unsigned default NULL,
  PRIMARY KEY  (`consecutivo`),
  KEY `prenda_nuevak` (`prenda_nueva`),
  KEY `prenda_anteriork` (`prenda_anterior`),
  KEY `index_4` (`id`),
  KEY `Index_5` (`fecha`)
) TYPE=MyISAM;

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL default '0',
  `ip_address` varchar(16) NOT NULL default '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text,
  PRIMARY KEY  (`session_id`)
) TYPE=InnoDB;

CREATE TABLE `clientes` (
  `id` int(9) unsigned NOT NULL auto_increment,
  `nombre` varchar(70) NOT NULL,
  `dire` varchar(255) NOT NULL,
  `col` varchar(100) default ' ',
  `pob` varchar(100) default ' ',
  `num` varchar(50) default ' ',
  `int` varchar(50) default ' ',
  `cp` varchar(100) default '0',
  `descu` decimal(5,2) default '0.00',
  `rfc` varchar(13) default ' ',
  `correo` varchar(45) default ' ',
  `telcasa` varchar(100) default ' ',
  `teltra` varchar(18) default ' ',
  `telcel` varchar(18) default ' ',
  `tipo` int(2) unsigned default '0',
  PRIMARY KEY  (`id`)
) TYPE=InnoDB ROW_FORMAT=DYNAMIC;

CREATE TABLE `cs_clientes` (
  `id` int(9) unsigned NOT NULL auto_increment,
  `nombre` varchar(70) NOT NULL,
  `dire` varchar(255) NOT NULL,
  `correo` varchar(45) default ' ',
  `telcasa` varchar(100) default ' ',
  `teltra` varchar(18) default ' ',
  `telcel` varchar(18) default ' ',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM ROW_FORMAT=DYNAMIC;

CREATE TABLE `cs_estatus` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) TYPE=MyISAM;

CREATE TABLE `cs_formas_pago` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) TYPE=MyISAM;

CREATE TABLE `cs_ordendetalle` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ordenid` int(10) unsigned NOT NULL default '0',
  `prendaid` int(10) unsigned NOT NULL default '0',
  `servicioid` int(10) unsigned NOT NULL default '0',
  `precio` decimal(11,2) NOT NULL default '0.00',
  `cantidad` int(10) unsigned NOT NULL default '0',
  `idservicio2` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `orden_c` (`ordenid`),
  KEY `prena` (`prendaid`),
  KEY `servicio` (`servicioid`),
  KEY `Index_4` (`idservicio2`)
) TYPE=MyISAM ROW_FORMAT=DYNAMIC;

CREATE TABLE `cs_ordenes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `id_cliente` int(10) unsigned NOT NULL default '0',
  `fecha_alta` date NOT NULL,
  `fecha_entrega` date NOT NULL,
  `hora_entrega` time NOT NULL,
  `importe` decimal(11,2) NOT NULL default '0.00',
  `descu` decimal(11,2) NOT NULL default '0.00',
  `descuentox` int(10) unsigned NOT NULL default '0',
  `total` decimal(11,2) NOT NULL default '0.00',
  `abono` decimal(11,2) NOT NULL default '0.00',
  `pendiente` decimal(11,2) NOT NULL default '0.00',
  `no_prendas` int(10) unsigned NOT NULL default '0',
  `observacion` text,
  `id_status` int(10) unsigned NOT NULL default '1',
  `id_user` int(10) unsigned default NULL,
  `fecha_captura` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `id_cliente` (`id_cliente`),
  KEY `fecha_alta` (`fecha_alta`),
  KEY `fecha_entrega` (`fecha_entrega`),
  KEY `id_status` (`id_status`),
  KEY `id_user` (`id_user`)
) TYPE=MyISAM ROW_FORMAT=DYNAMIC;

CREATE TABLE `cs_pagos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ordenid` int(10) unsigned NOT NULL,
  `pago` int(10) unsigned NOT NULL,
  `referencia` varchar(45) default NULL,
  `abono` decimal(11,2) NOT NULL default '0.00',
  `fecha` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `index_2` (`ordenid`),
  KEY `index_4` (`user_id`),
  KEY `index_3` (`fecha`)
) TYPE=MyISAM ROW_FORMAT=DYNAMIC;

CREATE TABLE `cs_prendas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `prenda` varchar(60) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `cs_servicios` (
  `id` int(10) unsigned NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `prenda` int(9) unsigned NOT NULL,
  `id2` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`,`prenda`),
  KEY `prendas` (`prenda`),
  KEY `index_3` (`id2`)
) TYPE=MyISAM;

CREATE TABLE `cs_usuarios` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `nivel` tinyint(3) unsigned NOT NULL,
  `nombre` varchar(60) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `index_2` (`username`)
) TYPE=MyISAM ROW_FORMAT=DYNAMIC;

CREATE TABLE `estatus` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  `tipo` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) TYPE=InnoDB AUTO_INCREMENT=5;

INSERT INTO `estatus` (`id`,`nombre`,`tipo`) VALUES
 (1,'PENDIENTE',1),
 (2,'CANCELADO',1),
 (3,'PROCESO',1),
 (4,'ENTREGADO',1);

CREATE TABLE `horario` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `horario` time NOT NULL,
  `tipo` int(2) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=InnoDB AUTO_INCREMENT=28;

INSERT INTO `horario` (`id`,`horario`,`tipo`) VALUES
 (1,'08:00:00',0),
 (2,'08:30:00',0),
 (3,'09:00:00',0),
 (4,'09:30:00',0),
 (5,'10:00:00',0),
 (6,'10:30:00',0),
 (7,'11:00:00',0),
 (8,'11:30:00',0),
 (9,'12:00:00',0),
 (10,'12:30:00',0),
 (11,'13:00:00',0),
 (12,'13:30:00',0),
 (13,'14:00:00',0),
 (14,'14:30:00',0),
 (15,'15:00:00',0),
 (16,'15:30:00',0),
 (17,'16:00:00',0),
 (18,'16:30:00',0),
 (19,'17:00:00',0),
 (20,'17:30:00',0),
 (21,'18:00:00',0),
 (22,'18:30:00',0),
 (23,'19:00:00',0),
 (24,'19:30:00',0),
 (25,'20:00:00',0),
 (26,'20:30:00',0),
 (27,'21:00:00',0);

CREATE TABLE `orden_c` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `id_cliente` int(10) unsigned NOT NULL default '0',
  `fecha_alta` date NOT NULL,
  `fecha_entrega` date NOT NULL,
  `hora_entrega` time NOT NULL,
  `importe` decimal(11,2) NOT NULL default '0.00',
  `descu` decimal(11,2) NOT NULL default '0.00',
  `descuentox` int(10) unsigned NOT NULL default '0',
  `total` decimal(11,2) NOT NULL default '0.00',
  `abono` decimal(11,2) NOT NULL default '0.00',
  `pendiente` decimal(11,2) NOT NULL default '0.00',
  `no_prendas` int(10) unsigned NOT NULL default '0',
  `observacion` text,
  `id_status` int(10) unsigned NOT NULL default '1',
  `id_user` int(10) unsigned default NULL,
  `fecha_captura` datetime default NULL,
  `motivo_cancelacion` varchar(255) default NULL,
  `fecha_cancelacion` datetime default NULL,
  `id_user_cancelacion` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `id_cliente` (`id_cliente`),
  KEY `fecha_alta` (`fecha_alta`),
  KEY `fecha_entrega` (`fecha_entrega`),
  KEY `id_status` (`id_status`),
  KEY `id_user` (`id_user`),
  KEY `Index_7` (`id_user_cancelacion`)
) TYPE=InnoDB ROW_FORMAT=DYNAMIC COMMENT='InnoDB free: 1136640 kB';

CREATE TABLE `orden_d` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `c_id` int(10) unsigned NOT NULL default '0',
  `s_id` int(10) unsigned NOT NULL default '0',
  `precio` decimal(11,2) NOT NULL default '0.00',
  `cantidad` int(10) unsigned NOT NULL default '0',
  `id_user` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `orden_c` (`c_id`),
  KEY `servicio` (`s_id`),
  KEY `Index_4` (`id_user`)
) TYPE=InnoDB ROW_FORMAT=DYNAMIC;

CREATE TABLE `orden_p` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `c_id` int(10) unsigned NOT NULL,
  `pago` int(10) unsigned NOT NULL,
  `referencia` varchar(45) default NULL,
  `abono` decimal(11,2) NOT NULL default '0.00',
  `fecha` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `index_2` (`c_id`),
  KEY `index_4` (`user_id`),
  KEY `index_3` (`fecha`)
) TYPE=InnoDB ROW_FORMAT=DYNAMIC;

CREATE TABLE `pagos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL,
  `tipo` int(2) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) TYPE=InnoDB AUTO_INCREMENT=6;

INSERT INTO `pagos` (`id`,`nombre`,`tipo`) VALUES
 (1,'EFECTIVO',1),
 (2,'CHEQUE',1),
 (3,'TARJETA',1),
 (4,'CLIENTE FRECUENTE',1),
 (5,'VALES',1);

 CREATE TABLE `parametros` (
  `dias` int(2) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL auto_increment,
  `sucursal` varchar(255) NOT NULL,
  `razon` varchar(255) NOT NULL,
  `rfc` varchar(13) NOT NULL,
  `regimen` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `clausulado` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2;

INSERT INTO `parametros` (`dias`,`id`,`sucursal`,`razon`,`rfc`,`regimen`,`direccion`,`clausulado`) VALUES
 (2,1,'Sucursal:','Razon Social','RFC','Regimen de Pequeño Contribuyente -----------------------------------------------','----------------------------------------------------','<p>Contrato de servicio que celebra entre el prestador del servicio y el consumidor cuyos nombres y datos constan en el presente documento, sujetándose a las siguientes clausulas:</p>\n1.	El número de prendas dejadas en el establecimiento están especificadas en el presente documento.</p>\n2.	Si al momento de recoger sus prendas el cliente no presenta su comprobante, deberá de presentar una copia de se identificación oficial.</p>\n3.	El cliente tiene una garantía de tres días hábiles para realizar cualquier reclamación sobre el trabajo realizado, con la presentación del comprobante de la prenda.</P>\n4.	En caso de no poder presentarse dentro de los tres días hábiles para hacer valida su garantía, deberá de notificar vía telefónica a la persona encargada, quien le proporcionara una clave para que el cliente pase en un lapso no mayor a 10 días hábiles.</p>\n5.	El establecimiento no se hace responsable de ningún objeto o valor olvidado en las prendas recibidas.</p>\n6.	El establecimiento no se hace responsable, por aquellas prendas que permanezcan más de noventa días y que no hayan sido buscadas por sus dueños, otorgándose de esta forma al establecimiento de manera inmediata, acreedor de las prendas olvidadas.</p>\n7.	El cliente pagara al establecimiento por concepto de almacenaje después de cuarenta y cinco días el 3% diario sobre el valor del comprobante, considerando que el importe a pagar no sea mayor o igual al importe del comprobante emitido.</p>\n8.	En caso de deterioro total o parcial de la prenda así como perdida de la misma, el establecimiento pagara al propietario de la misma hasta un máximo de 8 veces el costo del servicio pactado por dicha prenda, o un máximo del 80% del valor de la prenda que las partes de común acuerdo hayan declarado o en su defecto, el cliente puede demostrar con la nota de compra.</p>\n9.	Para dirimir cualquier controversia las partes se someten a la ley de protección al consumidor.</p>\nEl consumidor dará por aceptadas las normas, en el momento en que se reciba el comprobante de acuse de recibo.</p>');

 CREATE TABLE `prendas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL,
  `tipo` int(2) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) TYPE=InnoDB ROW_FORMAT=DYNAMIC;

CREATE TABLE `servicios` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `prenda` int(9) unsigned NOT NULL,
  `fecha` datetime NOT NULL,
  `tipo` int(2) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `prendas` (`prenda`)
) TYPE=InnoDB;

DELIMITER $$

CREATE TRIGGER `servicios_inserta` AFTER INSERT ON `servicios` FOR EACH ROW BEGIN
insert into audita_servicios (id, nombre_anterior, nombre_nuevo, precio_anterior, precio_nuevo, prenda_anterior, prenda_nueva, fecha, activo_antes, activo_despues) values (NEW.id, null, NEW.nombre, null, NEW.precio, null, NEW.prenda, now(), null, NEW.tipo);
END $$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER `servicios_actualiza` AFTER UPDATE ON `servicios` FOR EACH ROW BEGIN
insert into audita_servicios (id, nombre_anterior, nombre_nuevo, precio_anterior, precio_nuevo, prenda_anterior, prenda_nueva, fecha, activo_antes, activo_despues) values (NEW.id, OLD.nombre, NEW.nombre, OLD.precio, NEW.precio, OLD.prenda, NEW.prenda, now(), OLD.tipo, NEW.tipo);
END $$

DELIMITER ;

CREATE TABLE `usuarios` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `nivel` tinyint(3) unsigned NOT NULL,
  `tipo` tinyint(3) unsigned NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `puesto` varchar(45) NOT NULL,
  `email` varchar(45) default NULL,
  `avatar` varchar(45) NOT NULL default 'sample_user.png',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `index_2` (`username`)
) TYPE=InnoDB AUTO_INCREMENT=2 ROW_FORMAT=DYNAMIC;
INSERT INTO `usuarios` (`id`,`username`,`password`,`nivel`,`tipo`,`nombre`,`puesto`,`email`,`avatar`) VALUES
 (1,'admin','admin',1,1,'SUPERVISOR DE TIENDA','SUPERVISOR',NULL,'sample_user.png');";
    }


    function logout()
    {
        $this->session->sess_destroy();
        redirect('login', 'refresh');
    }

}
