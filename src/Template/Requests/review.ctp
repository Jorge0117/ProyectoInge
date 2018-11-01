<style>
	.form-section{
        background-color: #e4e4e4;
        padding: 2%;
        margin: 2%;
    }
</style>
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


<?php if($data_stage_completed): ?>
<?= $this->Form->create(false) ?>
	<div>
		<div class='input-group mb-2' id='modificar_tag'>
           <span style="width:8%" class="input-group-text" >Modificar</span>     
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
		Opcional
		<div style='width:64%'>
		<table class='table text-center'>
			<?php
				//debug($requirements);
				echo $this->Html->tableHeaders([
					['Requisito' => ['style' => 'width:70%; text-align: left;']], ['Aprobado'  => ['style' => 'width:10%']], ['Rechazado'  => ['style' => 'width:10%']],['Inopia' =>  ['style' => 'width:10%']]
					]);
				for ($i = 0; $i < count($requirements['Opcional']); $i++){
					
					echo('<td style= \'text-align: left;\'>'.$requirements['Opcional'][$i]['description'].'</td>'); 
					echo('<td><input type="radio" name="requirement_'.$requirements['Opcional'][$i]['requirement_number'].'"value="approved" required></td>'); 
					echo('<td><input type="radio" name="requirement_'.$requirements['Opcional'][$i]['requirement_number'].'"value="rejected"></td>');
					echo('<td>'.$this->Form->checkbox(
						'Editar',
						['checked' => false,
						 'name' => 'inopia_op_'.$requirements['Opcional'][$i]['requirement_number']]
					).'</td>');
					echo('</tr>');
					//$requirement_row[] = $requirements['Opcional'][$i]['description'];
					//$requirement_row[] = '<input type="radio" name="requirement_'.$requirements['Opcional'][$i]['requirement_number'].'"value="approved">';//$this->Form->radio('optional'.$i, [['value' => 'approved', 'text' => '']]);
					//$requirement_row[] = '<input type="radio" name="requirement_'.$requirements['Opcional'][$i]['requirement_number'].'"value="rejected">';//$this->Form->radio('optional'.$i, [['value' => 'rejected', 'text' => '']]);
					/*$requirement_row[] = $this->Form->checkbox(
							'Editar',
							['checked' => false,
							 'name' => 'inopia_op_'.$requirements['Opcional'][$i]['requirement_number']]
						);*/
					$this->Form->unlockField('requirement_'.$requirements['Opcional'][$i]['requirement_number']);
					//echo $this->Html->tableCells($requirement_row);
					//$requirement_row = [];
				}
			?>		  
		</table>
		</div>
		Obligatorio
		<div  style='width:58%'>
		<table class='table text-center '>
			<?php
				echo $this->Html->tableHeaders([
					['Requisito' => ['style' => 'width:62%; text-align: left;']], ['Aprobado'  => ['style' => 'width:10%']], ['Rechazado'  => ['style' => 'width:10%']]
					]);
				for ($i = 0; $i < count($requirements['Obligatorio']); $i++){
					echo('<td style= \'text-align: left;\'>'.$requirements['Obligatorio'][$i]['description'].'</td>'); 
					echo('<td><input type="radio" name="requirement_'.$requirements['Obligatorio'][$i]['requirement_number'].'"value="approved" required></td>'); 
					echo('<td><input type="radio" name="requirement_'.$requirements['Obligatorio'][$i]['requirement_number'].'"value="rejected"></td>'); 
					//$requirement_row[] = [$requirements['Obligatorio'][$i]['description'] , ['style' => 'text-align: left;']];
					//$requirement_row[] = '<input type="radio" name="requirement_'.$requirements['Obligatorio'][$i]['requirement_number'].'"value="approved">';//$this->Form->radio('compulsory'.$i, [['value' => 'approved', 'text' => '', 'id'=>'rc1']]);
					//$requirement_row[] = '<input type="radio" name="requirement_'.$requirements['Obligatorio'][$i]['requirement_number'].'" value="rejected">';//$this->Form->radio('compulsory'.$i, [['value' => 'rejected', 'text' => '', 'id'=>'rc2']]);
					$this->Form->unlockField('requirement_'.$requirements['Obligatorio'][$i]['requirement_number']);
					//debug($requirement_row);
					//echo $this->Html->tableCells($requirement_row);
					//$requirement_row = [];
				}
			?>		  

        </table>
	</div>
	</div>
	<div class='row container' id='BtnDiv'>
        <div class='col-md-9' >
        
        </div>
        <div class='col-md-2 row' style="text-align:right">
        
        
        <?= $this->Html->link(
			'Cancelar',
			['controller'=>'requests','action'=>'index'],
			['class'=>'btn btn-secondary float-right btn-space']
		)?>
        </div>
        <div class='col-md-1 row submit' style="text-align:right">
        <?php
            echo $this->Form->button(
                'Aceptar',
                [
					'id' => 'AceptarRequisitos',
                    'name' => 'AceptarRequisitos',
                    'type' => 'submit',
                    'class' => 'btn btn-primary btn-aceptar'
				]);
			
        ?>
        </div>
    </div>
	
<?= $this->Form->end() ?>
<?php endif; ?>
