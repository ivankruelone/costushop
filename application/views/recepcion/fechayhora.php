<?php
	$sql = "select now() as ahora;";
    $query = $this->db->query($sql);
    $row = $query->row();
?>
<table>
<thead>
<tr>
<th style="text-align: left;">Tipo</th>
<th style="text-align: left;">Fecha y hora</th>
</tr>
</thead>
<tbody>
<tr>
<td>Servidor</td>
<td><?php echo date('Y-m-d H:i:s');?></td>
</tr>
<tr>
<td>Base de datos</td>
<td><?php echo $row->ahora; ?></td>
</tr>
</tbody>
</table>