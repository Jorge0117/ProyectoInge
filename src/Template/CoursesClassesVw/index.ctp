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
    #image1 {
        height: 10px;
        width: 10px;
    }
</style>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/> 

 <?= $this->Html->link(
        'Agregar grupo',
        ['controller'=>'Classes','action'=>'add'],
        ['class'=>'btn btn-primary float-right']
    )?>
 <?= $this->Html->link(
        'Agregar curso',
        ['controller'=>'CoursesClassesVw','action'=>'add'],
        ['class'=>'btn btn-primary float-right']
    )?>
 <?= $this->Html->link(
        'Cargar archivo',
        ['controller'=>'CoursesClassesVw','action'=>'importExcelfile'],
        ['class'=>'btn btn-primary float-right']
    )?>

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
                <th scope="col" class="actions"><?= __('Opciones') ?></th>
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
                        '<i class="fa fa-eye fa_custom fa-2x"></i>', // Editar
                        [
                            'action' => 'edit', 
                            $course->Sigla,
                            $this->Number->format($course->Grupo),
                            $this->Number->format($course->Semestre),
                            $course->Año
                        ],
                        [
                            'escape' => false
                        ]
                    ) ?>
                    <?= $this->Form->postLink(
                        '<i class="fa fa-trash-o fa_custom fa-2x"></i>',// Eliminar
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
