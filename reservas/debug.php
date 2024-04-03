<?php
    session_start();
    if (!isset($_SESSION['usuario_login'])) {
        header("location: ./");
    } else if ($_SESSION['usuario_login']['cod_usuario'] == '0') {
?>
    <div class="container mx-auto">
        <div class="text-center">
            <a href="./"><button>Volver al inicio</button></a>
        </div>
    </div>
<?php
            // Muestra toda la información, por omision INFO_ALL
            phpinfo();

            // Mostrar solo la información de modulos.
            // phpinfo(8) produce el mismo resultado.
            phpinfo(INFO_MODULES);

    } 
    
    else header('location: ./');
?>