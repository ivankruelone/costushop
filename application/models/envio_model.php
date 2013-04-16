<?php
	class Envio_model extends CI_Model {

    function facturas()
    {
 
	$fech = getdate();
	$aaa=$fech['year'];
	$mes=$fech['mon'];
	$dia=$fech['mday'];
	$mes=10;
	$sem=0;
	$lin=1;
	$cia=1;
	$suc=100;
	$venta=0;
$this->load->helper('file');

$sql="SELECT 'NO' as var1,b.id,1600 as suc,b.prv,b.prv, left(b.factura,10) as factura,
extract(year from b.fecha)as aaas,
extract(month from b.fecha)as mess,
extract(day from b.fecha)as dias,
b.cia,b.orden,c.codigo,a.clave,
sum(a.can)as can,a.costo,
c.lin,c.sublin,
1 as per,'FARMABODEGA'as perx,b.orden,c.susa1,c.susa2,
sum(a.canr) as canr

FROM compra_d a
left join compra_c b on a.id_cc=b.id
left join catalogo.catalogo_bodega c on c.clabo=a.clave
where b.tipo=1
group by a.id_cc, a.clave
";
$query = $this->db->query($sql);

$linea=null;
$mensaje=null;
foreach($query->result() as $row)
{
$susa1=substr($row->susa1,0,40);
$susa2=substr($row->susa2,0,40);
$factura=substr($row->factura,0,10);

$linea.=str_pad($row->var1,2)
    .str_pad($row->id,9,"0",STR_PAD_LEFT)
    .str_pad($row->suc,8,"0",STR_PAD_LEFT)
    .str_pad($row->prv,4,"0",STR_PAD_LEFT)
    .str_pad($factura,10)
    .str_pad($row->aaas,4,"0",STR_PAD_LEFT)
    .str_pad($row->mess,2,"0",STR_PAD_LEFT)
    .str_pad($row->dias,2,"0",STR_PAD_LEFT)
    .str_pad($row->cia,2,"0",STR_PAD_LEFT)
    .str_pad($row->orden,9,"0",STR_PAD_LEFT)
    .str_pad($row->codigo,13,"0",STR_PAD_LEFT)
    .str_pad($row->clave,4,"0",STR_PAD_LEFT)
    .str_pad($row->can,7,"0",STR_PAD_LEFT)
    .str_pad(round($row->costo*100),11,"0",STR_PAD_LEFT)
    .str_pad($row->lin,2,"0",STR_PAD_LEFT)
    .str_pad($row->per,6,"0",STR_PAD_LEFT)
    .str_pad($row->perx,30)
    .str_pad($row->orden,9,"0",STR_PAD_LEFT)
    .str_pad($susa1,40)
    .str_pad($susa2,40)
    .str_pad($row->canr,7,"0",STR_PAD_LEFT)."\n"
    ;
    
}
if ( ! write_file('./txt/factura.txt', $linea))
{
    $mensaje.='EL ARCHIVO NO PUDO SER GENERADO<br />';
}
else
{
    $mensaje.='EL ARCHIVO FUE GENERADO CORRECTAMENTE<br />';
}



$servidor_ftp    = "10.10.0.7";
$ftp_nombre_usuario = "lidia";
$ftp_contrasenya = "puepue19";


// abrir algun archivo para lectura
$archivo = './txt/factura.txt';
$da = fopen($archivo, 'r');
$archivo_remoto = 'awsdata012/xlicxp';




// configurar la conexion basica
$id_con = ftp_connect($servidor_ftp);

// iniciar sesion con nombre de usuario y contrasenya
$resultado_login = ftp_login($id_con, $ftp_nombre_usuario, $ftp_contrasenya);


if (ftp_put($id_con, $archivo_remoto, $archivo, FTP_ASCII)) {
    $mensaje.='EL ARCHIVO FUE SUBIDO  CORRECTAMENTE AL AS/400 <br />';
} else {
    $mensaje.='EL ARCHIVO NO SE ENVIO  CORRECTAMENTE AL AS/400 <br />';
}


ftp_close($id_con);
fclose($da);
    return $mensaje; 
    }
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
 function pedidos_generar()
    {
        $tocan=0;
        $num=0;
        $this->db->select('a.nid,sum(a.can)as can,count(*)as totsuc,b.nombre');
        $this->db->from('pedido a');
        $this->db->join('catalogo.sucursal b' , 'a.nid=b.suc', "left");
        $this->db->group_by('a.nid');
        $query = $this->db->get();
        
        
        
        $tabla= "
        <table>
        <thead>
        
        
        <tr>
        <th align=\"center\">Nid</th>
        <th align=\"left\">Sucursal</th>
        <th align=\"right\">Total Prod</th>
        <th align=\"right\">Total Can.</th>
        </tr>
        
        
        </thead>
        <tbody>";
        
        foreach($query->result() as $row)
        {
            $l0 = anchor('envio/generar_pedido/'.$row->nid, '<img src="'.base_url().'img/icons/emoticon/emoticon_bomb.png" border="0" width="20px" />Generar</a>', array('title' => 'Haz Click aqui para Generar pedido!', 'class' => 'encabezado'));
            $tabla.="
            <tr>
        <td align=\"center\">$row->nid</td>
        <td align=\"left\">$row->nombre</td>
        <td align=\"right\">$row->totsuc</td>
        <td align=\"right\">$row->can</td>
        <td align=\"right\">$l0</td>
        </tr>
            ";
        $num=$num+1;
        $tocan=$tocan+$row->can;
        }
        $tabla.="
        <tr>
        <td align=\"center\">Pedidos..: $num</td>
        <td align=\"right\" colspan=\"3\">".number_format($tocan)."</td>
        </tr>
        </table>
        
        </tbody>";
        
        return $tabla;
        
        
    }
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
 /////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////insert y delete
function create_member($nid)
	{

       $sql = "SELECT a.*,b.nombre
        FROM pedido a 
        left join catalogo.sucursal b on b.suc=a.nid 
        where nid = ? group by nid";
        $query = $this->db->query($sql,array($nid));
        $row= $query->row();
        $sucx=$row->nombre; 
        if($query->num_rows() > 0){   
    //////////////////////////////////////////////inserta los datos en la base de datos
        $new_member_insert_data = array(
			'suc' => $nid,
			'sucx' =>  str_replace(' ', '',strtoupper(trim($sucx))),
			'tipo' => 1,			
			'fecha'=> date('Y-m-d H:s:i')
		);
		
		$insert = $this->db->insert('pedido_c', $new_member_insert_data);
        }  
       /////////////////////////////////////////////////////////detalle
       $id_cc=$this->db->insert_id();
       
       $sqld = "select a.*,b.lin,b.vtabo
        from pedido a 
       right join catalogo.catalogo_bodega b on b.clabo=a.clave
       where a.nid= ? and can>0 ";
        $queryd = $this->db->query($sqld,array($nid));
        if($queryd->num_rows() > 0){
        foreach($queryd->result() as $rowd)
        {
        $new_member_insert_datad = array(
			'id_cc' => $id_cc,
			'clave' => $rowd->clave,
			'fecha'=> date('Y-m-d H:s:i'),
            'vta' => $rowd->vtabo,
            'lin' => $rowd->lin,
            'canp'=> $rowd->can,
            'tipo'=> 1
            						
		);
		
		$insertd = $this->db->insert('pedido_d', $new_member_insert_datad);
        
        
        }
        }
    $this->db->delete('pedido', array('nid' => $nid));
}
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
   
//////////////////////////////////////////////////////////////////////////////////    
//////////////////////////////////////////////////////////////////////////////////
}