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

	<?php if($request_stage > 0): ?>
		<div class="requests view large-9 medium-8 columns content form-section">
			<?= $this->Form->create(false) ?>
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
					<?php endif; ?>
					<legend>
						Opcional
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
						Obligatorio
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
				<div class='row-btn container' id='BtnDiv'>
					<?= $this->Html->link(
						'Cancelar',
						['controller'=>'requests','action'=>'index'],
						['class'=>'btn btn-secondary float-right btn-space radioRequirements pull-right']
					)?>

					<?php
						echo $this->Form->button(
							'Aceptar',
							[
								'id' => 'AceptarRequisitos',
								'name' => 'AceptarRequisitos',
								'type' => 'submit',
								'class' => 'btn btn-primary btn-aceptar radioRequirements pull-right',
								'disabled' => $requirements['stage'] > 1
							]);
						
					?>
				</div>
			<?= $this->Form->end() ?>
		</div>
	<?php endif; ?>


	<?php if($request_stage > 1):?>
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
				<div class='row-btn container' id='BtnDiv'>
					<?= $this->Html->link(
						'Cancelar',
						['controller'=>'requests','action'=>'index'],
						['class'=>'btn btn-secondary float-right btn-space']
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
			<?= $this->Form->end() ?>
		</div>
	<?php endif;?>


	<?php $last = $this->Rounds->getLastRow(); ?>
	<?php $approved = false // cambiar este valor al valor actual de la solicitud, 1 si esta aprovado 0 todo lo demás?> 
	<?php if($request_stage > 2):?>
		<?= $this->Form->create(false) ?>
			<div id="divPreliminar" class="form-section">
				<legend>
					Revisión Final
				</legend>
				<?= $this->Form->control('ClasificaciónFinal',[
							'options' => ['-No Clasificado-', 'Aprobado', 'Rechazado'],
							'default' => $default_indexf,
							'onchange'=>"approve()",
				]);?>
				<div id = 'hoursDiv' style = 'width:100%; display:none;'>
					<div style = 'width:35%; display:flex'>
						<div style = 'width:5%; margin-top:2%' align = center>
							<?= $this->Form->checkbox('checkbox',[
									'id'=>'tsh',
									'value' => 'hs',
									'label' => false,
									'onclick'=>"studentHours()",
							]);?>
						</div>
						<div style = 'margin-top:0.6%'>
							<p> <?= "Horas Estudiante: " ?></p>
						</div>
						<div style = 'width:30%'>
							<?= $this->Form->control('hours',[
								'	id'=>'student',
									'type'=>'number',
									'min' => '3',
									'max' => '12',
									'label' => false,
									'disabled',
									
							]);?>
							<?php $this->Form->unlockField('hours')?>
						</div>
					</div>
					<div style = 'width:35%; display:flex'>
						<div style = 'width:5%; margin-top:2%' align = center>
							<?= $this->Form->checkbox('checkbox',[
									'id'=>'tah',
									'value' => 'ha',
									'label' => false,	
									'onclick'=>"assistantHours()",
											
							]);?>
						</div>
						<div style = 'margin-top:0.6%'>
							<p> <?= "Horas Asistente: " ?></p>
						</div>
						<div style = 'width:30%'>
							<?= $this->Form->control('hours',[
									'id'=>'assistant',
									'type'=>'number',
									'min' => '3',
									'max' => '20',
									'label' => false,
									'disabled',
									
							]);?>
							<?php $this->Form->unlockField('hours')?>
						</div>	
					</div>
					<?= $this->Form->control('date',[
									'type'=>'hidden',
									'value'=> $last[0]
							]);?>
							<?= $this->Form->control('type',[
									'type'=>'hidden',
							]);?>
							<?php $this->Form->unlockField('date')?>
							<?php $this->Form->unlockField('type')?>
					<div style = 'width:33%; display:flex'>
						<div style = 'margin-top:0.6%'>
							<p> <?= "Horas Disponibles: " ?></p>
						</div>
						<div style = 'width:30%'>
							<?= $this->Form->control('horasDisponibles',[
									'type'=>'number',
									'value'=> null,
									'label' => false,
									'disabled',
							]);?>
						</div>
					</div>
				</div>
				<div class='row container' id='BtnDiv'>
				<div class='col-md-9' >
				
				</div>
				<div class='col-md-2 row' style="text-align:right">
				
				<div id='submitDiv' class="submit" style = 'width:100%; height:4%; color:green; display:none'>
					<?= $this->Html->link('Cancelar',[
							'controller'=>'requests',
							'action'=>'index'],[
							'class'=>'btn btn-secondary float-right btn-space'
					]);?>
					</div>
				<div class='col-md-1 row submit' style="text-align:right">
					<?= $this->Form->button('Aceptar',[
							'id' => 'AceptarFin',
							'name' => 'AceptarFin',
							'type' => 'submit',
							'class' => 'btn btn-primary btn-aceptar'
					]);?>
						</div>
			</div>
				</div>
			</div>
			
				
		<?= $this->Form->end() ?>
	<?php endif;?>
</div>

<script type="text/javascript">
$(document).ready( function () {
    $("#edit_checkbox").change(function(){
		if($("#edit_checkbox").is(":checked")){
			$('.radioRequirements').prop( "disabled", false );
		}else{
			$('.radioRequirements').prop( "disabled", true );	
		}
    });
	if(!last){                
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
		byId('submitDiv').style.display = 'none';
		var clasification = byId('clasificacionfinal').value;
		if(clasification == 1){
			byId('hoursDiv').style.display = 'flex';
		}else{
			byId('hoursDiv').style.display = 'none';
			if(clasification == 2){
				byId('submitDiv').style.display = 'block';
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
			byId('student').value = 3;
			byId('student').disabled = false;
			byId('student').focus();
			var tsh = <?= $last[5]; ?>;
			var ash = <?= $last[7]; ?>;
			var tot = tsh-ash;// a este total se le debe de sumar la diferencia si se está revisitando la revisión y se le asignaron horas
			// debe de alterar las horas actuales de la tabla ronda con esos calculos
			byId('horasdisponibles').value = tot;
			byId('submitDiv').style.display = 'block';
		}else{
			byId('student').value = null;
			byId('student').disabled = true;
			byId('horasdisponibles').value = null;
			byId('submitDiv').style.display = 'none';
		}
	}
/** Función assistantHours
  * EFE: Se activa con el checkbox correspondiente, altera los campos en el div de Revisión final
  * 	 para que no existan incongruencias
  **/
	function assistantHours(){
		if(byId('tah').checked){
			byId('type').value = "ha";
			byId('tsh').checked = false;
			byId('student').value = null;
			byId('student').disabled = true;
			byId('assistant').value = 3;
			byId('assistant').disabled = false;
			byId('assistant').focus();
			var tah = <?= $last[6]; ?>;
			var aah = <?= $last[8]; ?>;
			var tot = tah-aah;// a este total se le debe de sumar la diferencia si se está revisitando la revisión y se le asignaron horas
			// debe de alterar las horas actuales de la tabla ronda con esos calculos
			byId('horasdisponibles').value = tot;
			byId('submitDiv').style.display = 'block';
		}else{
			byId('assistant').value = null;
			byId('assistant').disabled = true;
			byId('horasdisponibles').value = null;
			byId('submitDiv').style.display = 'none';
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