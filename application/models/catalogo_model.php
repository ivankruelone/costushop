<?php
class Catalogo_model extends CI_Model
{

    function get_num_clientes()
    {
        $this->db->select('count(*) as cuenta', false);
        $query = $this->db->get('clientes');
        $row = $query->row();

        return $row->cuenta;

    }

    public function observacion_cliente($id)
    {
        $this->db->select('obser_cli');
        $this->db->where('id', $id);
        $query = $this->db->get('clientes');
        
        if($query->num_rows() > 0){
            
            $row = $query->row();
            return $row->obser_cli;

        }else{
            return null;
        }
        
    }

    function clientes($campo, $orden, $limit, $offset = 0)
    {
        $this->db->order_by($campo, $orden);
        $this->db->limit($limit, $offset);
        $query = $this->db->get('clientes');


        $id_asc = anchor('catalogo/index/id/ASC', 'A');
        $id_desc = anchor('catalogo/index/id/DESC', 'D');

        $nom_asc = anchor('catalogo/index/nombre/ASC', 'A');
        $nom_desc = anchor('catalogo/index/nombre/DESC', 'D');

        $dir_asc = anchor('catalogo/index/dire/ASC', 'A');
        $dir_desc = anchor('catalogo/index/dire/DESC', 'D');
        $data = array(
            'name' => 'busca',
            'id' => 'busca',
            'maxlength' => '100',
            'size' => '50');
        $tabla = anchor('catalogo/tabla_clientes', 'Agrega un nuevo cliente.') .
            "<br /><br />" . "Busca un Cliente: " . form_input($data) . "
		<br />
		<div id=\"resultado_busqueda\">
        <table id=\"hor-minimalist-b\">
        <thead>
        
        <tr>
        <th align=\"left\" width=\"50px\">Id $id_asc / $id_desc</th>
        <th align=\"left\">Nombre $nom_asc / $nom_desc</th>
        <th align=\"left\">Direccion $dir_asc / $dir_desc</th>
        <th align=\"left\">Casa</th>
        <th align=\"left\">Trabajo</th>
        <th align=\"left\">Celular</th>
        <th align=\"left\">Modificar</th>
        
        </tr>
        </thead>
        <tbody>
        ";

        foreach ($query->result() as $row) {
            if ($row->tipo == 1) {
                $color = '#000000';
            } else {
                $color = '#FC0505';
            }
            $l1 = anchor('catalogo/cambia_cliente/' . $row->id, '<img src="' . base_url() .
                'img/edit.png" border="0" width="20px" /></a>', array('title' =>
                    'Haz Click aqui para cambiar datos del cliente!', 'class' => 'encabezado'));

            //id, nombre, dire, descu, rfc, correo, telcasa, teltra, telcel, tipo
            $tabla .= "
            <tr>
            <td align=\"left\"><font color=\"$color\">" . $row->id .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->nombre .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->dire .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->telcasa .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->teltra .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->telcel .
                "</font></td>
            <td align=\"right\"><font color=\"$color\">" . $l1 . "</font></td>
            </tr>
            ";
        }

        $tabla .= "
        </tbody>
        </table>";

        $tabla .= '<div align="center">' . $this->pagination->create_links() .
            '</div></div>';

        return $tabla;
    }

    function busqueda_clientes($busca)
    {
        $this->db->like('nombre', $busca);
        $this->db->order_by('nombre');
        $query = $this->db->get('clientes');

        $tabla = "
        <table id=\"hor-minimalist-b\">
        <thead>
        
        <tr>
        <th align=\"left\" width=\"50px\">Id</th>
        <th align=\"left\">Nombre</th>
        <th align=\"left\">Direccion</th>
        <th align=\"left\">Casa</th>
        <th align=\"left\">Trabajo</th>
        <th align=\"left\">Celular</th>
        <th align=\"left\">Modificar</th>
        
        </tr>
        </thead>
        <tbody>
        ";

        foreach ($query->result() as $row) {
            if ($row->tipo == 1) {
                $color = '#000000';
            } else {
                $color = '#FC0505';
            }
            $l1 = anchor('catalogo/cambia_cliente/' . $row->id, '<img src="' . base_url() .
                'img/edit.png" border="0" width="20px" /></a>', array('title' =>
                    'Haz Click aqui para cambiar datos del cliente!', 'class' => 'encabezado'));

            //id, nombre, dire, descu, rfc, correo, telcasa, teltra, telcel, tipo
            $tabla .= "
            <tr>
            <td align=\"left\"><font color=\"$color\">" . $row->id .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->nombre .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->dire .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->telcasa .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->teltra .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->telcel .
                "</font></td>
            <td align=\"right\"><font color=\"$color\">" . $l1 . "</font></td>
            </tr>
            ";
        }

        $tabla .= "
        </tbody>
        </table>";


        return $tabla;
    }

    function create_member_cliente($nom, $dir, $col, $pob, $cp, $correo, $rfc, $tcas,
        $ttra, $tcel, $num, $int)
    {

        $new_member_insert_data = array(
            'nombre' => strtoupper(trim($nom)),
            'dire' => strtoupper(trim($dir)),
            'col' => strtoupper(trim($col)),
            'pob' => strtoupper(trim($pob)),
            'num' => strtoupper(trim($num)),
            'int' => strtoupper(trim($int)),
            'cp' => strtoupper(trim($cp)),
            'descu' => 0,
            'rfc' => '',
            'correo' => '',
            'telcasa' => $tcas,
            'teltra' => $ttra,
            'telcel' => $tcel,
            'tipo' => 1);

        $insert = $this->db->insert('clientes', $new_member_insert_data);
        return $this->db->insert_id();

    }

    function trae_datos_cliente($id)
    {
        $sql = "SELECT *  FROM clientes  where id= ? ";
        $query = $this->db->query($sql, array($id));
        return $query;
    }

    function busca_cliente()
    {
        $sql = "SELECT id,nombre FROM  clientes where tipo=1";
        $query = $this->db->query($sql);
        $cli = array();
        $cli[0] = "Selecciona un Cliente";
        foreach ($query->result() as $row) {
            $cli[$row->id] = $row->nombre;
        }
        return $cli;
    }

    function busca_hora()
    {
        $sql = "SELECT * FROM  horario;";
        $query = $this->db->query($sql);
        $cli = array();
        foreach ($query->result() as $row) {
            $cli[$row->horario] = $row->horario;
        }
        return $cli;
    }

    function autocomplete()
    {
        $this->db->select('id, nombre, tipo');
        $this->db->like('nombre', $this->input->get_post('term'));
        $this->db->having('tipo', 1);
        $this->db->limit(15);
        $query = $this->db->get('clientes');
        return $query->result();
    }

    function autocomplete_orden()
    {
        $this->db->select('id');
        $this->db->like('id', $this->input->get_post('term'));
        $this->db->limit(15);
        $query = $this->db->get('orden_c');
        return $query->result();
    }

    function update_member_cliente($id, $nom, $dir, $col, $pob, $cp, $correo, $rfc,
        $tcas, $ttra, $tcel, $num, $int, $tipo, $observacion)
    {

        $data = array(
            'nombre' => strtoupper(trim($nom)),
            'dire' => strtoupper(trim($dir)),
            'col' => strtoupper(trim($col)),
            'pob' => strtoupper(trim($pob)),
            'num' => strtoupper(trim($num)),
            'int' => strtoupper(trim($int)),
            'cp' => strtoupper(trim($cp)),
            'descu' => 0,
            'rfc' => '',
            'correo' => '',
            'telcasa' => $tcas,
            'teltra' => $ttra,
            'telcel' => $tcel,
            'tipo' => $tipo,
            'obser_cli' => $observacion);

        $this->db->where('id', $id);
        $this->db->update('clientes', $data);

    }

    function prendas()
    {
        $sql = "SELECT * FROM prendas order by nombre;";
        $query = $this->db->query($sql);


        $tabla = "
        <table id=\"hor-minimalist-b\">
        <thead>
        
        
        
        <tr>
        <th>Id</th>
        <th align=\"left\">Nombre</th>
        
        <th></th>
        
        </tr>
        </thead>
        <tbody>
        ";

        foreach ($query->result() as $row) {
            if ($row->tipo == 1) {
                $color = '#000000';
            } else {
                $color = '#FC0505';
            }
            $l1 = anchor('catalogo/cambia_prendas/' . $row->id, '<img src="' . base_url() .
                'img/edit.png" border="0" width="20px" /></a>', array('title' =>
                    'Haz Click aqui para cambiar datos del cliente!', 'class' => 'encabezado'));
            //id, nombre, dire, descu, rfc, correo, telcasa, teltra, telcel, tipo
            $tabla .= "
            <tr>
            <td align=\"center\"><font color=\"$color\">" . $row->id .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->nombre .
                "</font></td>
            <td align=\"right\"><font color=\"$color\">" . $l1 . "</font></td>
            </tr>
            ";
        }

        $tabla .= "
        </tbody>
        </table>";

        return $tabla;
    }


    function servicios_de_prenda($prenda)
    {
        $this->db->where('prenda', $prenda);
        $this->db->having('tipo', 1);
        $this->db->order_by('nombre');
        $query = $this->db->get('servicios');

        $a = null;

        foreach ($query->result() as $row) {
            $a .= '<option value="' . $row->id . '">' . $row->nombre . ' ( $ ' . $row->
                precio . ' MX )</option>';
        }

        return $a;

    }

    function create_member_prenda($nom)
    {

        $new_member_insert_data = array('nombre' => strtoupper(trim($nom)), 'tipo' => 0);

        $insert = $this->db->insert('prendas', $new_member_insert_data);

    }

    function trae_datos_prendas($id)
    {
        $sql = "SELECT *  FROM prendas  where id= ? ";
        $query = $this->db->query($sql, array($id));
        return $query;
    }

    function busca_prenda()
    {
        $sql = "SELECT id,nombre FROM  prendas where tipo=1 order by nombre;";
        $query = $this->db->query($sql);
        $pre = array();
        $pre[0] = "Selecciona una Prenda";
        foreach ($query->result() as $row) {
            $pre[$row->id] = $row->nombre;
        }
        return $pre;
    }

    function update_member_prendas($id, $nom, $tipo)
    {

        $data = array('nombre' => strtoupper(trim($nom)), 'tipo' => $tipo);

        $this->db->where('id', $id);
        $this->db->update('prendas', $data);

    }

    function pagos()
    {
        $sql = "SELECT * FROM pagos";
        $query = $this->db->query($sql);


        $tabla = "
        <table id=\"hor-minimalist-b\">
        <thead>
        
        
        
        <tr>
        <th>Id</th>
        <th align=\"left\">Nombre</th>
        
        <th></th>
        
        </tr>
        </thead>
        <tbody>
        ";

        foreach ($query->result() as $row) {
            if ($row->tipo == 1) {
                $color = '#000000';
            } else {
                $color = '#FC0505';
            }
            $l1 = anchor('catalogo/cambia_pagos/' . $row->id, '<img src="' . base_url() .
                'img/edit.png" border="0" width="20px" /></a>', array('title' =>
                    'Haz Click aqui para cambiar datos del cliente!', 'class' => 'encabezado'));
            //id, nombre, dire, descu, rfc, correo, telcasa, teltra, telcel, tipo
            $tabla .= "
            <tr>
            <td align=\"center\"><font color=\"$color\">" . $row->id .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->nombre .
                "</font></td>
            <td align=\"right\"><font color=\"$color\">" . $l1 . "</font></td>
            </tr>
            ";
        }

        $tabla .= "
        </tbody>
        </table>";

        return $tabla;
    }

    function create_member_pagos($nom)
    {

        $new_member_insert_data = array('nombre' => strtoupper(trim($nom)), 'tipo' => 0);

        $insert = $this->db->insert('pagos', $new_member_insert_data);

    }

    function trae_datos_pagos($id)
    {
        $sql = "SELECT *  FROM pagos  where id= ? ";
        $query = $this->db->query($sql, array($id));
        return $query;
    }

    function update_member_pagos($id, $nom, $tipo)
    {

        $data = array('nombre' => strtoupper(trim($nom)), 'tipo' => $tipo);

        $this->db->where('id', $id);
        $this->db->update('pagos', $data);

    }

    function horarios()
    {
        $sql = "SELECT * FROM horario";
        $query = $this->db->query($sql);


        $tabla = "
        <table id=\"hor-minimalist-b\">
        <thead>
        
        
        
        <tr>
        <th>Id</th>
        <th align=\"left\">Nombre</th>
         </tr>
        </thead>
        <tbody>
        ";

        foreach ($query->result() as $row) {
            if ($row->tipo == 0) {
                $color = '#000000';
            } else {
                $color = '#FC0505';
            }
            $tabla .= "
            <tr>
            <td align=\"center\"><font color=\"$color\">" . $row->id .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->horario .
                "</font></td>
            </tr>
            ";
        }

        $tabla .= "
        </tbody>
        </table>";

        return $tabla;
    }

    function estatus()
    {
        $sql = "SELECT * FROM estatus";
        $query = $this->db->query($sql);


        $tabla = "
        <table id=\"hor-minimalist-b\">
        <thead>
        
        
        
        <tr>
        <th>Id</th>
        <th align=\"left\">Nombre</th>
         </tr>
        </thead>
        <tbody>
        ";

        foreach ($query->result() as $row) {
            if ($row->tipo == 0) {
                $color = '#000000';
            } else {
                $color = '#FC0505';
            }
            $tabla .= "
            <tr>
            <td align=\"center\"><font color=\"$color\">" . $row->id .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->nombre .
                "</font></td>
            </tr>
            ";
        }

        $tabla .= "
        </tbody>
        </table>";

        return $tabla;
    }

    function servicios()
    {
        $sql = "SELECT a.*,b.nombre as prendax FROM servicios a left join prendas b on b.id=a.prenda";
        $query = $this->db->query($sql);


        $tabla = "
        <table id=\"hor-minimalist-b\">
        <thead>
        
        
        
        <tr>
        <th>Id</th>
        <th align=\"left\">Prenda</th>
        <th align=\"left\">Servicio</th>
        <th align=\"left\">Precio</th>
        
        <th></th>
        
        </tr>
        </thead>
        <tbody>
        ";

        foreach ($query->result() as $row) {
            if ($row->tipo == 1) {
                $color = '#000000';
            } else {
                $color = '#FC0505';
            }
            $nivel = $this->session->userdata('nivel');
            if ($nivel == 1) {
                $l1 = anchor('catalogo/cambia_servicios/' . $row->id, '<img src="' . base_url() .
                    'img/edit.png" border="0" width="20px" /></a>', array('title' =>
                        'Haz Click aqui para cambiar precio!', 'class' => 'encabezado'));
            } else {
                $l1 = null;
            }
            //id, nombre, dire, descu, rfc, correo, telcasa, teltra, telcel, tipo
            $tabla .= "
            <tr>
            <td align=\"center\"><font color=\"$color\">" . $row->id .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->prendax .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->nombre .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->precio .
                "</font></td>
            <td align=\"right\"><font color=\"$color\">" . $l1 . "</font></td>
            </tr>
            ";
        }

        $tabla .= "
        </tbody>
        </table>";

        return $tabla;
    }

    function create_member_servicios($nom, $pre, $precio)
    {

        $new_member_insert_data = array(
            'nombre' => strtoupper(trim($nom)),
            'prenda' => $pre,
            'precio' => $precio,
            'fecha' => date('Y-m-d H:m'),
            'tipo' => 1);

        $this->db->insert('servicios', $new_member_insert_data);

        return $this->db->insert_id();

    }

    function trae_datos_servicios($id)
    {
        $sql = "SELECT a.*,b.nombre as prendax  FROM servicios a left join prendas b on b.id=a.prenda where a.id= ? ";
        $query = $this->db->query($sql, array($id));
        return $query;
    }

    function update_member_servicios($id, $nom, $pre, $precio, $tipo)
    {

        $data = array(
            'nombre' => strtoupper(trim($nom)),
            'prenda' => $pre,
            'precio' => $precio,
            'fecha' => date('Y-m-d H:m'),
            'tipo' => $tipo);

        $this->db->where('id', $id);
        $this->db->update('servicios', $data);

    }

    function trae_datos_parametro()
    {
        $sql = "SELECT date_add(date(now()), interval dias day)as fecha  FROM parametros where id=1";
        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->fecha;
    }

    function usuario($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('usuarios');
    }

    function usuarios()
    {
        $this->db->where('nivel', 2);
        $query = $this->db->get('usuarios');


        $tabla = "
        <table id=\"hor-minimalist-b\">
        <thead>
        
        <tr>
        <th align=\"left\">Id</th>
        <th align=\"left\">Usuario</th>
        <th align=\"left\">Nombre</th>
        <th align=\"left\">Puesto</th>
        <th align=\"left\">email</th>
        <th align=\"left\">Status</th>
        <th align=\"center\">Modificar</th>
        
        </tr>
        </thead>
        <tbody>
        ";

        foreach ($query->result() as $row) {
            $a = array('0' => 'Inactivo', '1' => 'Activo');
            if ($row->tipo == 1) {
                $color = '#000000';
            } else {
                $color = '#FC0505';
            }
            $l1 = anchor('catalogo/cambia_usuario/' . $row->id, '<img src="' . base_url() .
                'img/edit.png" border="0" width="20px" /></a>', array('title' =>
                    'Haz Click aqui para cambiar datos del cliente!', 'class' => 'encabezado'));
            //id, nombre, dire, descu, rfc, correo, telcasa, teltra, telcel, tipo
            $tabla .= "
            <tr>
            <td align=\"left\"><font color=\"$color\">" . $row->id .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->username .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->nombre .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->puesto .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $row->email .
                "</font></td>
            <td align=\"left\"><font color=\"$color\">" . $a[$row->tipo] .
                "</font></td>
            <td align=\"center\"><font color=\"$color\">" . $l1 . "</font></td>
            </tr>
            ";
        }

        $tabla .= "
        </tbody>
        </table>";

        return $tabla;
    }
}