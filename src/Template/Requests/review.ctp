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
<div class="requests view large-9 medium-8 columns content">
    <?= $this->Form->create($request)?>
    <fieldset>
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

        

        <?php if($load_preliminar_review):?>
            <div id="divPreliminar" class="form-section">
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
            </div>
        <?php endif;?>

        </fieldset>
        <?= $this->Html->link(
            'Cancelar',
            ['controller'=>'requests','action'=>'index'],
            ['class'=>'btn btn-secondary float-right btn-space']
        )?>
        <button type="submit" class="btn btn-primary float-right  btn-space">Aceptar</button>
    <?= $this->Form->end()?>
</div>