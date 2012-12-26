<?php
class Recepcion_model extends CI_Model
{
    var $dias = null;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db->where('id', 1);
        $q = $this->db->get('parametros');
        $r = $q->row();
        $this->dias = $r->dias;

    }

    function estatus_combo()
    {
        $a = array();

        $a[0] = "TODOS";
        $query = $this->db->get('estatus');

        foreach ($query->result() as $row) {
            $a[$row->id] = $row->nombre;
        }

        return $a;
    }

    function usuarios_combo()
    {
        $a = array();

        $a[0] = "TODOS";
        $this->db->select('id, nombre');
        $query = $this->db->get('usuarios');

        foreach ($query->result() as $row) {
            $a[$row->id] = $row->nombre;
        }

        return $a;
    }

    function detalle($id)
    {
        $this->db->select('o.*, s.nombre as serviciox, p.nombre as prendax');
        $this->db->from('orden_d o');
        $this->db->join('servicios s', 'o.s_id = s.id', 'LEFT');
        $this->db->join('prendas p', 'p.id = s.prenda', 'LEFT');
        $this->db->where('c_id', $id);

        return $this->db->get();
    }

    function detalle_sin_orden($id, $descuento = 0)
    {
        $this->db->select('o.*, s.nombre as serviciox, p.nombre as prendax');
        $this->db->from('orden_d o');
        $this->db->join('servicios s', 'o.s_id = s.id', 'LEFT');
        $this->db->join('prendas p', 'p.id = s.prenda', 'LEFT');
        $this->db->where('c_id', $id);

        $query = $this->db->get();

        $this->db->select('id_status, pendiente, abono');
        $this->db->where('id', $id);
        $q = $this->db->get('orden_c');
        $r = $q->row();


        $tabla = "
        <table id=\"hor-minimalist-b\">
        <thead>

        <tr>
        <th align=\"center\">Cantidad</th>
        <th align=\"left\">Prenda</th>
        <th align=\"left\">Servicio</th>
        <th align=\"right\">$ Unitario</th>
        <th align=\"right\">Importe</th>
        <th align=\"center\">Accion</th>
        
        </tr>
        </thead>
        <tbody>
        ";
        $importe = 0;
        foreach ($query->result() as $row) {
            if ($r->id_status == 1) {
                $l1 = "<a class=\"button-link\" href=\"#\" id=\"eliminar_$row->id\">Eliminar</a>";
            } else {
                $l1 = '&nbsp;';
            }
            //id, nombre, dire, descu, rfc, correo, telcasa, teltra, telcel, tipo
            $tabla .= "
            <tr>
            <td align=\"center\">" . $row->cantidad . "</td>
            <td align=\"left\">" . $row->prendax . "</td>
            <td align=\"left\">" . $row->serviciox . "</td>
            <td align=\"right\">" . number_format($row->precio, 2) . "</td>
            <td align=\"right\">" . number_format($row->precio * $row->cantidad,
                2) . "</td>
            <td align=\"center\">" . $l1 . "</td>
            </tr>
            ";

            $importe = $importe + ($row->precio * $row->cantidad);
        }

        $descuento_total = $importe * ($descuento / 100);
        $total_a_pagar = $importe - $descuento_total;

        $tabla .= "
        </tbody>
        <tfoot>
        <tr>
        <td colspan=\"4\" align=\"right\">Importe</td>
        <td align=\"right\">" . number_format($importe, 2) . "</td>
        </tr>
        <tr>
        <td colspan=\"4\" align=\"right\">Descuento $descuento %</td>
        <td align=\"right\">" . number_format($descuento_total, 2) . "</td>
        </tr>
        <tr>
        <td colspan=\"4\" align=\"right\">Total a Pagar MX $</td>
        <td align=\"right\">" . number_format($total_a_pagar, 2) . "</td>
        </tr>
        <tr>
        <td colspan=\"4\" align=\"right\">Abono MX $</td>
        <td align=\"right\">" . number_format($r->abono, 2) . "</td>
        </tr>
        <tr>
        <td colspan=\"4\" align=\"right\">Pendiente de Pago MX $</td>
        <td align=\"right\">" . number_format($r->pendiente, 2) . "</td>
        </tr>
        </tfoot
        </table>
          <script language=\"javascript\" type=\"text/javascript\">
          $('#valida').val('" . $query->num_rows() . "');
          
          
          $('a[id^=\"eliminar_\"]').click(function(){
            var a = $(this).attr('id');
            a = a.split('_');
            var id = a[1];
            borra_detalle_sin_orden(id);
          });

            function borra_detalle_sin_orden(id){
                var url = \"" . site_url() . "/recepcion/borra_detalle_sin_orden\";
                var descuento = $('#descuento').attr('value');
                var id_orden = $('#id').attr('value');
            
                var variables = {
                    descuento: descuento,
                    id: id,
                    id_orden: id_orden
                };
                
                $.post( url, variables, function(data) {
                    $('#tabla_recepcion').html(data);
                });
            }



          </script>
        ";

        return $tabla;
    }

    function abonos($id)
    {
        $this->db->select('o.*, p.nombre as pagox');
        $this->db->from('orden_p o');
        $this->db->join('pagos p', 'o.pago = p.id', 'LEFT');
        $this->db->where('c_id', $id);

        $query = $this->db->get();

        $this->db->select('id_status');
        $this->db->where('id', $id);
        $q = $this->db->get('orden_c');
        $r = $q->row();


        $tabla = "
        <table id=\"hor-minimalist-b\">
        <thead>

        <tr>
        <th align=\"center\">#</th>
        <th align=\"left\">Forma de Pago</th>
        <th align=\"left\">Referencia</th>
        <th align=\"right\">Abono</th>
        <th align=\"right\">Aplicado</th>
        <th align=\"center\">Accion</th>
        
        </tr>
        </thead>
        <tbody>
        ";
        $importe = 0;
        $num = 1;
        foreach ($query->result() as $row) {
            if ($r->id_status == 3) {
                $l1 = '&nbsp;'; //"<a class=\"button-link\" href=\"#\" id=\"eliminar_$row->id\">Eliminar</a>";
            } else {
                $l1 = '&nbsp;';
            }
            //id, nombre, dire, descu, rfc, correo, telcasa, teltra, telcel, tipo
            $tabla .= "
            <tr>
            <td align=\"left\">" . $num . "</td>
            <td align=\"left\">" . $row->pagox . "</td>
            <td align=\"left\">" . $row->referencia . "</td>
            <td align=\"right\">" . number_format($row->abono, 2) . "</td>
            <td align=\"right\">" . $row->fecha . "</td>
            <td align=\"center\">" . $l1 . "</td>
            </tr>
            ";

            $importe = $importe + $row->abono;
        }


        $tabla .= "
        </tbody>
        <tfoot>
        <tr>
        <td colspan=\"3\" align=\"right\">Total Abonado</td>
        <td align=\"right\" id=\"abonado\">" . number_format($importe, 2) .
            "</td>
        </tr>
        </tfoot
        </table>
          <script language=\"javascript\" type=\"text/javascript\">
          $('#valida').val('" . $query->num_rows() . "');
          
          
          $('a[id^=\"eliminar_\"]').click(function(){
            var a = $(this).attr('id');
            a = a.split('_');
            var id = a[1];
            borra_abono(id);
          });

            function borra_abono(id){
                var url = \"" . site_url() . "/recepcion/borra_abono\";
                var id_orden = $('#id').attr('value');
            
                var variables = {
                    id: id,
                    id_orden: id_orden
                };
                
                $.post( url, variables, function(data) {
                    $('#tabla_recepcion').html(data);
                });
            }
            
            calcula_deuda();
            
        function calcula_deuda()
        {
            var total = $('#total_pagar').html();
            var abonado = $('#abonado').html();
            total = total.replace(',', '');
            abonado = abonado.replace(',', '');
            total = parseFloat(total);
            abonado = parseFloat(abonado);
            
            var deuda = total - abonado;
            deuda = deuda.toFixed(2);
            
            $('#deuda').html(deuda);
        }

          </script>
        ";

        return $tabla;
    }

    function abonos_sin_accion($id)
    {
        $this->db->select('o.*, p.nombre as pagox');
        $this->db->from('orden_p o');
        $this->db->join('pagos p', 'o.pago = p.id', 'LEFT');
        $this->db->where('c_id', $id);

        $query = $this->db->get();

        $this->db->select('id_status');
        $this->db->where('id', $id);
        $q = $this->db->get('orden_c');
        $r = $q->row();


        $tabla = "
        <table id=\"hor-minimalist-b\">
        <thead>

        <tr>
        <th align=\"center\">#</th>
        <th align=\"left\">Forma de Pago</th>
        <th align=\"left\">Referencia</th>
        <th align=\"right\">Abono</th>
        <th align=\"right\">Aplicado</th>
        
        </tr>
        </thead>
        <tbody>
        ";
        $importe = 0;
        $num = 1;
        foreach ($query->result() as $row) {
            //id, nombre, dire, descu, rfc, correo, telcasa, teltra, telcel, tipo
            $tabla .= "
            <tr>
            <td align=\"left\">" . $num . "</td>
            <td align=\"left\">" . $row->pagox . "</td>
            <td align=\"left\">" . $row->referencia . "</td>
            <td align=\"right\">" . number_format($row->abono, 2) . "</td>
            <td align=\"right\">" . $row->fecha . "</td>
            </tr>
            ";

            $importe = $importe + $row->abono;
        }


        $tabla .= "
        </tbody>
        <tfoot>
        <tr>
        <td colspan=\"3\" align=\"right\">Total Abonado</td>
        <td align=\"right\" id=\"abonado\">" . number_format($importe, 2) .
            "</td>
        </tr>
        </tfoot
        </table>
        ";

        return $tabla;
    }

    function ordenes($estatus, $limit, $offset = 0)
    {
        $query = $this->get_ordenes($estatus, $limit, $offset);
        return $this->tabla_ordenes($query);
    }

    function num_ordenes($estatus)
    {
        $query = $this->get_ordenes($estatus);
    }

    function busca_orden_cliente($cliente)
    {
        $query = $this->get_ordenes_cliente($cliente);
        return $this->tabla_ordenes($query);
    }

    function busca_orden_id($orden)
    {
        $query = $this->get_ordenes_id($orden);
        return $this->tabla_ordenes($query);
    }

    function entregas_pendientes()
    {
        $query = $this->get_entregas_pendientes();
        return $this->tabla_ordenes($query);
    }

    function entregas_hoy()
    {
        $query = $this->get_entregas_hoy();
        return $this->tabla_ordenes($query);
    }

    function tabla_ordenes($query)
    {

        $tabla = "
        <table id=\"hor-minimalist-b\">
        <caption>Mostrando " . $query->num_rows() . " Resultados</caption>
        <thead>

        <tr>
        <th align=\"center\">ID</th>
        <th align=\"left\">Cliente</th>
        <th align=\"left\">Alta</th>
        <th align=\"left\">Entrega</th>
        <th align=\"left\">Status</th>
        <th align=\"right\">Total</th>
        <th align=\"right\">Abono</th>
        <th align=\"right\">Pendiente</th>
        
        </tr>
        </thead>
        <tbody>
        ";
        $importe = 0;
        $abono = 0;
        $pendiente = 0;

        foreach ($query->result() as $row) {

            if ($row->id_status == 1) {
                $color = 'orange';
            } elseif ($row->id_status == 2) {
                $color = 'red';
            } elseif ($row->id_status == 3) {
                $color = 'green';
            } elseif ($row->id_status == 4) {
                $color = 'blue';
            }

            //id, nombre, dire, descu, rfc, correo, telcasa, teltra, telcel, tipo
            $tabla .= "
            <tr id=\"tablatr_" . $row->id . "\">
            <td align=\"center\">" . $row->id . "</td>
            <td align=\"left\">" . $row->nombre . "</td>
            <td align=\"left\">" . $row->fecha_alta . "</td>
            <td align=\"left\">" . $row->fecha_entrega . "</td>
            <td align=\"left\"><span class=\"tag $color\" style=\"font-size: 8px;\">" .
                $row->estatusx . "</div></td>
            <td align=\"right\">" . number_format($row->total, 2) . "</td>
            <td align=\"right\">" . number_format($row->abono, 2) . "</td>
            <td align=\"right\">" . number_format($row->pendiente, 2) . "</td>
            </tr>
            ";

            $importe = $importe + $row->total;
            $abono = $abono + $row->abono;
            $pendiente = $pendiente + $row->pendiente;
        }

        $tabla .= "
        </tbody>
        </table>
        ";

        $tabla_resp = "
        </tbody>
        <tfoot>
        <tr>
        <td colspan=\"5\" align=\"right\">Totales</td>
        <td align=\"right\">" . number_format($importe, 2) . "</td>
        <td align=\"right\">" . number_format($abono, 2) . "</td>
        <td align=\"right\">" . number_format($pendiente, 2) . "</td>
        </tr>
        </tfoot>
        </table>
        ";

        $tabla .= "
        <script language=\"javascript\" type=\"text/javascript\">
          
          
          $('tr[id^=\"tablatr_\"]').dblclick(function(){
            var a = $(this).attr('id');
            a = a.split('_');
            var id = a[1];
            window.location = \"" . site_url() . "/recepcion/tabla_recepcion/\" + id
          });


          </script>";

        return $tabla;

    }

    function caja_excel($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT o.id, date(p.fecha) as fecha, s.nombre as forma_de_pago, referencia, sum(p.abono) as abono, p.pago FROM orden_c o
    left join orden_p p on o.id = p.c_id
    left join pagos s on p.pago = s.id
    where
    date(p.fecha) between ? and ?
    group by o.id, p.pago
    order by o.id;";

        return $this->db->query($sql, array($fecha_inicial, $fecha_final));

    }

    function venta($fecha1, $fecha2)
    {
        $this->db->select('sum(total) as venta');
        $this->db->where("id_status in (3, 4) and date(fecha_alta) between '$fecha1' and '$fecha2'",
            '', false);
        $query = $this->db->get('orden_c');
        $row = $query->row();
        return $row->venta;
    }

    function caja()
    {
        $sql = "SELECT o.id, date(p.fecha) as fecha, s.nombre as forma_de_pago, referencia, sum(p.abono) as abono, p.pago FROM orden_c o
    left join orden_p p on o.id = p.c_id
    left join pagos s on p.pago = s.id
    where
    date(p.fecha) between ? and ?
    group by o.id, p.pago
    order by o.id;";

        $query = $this->db->query($sql, array($this->input->post('fecha_inicial'), $this->
                input->post('fecha_final')));

        $tabla = "
        <h1>" . TITULO_WEB . "</h1>
        <h1>Reporte de Caja del " . $this->input->post('fecha_inicial') . " al " .
            $this->input->post('fecha_final') . "</h1>
        <table id=\"hor-minimalist-b\">
        <caption>Mostrando " . $query->num_rows() . " Resultados</caption>
        <thead>

        <tr>
        <th align=\"center\">ID Orden</th>
        <th align=\"left\">Fecha</th>
        <th align=\"left\">Forma de Pago</th>
        <th align=\"right\">Importe</th>
        
        </tr>
        </thead>
        <tbody>
        ";
        $importe = 0;

        $efe = 0;
        $che = 0;
        $tar = 0;
        $cli = 0;
        $val = 0;

        foreach ($query->result() as $row) {
            $l1 = anchor('recepcion/tabla_recepcion/' . $row->id, 'Abrir');
            //id, nombre, dire, descu, rfc, correo, telcasa, teltra, telcel, tipo
            $tabla .= "
            <tr>
            <td align=\"center\">" . $row->id . "</td>
            <td align=\"left\">" . $row->fecha . "</td>
            <td align=\"left\">" . $row->forma_de_pago . "</td>
            <td align=\"right\">" . number_format($row->abono, 2) . "</td>
            </tr>
            ";

            $importe = $importe + $row->abono;

            if ($row->pago == 1) {
                $efe = $efe + $row->abono;
            } elseif ($row->pago == 2) {
                $che = $che + $row->abono;
            } elseif ($row->pago == 3) {
                $tar = $tar + $row->abono;
            } elseif ($row->pago == 4) {
                $cli = $cli + $row->abono;
            } elseif ($row->pago == 5) {
                $val = $val + $row->abono;
            }

        }

        $tabla .= "
        </tbody>
        <tfoot>
        <tr>
        <td colspan=\"3\" align=\"right\">Total de Caja</td>
        <td align=\"right\">" . number_format($importe, 2) . "</td>
        </tr>

        <tr>
        <td colspan=\"3\" align=\"right\">Total Efectivo</td>
        <td align=\"right\">" . number_format($efe, 2) . "</td>
        </tr>

        <tr>
        <td colspan=\"3\" align=\"right\">Total Cheque</td>
        <td align=\"right\">" . number_format($che, 2) . "</td>
        </tr>

        <tr>
        <td colspan=\"3\" align=\"right\">Total Tarjeta</td>
        <td align=\"right\">" . number_format($tar, 2) . "</td>
        </tr>

        <tr>
        <td colspan=\"3\" align=\"right\">Total Cliente Preferente</td>
        <td align=\"right\">" . number_format($cli, 2) . "</td>
        </tr>

        <tr>
        <td colspan=\"3\" align=\"right\">Total Vales</td>
        <td align=\"right\">" . number_format($val, 2) . "</td>
        </tr>

        <tr>
        <td colspan=\"3\" align=\"right\">Total de Venta</td>
        <td align=\"right\">" . number_format($this->venta($this->input->post('fecha_inicial'),
            $this->input->post('fecha_final')), 2) . "</td>
        </tr>

        </tfoot>
        </table>
        ";

        $tabla .= anchor('recepcion/caja_excel/' . $this->input->post('fecha_inicial') .
            '/' . $this->input->post('fecha_final'), 'Bajarlo a excel');

        return $tabla;

    }

    function ventas_excel($fecha_inicial, $fecha_final, $estatus)
    {

        if ($estatus == 0) {
            $where = null;
        } else {
            $where = "and o.id_status = " . $estatus . " ";
        }

        $sql = "SELECT o.id, fecha_alta, fecha_entrega, total, e.nombre as estatus, c.nombre as cliente FROM orden_c o
left join clientes c on o.id_cliente = c.id
left join estatus e on o.id_status = e.id
where
fecha_alta between ? and ?
$where and o.id_status not in(1, 2)
order by o.id;";

        return $this->db->query($sql, array($fecha_inicial, $fecha_final));

    }


    function ventas()
    {

        $estatus = $this->input->post('status');

        if ($estatus == 0) {
            $where = null;
        } else {
            $where = "and o.id_status = " . $estatus . " ";
        }

        $sql = "SELECT o.id, fecha_alta, fecha_entrega, total, e.nombre as estatus, c.nombre as cliente FROM orden_c o
left join clientes c on o.id_cliente = c.id
left join estatus e on o.id_status = e.id
where
fecha_alta between ? and ?
$where and o.id_status not in(1, 2)
order by o.id;";

        $query = $this->db->query($sql, array($this->input->post('fecha_inicial'), $this->
                input->post('fecha_final')));

        $tabla = "
        <span><h1>" . TITULO_WEB . "</h1></span>
        <h1>Reporte de Venta del <span id=\"fecha1\">" . $this->input->post('fecha_inicial') .
            "</span> al <span id=\"fecha2\">" . $this->input->post('fecha_final') .
            "</span></h1>
        <table id=\"hor-minimalist-b\">
        <caption>Mostrando " . $query->num_rows() .
            " Resultados, Status: <span id=\"status_reporte\">$estatus</span></caption>
        <thead>

        <tr>
        <th align=\"center\">ID Orden</th>
        <th align=\"left\">Fecha Alta</th>
        <th align=\"left\">Fecha Entrega</th>
        <th align=\"left\">Status</th>
        <th align=\"left\">Cliente</th>
        <th align=\"right\">Total</th>

        </tr>
        </thead>
        <tbody>
        ";
        $total = 0;


        foreach ($query->result() as $row) {
            $l1 = anchor('recepcion/tabla_recepcion/' . $row->id, 'Abrir');
            //id, nombre, dire, descu, rfc, correo, telcasa, teltra, telcel, tipo
            $tabla .= "
            <tr>
            <td align=\"center\">" . $row->id . "</td>
            <td align=\"left\">" . $row->fecha_alta . "</td>
            <td align=\"left\">" . $row->fecha_entrega . "</td>
            <td align=\"left\">" . $row->estatus . "</td>
            <td align=\"left\">" . $row->cliente . "</td>
            <td align=\"right\">" . number_format($row->total, 2) . "</td>
            </tr>
            ";

            $total = $total + $row->total;

        }

        $tabla .= "
        </tbody>
        <tfoot>
        <tr>
        <td colspan=\"5\" align=\"right\">Total</td>
        <td align=\"right\">" . number_format($total, 2) . "</td>
        </tr>

        </tfoot>
        </table>
        ";

        $tabla .= anchor('recepcion/ventas_excel/' . $this->input->post('fecha_inicial') .
            '/' . $this->input->post('fecha_final') . '/' . $estatus, 'Bajarlo a excel');


        return $tabla;

    }

    function auditoria_excel($fecha_inicial, $fecha_final, $estatus, $usuario)
    {

        if ($estatus == 0) {
            $where = null;
        } else {
            $where = "and o.id_status = " . $estatus . " ";
        }

        if ($usuario == 0) {
            $having = null;
        } else {
            $having = "having id_user = " . $usuario . " ";
        }

        $sql = "SELECT o.id, p.fecha, e.nombre as estatus, s.nombre as forma_de_pago, referencia, u.nombre as usuario, sum(p.abono) as abono, p.pago, id_user FROM orden_c o
    left join orden_p p on o.id = p.c_id
    left join pagos s on p.pago = s.id
    left join estatus e on o.id_status = e.id
    left join usuarios u on o.id_user = u.id
    where
    date(p.fecha) between ? and ?
    $where
    group by o.id, p.pago
    $having
    order by o.id;";

        return $this->db->query($sql, array($fecha_inicial, $fecha_final));

    }

    function auditoria()
    {

        $estatus = $this->input->post('status');
        $usuario = $this->input->post('usuario');

        if ($estatus == 0) {
            $where = null;
        } else {
            $where = "and o.id_status = " . $estatus . " ";
        }

        if ($usuario == 0) {
            $having = null;
        } else {
            $having = "having id_user = " . $usuario . " ";
        }

        $sql = "SELECT o.id, p.fecha, e.nombre as estatus, s.nombre as forma_de_pago, referencia, u.nombre as usuario, sum(p.abono) as abono, p.pago, id_user FROM orden_c o
    left join orden_p p on o.id = p.c_id
    left join pagos s on p.pago = s.id
    left join estatus e on o.id_status = e.id
    left join usuarios u on o.id_user = u.id
    where
    date(p.fecha) between ? and ?
    $where
    group by o.id, p.pago
    $having
    order by o.id;";

        $query = $this->db->query($sql, array($this->input->post('fecha_inicial'), $this->
                input->post('fecha_final')));

        $tabla = "
        <h1>" . TITULO_WEB . "</h1>
        <h1>Reporte de Venta del " . $this->input->post('fecha_inicial') .
            " al " . $this->input->post('fecha_final') . "</h1>
        <table id=\"hor-minimalist-b\">
        <caption>Mostrando " . $query->num_rows() . " Resultados</caption>
        <thead>

        <tr>
        <th align=\"center\">ID Orden</th>
        <th align=\"left\">Status</th>
        <th align=\"left\">Fecha</th>
        <th align=\"left\">Forma de Pago</th>
        <th align=\"left\">Referencia</th>
        <th align=\"left\">Usuario</th>
        <th align=\"right\">Total</th>

        </tr>
        </thead>
        <tbody>
        ";
        $total = 0;


        foreach ($query->result() as $row) {
            $l1 = anchor('recepcion/tabla_recepcion/' . $row->id, 'Abrir');
            //id, nombre, dire, descu, rfc, correo, telcasa, teltra, telcel, tipo
            $tabla .= "
            <tr>
            <td align=\"center\">" . $row->id . "</td>
            <td align=\"left\">" . $row->estatus . "</td>
            <td align=\"left\">" . $row->fecha . "</td>
            <td align=\"left\">" . $row->forma_de_pago . "</td>
            <td align=\"left\">" . $row->referencia . "</td>
            <td align=\"left\">" . $row->usuario . "</td>
            <td align=\"right\">" . number_format($row->abono, 2) . "</td>
            </tr>
            ";

            $total = $total + $row->abono;

        }

        $tabla .= "
        </tbody>
        <tfoot>
        <tr>
        <td colspan=\"6\" align=\"right\">Total</td>
        <td align=\"right\">" . number_format($total, 2) . "</td>
        </tr>

        </tfoot>
        </table>
        ";

        $tabla .= anchor('recepcion/auditoria_excel/' . $this->input->post('fecha_inicial') .
            '/' . $this->input->post('fecha_final') . '/' . $estatus . '/' . $usuario,
            'Bajarlo a excel');


        return $tabla;

    }

    function clientes_excel()
    {

        $sql = "SELECT id_cliente, c.nombre as nombre, count(o.id) as ordenes, sum(importe) as importe, sum(o.descu) as descu, sum(total) as total, sum(abono) as abono, sum(pendiente) as pendiente, dire, telcasa, correo
FROM orden_c o
left join clientes c on o.id_cliente = c.id
where id_status in(3, 4)
group by id_cliente
order by id_cliente;";

        return $this->db->query($sql);

    }

    function clientes()
    {

        $sql = "SELECT id_cliente, c.nombre as nombre, count(o.id) as ordenes, sum(importe) as importe, sum(o.descu) as descu, sum(total) as total, sum(abono) as abono, sum(pendiente) as pendiente, dire, telcasa, correo
FROM orden_c o
left join clientes c on o.id_cliente = c.id
where id_status in(3, 4)
group by id_cliente
order by id_cliente;";

        $query = $this->db->query($sql);

        $tabla = "
        <h1>" . TITULO_WEB . "</h1>
        <h1>Reporte de Clientes</h1>
        <table id=\"hor-minimalist-b\">
        <caption>Mostrando " . $query->num_rows() . " Resultados</caption>
        <thead>

        <tr>
        <th align=\"center\">ID Cliente</th>
        <th align=\"left\">Nombre</th>
        <th align=\"left\">Direccion</th>
        <th align=\"left\">Tel.</th>
        <th align=\"left\">Mail</th>
        <th align=\"right\">Ordenes</th>
        <th align=\"right\">Importe</th>
        <th align=\"right\">Descuento</th>
        <th align=\"right\">Total</th>
        <th align=\"right\">Abono</th>
        <th align=\"right\">Pendiente</th>

        </tr>
        </thead>
        <tbody>
        ";
        $ordenes = 0;
        $importe = 0;
        $descu = 0;
        $total = 0;
        $abono = 0;
        $pendiente = 0;


        foreach ($query->result() as $row) {
            //id, nombre, dire, descu, rfc, correo, telcasa, teltra, telcel, tipo
            $tabla .= "
            <tr>
            <td align=\"center\">" . $row->id_cliente . "</td>
            <td align=\"left\">" . $row->nombre . "</td>
            <td align=\"left\">" . $row->dire . "</td>
            <td align=\"left\">" . $row->telcasa . "</td>
            <td align=\"left\">" . $row->correo . "</td>
            <td align=\"right\">" . number_format($row->ordenes, 0) . "</td>
            <td align=\"right\">" . number_format($row->importe, 2) . "</td>
            <td align=\"right\">" . number_format($row->descu, 2) . "</td>
            <td align=\"right\">" . number_format($row->total, 2) . "</td>
            <td align=\"right\">" . number_format($row->abono, 2) . "</td>
            <td align=\"right\">" . number_format($row->pendiente, 2) . "</td>
            </tr>
            ";

            $ordenes = $ordenes + $row->ordenes;
            $importe = $importe + $row->importe;
            $descu = $descu + $row->descu;
            $total = $total + $row->total;
            $abono = $abono + $row->abono;
            $pendiente = $pendiente + $row->pendiente;

        }

        $tabla .= "
        </tbody>
        <tfoot>
        <tr>
        <td colspan=\"5\" align=\"right\">Total</td>
        <td align=\"right\">" . number_format($ordenes, 0) . "</td>
        <td align=\"right\">" . number_format($importe, 2) . "</td>
        <td align=\"right\">" . number_format($descu, 2) . "</td>
        <td align=\"right\">" . number_format($total, 2) . "</td>
        <td align=\"right\">" . number_format($abono, 2) . "</td>
        <td align=\"right\">" . number_format($pendiente, 2) . "</td>
        </tr>

        </tfoot>
        </table>
        ";

        $tabla .= anchor('recepcion/clientes_excel/', 'Bajarlo a excel');

        return $tabla;

    }

    function canceladas_excel($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT o.*, c.nombre, u1.nombre as realizo, u2.nombre as cancelo FROM orden_c o
left join clientes c on o.id_cliente = c.id
left join usuarios u1 on o.id_user = u1.id
left join usuarios u2 on o.id_user_cancelacion = u2.id
where o.id_status = 2
and date(fecha_cancelacion) between ? and ?;";

        return $this->db->query($sql, array($fecha_inicial, $fecha_final));
    }

    function canceladas()
    {
        $sql = "SELECT o.*, c.nombre, u1.nombre as realizo, u2.nombre as cancelo FROM orden_c o
left join clientes c on o.id_cliente = c.id
left join usuarios u1 on o.id_user = u1.id
left join usuarios u2 on o.id_user_cancelacion = u2.id
where o.id_status = 2
and date(fecha_cancelacion) between ? and ?;";

        $query = $this->db->query($sql, array($this->input->post('fecha_inicial'), $this->
                input->post('fecha_final')));

        $tabla = "
        <h1>" . TITULO_WEB . "</h1>
        <h1>Reporte de Canceladas del " . $this->input->post('fecha_inicial') .
            " al " . $this->input->post('fecha_final') . "</h1>
        <table id=\"hor-minimalist-b\">
        <caption>Mostrando " . $query->num_rows() . " Resultados</caption>
        <thead>

        <tr>
        <th align=\"center\">ID Orden</th>
        <th align=\"left\">Cliente</th>
        <th align=\"left\">Fecha Recepcion</th>
        <th align=\"left\">Realizo</th>
        <th align=\"left\">Motivo</th>
        <th align=\"left\">F. Cancelacion</th>
        <th align=\"left\">Cancelo</th>
        <th align=\"right\">Importe Cancelado</th>
        
        </tr>
        </thead>
        <tbody>
        ";
        $importe = 0;

        foreach ($query->result() as $row) {
            $l1 = anchor('recepcion/tabla_recepcion/' . $row->id, 'Abrir');
            //id, nombre, dire, descu, rfc, correo, telcasa, teltra, telcel, tipo
            $tabla .= "
            <tr>
            <td align=\"center\">" . $row->id . "</td>
            <td align=\"left\">" . $row->nombre . "</td>
            <td align=\"left\">" . $row->fecha_alta . "</td>
            <td align=\"left\">" . $row->realizo . "</td>
            <td align=\"left\">" . $row->motivo_cancelacion . "</td>
            <td align=\"left\">" . $row->fecha_cancelacion . "</td>
            <td align=\"left\">" . $row->cancelo . "</td>
            <td align=\"right\">" . number_format($row->pendiente, 2) . "</td>
            </tr>
            ";

            $importe = $importe + $row->pendiente;


        }

        $tabla .= "
        </tbody>
        <tfoot>
        <tr>
        <td colspan=\"7\" align=\"right\">Total</td>
        <td align=\"right\">" . number_format($importe, 2) . "</td>
        </tr>

        </tfoot>
        </table>
        ";

        $tabla .= anchor('recepcion/canceladas_excel/' . $this->input->post('fecha_inicial') .
            '/' . $this->input->post('fecha_final'), 'Bajarlo a excel');

        return $tabla;

    }

    function servicios1_excel($fecha_inicial, $fecha_final)
    {
        $sql = "SELECT a.*, p1.nombre as prenda1, p2.nombre as prenda2 FROM audita_servicios a
left join prendas p1 on a.prenda_anterior = p1.id
left join prendas p2 on a.prenda_nueva = p2.id
 where date(a.fecha) between ? and ?;";

        return $this->db->query($sql, array($fecha_inicial, $fecha_final));
    }

    function servicios1()
    {
        $sql = "SELECT a.*, p1.nombre as prenda1, p2.nombre as prenda2 FROM audita_servicios a
left join prendas p1 on a.prenda_anterior = p1.id
left join prendas p2 on a.prenda_nueva = p2.id
 where date(a.fecha) between ? and ?;";

        $query = $this->db->query($sql, array($this->input->post('fecha_inicial'), $this->
                input->post('fecha_final')));

        $tabla = "
        <h1>" . TITULO_WEB . "</h1>
        <h1>Reporte de Auditoria de Servicios " . $this->input->post('fecha_inicial') .
            " al " . $this->input->post('fecha_final') . "</h1>
        <table id=\"hor-minimalist-b\">
        <caption>Mostrando " . $query->num_rows() . " Resultados</caption>
        <thead>

        <tr>
        <th align=\"left\">Prenda Ant.</th>
        <th align=\"left\">Prenda Nue.</th>
        <th align=\"left\">Servicio Ant.</th>
        <th align=\"left\">Servicio Nue.</th>
        <th align=\"left\">Precio Ant.</th>
        <th align=\"left\">Precio Nue.</th>
        <th align=\"left\">Activo Ant.</th>
        <th align=\"left\">Activo Nue.</th>
        <th align=\"left\">Modificado</th>
        
        </tr>
        </thead>
        <tbody>
        ";

        foreach ($query->result() as $row) {
            //id, nombre, dire, descu, rfc, correo, telcasa, teltra, telcel, tipo
            $tabla .= "
            <tr>
            <td align=\"left\">" . $row->prenda1 . "</td>
            <td align=\"left\">" . $row->prenda2 . "</td>
            <td align=\"left\">" . $row->nombre_anterior . "</td>
            <td align=\"left\">" . $row->nombre_nuevo . "</td>
            <td align=\"left\">" . $row->precio_anterior . "</td>
            <td align=\"left\">" . $row->precio_nuevo . "</td>
            <td align=\"left\">" . $row->activo_antes . "</td>
            <td align=\"left\">" . $row->activo_despues . "</td>
            <td align=\"left\">" . $row->fecha . "</td>
            </tr>
            ";


        }

        $tabla .= "
        </tbody>
        </table>
        ";

        $tabla .= anchor('recepcion/servicios_excel/' . $this->input->post('fecha_inicial') .
            '/' . $this->input->post('fecha_final'), 'Bajarlo a excel');

        return $tabla;

    }

    function create_member_orden_c()
    {
        $this->db->select('id');
        $this->db->where('id_cliente', 0);
        $this->db->where('importe', 0);
        $this->db->order_by('id');
        $this->db->limit(1);
        $q = $this->db->get('orden_c');

        if ($q->num_rows() > 0) {

            $r = $q->row();
            //id, id_cliente, fecha_alta, fecha_entrega, hora_entrega, importe, descu, descuentox, total, abono, pendiente,
            //no_prendas, observacion, id_status, id_user, fecha_captura
            $data = array(
                'id_cliente' => 0,
                'hora_entrega' => '18:00:00',
                'importe' => 0,
                'descu' => 0,
                'descuentox' => 0,
                'total' => 0,
                'abono' => 0,
                'pendiente' => 0,
                'no_prendas' => 0,
                'observacion' => '',
                'id_status' => 1,
                'id_user' => $this->session->userdata('id'));
            $this->db->set('fecha_alta', 'date(now())', false);
            $this->db->set('fecha_entrega', 'date_add(date(now()), interval ' . $this->dias .
                ' day)', false);
            $this->db->set('fecha_captura', 'now()', false);
            $this->db->where('id', $r->id);
            $this->db->update('orden_c', $data);

            $this->db->delete('orden_d', array('c_id' => $r->id));
            $this->db->delete('orden_p', array('c_id' => $r->id));

            return $r->id;

        } else {

            $new_member_insert_data = array(
                'id_cliente' => 0,
                'hora_entrega' => '18:00:00',
                'observacion' => '',
                'id_status' => 1,
                'id_user' => $this->session->userdata('id'));

            $this->db->set('fecha_alta', 'date(now())', false);
            $this->db->set('fecha_entrega', 'date_add(date(now()), interval ' . $this->dias .
                ' day)', false);
            $this->db->set('fecha_captura', 'now()', false);

            $this->db->insert('orden_c', $new_member_insert_data);

            return $this->db->insert_id();

        }
    }

    function trae_datos_parametro()
    {
        $sql = "SELECT date_add(date(now()), interval dias day)as fecha  FROM parametros where id=1";
        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->fecha;
    }

    function get_parametros()
    {
        $this->db->where('id', 1);
        return $this->db->get('parametros');
    }

    function get_orden($id)
    {
        $this->db->select('o.*, c.nombre, e.nombre as estatusx, telcasa, telcel, dayofweek(o.fecha_entrega) as dia, dayofweek(o.fecha_alta) as dia_alta');
        $this->db->from('orden_c o');
        $this->db->join('clientes c', 'o.id_cliente = c.id', 'LEFT');
        $this->db->join('estatus e', 'o.id_status = e.id', 'LEFT');
        $this->db->where('o.id', $id);
        $query = $this->db->get();

        return $query->row();

    }

    function get_ordenes($estatus, $limit, $offset)
    {
        $this->db->select('o.*, c.nombre, e.nombre as estatusx');
        $this->db->from('orden_c o');
        $this->db->join('clientes c', 'o.id_cliente = c.id', 'LEFT');
        $this->db->join('estatus e', 'o.id_status = e.id', 'LEFT');
        $this->db->where('o.id_status', $estatus);

        if ($estatus == 2) {
            $this->db->order_by('o.fecha_cancelacion', 'DESC');
        } elseif ($estatus == 3) {
            $this->db->order_by('o.id', 'DESC');
        } elseif ($estatus == 4) {
            $this->db->order_by('o.fecha_entrega', 'DESC');
        } else {
            $this->db->order_by('o.id', 'DESC');
        }


        $this->db->limit($limit, $offset);
        $query = $this->db->get();

        return $query;

    }

    function get_num_ordenes($estatus)
    {
        $this->db->select('count(*) as cuenta', false);
        $this->db->where('id_status', $estatus);
        $query = $this->db->get('orden_c');
        $row = $query->row();

        return $row->cuenta;

    }

    function get_ordenes_cliente($cliente)
    {
        $this->db->select('o.*, c.nombre, e.nombre as estatusx');
        $this->db->from('orden_c o');
        $this->db->join('clientes c', 'o.id_cliente = c.id', 'LEFT');
        $this->db->join('estatus e', 'o.id_status = e.id', 'LEFT');
        $this->db->where('o.id_cliente', $cliente);
        $this->db->order_by('o.id', 'DESC');
        $query = $this->db->get();

        return $query;

    }

    function get_ordenes_id($orden)
    {
        $this->db->select('o.*, c.nombre, e.nombre as estatusx');
        $this->db->from('orden_c o');
        $this->db->join('clientes c', 'o.id_cliente = c.id', 'LEFT');
        $this->db->join('estatus e', 'o.id_status = e.id', 'LEFT');
        $this->db->where('o.id', $orden);
        $this->db->order_by('o.id', 'DESC');
        $query = $this->db->get();

        return $query;

    }

    function get_entregas_pendientes()
    {
        $this->db->select('o.*, c.nombre, e.nombre as estatusx');
        $this->db->from('orden_c o');
        $this->db->join('clientes c', 'o.id_cliente = c.id', 'LEFT');
        $this->db->join('estatus e', 'o.id_status = e.id', 'LEFT');
        $this->db->where('o.id_status', 3);
        $this->db->order_by('o.id', 'DESC');
        $query = $this->db->get();

        return $query;

    }

    function get_entregas_hoy()
    {
        $this->db->select('o.*, c.nombre, e.nombre as estatusx');
        $this->db->from('orden_c o');
        $this->db->join('clientes c', 'o.id_cliente = c.id', 'LEFT');
        $this->db->join('estatus e', 'o.id_status = e.id', 'LEFT');
        $this->db->where('o.fecha_entrega = date(now())');
        $this->db->order_by('o.id', 'DESC');
        $query = $this->db->get();

        return $query;

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
            'rfc' => strtoupper(trim($rfc)),
            'correo' => strtoupper(trim($dir)),
            'telcasa' => $tcas,
            'teltra' => $ttra,
            'telcel' => $tcel,
            'tipo' => 0);

        $insert = $this->db->insert('clientes', $new_member_insert_data);

    }

    function trae_datos_cliente($id)
    {
        $sql = "SELECT *  FROM clientes  where id= ? ";
        $query = $this->db->query($sql, array($id));
        return $query;
    }

    function update_member_cliente($id, $nom, $dir, $col, $pob, $cp, $correo, $rfc,
        $tcas, $ttra, $tcel, $num, $int, $tipo)
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
            'rfc' => strtoupper(trim($rfc)),
            'correo' => strtoupper(trim($dir)),
            'telcasa' => $tcas,
            'teltra' => $ttra,
            'telcel' => $tcel,
            'tipo' => $tipo);

        $this->db->where('id', $id);
        $this->db->update('clientes', $data);

    }

    function prendas()
    {
        $sql = "SELECT * FROM prendas";
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
            if ($row->tipo == 0) {
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
        $sql = "SELECT id,nombre FROM  prendas where tipo = 1";
        $query = $this->db->query($sql);
        $pre = array();
        $pre[0] = "Selecciona una Prenda";
        foreach ($query->result() as $row) {
            $pre[$row->id] = $row->nombre;
        }
        return $pre;
    }

    function busca_tipo_pago()
    {
        $sql = "SELECT * FROM pagos where tipo = 1";
        $query = $this->db->query($sql);
        $pre = array();
        $pre[0] = "Selecciona un Tipo de Pago";
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
            if ($row->tipo == 0) {
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
            if ($row->tipo == 0) {
                $color = '#000000';
            } else {
                $color = '#FC0505';
            }
            $l1 = anchor('catalogo/cambia_servicios/' . $row->id, '<img src="' . base_url() .
                'img/edit.png" border="0" width="20px" /></a>', array('title' =>
                    'Haz Click aqui para cambiar precio!', 'class' => 'encabezado'));
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
            'tipo' => 0);

        $insert = $this->db->insert('servicios', $new_member_insert_data);

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

    function agrega_servicio($id, $sevicio, $cantidad, $descuento)
    {
        //id, c_id, s_id, precio, cantidad, id_user
        $this->db->where('s_id', $sevicio);
        $this->db->where('c_id', $id);
        $query = $this->db->get('orden_d');

        if ($query->num_rows() == 0) {

            $data->c_id = $id;
            $data->s_id = $sevicio;
            $data->precio = $this->__precio($sevicio);
            $data->cantidad = $cantidad;
            $data->id_user = $this->session->userdata('id');

            $this->db->insert('orden_d', $data);

            return $this->detalle_sin_orden($id, $descuento);

        } else {
            return $this->detalle_sin_orden($id, $descuento);
        }

    }

    function borra_servicio_sin_orden($id, $descuento, $id_orden)
    {
        $this->db->delete('orden_d', array('id' => $id));
        return $this->detalle_sin_orden($id_orden, $descuento);
    }

    function agrega_abono($id, $tipo_pago, $abono)
    {
        //id, c_id, pago, referencia, abono, fecha
        $data->c_id = $id;
        $data->pago = $tipo_pago;
        $data->referencia = null;
        $data->abono = $abono;

        $this->db->set('fecha', 'now()', false);
        $this->db->where('c_id', $id);
        $this->db->insert('orden_p', $data);

        $this->cargar_abono($id);

        return $this->abonos($id);
    }


    function __precio($servicio)
    {
        $this->db->select('precio');
        $this->db->where('id', $servicio);
        $query = $this->db->get('servicios');

        $row = $query->row();

        return $row->precio;
    }

    function cierra_orden($id)
    {
        $this->db->select('sum(precio * cantidad) as total');
        $this->db->where('c_id', $id);
        $query = $this->db->get('orden_d');
        $row = $query->row();

        $this->db->select('descuentox');
        $this->db->where('id', $id);
        $query2 = $this->db->get('orden_c');
        $row2 = $query2->row();


        $data->importe = $row->total;
        $data->descu = round($row->total * ($row2->descuentox / 100), 2);
        $data->total = $data->importe - $data->descu;
        $data->pendiente = $data->total;
        $data->id_status = 3;

        $this->db->where('id', $id);
        $this->db->update('orden_c', $data);
    }

    function cancela_orden()
    {
        $data->motivo_cancelacion = $this->input->post('motivo');
        $data->id_status = 2;
        $data->id_user_cancelacion = $this->session->userdata('id');
        $this->db->set('fecha_cancelacion', 'now()', false);
        $this->db->where('id', $this->input->post('id'));

        $this->db->update('orden_c', $data);

        $registro = $this->db->affected_rows();

        $this->db->delete('orden_p', array('c_id' => $this->input->post('id')));

        return $registro;

    }

    function entregar($id)
    {
        $this->db->select('sum(abono) as abono');
        $this->db->where('c_id', $id);
        $query = $this->db->get('orden_p');
        $row = $query->row();

        $data->abono = $row->abono;
        $data->id_status = 4;
        $this->db->set('fecha_entrega', 'date(now())', false);
        $this->db->where('id', $id);
        $this->db->update('orden_c', $data);

        $this->aplicar_abono($id);

    }

    function cargar_abono($id)
    {
        $this->db->select('sum(abono) as abono');
        $this->db->where('c_id', $id);
        $query = $this->db->get('orden_p');
        $row = $query->row();

        $data->abono = $row->abono;
        $this->db->where('id', $id);
        $this->db->update('orden_c', $data);


        $this->aplicar_abono($id);

    }

    function aplicar_abono($id)
    {
        $this->db->set('pendiente', '(total - abono)', false);
        $this->db->update('orden_c', null, array('id' => $id));
    }

}