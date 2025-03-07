<?php require_once "../controller/cubi.php";
include "../controller/cusu.php"; ?>
<div class="row full-height justify-content-center">
    <div class="col-12 text-center aling-self-center py-5">
        <div class="section pb-5 pt-5 pt-sm-2 text-center">
            <h6 class="mb-0 pb-3"><span>Ingresar</span><span>Registrarme</span></h6>
            <input class="checkbox" type="checkbox" name="reg-log" id="reg-log">
            <label for="reg-log"></label>
            <div class="card-3d-wrap mx-auto">
                <div class="card-3d-wrapper">
                    <div class="card-front" id="bx-login">
                        <div class="center-wrap">
                            <div class="section text-center">
                                <h4 class="mb-4 pb-3">Iniciar Sesión</h4>
                                <form action="../model/control.php" method="POST">
                                    <?php
                                    $err = isset($_GET['err']) ? $_GET['err'] : NULL;
                                    if ($err == 'email') {
                                        echo "<p class='msjErr'>El correo es incorrecto</p>";
                                    } elseif ($err == 'password') {
                                        echo "<p class='msjErr'>La contraseña es incorrecta</p>";
                                    } elseif ($err == 'empty') {
                                        echo "<p class='msjErr'>Por favor, ingrese el correo y la contraseña</p>";
                                    } elseif ($err == 'inactivo') {
                                        echo "<p class='msjErr'>El usuario está inactivo</p>";
                                    }
                                    ?>

                                    <div class="form-group">
                                        <input type="text" class="form-style" placeholder="Usuario" name="user"
                                            id="inp-user" required>
                                        <i class="bi bi-person input-icon"></i>
                                    </div>
                                    <div class="form-group mt-2">
                                        <input type="password" class="form-style" placeholder="Contraseña" name="pass"
                                            id="inp-pass" required>
                                        <i class="bi bi-lock input-icon"></i>
                                    </div>
                                    <input type="submit" value="Ingresar" class="btn mt-4">
                                </form>
                                <p class="mb-0 mt-4 text-center"><a href="vwLogin.php?aw=01" class="link">Olvido su
                                        contraseña?</a></p>

                            </div>
                        </div>
                    </div>
                    <div class="card-back">
                        <div class="center-wrap">
                            <div class="section text-center">
                                <h4 class="mb-3 pb-3">Registrarme</h4>
                                <p id="msjRegis"></p>
                                <form action="#" method="POST" id="formRegistro">
                                    <div class="row">
                                        <div class="col form-group">
                                            <input type="text" class="form-style" placeholder="Nombres" name="nomusu"
                                                required>
                                            <i class="bi bi-person input-icon"></i>
                                        </div>
                                        <div class="col form-group">
                                            <input type="text" class="form-style" placeholder="Apellidos" name="apeusu"
                                                required>
                                            <i class="bi bi-alphabet input-icon"></i>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col form-group mt-2">
                                            <select class="form-style" name="genusu" id="">
                                                <option value="">Sexo</option>
                                                <option value="M">Masculino</option>
                                                <option value="F">Femenino</option>
                                                <option value="otro">Otro</option>
                                            </select>
                                            <i class="bi bi-gender-trans input-icon"></i>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col form-group mt-2">
                                            <input type="tel" class="form-style" placeholder="Número de Teléfono"
                                                name="celusu" required>
                                            <i class="bi bi-phone input-icon"></i>
                                        </div>
                                        <div class="col form-group mt-2">
                                            <input type="email" class="form-style" placeholder="Correo" name="emausu"
                                                id="emausu" required>
                                            <i class="bi bi-at input-icon"></i>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col form-group mt-2">
                                            <select class="form-style" name="tipdoc" id="" required>
                                                <option value="">Tipo Documento</option>
                                                <option value="CC">CC</option>
                                                <option value="TI">TI</option>
                                                <option value="CE">CE</option>
                                                <option value="RC">RC</option>
                                                <option value="PEP">PEP</option>
                                                <option value="DNI">DNI</option>
                                                <option value="PA">PA</option>
                                                <option value="SCR">SCR</option>
                                            </select>
                                            <i class="bi bi-person-vcard input-icon"></i>
                                        </div>
                                        <div class="col form-group mt-2">
                                            <input type="number" class="form-style" placeholder="Identificación"
                                                name="docusu" id="" required>
                                            <i class="bi bi-123 input-icon"></i>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col form-group mt-2">
                                            <select class="form-style" name="depart" id="depart" required>
                                                <option value="">Departamento</option>
                                                <?php if ($dtDtp) {
                                                    foreach ($dtDtp as $dtD) { ?>
                                                        <option value="<?= $dtD['idubi']; ?>"><?= $dtD['nomubi']; ?></option>
                                                    <?php }
                                                } ?>
                                            </select>
                                            <i class="bi bi-geo-alt-fill input-icon"></i>
                                        </div>
                                        <div class="col form-group mt-2">
                                            <select class="form-style" name="ciudad" id="ciudad" required>
                                                <option value="">Ciudad</option>
                                            </select>
                                            <i class="bi bi-geo-fill input-icon"></i>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col form-group">
                                            <input type="text" class="form-style" placeholder="Dirección" name="dirrecusu"
                                                required>
                                            <i class="bi bi-signpost-split input-icon"></i>
                                        </div>
                                        <div class="col form-group">
                                            <input type="password" class="form-style" placeholder="Contraseña"
                                                name="pasusu" id="" required>
                                            <i class="bi bi-key-fill input-icon"></i>
                                        </div>
                                    </div>
                                    <p><i class="bi bi-question-circle-fill"></i> El usuario es su correo electrónico.</p>
                                    <input type="hidden" name="idpef" value="1">
                                    <input type="hidden" name="ope" value="save">
                                    <!-- <div class="g-recaptcha" data-sitekey="6Ldez-wqAAAAAJrl2TYRMsj3J5tCtRUW6O3cVI8T"></div> -->
                                    <input type="submit" value="Registrar" class="btn mt-4" id="btn-registrar">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>