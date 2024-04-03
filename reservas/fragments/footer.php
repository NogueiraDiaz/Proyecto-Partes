<!-- Toasts -->
<div class="toast-container position-fixed top-0 end-0">
    <div id="toast" class="toast align-items-center bg-secondary text-white border-0 w-100" style="z-index: 11" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    <div id="e_toast" class="toast align-items-center bg-danger text-white border-0" style="z-index: 11" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
<div class="bg-dark bg-gradient bg-opacity-10">
    <footer class="align-items-center pt-3 my-4 border-top text-center">
        <p class="col-12 text-center"><a href="http://ies-julioverne.centros.castillalamancha.es/" target="_blank" class="text-decoration-none p-2">IES Julio Verne (Bargas, Toledo)</a></p>
        <a href="#" class="col-12">Volver arriba</a>
        <div id="footerCredits" class="text-center my-2 p-2">
            <h6 class="fw-bold">Desarrollado por alumnos de 2º DAM</h6>
            <div class="row container mx-auto">
                <div class="col-12 col-md-3">Eloy Rodríguez Martín</div>
                <div class="col-12 col-md-3">Blanca Moraga Pantoja</div>
                <div class="col-12 col-md-3">Guillermo Jiménez Barroso</div>
                <div class="col-12 col-md-3">Samuel Sánchez Arroyo</div>
            </div>
            <p class="fw-bold mt-2">Copyright &copy; 2022</p>
        </div>
    </footer>
</div>
<script>
    function showToast(msg, bg = 'primary', delay = 10000){
        let myToast = document.querySelector('#toast')
        bsToast = new bootstrap.Toast(myToast, {delay})
        myToast.className = myToast.className.replace(/bg-[\w]+/g,'bg-'+bg)
        myToast.querySelector('.toast-body').innerHTML = msg.replace('script>','pre>')
        bsToast.show()
    }

    function showError(msg, delay = 8000){
        let myToast = document.querySelector('#e_toast')
        bsToast = new bootstrap.Toast(myToast, {delay})
        myToast.querySelector('.toast-body').innerHTML = msg.replace('script>','pre>')
        bsToast.show()
    }
</script>
</body>
</html>