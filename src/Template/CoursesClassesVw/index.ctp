<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Course[]|\Cake\Collection\CollectionInterface $courses
 */
?>
<nav class="large-8 medium-8 columns" id="actions-sidebar">
    <ul class="nav">
        <li><?= $this->Html->link(__('Agregar un curso'), ['controller' => 'CoursesClassesVw', 'action' => 'add']) ?></li>
    </ul>
</nav>
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
                    <?= $this->Html->link(__('Editar'), [
                        'action' => 'edit', 
                        $course->Sigla,
                        $this->Number->format($course->Grupo),
                        $this->Number->format($course->Semestre),
                        $course->Año
                    ]) ?>
                    <?= $this->Form->postLink(__('Eliminar'), [
                        'action' => 'delete', 
                        $course->Sigla,
                        $this->Number->format($course->Grupo),
                        $this->Number->format($course->Semestre),
                        $course->Año
                    ], 
                    ['confirm' => __(
                        '                            Cursos-Grupo \n\n ¿Está seguro que desea eliminar el curso  {0}?', $course->code)]) ?>
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
