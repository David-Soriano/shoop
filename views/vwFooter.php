<footer class="row">
    <div class="col">
        <div class="row">
            <div class="col-sm-3 bx-foot-info">
                <p>&copy; 2025 SHOOP. Todos los derechos reservados.</p>
            </div>

            <div class="col-sm-3 bx-foot-contact">
                <p>Contacto: <a href="mailto:soporte@shoop.com">soporte@shoop.com</a></p>
                <p>Teléfono: +57 123 456 7890</p>
            </div>

            <div class="col-sm-3 bx-foot-links">
                <ul>
                    <li><a href="<?= $isLoggedIn ? 'home.php?pg=5' : 'index.php?pg=5'; ?>">Sobre Nosotros</a></li>
                    <li><a href="/terms">Términos y Condiciones</a></li>
                    <li><a href="/privacy">Política de Privacidad</a></li>
                    <li><a href="<?= $isLoggedIn ? 'home.php?pg=8' : 'index.php?pg=8'; ?>"">Centro de Ayuda</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class=" col">
                            <div class=" row">
                                <div class=" col-sm-3 bx-foot-newsletter">
                                    <p>Suscríbete para recibir novedades y ofertas:</p>
                                    <form>
                                        <input type="email" placeholder="Tu correo electrónico" required>
                                        <button type="submit">Suscribirse</button>
                                    </form>
                                </div>

                                <div class="col-sm-3 bx-foot-location">
                                    <p>Ubicación: Chía, Cundinamarca</p>
                                    <a href="https://www.google.com/maps?q=Cl.+25+%2311-135,+Ch%C3%ADa,+Cundinamarca"
                                        target="_blank">Ver en
                                        Google Maps</a>
                                </div>

                                <div class="col-sm-3 bx-social">
                                    <a href="https://web.facebook.com/" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                                        </svg>
                                    </a>
                                    <a href="https://www.instagram.com/" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                            <path
                                                d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zM12.6 2.77a.96.96 0 1 1 0 1.92.96.96 0 0 1 0-1.92zM8 5.22a4.109 4.109 0 1 1 0 8.217 4.109 4.109 0 0 1 0-8.217z" />
                                        </svg>
                                    </a>
                                    <a href="https://twitter.com/?lang=es" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                                            <path
                                                d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z" />
                                        </svg>
                                    </a>
                                    <a href="https://github.com/" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                                            <path
                                                d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
            </div>
</footer>