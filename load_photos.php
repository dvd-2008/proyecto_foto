<?php
$files = array_diff(scandir('fotos'), array('..', '.'));
echo json_encode($files);
?>
