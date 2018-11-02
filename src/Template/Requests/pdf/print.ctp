<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request $request
 */
?>


<div class="container mb-5">
    <div class="mb-4"><h3>Solicitud #<?php echo h($request->id);?></h3></div>

    <div class="mb-4">
        <h4>Datos del estudiante:</h4>
    </div>

    <div class="mb-4">
        <div class="row justify-content-between">
            <div class="col-3 border-bottom border-dark text-center">
                <?= $request->has('user') ? h($request->user->lastname1) : '' ?>
            </div>
            <div class="col-3 border-bottom border-dark text-center">
                <?= $request->has('user') ? h($request->user->lastname2) : '' ?>
            </div>
            <div class="col-3 border-bottom border-dark text-center">
                <?= $request->has('user') ? h($request->user->name) : '' ?>
            </div>
        </div>

        <div class="row justify-content-between">
            <div class="col-3 text-center">
                <strong>Primer Apellido</strong>
            </div>
            <div class="col-3 text-center">
                <strong>Segundo Apellido</strong>
            </div>
            <div class="col-3 text-center">
                <strong>Nombre</strong>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <div class="row justify-content-between">
            <div class="col-2 border-bottom border-dark text-center">
                <?= $request->has('user') ? h($request->user->identification_number) : '' ?>
            </div>
            <div class="col-2 border-bottom border-dark text-center">
                <?= $request->has('student') ? h($request->student->carne) : '' ?>
            </div>
            <div class="col-2 border-bottom border-dark text-center">
                <?= $request->has('user') ? h($request->user->phone) : '' ?>
            </div>
            <div class="col-3 border-bottom border-dark text-center">
                <?= $request->has('user') ? h($request->user->email_personal) : '' ?>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-2 text-center">
                <strong>Cédula</strong>
            </div>
            <div class="col-2 text-center">
                <strong>Carné</strong>
            </div>
            <div class="col-2 text-center">
                <strong>Teléfono</strong>   
            </div>
            <div class="col-3 text-center">
                <strong>Correo  electrónico</strong>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <div class="row justify-content-between">
            <div class="col-5 border-bottom border-dark text-center">
                Bach. en Ciencias de la Computación e Informática
            </div>
            <div class="col-1">
                Solicita
            </div>
            <div class="col-1">
                HE:
                <?php if ($request->wants_student_hours): ?>
                    <input type="checkbox" checked="checked" aria-label="HE" disabled>
                <?php else: ?>
                    <input type="checkbox" aria-label="HE" disabled>
                <?php endif ?>
            </div>
            <div class="col-1">
                HA:
                <?php if ($request->wants_assistant_hours): ?>
                    <input type="checkbox" checked="checked" aria-label="HA" disabled>
                <?php else: ?>
                    <input type="checkbox" aria-label="HA" disabled>
                <?php endif ?>
            </div>
            <div class="col">
                (Puede marcar ambas opciones)
            </div>
        </div>

        <div class="row">
            <div class="col-5 text-center">
                <strong>Carrera</strong>
            </div>
            <div class="col-1">
            </div>
            <div class="col-1">
            </div>
            <div class="col-1">
            </div>
            <div class="col">
            </div>
        </div>
    </div>

    <div class="mt-4 mb-4">
        <p>Documentos que debe adjuntar al entregar el formulario en la ECCI:<p>
        <ol>
            <li>Entregar este formulario debidamente en la Secretaria de la ECCI, sin la firma del docente.</li>
            <li>Si es su primera asistencia en la UCR debe traer además una carta de un Banco Público en la que certifique su número de cuenta de ahorro o cuenta corriente y copia de su documento de identificación.</li>
        </ol>
    </div>

    <div class="mt-4 mb-4">
        <p>Información sobre otras asistencias:<p>
        <ol>
            <li>¿Tiene o va a solicitar asistencia en otra Unidad Académica u oficina de la Universidad?</li>
        </ol>
        <div class="row justify-content-start">
            <div class="col-2 offset-1">
                <strong>No</strong>
                <?php if (!$request->has_another_hours): ?>
                    <input type="checkbox" checked="checked" disabled aria-label="no_oh">
                <?php else: ?>
                    <input type="checkbox" aria-label="no_oh" disabled>
                <?php endif ?>
            </div>
            <div class="col-2">
                <strong>Sí</strong>
                <?php if ($request->has_another_hours): ?>
                    <input type="checkbox" checked="checked" disabled aria-label="has_oh">
                <?php else: ?>
                    <input type="checkbox" aria-label="has_oh" disabled>
                <?php endif ?>
            </div>
            <div class="col-1">
                Cantidad
            </div>
            <div class="col-1">
                <strong>HA:</strong> <?= $request->another_assistant_hours ?>
            </div>
            <div class="col-1">
                <strong>HE:</strong> <?= $request->another_student_hours ?>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <h4>Curso Solicitado</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Sigla</th>
                    <th scope="col">Grupo</th>
                    <th scope="col">Nombre del Curso</th>
                    <th scope="col">Nombre del Docente</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="row"><?= $request->has('course') ? h($request->course->code) : '' ?></td>
                    <td><?= h($request->class_number) ?></td>
                    <td><?= $request->has('course') ? h($request->course->name) : '' ?></td>
                    <td><?= $request->has('docente') ? h($request->docente->name) . ' ' . h($request->docente->lastname1) : '' ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-4 mb-5">
        <div class="row justify-content-start">
            <div class="col-3 text-right">
                <strong>Firma del estudiante:</strong>
            </div>
            <div class="col-4 border-bottom border-dark">&nbsp</div>
        </div>
    <div>

    <div class="mt-5 mb-3"><h4><strong>Uso exclusivo del docente</strong></h4></div>

    <div class="mb-3"
        <h5><strong>Justificación (en ambos casos, aceptado o rechazado):</strong></h5>

        <div class="row mb-1">
            <div class="col border-bottom border-dark">&nbsp</div>
        </div>
        <div class="row mb-1">
            <div class="col border-bottom border-dark">&nbsp</div>
        </div>
        <div class="row mb-1">
            <div class="col border-bottom border-dark">&nbsp</div>
        </div>
    </div>

    <div class="mb-3">
        <div class="row justify-content-start">
            <div class="col-2 offset-2">
                <strong>Rechazado</strong>
                <input type="checkbox" aria-label="rechazado">
            </div>
            <div class="col-2">
                <strong>Aceptado</strong>
                <input type="checkbox" aria-label="aceptado">
            </div>
            <div class="col-2 text-right">
                <strong>Horas asignadas:</strong>
            </div>
            <div class="col-2 border-bottom border-dark">&nbsp</div>
        </div>
    </div>

    <div class="mt-4 mb-5">
        <div class="row justify-content-start">
            <div class="col-3 text-right">
                <strong>Firma del docente:</strong>
            </div>
            <div class="col-4 border-bottom border-dark">&nbsp</div>
        </div>
    <div>
</div>