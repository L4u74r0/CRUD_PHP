<?php

if (!empty($_POST["btnModificar"])) {
    if (!empty($_POST["nombre"]) and !empty($_POST["correo"]) and !empty($_POST["telefono"]) and !empty($_POST["nacimiento"]) and !empty($_POST["cargo"])) {
        $id=$_POST["id"];
        $nombre=$_POST["nombre"];
        $correo=$_POST["correo"];
        $telefono=$_POST["telefono"];
        $nacimiento=$_POST["nacimiento"];
        $cargo=$_POST["cargo"];

        $sql=$conexion->query("UPDATE personas SET nombre='$nombre', correo='$correo', telefono='$telefono', nacimiento='$nacimiento', cargo='$cargo' WHERE id=$id ");
        if ($sql == 1) {
            header("Location:index.php");
        } else {
            echo "<div class='alert alert-warning'>error al modificar personas</div>";
        }

    }else{
        echo "<div class='alert alert-warning'>campos vacios</div>";
    }
}
