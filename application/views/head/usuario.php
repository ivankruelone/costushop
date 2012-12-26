		<!-- User Info -->
        <?php
        $avatar = $this->session->userdata('avatar');
        ?>
        
		<section id="user-info">
			<!--<img src="<?php //echo base_url();?>img/avatar/<?php //echo $avatar;?>" alt="<?php //echo $this->session->userdata('nombre');?>" />-->
			<div>
                <?php echo anchor('login/perfin', $this->session->userdata('nombre'), 'title="Modifica tu Perfil de Usuario"');?>
				<em><?php echo $this->session->userdata('puesto');?></em>
				<ul>
					<li><?php echo anchor('login/perfil', 'Modificar Perfil', 'class="button-link" title="Modificar mi Perfil!" rel="tooltip"');?></li>
				</ul>
			</div>
		</section>
		<!-- /User Info -->
        
