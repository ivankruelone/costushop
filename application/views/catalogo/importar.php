<div>
<h2>Importar Base de datos anterior</h2>
<?php echo form_open_multipart('catalogo/do_upload');?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="Importar base de datos" />

</form>
</div>
<div>
<h2>Cargar Catalogo</h2>
<?php echo form_open_multipart('catalogo/do_upload_csv');?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="Cargar catalogo de servicios" />

</form>
</div>
