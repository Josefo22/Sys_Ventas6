<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - <?php echo isset($pageTitle) ? $pageTitle : 'Error general'; ?></title>
    <link href="<?php echo BASE_URL; ?>assets/css/styles.css" rel="stylesheet" />
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="text-center">
            <h1 class="display-4">Error</h1>
            <p class="lead"><?php echo isset($message) ? $message : 'Ha ocurrido un error inesperado'; ?></p>
            <a href="<?php echo BASE_URL; ?>" class="btn btn-primary">Volver al inicio</a>
        </div>
    </div>
</body>
</html>