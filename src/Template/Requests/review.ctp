<style>
	.btn-space {
        margin-right: 3px;
        margin-left: 3px;
    }
</style>
<div class='form-size container'>
	<div class="requests view large-9 medium-8 columns content">
		<h3 id='title' > Revisión de la solicitud número <?= $id ?> </h3>
		<?= $this->Form->create($request)?>
		<div id="divEstudiante" class="form-section">
		<legend> Datos del estudiante </legend>
		
		<?php
			echo $this->Form->control('Cédula',array('value' => $user['identification_number'], 'disabled'));
			echo $this->Form->control('Carné',array('value' => strtoupper($user['carne']), 'disabled'));
			echo $this->Form->control('Nombre',array('value' => ($user['name'] . " ". $user['lastname1'] . " " . $user['lastname2']), 'disabled'));
			//Tal vez no deberia ir este?
			echo $this->Form->control('Correo',array('value' => $user['email_personal'], 'disabled'));
			echo $this->Form->control('Promedio',array('value' => $request['average'], 'disabled'));
		?>
		</div>
		
		<div id="divSolicitud" class="form-section">
		<legend> Datos de la solicitud </legend>
		<?php
			echo $this->Form->control('Sigla del curso',array('value' => $request['course_id'], 'disabled'));
			echo $this->Form->control('Nombre del Curso',array('value' => $class['name'], 'disabled'));
			echo $this->Form->control('Grupo',array('value' => $request['class_number'], 'disabled'));
			//Esta solo imprime el nombre por que todo el nombre y los apellidos de un profesor va en el campo nombre, de acuerdo con la profe y Jorge
			echo $this->Form->control('Profesor',array('value' => $professor['name'], 'disabled'));
			//Supongo que el semestre y el año es información inutil
			echo $this->Form->control('Horas asistente',array('value' => $request['another_assistant_hours'], 'disabled'));
			echo $this->Form->control('Horas estudiante',array('value' => $request['another_student_hours'], 'disabled'));
			if($request['first_time'] == 1)
			{
				echo  "Primera vez que solicita una asistencia.";
				?><br> </br> <?php
			}
			if($request['wants_assistant_hours'] == 1)
			{
				echo "Solicitó horas asistente.";
				?><br> </br> <?php
			}
			if($request['wants_student_hours'] == 1)
			{
				echo "Solicitó horas estudiante.";
				?><br> </br> <?php
			}
			
			//Impide que se activen los campos si la solicitud no esta pendiente
			if($request['status'] == 'p')
			echo $this->Form->control('modify_hours', ['id' => 'hours_change','label' => 'Cambiar horas', 'type' => 'checkbox', 'onchange' => 'allowUpdateHours()']);

			{
			?> <div id="divChangeHours" style="display:none;">
			<?php
			echo $this->Form->control('modify_hours_ha', ['id' => 'new_ha', 'label' => 'Asignar horas asistente', 'type' => 'checkbox']);
			echo $this->Form->control('modify_hours_he', ['id' => 'new_he', 'label' => 'Asignar horas estudiante', 'type' => 'checkbox']);
			echo $this->Form->control('reqId', ['id' => 'requId', 'label' => '', 'type' => 'text', 'value' => $id, 'hidden']);
			echo $this->Form->control(
			'Aceptar',
			[
				'id' => 'AceptarCambioHoras',
				'name' => 'AceptarCambioHoras',
				'type' => 'submit',
				'class' => 'btn btn-primary btn-aceptar'			
			]);
			
			
		
			?> </div>
			<?php
			}
			?><br> </br> <?php
			

		?>	
		</div>
		<?= $this->Form->end() ?>
	</div>

	<?php if($anulada): ?>
		<div class="requests form large-9 medium-8 columns content form-section">
		<?= $this->Form->create(false) ?>
		<fieldset>
			<legend><?= __('Solicitud anulada') ?></legend>
			<?php
				echo $this->Form->control('Motivo: ',array('value' => $justificacion[0], 'disabled'));
			?>
		</fieldset>
		
		<?= $this->Form->end() ?>
		</div>
	<?php endif; ?>

	<?php if($load_requirements_review): ?>
		<div class="requests view large-9 medium-8 columns content form-section">
			<?= $this->Form->create(false) ?>
				<div>
					<?php if($requirements['stage'] > 1 && $requirements['stage'] < 3): ?>
						<div class='input-group mb-2' id='modificar_tag'>
							<span class="input-group-text" >Modificar</span>     
							<div class="input-group-append" >
								<div class="input-group-text bg-white">
									<?php
										echo $this->Form->checkbox(
											'Editar',
											['id' => 'edit_checkbox'
											]
										);
									?>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php echo $this->Form->control('ponderado',['onchange'=>'autoReqs()','label'=>['text'=>'Promedio verificado:'],'type'=>'number','step' => 0.01,  'value' => $request_ponderado, 'min' => 5.0, 'max' => 10.0, 'disabled'=> $requirements['stage'] > 1, 'class' => 'radioRequirements']);?>
					<?php $this->Form->unlockField('ponderado');?>
					<legend>
					Requisitos de horas estudiante
					</legend>

					<div>
						<table class='table text-center'>
							<?php
								echo ("<tr class='bg-white'>
									\t<th style='width:60%; text-align: left;'>Requisito</th> 
									\t<th style='width:10%'>Tipo</th>
									\t<th style='width:10%'>Aprobado</th> 
									\t<th style='width:10%'>Rechazado</th> 
									\t<th style='width:10%'>Inopia</th>
									</tr>");
								for ($i = 0; $i < count($requirements['Estudiante']); $i++){
									$checkedApproved = $requirements['Estudiante'][$i]['acepted_inopia'] == 0 && $requirements['Estudiante'][$i]['state'] == 'a'?'checked':'';
									$checkedRejected = $requirements['Estudiante'][$i]['state'] == 'r'?'checked':'';
									$checkedInopia = $requirements['Estudiante'][$i]['acepted_inopia'] == 1?'checked':'';
									$disable_radios = $requirements['stage'] > 1? 'disabled':''; 
									echo('<tr class="bg-white">'."\n");
									echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$requirements['Estudiante'][$i]['description'].'</td>'."\n"); 
									echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$requirements['Estudiante'][$i]['type'].'</td>'."\n"); 
									echo("\t\t\t\t".'<td><input class="radioRequirements" type="radio" id="requirement_'.$requirements['Estudiante'][$i]['requirement_number'].'_a" name="requirement_'.$requirements['Estudiante'][$i]['requirement_number'].'"value="approved" required '.$checkedApproved.' '.$disable_radios.'></td>'."\n"); 
									echo("\t\t\t\t".'<td><input class="radioRequirements" type="radio" id="requirement_'.$requirements['Estudiante'][$i]['requirement_number'].'_r" name="requirement_'.$requirements['Estudiante'][$i]['requirement_number'].'"value="rejected"'.$checkedRejected.' '.$disable_radios.'></td>'."\n");
									if($requirements['Estudiante'][$i]['type'] == 'Opcional'){
										echo("\t\t\t\t".'<td><input class="radioRequirements" type="radio" id="requirement_'.$requirements['Estudiante'][$i]['requirement_number'].'_i" name="requirement_'.$requirements['Estudiante'][$i]['requirement_number'].'"value="inopia"'.$checkedInopia.' '.$disable_radios.'></td>'."\n");
									}else{
										echo("\t\t\t\t".'<td style= \'text-align: left;\'>  </td>'."\n"); 
									}
									echo('</tr>'."\n");
									$this->Form->unlockField('inopia_op_'.$requirements['Estudiante'][$i]['requirement_number']);
									$this->Form->unlockField('requirement_'.$requirements['Estudiante'][$i]['requirement_number']);
								}
							?>		  
						</table>
					</div>

					<legend>
						Requisitos de horas asistente
					</legend>

					<div>
						<table class='table text-center '>
							<?php
								echo ("<tr class='bg-white'>
									\t<th style='width:70%; text-align: left;'>Requisito</th> 
									\t<th style='width:10%'>Tipo</th>
									\t<th style='width:10%'>Aprobado</th>
									\t<th style='width:10%'>Rechazado</th> 
									\t<th style='width:10%'>Inopia</th>
									</tr>");
									
								for ($i = 0; $i < count($requirements['Asistente']); $i++){
									$checkedApproved = $requirements['Asistente'][$i]['acepted_inopia'] == 0 && $requirements['Asistente'][$i]['state'] == 'a'?'checked':'';
									$checkedRejected = $requirements['Asistente'][$i]['state'] == 'r'?'checked':'';
									$checkedInopia = $requirements['Asistente'][$i]['acepted_inopia'] == 1?'checked':'';
									$disable_radios = $requirements['stage'] > 1? 'disabled':''; 
									echo('<tr class="bg-white">'."\n");
									echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$requirements['Asistente'][$i]['description'].'</td>'."\n"); 
									echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$requirements['Asistente'][$i]['type'].'</td>'."\n"); 
									echo("\t\t\t\t".'<td><input class="radioRequirements" type="radio" id="requirement_'.$requirements['Asistente'][$i]['requirement_number'].'_a" name="requirement_'.$requirements['Asistente'][$i]['requirement_number'].'" value="approved" required '.$checkedApproved.' '.$disable_radios.'></td>'."\n"); 
									echo("\t\t\t\t".'<td><input class="radioRequirements" type="radio" id="requirement_'.$requirements['Asistente'][$i]['requirement_number'].'_r" name="requirement_'.$requirements['Asistente'][$i]['requirement_number'].'" value="rejected"'.$checkedRejected.' '.$disable_radios.'></td>'."\n");
									if($requirements['Asistente'][$i]['type'] == 'Opcional'){
										echo("\t\t\t\t".'<td><input class="radioRequirements" type="radio" id="requirement_'.$requirements['Asistente'][$i]['requirement_number'].'_i" name="requirement_'.$requirements['Asistente'][$i]['requirement_number'].'" value="inopia"'.$checkedInopia.' '.$disable_radios.'></td>'."\n");
									}else{
										echo("\t\t\t\t".'<td style= \'text-align: left;\'>  </td>'."\n"); 
									}
									echo('</tr>'."\n"); 
									$this->Form->unlockField('requirement_'.$requirements['Asistente'][$i]['requirement_number']);
								}
							?>		  

						</table>
					</div>

					<legend>
						Requisitos generales
					</legend>

					<div>
						<table class='table text-center '>
							<?php
								echo ("<tr class='bg-white'>
									\t<th style='width:60%; text-align: left;'>Requisito</th> 
									\t<th style='width:10%'>Tipo</th>
									\t<th style='width:10%'>Aprobado</th>
									\t<th style='width:10%'>Rechazado</th> 
									\t<th style='width:10%'>Inopia</th>
									</tr>");
								for ($i = 0; $i < count($requirements['Ambos']); $i++){
									$checkedApproved = $requirements['Ambos'][$i]['acepted_inopia'] == 0 && $requirements['Ambos'][$i]['state'] == 'a'?'checked':'';
									$checkedRejected = $requirements['Ambos'][$i]['state'] == 'r'?'checked':'';
									$checkedInopia = $requirements['Ambos'][$i]['acepted_inopia'] == 1?'checked':'';
									$disable_radios = $requirements['stage'] > 1? 'disabled':''; 
									echo('<tr class="bg-white">'."\n");
									echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$requirements['Ambos'][$i]['description'].'</td>'."\n"); 
									echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$requirements['Ambos'][$i]['type'].'</td>'."\n"); 
									echo("\t\t\t\t".'<td><input class="radioRequirements" type="radio" id="requirement_'.$requirements['Ambos'][$i]['requirement_number'].'_a" name="requirement_'.$requirements['Ambos'][$i]['requirement_number'].'"value="approved" required '.$checkedApproved.' '.$disable_radios.'></td>'."\n"); 
									echo("\t\t\t\t".'<td><input class="radioRequirements" type="radio" id="requirement_'.$requirements['Ambos'][$i]['requirement_number'].'_r" name="requirement_'.$requirements['Ambos'][$i]['requirement_number'].'"value="rejected"'.$checkedRejected.' '.$disable_radios.'></td>'."\n");
									if($requirements['Ambos'][$i]['type'] == 'Opcional'){
										echo("\t\t\t\t".'<td><input class="radioRequirements" type="radio" id="requirement_'.$requirements['Ambos'][$i]['requirement_number'].'_i" name="requirement_'.$requirements['Ambos'][$i]['requirement_number'].'"value="inopia"'.$checkedInopia.' '.$disable_radios.'></td>'."\n");
									}else{
										echo("\t\t\t\t".'<td style= \'text-align: left;\'>  </td>'."\n"); 
									}
									echo('</tr>'."\n"); 
									$this->Form->unlockField('requirement_'.$requirements['Ambos'][$i]['requirement_number']);
								}
							?>
						</table>
					</div>
				</div>
				<div class="container">
				<?php if( $requirements['stage'] < 3): ?>
				<div class='row justify-content-end'> 
					<?= $this->Html->link(
						'Cancelar',
						['controller'=>'requests','action'=>'index'],
						['class'=>'btn btn-secondary btn-cancelar radioRequirements']
					)?>

					<?php
						echo $this->Form->button(
							'Aceptar',
							[
								'onclick' => 'habilitarReqs()',
								'id' => 'AceptarRequisitos',
								'name' => 'AceptarRequisitos',
								'type' => 'submit',
								'class' => 'btn btn-primary btn-aceptar radioRequirements',
								'disabled' => $requirements['stage'] > 1
							]);
						
					?>
				</div>
				<?php endif; ?>
				</div>
			<?= $this->Form->end() ?>
		</div>
	<?php endif; ?>


	<?php if($load_preliminar_review):?>
		<div id="divPreliminar" class="form-section">
			<?= $this->Form->create(false) ?>
				<legend>
					Revisión preliminar
				</legend>

				<?php
					echo $this->Form->control(
						'Clasificación',
						[
							'options' => $preeliminarOptions,
							'default' => $default_index
						]
					);
				?>
				<div class="container">
				<div class='row justify-content-end'> 
					<?= $this->Html->link(
						'Cancelar',
						['controller'=>'requests','action'=>'index'],
						['class'=>'btn btn-secondary btn-cancelar']
					)?>
					<?php
						echo $this->Form->button(
							'Aceptar',
							[
								'id' => 'AceptarPreliminar',
								'name' => 'AceptarPreliminar',
								'type' => 'submit',
								'class' => 'btn btn-primary btn-aceptar'
						]);
							
					?>
				</div>
				</div>
			<?= $this->Form->end() ?>
		
		</div>
	<?php endif;?>






	<?php 
		$last = $this->Rounds->getLastRow(); 
		$approved_request = $this->Requests->getApproved($id); 
		$hsCnt = 0;
		$hdCnt = 0;
		$haCnt = 0;
		if($approved_request){
			if($approved_request[0][1] == 'HEE'){
				$hsCnt = $approved_request[0][2];
			}else if($approved_request[0][1] == 'HED'){
				$hdCnt = $approved_request[0][2];
			}else{
				$haCnt = $approved_request[0][2];
			}
		}
		$reviewed = $default_index == 'a' || $default_index == 'r' || $default_index == 'c';
		$approved = $load_final_review && ($default_index == 'e' || $default_index =='i' || $reviewed);
	?> 

	<?php if($approved):?>
		<div id="divFinal" class="form-section">
			<?= $this->Form->create(false,['id'=>'endForm']) ?>
				<legend>
					Revisión Final
				</legend>
				<fieldset>
					<?= $this->Form->control('Clasificación Final',[
						'id' => 'End-Classification',
						'name' => 'End-Classification',
						'options' => ['-No Clasificado-', 'Aceptado', 'Rechazado'],
						'default' => $default_indexf,
						'onchange'=>"approve()",
					]);?>
					
					<div class="container" id = 'hoursDiv'>
						<div class="row justify-content-left" id = 'studentRow'>
							<div class="col-auto">
								<?= $this->Form->checkbox('checkbox',[
									'id'=>'tsh',
									'value' => 'HEE',
									'label' => false,
									'onchange'=>"studentHours()",
								]);?>
							</div>
							<div class="col-4"><p> <?= "Horas Estudiante ECCI: " ?></p></div>
							<div class="col-auto">
								<?= $this->Form->control('hours',[
									'id'=>'student',
									'type'=>'number',
									'min' => $student_max_hours['HEE'] < 3 || $hasAsignedHours? 0:3,
									'max' => $student_max_hours['HEE'],
									'label' => false,
									'disabled',
									'style' => 'width:65px'
								]);?>
							</div>
							<div class="col-auto" id ='hsdLabel'><p> <?= "Disponibles: ".strval($roundData['total_student_hours']-$roundData['actual_student_hours'] + $hsCnt) ?></p></div>
						</div>
						<div class="row justify-content-left" id = 'studentDRow'>
							<div class="col-auto">
								<?= $this->Form->checkbox('checkbox',[
									'id'=>'tdh',
									'value' => 'HED',
									'label' => false,
									'onchange'=>"studentDHours()",
								]);?>
							</div>
							<div class="col-4"><p> <?= "Horas Estudiante DOC: " ?></p></div>
							<div class="col-auto">
								<?= $this->Form->control('hours',[
									'id'=>'studentD',
									'type'=>'number',
									'min' => $student_max_hours['HED'] < 3 || $hasAsignedHours? 0:3,
									'max' => $student_max_hours['HED'],
									'label' => false,
									'disabled',
									'style' => 'width:65px'
								]);?>
							</div>
							<div class="col-auto" id ='hddLabel'><p> <?= "Disponibles: ".strval($roundData['total_student_hours_d']-$roundData['actual_student_hours_d'] + $hdCnt) ?></p></div>
						</div>
						<div class="row justify-content-left" id = 'assistantRow'>
							<div class="col-auto">
								<?= $this->Form->checkbox('checkbox',[
									'id'=>'tah',
									'value' => 'HAE',
									'label' => false,	
									'onchange'=>"assistantHours()",						
								]);?>
							</div>
							<div class="col-4"><p> <?= "Horas Asistente: " ?></p></div>
							<div class="col-auto">
								<?= $this->Form->control('hours',[
									'id'=>'assistant',
									'type'=>'number',
									'min' => $student_max_hours['HAE'] < 3 || $hasAsignedHours? 0:3,
									'max' => $student_max_hours['HAE'],
									'label' => false,
									'disabled',		
									'style' => 'width:65px'
								]);?>
							</div>
							<div class="col-auto" id ='hadLabel'><p> <?= "Disponibles: ".strval($roundData['total_assistant_hours']-$roundData['actual_assistant_hours'] + $haCnt) ?></p></div>
						</div>
						<?php
							echo $this->Form->control('type',['type'=>'hidden',]);
							$this->Form->unlockField('hours');
							$this->Form->unlockField('type');
							$this->Form->unlockField('AceptarFin');
						?>
					</div>
				</fieldset>
			<?= $this->Form->end() ?>
			<div class="container" id = 'endButtons'>
				<div class='row justify-content-end'> 
						<?= $this->Form->postbutton('Cancelar',[
							'controller'=>'requests',
							'action'=>'index'],[
							'class'=>'btn btn-secondary btn-cancelar'
						]);?>
						<?= $this->Form->button('Aceptar',[
							'id' => 'AceptarFin',
							'name' => 'AceptarFin',
							'type' => 'submit',
							'form' => 'endForm',
							'class' => 'btn btn-primary btn-aceptar'
						]);?>							
				</div>
			</div>
		</div>
	<?php endif;?>

<?= $this->Html->script('Generic'); ?>

<script type="text/javascript">
$(document).ready( function () {
    $("#edit_checkbox").change(function(){
		if($("#edit_checkbox").is(":checked")){
			$('.radioRequirements').prop( "disabled", false );
			if(byId('ponderado').value != 0){
				autoReqs();
			}
		}else{
			$('.radioRequirements').prop( "disabled", true );	
		}
	});
	if(byId('ponderado').value != 0){
		autoReqs();
	}
});

function autoReqs(){
	byId('requirement_6_a').disabled = true;
	byId('requirement_4_a').disabled = true;
	byId('requirement_6_r').disabled = true;
	byId('requirement_4_r').disabled = true;
	byId('requirement_6_i').disabled = true;
	byId('requirement_4_i').disabled = true;
	if(byId('ponderado').value >= 8){
		byId('requirement_6_a').checked = true;
		byId('requirement_4_a').checked = true;
	}else if(byId('ponderado').value >= 7.5){
		byId('requirement_6_i').checked = true;
		byId('requirement_4_a').checked = true;
	}else if(byId('ponderado').value >= 7.0){
		byId('requirement_6_i').checked = true;
		byId('requirement_4_i').checked = true;
	}else{
		byId('requirement_6_r').checked = true;
		byId('requirement_4_r').checked = true;
		byId('requirement_6_i').disabled = false;
		byId('requirement_4_i').disabled = false;
	}
}

function habilitarReqs(){
	byId('requirement_6_a').disabled = false;
	byId('requirement_4_a').disabled = false;
	byId('requirement_6_r').disabled = false;
	byId('requirement_4_r').disabled = false;
	byId('requirement_6_i').disabled = false;
	byId('requirement_4_i').disabled = false;
}

</script>



<?php if($approved): ?>
<script type="text/javascript">

hourTypeAsignableb = '<?= $hourTypeAsignableb ?>';

$(document).ready(function(){
		
		if('<?= $reviewed ?>'){
			byId('divPreliminar').style.display = 'none';
		}

		// Esconde campos en base al tipo de horas asignables
		if(hourTypeAsignableb != 'a' && hourTypeAsignableb != 'c' && hourTypeAsignableb != 'b'){
			byId('assistantRow').style.display = 'none';
		}
		if(hourTypeAsignableb == 'n'){
			byId('studentDRow').style.display = 'none';
			byId('studentRow').style.display = 'none';
		}

		// calcula el tope de horas que se le puede asignar al estudiante
		var tsh = <?= $roundData['total_student_hours']; ?>;
		var ash = <?= $roundData['actual_student_hours']; ?>;
		var totS = tsh-ash + <?= $hsCnt ?>;
		if(totS < parseInt(byId('student').max))byId('student').max = totS;
		var tdh = <?= $roundData['total_student_hours_d']; ?>;
		var adh = <?= $roundData['actual_student_hours_d']; ?>;
		var totD = tdh-adh + <?= $hdCnt ?>;
		if(totS < parseInt(byId('studentD').max))byId('studentD').max = totD;
		var tah = <?= $roundData['total_assistant_hours']; ?>;
		var aah = <?= $roundData['actual_assistant_hours']; ?>;
		var totA = tah-aah + <?= $haCnt ?>;
		if(totA < parseInt(byId('assistant').max))byId('assistant').max = totA;
		approve();
		if('<?= $hsCnt ?>'){
			byId('tsh').checked = true;
			studentHours();
		}
		if('<?= $hdCnt ?>'){
			byId('tdh').checked = true;
			studentDHours();
		}	
		if('<?= $haCnt ?>'){
			byId('tah').checked = true;
			assistantHours();
		}

});
	/** Función approve
	  * EFE: verifica que el dato de aprovado en el combobox sea selecionado para mostrar el resto de campos
	  *		 por agregar.
	  **/
	function approve(){
		byId('tsh').checked = false;
		byId('tdh').checked = false;
		byId('tah').checked = false;
		
		byId('student').disabled = true;
		byId('student').value = null;
		byId('studentD').disabled = true;
		byId('studentD').value = null;
		byId('assistant').disabled = true;
		byId('assistant').value = null;
		byId('hsdLabel').style.visibility = 'hidden';
		byId('hddLabel').style.visibility = 'hidden';
		byId('hadLabel').style.visibility = 'hidden';

		byId('endButtons').style.visibility = 'hidden';

		var clasification = byId('End-Classification').value;
		if(clasification == 1){
			byId('hoursDiv').style.display = 'table';
		}else{
			byId('hoursDiv').style.display = 'none';
			if(clasification == 2){
				byId('endButtons').style.visibility = 'visible';
			}
		}
	}
	/** Función studentHours
	  * EFE: Se activa con el checkbox correspondiente, altera los campos en el div de Revisión final
	  * 	 para que no existan incongruencias
	  **/
	function studentHours(){
		if(byId('tsh').checked){
			if((hourTypeAsignableb == 'i' || hourTypeAsignableb == 'b') && byId('End-Classification').value == 1){
				byId('End-Classification').options[1].innerText = 'Aceptado por inopia';
			}else{
				byId('End-Classification').options[1].innerText = 'Aceptado';
			}
			byId('type').value = "HEE";

			byId('tdh').checked = false;
			byId('studentD').value = null;
			byId('studentD').disabled = true;
			if(hourTypeAsignableb == 'a'|| hourTypeAsignableb == 'b'|| hourTypeAsignableb == 'c'){
				byId('tah').checked = false;	
				byId('assistant').value = null;
				byId('assistant').disabled = true;
			}

			<?php if(!array_key_exists('HEE', $student_asigned_hours_request)): ?>
			if('<?= $hasAsignedHours?>'){
				byId('student').value = 0;
			}else{
				byId('student').value = 3;
			}	
			<?php else: ?>
			byId('student').value = <?= $student_asigned_hours_request['HEE'] ?>;
			<?php endif; ?>

			byId('student').disabled = false;
			byId('student').focus();

			byId('hsdLabel').style.visibility = 'visible';
			byId('hddLabel').style.visibility = 'hidden';
			if(hourTypeAsignableb == 'a'|| hourTypeAsignableb == 'b'|| hourTypeAsignableb == 'c'){
				byId('hadLabel').style.visibility = 'hidden';
			}

			byId('endButtons').style.visibility = 'visible';
		}else{
			byId('End-Classification').options[1].innerText = 'Aceptado';
			byId('student').value = null;
			byId('student').disabled = true;

			byId('hsdLabel').style.visibility = 'hidden';

			byId('endButtons').style.visibility = 'hidden';
		}
	}

	/** Función studentDHours
	  * EFE: Se activa con el checkbox correspondiente, altera los campos en el div de Revisión final
	  * 	 para que no existan incongruencias
	  **/
	  function studentDHours(){
		if(byId('tdh').checked){
			if((hourTypeAsignableb == 'i' || hourTypeAsignableb == 'b') && byId('End-Classification').value == 1){
				byId('End-Classification').options[1].innerText = 'Aceptado por inopia';
			}else{
				byId('End-Classification').options[1].innerText = 'Aceptado';
			}
			byId('type').value = "HED";

			byId('tsh').checked = false;
			byId('student').value = null;
			byId('student').disabled = true;
			if(hourTypeAsignableb == 'a'||hourTypeAsignableb == 'b'||hourTypeAsignableb == 'c'){
				byId('tah').checked = false;
				byId('assistant').value = null;
				byId('assistant').disabled = true;
			}

			<?php if(!array_key_exists('HED', $student_asigned_hours_request)): ?>
			if('<?= $hasAsignedHours?>'){
				byId('studentD').value = 0;
			}else{
				byId('studentD').value = 3;
			}	
			<?php else: ?>
			byId('studentD').value = <?= $student_asigned_hours_request['HED'] ?>;
			<?php endif; ?>
			byId('studentD').disabled = false;
			byId('studentD').focus();

			byId('hddLabel').style.visibility = 'visible';
			byId('hsdLabel').style.visibility = 'hidden';
			if(hourTypeAsignableb == 'a'|| hourTypeAsignableb == 'b'||hourTypeAsignableb == 'c'){
				byId('hadLabel').style.visibility = 'hidden';
			}

			byId('endButtons').style.visibility = 'visible';
		}else{
			byId('End-Classification').options[1].innerText = 'Aceptado';
			byId('studentD').value = null;
			byId('studentD').disabled = true;

			byId('hddLabel').style.visibility = 'hidden';

			byId('endButtons').style.visibility = 'hidden';
		}
	}

	/** Función assistantHours
	  * EFE: Se activa con el checkbox correspondiente, altera los campos en el div de Revisión final
	  * 	 para que no existan incongruencias
	  **/
	function assistantHours(){
		if(byId('tah').checked){
			if((hourTypeAsignableb == 'c' || hourTypeAsignableb == 'b') && byId('End-Classification').value == 1){
				byId('End-Classification').options[1].innerText = 'Aceptado por inopia';
			}else{
				byId('End-Classification').options[1].innerText = 'Aceptado';
			}
			byId('tah').style.disabled = true;
			byId('tsh').style.disabled = false;
			byId('type').value = "HAE";
			byId('tsh').checked = false;
			byId('student').value = null;
			byId('student').disabled = true;
			byId('tdh').checked = false;
			byId('studentD').value = null;
			byId('studentD').disabled = true;
			
			byId('assistant').disabled = false;
			byId('assistant').focus();
			
			<?php if(!array_key_exists('HAE', $student_asigned_hours_request)): ?>
			if('<?= $hasAsignedHours?>'){
				byId('assistant').value = 0;
			}else{
				byId('assistant').value = 3;
			}	
			<?php else: ?>
			byId('assistant').value = <?= $student_asigned_hours_request['HAE'] ?>;
			<?php endif; ?>
			byId('hadLabel').style.visibility = 'visible';
			byId('hsdLabel').style.visibility = 'hidden';
			byId('hddLabel').style.visibility = 'hidden';

			byId('endButtons').style.visibility = 'visible';
		}else{
			byId('End-Classification').options[1].innerText = 'Aceptado';
			byId('assistant').value = null;
			byId('assistant').disabled = true;

			byId('hadLabel').style.visibility = 'hidden';

			byId('endButtons').style.visibility = 'hidden';
		}
	}
	

	
	function cambiarhoras()
	{
			$.ajax({
		url:"<?php echo \Cake\Routing\Router::url(array('controller'=>'Requests','action'=>'changeRequestHours'));?>" ,   cache: false,
		type: 'GET',
		contentType: 'application/json; charset=utf-8',
		dataType: 'text',
		async: false,
		data: {},
		success: function (data,response) {

		},
		error: function(jqxhr, status, exception)
		{
			alert(exception);

		}
			});
	}
</script>
<?php endif; ?>

<script type="text/javascript">
	/** Función allowUpdateHours
	  * EFE: Permite activar o desactivar la opción de cambiar horas
	  **/
	function allowUpdateHours()
	{
		if(document.getElementById("hours_change").checked)
		{
			/*byId("AceptarCambioHoras").style.visibility = 'visible';
			byId("new_ha").style.visibility = 'visible';
			byId("new_he").style.visibility = 'visible';*/
			document.getElementById("divChangeHours").style.display = 'block';
			
		}
		else
		{
			/*byId("AceptarCambioHoras").style.visibility = 'hidden';
			byId("new_ha").style.visibility = 'hidden';
			byId("new_ha").value = 'xdxd';
			byId("new_he").style.visibility = 'hidden';*/
			
			document.getElementById("divChangeHours").style.display = 'none';
		}
	}

</script>