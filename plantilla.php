<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include 'includes/header.php'; ?>

    <title>AgroGestion</title>
</head>

<body>
    <?php include 'includes/menu.php'; ?>
    <div class="container border bg-white">
        <div id="alerta"></div>
        <form id="formcampos">
            <!-- Campos y lotes-->
            <div>
                <div class="row">
                    <div class="shadow p-3 mb-3 bg-white rounded col-md-12 ">
                        <h5>Campos</h5>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php

    include 'includes/footer.php';
    include 'modales/modalCampos.php';
    ?>
    <?php include 'includes/footer.php'; ?>
</body>

</html>