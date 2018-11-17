<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request $request
 */
?>


<div class="container mb-5">
    <div class="mb-3"><h3>Solicitud #<?php echo h($request->id);?></h3></div>

    <h4>Datos del estudiante:</h4>

    <table class="table">
        <tbody>

            <tr>
                <th scope="row">Primer Apellido</th>
                <td><?= $request->has('user') ? h($request->user->lastname1) : '' ?></td>
            </tr>
            <tr>
                <th scope="row">Segundo Apellido</th>
                <td><?= $request->has('user') ? h($request->user->lastname2) : '' ?></td>
            </tr>
            <tr>
                <th scope="row">Nombre</th>
                <td><?= $request->has('user') ? h($request->user->name) : '' ?></td>
            </tr>
            <tr>
                <th scope="row">Cédula</th>
                <td><?= $request->has('user') ? h($request->user->identification_number) : '' ?></td>
            </tr>
            <tr>
                <th scope="row">Carné</th>
                <td><?= $request->has('student') ? h($request->student->carne) : '' ?></td>
            </tr>
            <tr>
                <th scope="row">Teléfono</th>
                <td><?= $request->has('user') ? h($request->user->phone) : '' ?></td>
            </tr>
            <tr>
                <th scope="row">Correo electrónico</th>
                <td><?= $request->has('user') ? h($request->user->email_personal) : '' ?></td>
            </tr>
            <tr>
                <th scope="row">Carrera</th>
                <td>Bachillerato en Ciencias de la Computación e Informática</td>
            </tr>
            <tr>
                <th scope="row">Solicita Horas</th>
                <?php if ($request->wants_student_hours && $request->wants_assistant_hours): ?>
                    <td> Asistente y estudiante </td>
                <?php elseif ($request->wants_assistant_hours): ?>
                    <td> Asistente </td>
                <?php elseif ($request->wants_student_hours): ?>
                    <td> Estudiante </td>
                <?php else: ?>
                    <td></td>
                <?php endif ?>
            </tr>
        </tbody>    
    </table>

    <div class="row mb-3"><h5><strong> ¿Tiene o va a solicitar asistencia en otra Unidad Académica u oficina de la Universidad? </strong></h5></div>
    
    <div class="row mb-4">
        <?php if($request->has_another_hours): ?>
            <div class="col-md-1 offset-md-1"><strong>Sí</strong></div>
            <div class="col-md-1"><strong>HA</strong>: <?= $request->another_assistant_hours ?></div>
            <div class="col-md-1"><strong>HE</strong>: <?= $request->another_student_hours ?></div>
        <?php else:?>
            <div class="col-md-1 offset-md-1"><strong>No</strong></div>
        <?php endif?>
    </div>

    <h4>Curso Solicitado:</h4>

    <table class="table">
        <tbody>
            <tr>
                <th scope="row">Sigla</th>
                <td><?= $request->has('course') ? h($request->course->code) : '' ?></td>
            </tr>
            <tr>
                <th scope="row">Grupo</th>
                <td><?= h($request->class_number) ?></td>
            </tr>
            <tr>
                <th scope="row">Nombre del curso</th>
                <td><?= $request->has('course') ? h($request->course->name) : '' ?></td>
            </tr>
            <tr>
                <th scope="row">Nombre del docente</th>
                <td><?= $request->has('docente') ? h($request->docente->name) . ' ' . h($request->docente->lastname1) : '' ?></td>
            </tr>
            <tr>
                <th scope="row">Semestre</th>
                <td><?= h($request->class_semester) ?></td>
            </tr>
            <tr>
                <th scope="row">Año</th>
                <td><?= h($request->class_year) ?></td>
            </tr>
        </tbody>
    </table>

    <div class="row">
        <div class="col" align="right">
            <?= $this->Html->link('Atrás', ['controller' => 'Requests', 'action' => 'index'], ['class' => 'btn btn-secondary']) ?>
            <?= $this->Html->link('Imprimir', ['controller' => 'Requests', 'action' => 'print', $request->id], ['class' => 'btn btn-primary', 'target' => '_blank']) ?>
        </div>
    </div>
</div>


<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#myModal").modal('show');
	});
</script>
</head>
<body>
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Subscribe our Newsletter</h4>
            </div>
            <div class="modal-body">
				<p>Subscribe to our mailing list to get the latest updates straight in your inbox.</p>
                <form>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email Address">
                    </div>
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html> 