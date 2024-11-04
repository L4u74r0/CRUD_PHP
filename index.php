<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD PHP Y MySQL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<script>
    function eliminar(){
        var respuesta = confirm("¿Seguro de eliminar este registro?");
        return respuesta;
    }
</script>

<!-- FORMULARIO -->
    <h1 class="text-center p-2">CRUD PHP y MySQL</h1>

    <?php 
    include "modelo/conexion.php";
    include "controlador/eliminar_persona.php";
    ?>

    <div class="container-fluid row" >
        <form class="col-3 p-3" method="POST" enctype="multipart/form-data">
            <h3 class="text-center">Registro</h3>

            <?php
            include "controlador/registros.php";
            ?>

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" name="correo" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" name="telefono" required>
            </div>
            <div class="mb-3">
                <label for="nacimiento" class="form-label">Nacimiento</label>
                <input type="date" class="form-control" name="nacimiento" required>
            </div>
            <div class="mb-3">
                <label for="cargo" class="form-label">Cargo</label>
                <select class="form-select" name="cargo" required>
                    <option value="">Seleccione un cargo</option>
                    <option value="Desarrollador Backend">Desarrollador Backend</option>
                    <option value="Desarrollador Frontend">Desarrollador Frontend</option>
                    <option value="Ingeniero en Software">Ingeniero en Software</option>
                    <option value="Administrador de Bases de Datos">Administrador de Bases de Datos</option>
                    <option value="Diseñador UX/UI">Diseñador UX/UI</option>
                    <option value="Desarrollador Fullstack">Desarrollador Fullstack</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="avatar" class="form-label">Foto de Perfil</label>
                <input type="file" class="form-control" name="avatar" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary" name="btnRegistrar" value="ok">Registrar</button>
        </form>

<!-- TABLA -->

        <div class="col-8 p-4">
            <table class="table table-striped table-bordered mt-4">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Nacimiento</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Avatar</th>
                        <th class="acciones" scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "modelo/conexion.php";

                    // Número de registros por página
                    $registrosPorPagina = 8;

                    // Obtener el número total de registros
                    $resultadoTotal = $conexion->query("SELECT COUNT(*) as total FROM personas");
                    $totalRegistros = $resultadoTotal->fetch_assoc()['total'];

                    // Calcular el número total de páginas
                    $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

                    // Obtener la página actual
                    $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                    $paginaActual = max(1, min($paginaActual, $totalPaginas)); // Asegurarse de que la página actual esté dentro del rango

                    // Calcular el inicio de los registros a mostrar
                    $inicio = ($paginaActual - 1) * $registrosPorPagina;

                    // Consulta para obtener los registros de la página actual
                    $sql = "SELECT * FROM personas LIMIT $inicio, $registrosPorPagina";
                    $resultado = $conexion->query($sql);

                    while ($datos = $resultado->fetch_object()) { ?>
                        <tr>
                            <td><?= $datos->id ?></td>
                            <td><?= $datos->nombre ?></td>
                            <td><?= $datos->correo ?></td>
                            <td><?= $datos->telefono ?></td>
                            <td><?= $datos->nacimiento ?></td>
                            <td><?= $datos->cargo ?></td>
                            <td>
                                <?php if (!empty($datos->avatar)) { ?>
                                    <img src="<?= $datos->avatar ?>" alt="Avatar" style="width:50px; height:50px; border-radius:50%;">
                                <?php } else { ?>
                                    <img src="ruta/a/imagen/por_defecto.png" alt="Avatar" style="width:50px; height:50px; border-radius:50%;">
                                <?php } ?>
                            </td>
                            <td class="acciones">
                                <a href="modificar.php?id=<?= $datos->id ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="30" height="30"><path fill="blue" d="m14.25,11.664l-4.25,4.25c-.373.372-.888.586-1.414.586h-.586v-.586c0-.534.208-1.036.586-1.414l4.25-4.25,1.414,1.414Zm1.043-3.871l-1.043,1.043,1.414,1.414,1.043-1.043c.39-.39.39-1.024,0-1.414-.378-.379-1.037-.379-1.414,0Zm8.707-2.793v14c0,2.757-2.243,5-5,5H5c-2.757,0-5-2.243-5-5V5C0,2.243,2.243,0,5,0h14c2.757,0,5,2.243,5,5Zm-5.878,1.379c-1.134-1.133-3.11-1.133-4.243,0l-6.707,6.707c-.755.755-1.172,1.76-1.172,2.828v1.586c0,.553.448,1,1,1h1.586c1.068,0,2.073-.416,2.828-1.172l6.707-6.707c1.17-1.17,1.17-3.072,0-4.242Z"/></svg>
                                </a>
                                <a onclick="return eliminar()" href="index.php?id=<?= $datos->id ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="30" height="30"><path fill="red" d="m19,0H5C2.243,0,0,2.243,0,5v14c0,2.757,2.243,5,5,5h14c2.757,0,5-2.243,5-5V5c0-2.757-2.243-5-5-5Zm-1.231,6.641l-4.466,5.359,4.466,5.359c.354.425.296,1.056-.128,1.409-.188.155-.414.231-.64.231-.287,0-.571-.122-.77-.359l-4.231-5.078-4.231,5.078c-.198.237-.482.359-.77.359-.226,0-.452-.076-.64-.231-.424-.354-.481-.984-.128-1.409l4.466-5.359-4.466-5.359c-.354-.425-.296-1.056.128-1.409.426-.353,1.056-.296,1.409.128l4.231,5.078,4.231-5.078c.354-.424.983-.48,1.409-.128.424.354.481.984.128,1.409Z"/></svg>
                                </a>
                            </td>
                        </tr>
                    <?php }
                ?>
            </tbody>
            </table>

            <!-- Paginación -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($paginaActual > 1) { ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?= $paginaActual - 1 ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                        <li class="page-item <?= ($i == $paginaActual) ? 'active' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php } ?>

                    <?php if ($paginaActual < $totalPaginas) { ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?= $paginaActual + 1 ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>

    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>