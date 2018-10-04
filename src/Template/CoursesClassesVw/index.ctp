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
    <table cellpadding="0" cellspacing="0">
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
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $course->code]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $course->code], ['confirm' => __('Are you sure you want to delete # {0}?', $course->code)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('siguiente') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Página {{page}} de {{pages}}, se muestran {{current}} curso(s) de {{count}} en total.')]) ?></p>
    </div>
</div>
