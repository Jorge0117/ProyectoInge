<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request[]|\Cake\Collection\CollectionInterface $requests
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Acciones') ?></li>
		<?php if ($disponible === true): ?>
        <li><?= $this->Html->link(__('Nueva Solicitud'), ['action' => 'add']) ?></li>
		<?php endif; ?>
    </ul>
</nav>
<div class="requests index large-9 medium-8 columns content">
    <h3><?= __('Solicitudes') ?></h3>
    <table cellpadding="0" cellspacing="0" id = "requesttable">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Fecha de Solicitud') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Año') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Curso') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Semestre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Grupo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Estado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Otras Horas Asistente') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Otras Horas Estudiante') ?></th>
                <th scope="col"><?= $this->Paginator->sort('¿Tiene otras Horas?') ?></th>
                <th scope="col"><?= $this->Paginator->sort('¿Es primera Solicitud?') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Promedio') ?></th>
                <th scope="col" class="actions"><?= __('Acciones') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requests as $request): ?>
            <tr>
                <td><?= h($request->reception_date) ?></td>
                <td><?= h($request->class_year) ?></td>
               <!-- <td><?= $request->has('course') ? $this->Html->link($request->course->name, ['controller' => 'Courses', 'action' => 'view', $request->course->code]) : '' ?></td>-->
                <td><?= h($request->course_id) ?></td>
				<td><?= $this->Number->format($request->class_semester) ?></td>
                <td><?= $this->Number->format($request->class_number) ?></td>
                <td><?= h($request->status) ?></td>
				
				
                <td><?= $this->Number->format($request->another_assistant_hours) ?></td>

				
                <td><?= $this->Number->format($request->another_student_hours) ?></td>
				<?php if ($request->has_another_hours === true): ?>
					<td> SI </td>
				<?php else: ?>
					<td> NO </td>
				<?php endif; ?>
				
				<?php if ($request->first_time === true): ?>
					<td> SI </td>
				<?php else: ?>
					<td> NO </td>
				<?php endif; ?>
				
                <td><?= $this->Number->format($request->average) ?></td>
				
                <td class="actions">
                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $request->id]) ?>
                </td>
				
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <!--<?= $this->Paginator->numbers() ?>-->
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Pagina {{page}} de {{pages}}, mostrando {{current}} solicitudes de {{count}}')]) ?></p>
    </div>
</div>

<script type="text/javascript">
    $(document).ready( function () {
        $("#requesttable").DataTable(
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

