<!--Hay que añadir primero jquery y luego bootstrap, al reves
    no funciona, por lo menos con la  version jquery 3.1.1 y 
    bootstrap 3.7.7-->
<script src="js/jquery-3.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>   
<script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>
<?php
// para evitar problemas con las cabeceras de php, que dan problemas raros
// con los espacio en blanco antes y despues de la etiquetas de php
// de esta forma se elimina todos automaticamente.
ob_end_flush();
?>
