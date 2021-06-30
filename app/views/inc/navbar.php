<!-- modal-login -->
<div id="modal-login" class="login">
    <div class="login-formulario">
        <span class="closes-login">&times;</span>
        <h2>Accede a tu cuenta</h2>
        <form class="login_modal" action="<?= URLROOT; ?>/users/login" method="post">
            <input id="email" name="email" placeholder="Dirección de email" type="email" class="casilla-formulario">
            <input id="password" name="pass" placeholder="Contraseña" type="password" class="casilla-formulario">
            <input name="submit" type="submit" value="ACCEDER" class=boton-acceder>
            <div class="js-error" style='display: none;'></div>
        </form>
        <form class="form2" action="<?= URLROOT; ?>/users/register">
            <h2>¿Nuevo usuario?</h2>
            <input type="submit" value="REGÍSTRATE" class=boton-nuevo>
        </form>
    </div>
</div>

<div class="contenedor">
    <!-- Main-Nav -->
    <nav class="main-nav">
        <!-- menu desplegable -->
        <div class="boton-menu" id="botonmenu">
            <i class="fas fa-bars fa-2x"></i>
        </div>
        <ul class="otromenu" id="menulateral">
            <li><a href="<?= URLROOT; ?>/products/newIn">Novedades</a></li>
            <li><a href="<?= URLROOT; ?>/products/show/1">Gafas de sol</a></li>
            <li><a href="<?= URLROOT; ?>/products/show/2">Bisutería</a></li>
            <li><a href="<?= URLROOT; ?>/products/show/3">Sombreros</a></li>
            
        </ul>
        <div class="home">
            <a href="<?= URLROOT ?>">Summer Shop</a>
        </div>
        <!-- menu dcha -->
        <ul class="right-menu">
            <li>
                <form action="<?= URLROOT; ?>/products/search" method="POST">
                    <input id="busqueda" name="search" type="text">
                    <button type="submit" class="boton-busqueda">
                        <i class="fa fa-fw fa-search"></i>
                    </button>
                </form>
            </li>
            <li>
                <a href="<?= URLROOT ?>/carts">
                    <i class="fas fa-shopping-bag"></i> 
                </a>
            </li>
            <li>
                <!-- si el usuario está logueado, dirige al panel de usuario. Si no está logueado, se abre el modal de login/registro -->
                <a id="<?php echo (isset($_SESSION['user_id'])) ?  '' : 'opens-login'; ?>" href="<?php echo (isset($_SESSION['user_id'])) ?  URLROOT . '/users/index' : '#'; ?>">
                    <i class="fa fa-fw fa-user"></i> 
                </a>
            </li>
        </ul>
    </nav>

    <!-- FIN Main-Nav -->