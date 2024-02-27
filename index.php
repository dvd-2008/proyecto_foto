<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir y Mostrar Fotos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            max-width: 90%;
            margin: 0 auto;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        #photos {
            max-height: 400px;
            overflow-y: auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        #photos img {
            margin: 5px;
            border-radius: 5px;
        }
        .btn-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 10px;
            justify-content: center;
        }
        .btn-grid button {
            width: 100%;
            font-size: 12px;
            padding: 6px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <h2 class="text-center mb-4">Subir Foto</h2>
        <form id="uploadForm" enctype="multipart/form-data">
            <div class="mb-3">
                <input class="form-control" type="file" name="fileInput" id="fileInput" accept="image/*">
            </div>
            <div class="mb-3">
                <input class="btn btn-primary" type="submit" value="Subir Foto">
            </div>
        </form>
        <div id="message"></div>

        <div class="btn-grid">
            <button id="showPhotosBtn" class="btn btn-primary">Mostrar Fotos</button>
            <button id="selectImagesBtn" class="btn btn-secondary">Seleccionar Imágenes</button>
            <button id="deleteImagesBtn" class="btn btn-danger">Borrar Imágenes</button>
            <button id="hideImagesBtn" class="btn btn-dark">Ocultar Imágenes</button>
        </div>

        <h2 class="text-center mt-4">Fotos</h2>
        <div id="photos" class="text-center"></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        // Función para subir archivo usando AJAX
        $('#uploadForm').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: 'upload.php',
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(response){
                    $('#message').html(response);
                    $('#fileInput').val('');
                    // Mostrar mensaje en ventana emergente
                    alert("¡Felicidades! " + response);
                }
            });
        });

        // Función para cargar las fotos usando AJAX
        $('#showPhotosBtn').click(function(){
            $.ajax({
                url: 'load_photos.php',
                type: 'GET',
                dataType: 'json',
                success: function(response){
                    $('#photos').empty(); // Limpiar contenedor de fotos
                    $.each(response, function(index, photo){
                        $('#photos').append('<img src="fotos/' + photo + '" class="img-thumbnail" width="150" height="150">');
                    });
                }
            });
        });

        // Función para seleccionar imágenes
        $('#selectImagesBtn').click(function(){
            $('.image-checkbox').prop('checked', true);
        });

        // Función para eliminar imágenes seleccionadas
        $('#deleteImagesBtn').click(function(){
            var selectedImages = $('.image-checkbox:checked').map(function(){
                return $(this).data('name');
            }).get();
            
            if(selectedImages.length === 0) {
                alert("Por favor, seleccione al menos una imagen para eliminar.");
                return;
            }

            $.ajax({
                url: 'delete_images.php',
                type: 'POST',
                data: {images: selectedImages},
                success: function(response){
                    alert(response);
                    $('#showPhotosBtn').click(); // Recargar las fotos después de eliminar
                }
            });
        });

        // Función para ocultar imágenes
        $('#hideImagesBtn').click(function(){
            $('#photos').empty(); // Limpiar contenedor de fotos
        });
    });
</script>

</body>
</html>
