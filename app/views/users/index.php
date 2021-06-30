<?php require APPROOT . '/views/inc/header.php'; 
// if(!isLogged()){
//     echo "<script>$('#login-modal').modal('show');</script>";
// }
?>
<h2 class="user-title">Cuenta de usuario</h2>
<div class="user-panel">
    <div class="card">
        <a href="<?= URLROOT; ?>/reviews/index">
            <i class="far fa-comments"></i>
            <h3>Tus opiniones</h3>
        </a>
    </div>
    <div>
        <a href="<?= URLROOT; ?>/users/logout">
            <i class="far fa-window-close"></i>
            <h3>Cerrar sesión</h3>
        </a>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>