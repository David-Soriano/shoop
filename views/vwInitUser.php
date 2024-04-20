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
                                <form action="../home.php">
                                    <div class="form-group">
                                        <input type="text" class="form-style" placeholder="Usuario" name=""
                                            id="inp-user" required>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-person input-icon" viewBox="0 0 16 16">
                                            <path
                                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                                        </svg>
                                    </div>
                                    <div class="form-group mt-2">
                                        <input type="password" class="form-style" placeholder="Contraseña" name=""
                                            id="inp-pass" required>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-lock input-icon" viewBox="0 0 16 16">
                                            <path
                                                d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1" />
                                        </svg>
                                    </div>
                                    <input type="button" value="Ingresar" class="btn mt-4" id="btn-ingresar">
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
                                <form action="#">
                                    <div class="form-group">
                                        <input type="text" class="form-style" placeholder="Nombre Completo" required>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-person input-icon" viewBox="0 0 16 16">
                                            <path
                                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                                        </svg>
                                    </div>
                                    <div class="form-group mt-2">
                                        <input type="tel" class="form-style" placeholder="Número de Teléfono" id=""
                                            required>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-phone input-icon" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                            <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                        </svg>
                                    </div>
                                    <div class="form-group mt-2">
                                        <select class="form-style" name="" id="">
                                            <option value="Seleccione">Sexo</option>
                                            <option value="masc">Masculino</option>
                                            <option value="fem">Femenino</option>
                                            <option value="otro">Otro</option>
                                        </select>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-person-vcard input-icon"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M5 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4m4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5M9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8m1 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5" />
                                            <path
                                                d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H8.96q.04-.245.04-.5C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 1 1 12z" />
                                        </svg>
                                    </div>
                                    <div class="form-group mt-2">
                                        <input type="email" class="form-style" placeholder="Correo" name="" id=""
                                            required>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-envelope-heart input-icon"
                                            viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l3.235 1.94a2.8 2.8 0 0 0-.233 1.027L1 5.384v5.721l3.453-2.124q.219.416.55.835l-3.97 2.443A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741l-3.968-2.442q.33-.421.55-.836L15 11.105V5.383l-3.002 1.801a2.8 2.8 0 0 0-.233-1.026L15 4.217V4a1 1 0 0 0-1-1zm6 2.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132" />
                                        </svg>
                                    </div>
                                    <div class="form-group mt-2">
                                        <select class="form-style" name="" id="" required>
                                            <option value="Seleccione">Tipo Documento</option>
                                            <option value="CC">CC</option>
                                            <option value="TI">TI</option>
                                            <option value="CE">CE</option>
                                            <option value="RC">RC</option>
                                            <option value="PEP">PEP</option>
                                            <option value="DNI">DNI</option>
                                            <option value="PA">PA</option>
                                            <option value="SCR">SCR</option>
                                        </select>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-person-vcard input-icon"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M5 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4m4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5M9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8m1 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5" />
                                            <path
                                                d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H8.96q.04-.245.04-.5C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 1 1 12z" />
                                        </svg>
                                    </div>
                                    <div class="form-group mt-2">
                                        <input type="text" class="form-style" placeholder="Identificación" name="" id=""
                                            required>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-lock input-icon" viewBox="0 0 16 16">
                                            <path
                                                d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1" />
                                        </svg>
                                    </div>
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