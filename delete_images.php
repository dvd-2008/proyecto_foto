<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['images'])) {
    $deletedImages = [];
    foreach ($_POST['images'] as $image) {
        $filePath = 'fotos/' . $image;
        if (file_exists($filePath)) {
            unlink($filePath);
            $deletedImages[] = $image;
        }
    }
    echo "Se han eliminado las siguientes imágenes: " . implode(", ", $deletedImages);
} else {
    echo "No se han recibido imágenes para eliminar.";
}
?>
