<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Course[]|\Cake\Collection\CollectionInterface $courses
 */
?>
<style>
    .button {
        background-color: #ceb92bff;
        border: none;
        padding: 5px 7px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 8px 2px;
        cursor: pointer;
        float: right;
    }
    .btn-space {
        margin-right: 3px;
        margin-leftt: 3px;
    }
    .button a {
        color:#fff; 
    }
    /* .actions a {
        color:#000; 
    } */
    .btn-space {
        margin-right: 3px;
        margin-leftt: 3px;
    }
    #image1 {
        height: 10px;
        width: 10px;
    }
</style>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/> 

 <?= $this->Html->link(
        'Agregar grupo',
        ['controller'=>'Classes','action'=>'add'],
        ['class'=>'btn btn-primary float-right btn-space']
    )?>
 <?= $this->Html->link(
        'Agregar curso',
        ['controller'=>'CoursesClassesVw','action'=>'add'],
        ['class'=>'btn btn-primary float-right btn-space']
    )?>
<button id="butExcel" class="btn btn-primary float-right btn-space">Cargar Archivo</button>

<div class="courses index large-9 medium-8 columns content">
    <h3><?= __('Cursos-Grupos') ?></h3>
    <table cellpadding="0" cellspacing="0" id = 'viewCoursesClassesDatagrid'>
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Sigla') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Curso') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Grupo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Profesor') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Semestres') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Año') ?></th>
                <th scope="col" class="actions"><?= __('') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($coursesClassesVw as $course): ?>
            <tr>
                <td><?= h($course->Sigla) ?></td>
                <td><?= h($course->Curso) ?></td>
                <td><?= $this->Number->format($course->Grupo) ?></td>
                <td><?= h($course->Profesor) ?></td>
                <td><?= h($course->Semestre) ?></td>
                <td><?= h($course->Año) ?></td>
                
                <td class="actions">
                    <?= $this->Html->link(
                        '<i class="fa fa-pencil fa_custom fa-1x"></i>', // Editar
                        [
                            'action' => 'edit', 
                            $course->Sigla,
                            $this->Number->format($course->Grupo),
                            $this->Number->format($course->Semestre),
                            $course->Año,
                            $course->Curso,
                            $course->Profesor
                        ],
                        [
                            'escape' => false
                        ]
                    ) ?>
                    <?= $this->Form->postLink(
                        '<i class="fa fa-trash-o fa_custom fa-1x"></i>',// Eliminar
                        [
                            'action' => 'delete', 
                            $course->Sigla,
                            $this->Number->format($course->Grupo),
                            $this->Number->format($course->Semestre),
                            $course->Año
                        ], 
                        [
                            'escape' => false,
                            'confirm' => __(
                            '                            Cursos-Grupo \n\n ¿Está seguro que desea eliminar el curso  {0}?', 
                            $course->code)
                        ]
                    ) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    

<script type="text/javascript">
    $(document).ready( function () {
        $("#viewCoursesClassesDatagrid").DataTable(
          {
            /** Configuración del DataTable para cambiar el idioma, se puede personalisar aun más **/
            "language": {
                "lengthMenu": "Mostrar _MENU_ filas por página",
                "zeroRecords": "Sin resultados",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Sin datos disponibles",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "sSearch": "Buscar:",
                "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    }
            }
          }
        );
    } );
</script>



<div id="Subir archivo" class="modal">
    <div class="modal-content">
        <div class="files form large-9 medium-8 columns content">
            <?= $this->Form->create(null, ['type' => 'file', 'url' => '/Files/add']) ?>
            <fieldset>
                <legend><?= __('Seleccione el archivo') ?></legend>
                <?php
                    echo $this->Form->control('file', ['label'=>['text'=>''], 'type' => 'file']);
                ?>
            </fieldset>
            <button type="submit" class="btn btn-primary float-right">Aceptar</button>
            <button id="butCanc" type="reset" class="btn btn-secondary float-right btn-space">Cancelar</button>
        
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>


<style>
    body {font-family: Arial, Helvetica, sans-serif;}

    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
    }

    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<script>
// Get the modal
var modal = document.getElementById('Subir archivo');

// Get the button that opens the modal
var btn = document.getElementById("butExcel");

// Get the <span> element that closes the modal
var span = document.getElementById("butCanc");

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>