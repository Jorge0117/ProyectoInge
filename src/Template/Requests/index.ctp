<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request[]|\Cake\Collection\CollectionInterface $requests
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Request'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Courses'), ['controller' => 'Courses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Course'), ['controller' => 'Courses', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="requests index large-9 medium-8 columns content">
    <h3><?= __('Solicitudes') ?></h3>
    <table cellpadding="0" cellspacing="0" id = "requeststable">
        <thead>
            <tr>
                <!--<th scope="col"><?= $this->Paginator->sort('id') ?></th> no le sirve de nada al estudiante-->
                <th scope="col"><?= $this->Paginator->sort('Numero Ronda') ?></th> 
                <th scope="col"><?= $this->Paginator->sort('Semestre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Año') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Fecha Solicitud') ?></th>
               <!-- <th scope="col"><?= $this->Paginator->sort('class_year') ?></th> Fecha redundante-->
                <th scope="col"><?= $this->Paginator->sort('Curso') ?></th>
               <!-- <th scope="col"><?= $this->Paginator->sort('class_semester') ?></th> Semestre redundante-->
               <th scope="col"><?= $this->Paginator->sort('Numero Grupo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('id estudiante (*)') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Estado') ?></th>
                 <th scope="col"><?= $this->Paginator->sort('Otras Horas Asistente') ?></th>
               <th scope="col"><?= $this->Paginator->sort('Otras Horas Estudiante') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requests as $request): ?>
            <tr>
               <!--  <td><?= $this->Number->format($request->id) ?></td>-->
                <td><?= $this->Number->format($request->round_number) ?></td>
                <td><?= $this->Number->format($request->round_semester) ?></td>
                <td><?= $this->Number->format($request->round_year) ?></td>
                <td><?= h($request->reception_date) ?></td>
             <!--   <td><?= h($request->class_year) ?></td> -->
                <td><?= $request->has('course') ? $this->Html->link($request->course->name, ['controller' => 'Courses', 'action' => 'view', $request->course->code]) : '' ?></td>
              <td><?= $this->Number->format($request->class_semester) ?></td>
             <!--     <td><?= $this->Number->format($request->class_number) ?></td> -->
                <td><?= $request->has('student') ? $this->Html->link($request->student->user_id, ['controller' => 'Students', 'action' => 'view', $request->student->user_id]) : '' ?></td>
                <td><?= h($request->status) ?></td>
                <td><?= $this->Number->format($request->another_assistant_hours) ?></td>
                <td><?= $this->Number->format($request->another_student_hours) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $request->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $request->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $request->id], ['confirm' => __('Are you sure you want to delete # {0}?', $request->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>

<script type="text/javascript">
    $(document).ready( function () {
        $("#requeststable").DataTable(
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

