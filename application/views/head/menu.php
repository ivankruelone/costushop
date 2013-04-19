		<?php
        //" class=\"current\"";
        $nivel = $this->session->userdata('nivel');
        if(!isset($menu))$menu = null;
        if(!isset($submenu))$submenu = null;
        
        
        ?>

  		<?php
        if($nivel == 1){
        ?>              
        
        <!-- Main Navigation -->
		<nav id="main-nav">
			<ul>
                <li<?php if($menu == "catalogo")echo ' class="current"';?>><?php echo anchor('welcome', 'Catalogo' , 'class="products"')?>
                    <ul>
                        <li><?php echo anchor('catalogo/index', 'Clientes')?></li>
                        <li><?php echo anchor('catalogo/tabla_prendas', 'Prendas')?></li>
                        <li><?php echo anchor('catalogo/tabla_servicios', 'Servicios')?></li>
                        <li><?php echo anchor('catalogo/tabla_condiciones', 'Condiciones')?></li>
                        <li><?php echo anchor('catalogo/usuarios', 'Usuarios')?></li>
                        
                    </ul>
                </li> <!-- Use class .no-submenu to open link instead of a sub menu-->
				<!-- Use class .current to open submenu on page load -->
                
                <li>
                <?php echo anchor('recepcion/nueva_recepcion', 'Recepci&oacute;n (F2)', 'class="no-submenu"')?>
				</li>

                <li>
                <?php echo anchor('recepcion/entregas', 'Entrega (F4)', 'class="no-submenu"')?>
				</li>

				<li<?php if($menu == "recepcion")echo ' class="current"';?>>
					<?php echo anchor('recepcion', 'Ordenes' , 'class="dashboard"')?>
                    <ul>
                        <li><?php echo anchor('recepcion/ordenes/1', 'PENDIENTE')?></li>
                        <li><?php echo anchor('recepcion/ordenes/2', 'CANCELADO')?></li>
                        <li><?php echo anchor('recepcion/ordenes/3', 'EN PROCESO')?></li>
                        <li><?php echo anchor('recepcion/ordenes/4', 'ENTREGADO')?></li>
                    </ul>
				</li>

                <li<?php if($menu == "reportes")echo ' class="current"';?>><?php echo anchor('welcome', 'Reportes' , 'class="products"')?>
                    <ul>
                        <li><?php echo anchor('recepcion/ventas', 'Ventas')?></li>
                        <li><?php echo anchor('recepcion/caja', 'Caja')?></li>
                        <li><?php echo anchor('recepcion/auditoria', 'Auditoria')?></li>
                        <li><?php echo anchor('recepcion/clientes', 'Clientes')?></li>
                        <li><?php echo anchor('recepcion/canceladas', 'Canceladas')?></li>
                        <li><?php echo anchor('recepcion/servicios', 'Servicios')?></li>
                        <li><?php echo anchor('recepcion/reimpresiones', 'Reimpresiones')?></li>
                        <li><?php echo anchor('recepcion/cuota', 'Cuota')?></li>
                    </ul>
                </li> <!-- Use class .no-submenu to open link instead of a sub menu-->

                <li>
                <?php echo anchor('recepcion/configuracion', 'Configuracion', 'class="no-submenu"')?>
				</li>
                
                <li>
                <?php echo anchor('recepcion/fechayhora', 'Fecha y hora', 'class="no-submenu"')?>
				</li>

                <li>
                <?php echo anchor('login/logout', 'Cerrar sesi&ocirc;n', 'class="no-submenu"')?>
				</li>

                
 			</ul>
		</nav>
        <!-- /Main Navigation -->
        
        <?php
        }elseif($nivel == 2)
        {
        ?>


        
        <!-- Main Navigation -->
		<nav id="main-nav">
			<ul>
                <li<?php if($menu == "catalogo")echo ' class="current"';?>><?php echo anchor('welcome', 'Catalogo' , 'class="products"')?>
                    <ul>
                        <li><?php echo anchor('catalogo/index', 'Clientes')?></li>
                        <li><?php echo anchor('catalogo/tabla_prendas', 'Prendas')?></li>
                        <li><?php echo anchor('catalogo/tabla_servicios', 'Servicios')?></li>
                    </ul>
                </li> <!-- Use class .no-submenu to open link instead of a sub menu-->
				<!-- Use class .current to open submenu on page load -->
                
                <li>
                <?php echo anchor('recepcion/nueva_recepcion', 'Recepci&oacute;n (F2)', 'class="no-submenu"')?>
				</li>

                <li>
                <?php echo anchor('recepcion/entregas', 'Entrega (F4)', 'class="no-submenu"')?>
				</li>

				<li<?php if($menu == "recepcion")echo ' class="current"';?>>
					<?php echo anchor('recepcion', 'Ordenes' , 'class="dashboard"')?>
                    <ul>
                        <li><?php echo anchor('recepcion/ordenes/2', 'CANCELADO')?></li>
                        <li><?php echo anchor('recepcion/ordenes/3', 'EN PROCESO')?></li>
                        <li><?php echo anchor('recepcion/ordenes/4', 'ENTREGADO')?></li>
                    </ul>
				</li>

                <li<?php if($menu == "reportes")echo ' class="current"';?>><?php echo anchor('welcome', 'Reportes' , 'class="products"')?>
                    <ul>
                        <li><?php echo anchor('recepcion/ventas', 'Ventas')?></li>
                        <li><?php echo anchor('recepcion/caja', 'Caja')?></li>
                    </ul>
                </li> <!-- Use class .no-submenu to open link instead of a sub menu-->

                <li>
                <?php echo anchor('login/logout', 'Cerrar sesi&ocirc;n', 'class="no-submenu"')?>
				</li>
				

                
 			</ul>
		</nav>
        <!-- /Main Navigation -->

        
        <?php
        }
        ?>   

		