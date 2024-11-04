<?php
include "modelo/conexion.php";
$id = $_GET["id"];
$sql = $conexion->query("SELECT * FROM personas WHERE id=$id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<form class="col-3 p-3 m-auto" method="POST" enctype="multipart/form-data">
    <h3 class="text-center text-secondary">Modificar</h3>

    <input type="hidden" name="id" value="<?= $_GET["id"] ?>">

    <?php
    include "controlador/modificar_persona.php";
    while ($datos = $sql->fetch_object()) { ?>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nombre</label>
            <input type="text" class="form-control" name="nombre" value="<?= $datos->nombre ?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Correo</label>
            <input type="email" class="form-control" name="correo" value="<?= $datos->correo ?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Telefono</label>
            <input type="text" class="form-control" name="telefono" value="<?= $datos->telefono ?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nacimiento</label>
            <input type="date" class="form-control" name="nacimiento" value="<?= $datos->nacimiento ?>">
        </div>
        <div class="mb-3">
            <label for="cargo" class="form-label">Cargo</label>
            <select class="form-select" name="cargo">
                <option value="">Seleccione un cargo</option>
                <option value="Desarrollador Backend" <?= $datos->cargo == 'Desarrollador Backend' ? 'selected' : '' ?>>Desarrollador Backend</option>
                <option value="Desarrollador Frontend" <?= $datos->cargo == 'Desarrollador Frontend' ? 'selected' : '' ?>>Desarrollador Frontend</option>
                <option value="Ingeniero en Software" <?= $datos->cargo == 'Ingeniero en Software' ? 'selected' : '' ?>>Ingeniero en Software</option>
                <option value="Administrador de Bases de Datos" <?= $datos->cargo == 'Administrador de Bases de Datos' ? 'selected' : '' ?>>Administrador de Bases de Datos</option>
                <option value="Diseñador UX/UI" <?= $datos->cargo == 'Diseñador UX/UI' ? 'selected' : '' ?>>Diseñador UX/UI</option>
                <option value="Desarrollador Fullstack" <?= $datos->cargo == 'Desarrollador Fullstack' ? 'selected' : '' ?>>Desarrollador Fullstack</option>
            </select>
        </div> 
        <div class="mb-3">
                <label for="avatar" class="form-label">Foto de Perfil</label>
                <input type="file" class="form-control" name="avatar" accept="image/*" required>
        </div>

    <?php } ?>

    <button type="submit" class="btn btn-primary" name="btnModificar" value="ok">Modificar</button>
</form>
</body>
</html>