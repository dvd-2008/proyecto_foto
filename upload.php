<?php
$targetDir = "fotos/";
$targetFile = $targetDir . basename($_FILES["fileInput"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

// Verificar si es una imagen real o una imagen falsa
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileInput"]["tmp_name"]);
    if($check !== false) {
        echo "El archivo es una imagen - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "El archivo no es una imagen.";
        $uploadOk = 0;
    }
}

// Verificar si el archivo ya existe
if (file_exists($targetFile)) {
    echo "Lo siento, el archivo ya existe.";
    $uploadOk = 0;
}

// Verificar el tamaño del archivo
if ($_FILES["fileInput"]["size"] > 500000) {
    echo "Lo siento, tu archivo es demasiado grande.";
    $uploadOk = 0;
}

// Permitir ciertos formatos de archivo
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG & GIF.";
    $uploadOk = 0;
}

// Verificar si $uploadOk está configurado en 0 por un error
if ($uploadOk == 0) {
    echo "Lo siento, tu archivo no fue cargado.";
// si todo está bien, intenta cargar el archivo
} else {
    if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $targetFile)) {
        echo "El archivo ". basename( $_FILES["fileInput"]["name"]). " ha sido cargado.";
    } else {
        echo "Lo siento, hubo un error al cargar tu archivo.";
    }
}
?>
