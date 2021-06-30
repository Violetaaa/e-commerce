<?php require APPROOT . '/views/inc/header.php'; ?>

<form action="<?= URLROOT; ?>/users/register" method="post" class="registro-formulario">

        <h2>Escribe tus datos personales</h2>

        <ul>
                <li class="entero"><input class="<?php echo (!empty($data['errorEmail'])) ? 'error' : ''; ?>" value="<?= $data['email']; ?>" type="text" id="correo" name="email" maxlength="40" placeholder="Email" value="<?= htmlspecialchars($data['email']) ?>" />
                        <div class=error-message>
                                <?= $data['errorEmail']; ?>
                        </div>
                </li>
                <li class="columnas"><input class="<?php echo (!empty($data['errorPass'])) ? 'error' : ''; ?>" type="password" id="pass" name="pass" maxlength="40" placeholder="Contraseña" />
                        <div class=error-message>
                                <?= $data['errorPass']; ?>
                        </div>
                </li>
                <li class="columnas"><input class="<?php echo (!empty($data['errorRepeatPass'])) ? 'error' : ''; ?>" type="password" id="repeatPass" name="repeatPass" maxlength="40" placeholder="Confirmar contraseña" />
                        <div class=error-message>
                                <?= $data['errorRepeatPass']; ?>
                        </div>
                </li>
                </li>
                <li class="columnas"><input class="<?php echo (!empty($data['errorName'])) ? 'error' : ''; ?>" type="text" id="name" name="name" maxlength="40" placeholder="Nombre" value="<?= htmlspecialchars($data['name']) ?>" />
                        <div class="error-message">
                                <?= $data['errorName']; ?>
                        </div>
                </li>
                <li class="columnas"><input class="<?php echo (!empty($data['errorSurname'])) ? 'error' : ''; ?>" type="text" id="surname" name="surname" maxlength="40" placeholder="Apellidos" value="<?= htmlspecialchars($data['surname']) ?>" />
                        <div class="error-message">
                                <?= $data['errorSurname']; ?>
                        </div>
                </li>
                <li class="entero"><input class="<?php echo (!empty($data['errorAddress'])) ? 'error' : ''; ?>" type="text" id="address" name="address" maxlength="40" placeholder="Dirección" value="<?= htmlspecialchars($data['address']) ?>" />
                        <div class="error-message">
                                <?= $data['errorAddress']; ?>
                        </div>
                </li>
                <li class="columnas"><input class="<?php echo (!empty($data['errorCity'])) ? 'error' : ''; ?>" type="text" id="city" name="city" maxlength="40" placeholder="Población" value="<?= htmlspecialchars($data['city']) ?>" />
                        <div class="error-message">
                                <?= $data['errorCity']; ?>
                        </div>
                </li>
                <li class="columnas"><input class="<?php echo (!empty($data['errorPostalCode'])) ? 'error' : ''; ?>" type="text" id="postalCode" name="postalCode" maxlength="10" placeholder="Código Postal" value="<?= htmlspecialchars($data['postalCode']) ?>" />
                        <div class="error-message">
                                <?= $data['errorPostalCode']; ?>
                        </div>
                </li>
                <li class="columnas"><input class="<?php echo (!empty($data['errorState'])) ? 'error' : ''; ?>" type="text" id="state" name="state" maxlength="40" placeholder="Provincia" value="<?= htmlspecialchars($data['state']) ?>" />
                        <div class="error-message">
                                <?= $data['errorState']; ?>
                        </div>
                </li>
                <li class="columnas"><input class="<?php echo (!empty($data['errorCountry'])) ? 'error' : ''; ?>" type="text" id="country" name="country" maxlength="40" placeholder="País" value="<?= htmlspecialchars($data['country']) ?>" />
                        <div class="error-message">
                                <?= $data['errorCountry']; ?>
                        </div>
                </li>
        </ul>
        <button type="submit" class="enviar-form boton-comprar boton-acceder">REGISTRARSE</button>
</form>
<?php require APPROOT . '/views/inc/footer.php'; ?>