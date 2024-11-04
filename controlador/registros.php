<?php
// Incluir el archivo de conexión a la base de datos
include 'modelo/conexion.php'; // Asegúrate de que la ruta sea correcta

if (isset($_POST["btnRegistrar"])) {
    if (!empty($_POST["nombre"]) && !empty($_POST["correo"]) && !empty($_POST["telefono"]) && !empty($_POST["nacimiento"]) && !empty($_POST["cargo"])) {
        $nombre = $_POST["nombre"];
        $correo = $_POST["correo"];
        $telefono = $_POST["telefono"];
        $nacimiento = $_POST["nacimiento"];
        $cargo = $_POST["cargo"];
        
        // Inicializar la variable avatar
        $avatar = null; // O puedes usar $avatar = ''; si prefieres

        // Manejo del archivo avatar
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
            $avatar = $_FILES['avatar']['name'];
            $ruta = "uploads/" . basename($avatar); // Ruta donde se almacenará la imagen

            // Mover el archivo a la carpeta deseada
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $ruta)) {
                // Si se sube un nuevo avatar, se usa la nueva ruta
                $avatar = $ruta;
            } else {
                echo "Error al subir la imagen.";
            }
        }

        // Imprimir valores para depuración
        echo "Nombre: $nombre<br>";
        echo "Correo: $correo<br>";
        echo "Teléfono: $telefono<br>";
        echo "Nacimiento: $nacimiento<br>";
        echo "Cargo: $cargo<br>";
        echo "Avatar: $avatar<br>";

        // Insertar en la base de datos
        $sql = "INSERT INTO personas (nombre, correo, telefono, nacimiento, cargo, avatar) VALUES ('$nombre', '$correo', '$telefono', '$nacimiento', '$cargo', '$avatar')";

        // Ejecutar la consulta
        if ($conexion->query($sql) === TRUE) {
            header("Location:index.php"); // Redirigir después de la inserción
        } else {
            echo "<div class='alert alert-danger'>Error al registrar persona: " . $conexion->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Algunos campos están vacíos</div>";
    }
}
?>