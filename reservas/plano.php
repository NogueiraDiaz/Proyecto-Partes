<?php
session_start();
if (isset($_SESSION['usuario_login'])) {
    include_once('./fragments/headers.php');
?>

<main class="container mx-auto p-5">
    <div class="text-center">
        <h3>Plano del centro</h3>
        <p>-- WIP --</p>
        <p>Preparado para futura implementación</p>
    </div>
</main>

<script>
    
</script>
<?php
    include_once('./fragments/footer.php');
}
?>