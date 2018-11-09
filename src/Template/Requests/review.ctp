<style>
	.btn-space {
        margin-right: 3px;
        margin-leftt: 3px;
    }

	.form-section{
        background-color: #e4e4e4;
        padding: 2%;
        margin: 2%;
    }
</style>
<div class='form-size container'>
	<div class="requests view large-9 medium-8 columns content">
		<?= $this->Form->create($request)?>
		<div id="divEstudiante" class="form-section">
		<legend> Datos del estudiante </legend>
		
		<?php
			echo $this->Form->control('Cédula: ',array('value' => $user['identification_number'], 'disabled'));
			echo $this->Form->control('Carnet: ',array('value' => $user['carne'], 'disabled'));
			echo $this->Form->control('Nombre: ',array('value' => ($user['name'] . " ". $user['lastname1'] . " " . $user['lastname2']), 'disabled'));
			//Tal vez no deberia ir este?
			echo $this->Form->control('Correo Electronico: ',array('value' => $user['email_personal'], 'disabled'));
			echo $this->Form->control('Promedio Ponderado: ',array('value' => $request['average'], 'disabled'));
		?>
		</div>
		
		<div id="divSolicitud" class="form-section">
		<legend> Datos de la solicitud </legend>
		<?php
			echo $this->Form->control('Sigla del Curso: ',array('value' => $request['course_id'], 'disabled'));
			echo $this->Form->control('Nombre del Curso: ',array('value' => $class['name'], 'disabled'));
			echo $this->Form->control('Grupo: ',array('value' => $request['class_number'], 'disabled'));
			//Esta solo imprime el nombre por que todo el nombre y los apellidos de un profesor va en el campo nombre, de acuerdo con la profe y Jorge
			echo $this->Form->control('Nombre del Profesor: ',array('value' => $professor['name'], 'disabled'));
			//Supongo que el semestre y el año es información inutil
			echo $this->Form->control('El estudiante ya tiene esta cantidad de horas asistente: ',array('value' => $request['another_assistant_hours'], 'disabled'));
			echo $this->Form->control('El estudiante ya tiene esta cantidad de horas estudiante: ',array('value' => $request['another_student_hours'], 'disabled'));
			if($request['first_time'] == 1)
			{
				echo "Es la primera vez que el estudiante presenta una solicitud de asistencia";
			}
			if($request['wants_assistant_hours'] == 1)
			{
				echo "El estudiante solicito horas Asistente";
			}
			if($request['wants_student_hours'] == 1)
			{
				echo "El estudiante solicito horas Asistente";
			}
		?>	
		</div>
			
		<?= $this->Form->end() ?>
	</div>

	<?php if($load_requirements_review): ?>
		<div class="requests view large-9 medium-8 columns content form-section">
			<?= $this->Form->create(false) ?>
				<legend>
					Revisión de requisitos
				</legend>
				<div>
					<?php if($requirements['stage'] > 1): ?>
						<div class='input-group mb-2' id='modificar_tag'>
							<span style="width:13%" class="input-group-text" >Modificar</span>     
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
						<?php echo $this->Form->control('ponderado', ['label'=>['text'=>'Promedio ponderado verificado:'],'type'=>'float', 'value' => $request_ponderado, 'disabled'=> true, 'class' => 'radioRequirements']);?>
					<?php endif; ?>
					
					<?php if($requirements['stage'] == 1): ?>
						<?php echo $this->Form->control('ponderado', ['label'=>['text'=>'Promedio ponderado verificado:'],'type'=>'float']);?>
					<?php endif; ?>

					<legend>
						Requisitos opcionales
					</legend>

					<div>
						<table class='table text-center'>
							<?php
								
								echo ("<tr class='bg-white'>
									\t<th style='width:70%; text-align: left;'>Requisito</th> 
									\t<th style='width:10%'>Aprobado</th> 
									\t<th style='width:10%'>Rechazado</th> 
									\t<th style='width:10%'>Inopia</th>
									</tr>");
								for ($i = 0; $i < count($requirements['Opcional']); $i++){
									$checkedApproved = $requirements['Opcional'][$i]['state'] == 'a'?'checked':'';
									$checkedRejected = $requirements['Opcional'][$i]['state'] == 'r'?'checked':'';
									$checkedInopia = $requirements['Opcional'][$i]['acepted_inopia'] == 0? false : true;
									$disable_radios = $requirements['stage'] > 1? 'disabled':''; 
									echo('<tr class="bg-white">'."\n");
									echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$requirements['Opcional'][$i]['description'].'</td>'."\n"); 
									echo("\t\t\t\t".'<td><input class="radioRequirements" type="radio" name="requirement_'.$requirements['Opcional'][$i]['requirement_number'].'"value="approved" required '.$checkedApproved.' '.$disable_radios.'></td>'."\n"); 
									echo("\t\t\t\t".'<td><input class="radioRequirements" type="radio" name="requirement_'.$requirements['Opcional'][$i]['requirement_number'].'"value="rejected"'.$checkedRejected.' '.$disable_radios.'></td>'."\n");
									echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
											'Editar',
											['checked' => $checkedInopia,
											'name' => 'inopia_op_'.$requirements['Opcional'][$i]['requirement_number'],
											'class'=> "radioRequirements",
											'disabled' => $requirements['stage'] > 1]
										).'</td>'."\n");
									echo('</tr>'."\n");
									$this->Form->unlockField('inopia_op_'.$requirements['Opcional'][$i]['requirement_number']);
									$this->Form->unlockField('requirement_'.$requirements['Opcional'][$i]['requirement_number']);
								}
							?>		  
						</table>
					</div>

					<legend>
						Requisitos obligatorios
					</legend>

					<div>
						<table class='table text-center '>
							<?php
								echo ("<tr class='bg-white'>
									\t<th style='width:70%; text-align: left;'>Requisito</th> 
									\t<th style='width:10%'>Aprobado</th>
									\t<th style='width:10%'>Rechazado</th> 
									</tr>");
								for ($i = 0; $i < count($requirements['Obligatorio']); $i++){
									$checkedApproved = $requirements['Obligatorio'][$i]['state'] == 'a'?'checked':'';
									$checkedRejected = $requirements['Obligatorio'][$i]['state'] == 'r'?'checked':'';
									$disable_radios = $requirements['stage'] > 1? 'disabled':''; 
									echo('<tr class="bg-white">'."\n");
									echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$requirements['Obligatorio'][$i]['description'].'</td>'."\n"); 
									echo("\t\t\t\t".'<td><input class="radioRequirements" type="radio" name="requirement_'.$requirements['Obligatorio'][$i]['requirement_number'].'"value="approved" required '.$checkedApproved.' '.$disable_radios.'></td>'."\n"); 
									echo("\t\t\t\t".'<td><input class="radioRequirements" type="radio" name="requirement_'.$requirements['Obligatorio'][$i]['requirement_number'].'"value="rejected"'.$checkedRejected.' '.$disable_radios.'></td>'."\n");
									echo('</tr>'."\n"); 
									$this->Form->unlockField('requirement_'.$requirements['Obligatorio'][$i]['requirement_number']);
								}
							?>		  

						</table>
					</div>
				</div>
				<div class="container">
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
								'id' => 'AceptarRequisitos',
								'name' => 'AceptarRequisitos',
								'type' => 'submit',
								'class' => 'btn btn-primary btn-aceptar radioRequirements',
								'disabled' => $requirements['stage'] > 1
							]);
						
					?>
				</div>
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
							'options' => ['-No Clasificado-', 'Elegible', 'No Elegible','Elegible por Inopia'],
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
		$haCnt = 0;
		if($approved_request){
			if($approved_request[0][1] == 'hs'){
				$hsCnt = $approved_request[0][2];
			}else{
				$haCnt = $approved_request[0][2];
			}
		}
	?>
	<?php $approved = $load_final_review && ($default_index == 1 || $default_index >= 3)?> 
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
						'options' => ['-No Clasificado-', 'Aprobado', 'Rechazado'],
						'default' => $default_indexf,
						'onchange'=>"approve()",
					]);?>
					
					<div class="container" id = 'hoursDiv'>
						<div class="row justify-content-center" id = 'studentRow'>
							<div class="col-auto">
								<?= $this->Form->checkbox('checkbox',[
									'id'=>'tsh',
									'value' => 'hs',
									'label' => false,
									'onclick'=>"studentHours()",
								]);?>
							</div>
							<div class="col-3"><p> <?= "Horas Estudiante: " ?></p></div>
							<div class="col-2">
								<?= $this->Form->control('hours',[
									'id'=>'student',
									'type'=>'number',
									'min' => '3',
									'max' => '12',
									'label' => false,
									'disabled'
								]);?>
							</div>
							<div class="col-auto" id ='hsdLabel' style = 'visibility:hidden'><p> <?= "Disponibles: " ?></p></div>
							<div class="col-2">
								<?= $this->Form->control('hsd',[
									'type'=>'number',
									'value'=> $last[5]-$last[7] + $hsCnt,
									'label' => false,
									'disabled',
									'visibility'=>'hidden'
								]);?>
							</div>
						</div>		

						<div class="row justify-content-center" id = 'assistantRow'>
							<div class="col-auto">
								<?= $this->Form->checkbox('checkbox',[
									'id'=>'tah',
									'value' => 'ha',
									'label' => false,	
									'onclick'=>"assistantHours()",						
								]);?>
							</div>
							<div class="col-3"><p> <?= "Horas Asistente: " ?></p></div>
							<div class="col-2">
								<?= $this->Form->control('hours',[
									'id'=>'assistant',
									'type'=>'number',
									'min' => '3',
									'max' => '20',
									'label' => false,
									'disabled',		
								]);?>
							</div>
							<div class="col-auto" id ='hadLabel' style = 'visibility:hidden'><p> <?= "Disponibles: " ?></p></div>
							<div class="col-2">
								<?= $this->Form->control('had',[
									'type'=>'number',
									'value'=> $last[6]-$last[8] + $haCnt,
									'label' => false,
									'disabled',
									'visibility'=>'hidden'
								]);?>
							</div>
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
							'onclick' => "finishEndForm()",
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


<script type="text/javascript">
$(document).ready( function () {
    $("#edit_checkbox").change(function(){
		if($("#edit_checkbox").is(":checked")){
			$('.radioRequirements').prop( "disabled", false );
		}else{
			$('.radioRequirements').prop( "disabled", true );	
		}
    });
	if('<?= $approved ?>'){
		var tsh = '<?= $last[5]; ?>';
		var ash = '<?= $last[7]; ?>';
		var totS = tsh-ash;
		if(totS < 12)byId('student').max = totS;
		var tah = '<?= $last[6]; ?>';
		var aah = '<?= $last[8]; ?>';
		var totA = tah-aah;
		if(totA < 20)byId('assistant').max = totA;
		approve();
    }
});
	/** Función approve
	  * EFE: verifica que el dato de aprovado en el combobox sea selecionado para mostrar el resto de campos
	  *		 por agregar.
	  **/
	function approve(){
		byId('tsh').checked = false;
		byId('tah').checked = false;
		
		byId('student').disabled = true;
		byId('student').value = null;
		byId('assistant').disabled = true;
		byId('assistant').value = null;
		byId('hsdLabel').style.visibility = 'hidden';
		byId('hsd').style.visibility = 'hidden';
		byId('hadLabel').style.visibility = 'hidden';
		byId('had').style.visibility = 'hidden';

		byId('endButtons').style.display = 'none';

		var clasification = byId('End-Classification').value;
		if(clasification == 1){
			byId('hoursDiv').style.display = 'table';
		}else{
			byId('hoursDiv').style.display = 'none';
			if(clasification == 2){
				byId('endButtons').style.display = 'table';
			}
		}
	}
	/** Función studentHours
	  * EFE: Se activa con el checkbox correspondiente, altera los campos en el div de Revisión final
	  * 	 para que no existan incongruencias
	  **/
	function studentHours(){
		if(byId('tsh').checked){

			byId('type').value = "hs";

			byId('tah').checked = false;
			byId('assistant').value = null;
			byId('assistant').disabled = true;
			if('<?= $hsCnt == 0 ?>'){
				byId('student').value = 3;
			}else{
				byId('student').value = '<?= $hsCnt ?>';
			}
			byId('student').disabled = false;
			byId('student').focus();

			byId('hsdLabel').style.visibility = 'visible';
			byId('hsd').style.visibility = 'visible';
			byId('hadLabel').style.visibility = 'hidden';
			byId('had').style.visibility = 'hidden';

			byId('endButtons').style.display = 'table';
			byId('endButtons').style.visibility = 'visible';
		}else{
			byId('student').value = null;
			byId('student').disabled = true;

			byId('hsdLabel').style.visibility = 'hidden';
			byId('hsd').style.visibility = 'hidden';

			byId('endButtons').style.visibility = 'hidden';
		}
	}
	/** Función assistantHours
	  * EFE: Se activa con el checkbox correspondiente, altera los campos en el div de Revisión final
	  * 	 para que no existan incongruencias
	  **/
	function assistantHours(){
		if(byId('tah').checked){
			byId('tah').style.disabled = true;
			byId('tsh').style.disabled = false;
			byId('type').value = "ha";
			byId('tsh').checked = false;
			byId('student').value = null;
			byId('student').disabled = true;
			if('<?= $haCnt == 0 ?>'){
				byId('assistant').value = 3;
			}else{
				byId('assistant').value = '<?= $haCnt ?>';
			}
			byId('assistant').disabled = false;
			byId('assistant').focus();

			byId('hadLabel').style.visibility = 'visible';
			byId('had').style.visibility = 'visible';
			byId('hsdLabel').style.visibility = 'hidden';
			byId('hsd').style.visibility = 'hidden';

			byId('endButtons').style.display = 'table';
			byId('endButtons').style.visibility = 'visible';
		}else{
			byId('assistant').value = null;
			byId('assistant').disabled = true;

			byId('hadLabel').style.visibility = 'hidden';
			byId('had').style.visibility = 'hidden';

			byId('endButtons').style.visibility = 'hidden';
		}
	}

	/** Función byId
	  * EFE: Función wrapper de getElementById
	  * REQ: Id del elemento a obtener.
	  * RET: Elemento requerido.
	  **/
  	function byId(id) {
		return document.getElementById(id);
	}

</script>