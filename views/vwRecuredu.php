<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recursos Educativos</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>

<body>
    <header>
        <h1>Recursos Educativos</h1>
        <p>Explora nuestra colección de recursos educativos para mejorara tu experiencia .</p>
    </header>

    <section class="filtros">
        <h2>Filtrar por categoría</h2>
        <select id="categoria">
            <option value="todos">Todos</option>
            <option value="carga masiva">carga masiva</option>
            <option value="guias">videos</option>
            <option value="perfil">perfil</option>
            <option value="manual">manual</option>
        </select>
    </section>

    <section class="recursos">
        <div class="recurso" data-categoria="carga masiva">
            <h3>carga masiva</h3>
            <p> en lugar de agregar cada producto manualmente, puedes usar una carga masiva para subirlos todos a la
                vez, generalmente mediante un archivo CSV, Excel</p>

        </div>
        <div class="recurso" data-categoria="guias">
            <h3>video</h3>
            <p>aqui encontraras un video de como funcina la plataforma shoop.</p>
            <a href="video.php" class="btn">Ver más</a>
        </div>
        <div class="recurso" data-categoria="perfil">
            <h3>perfil:usuario</h3>
            <p>muestra su nombre, foto, publicaciones y configuración de privacidad..</p>
            <a href="#" class="btn">Registrarse</a>
        </div>
        <div class="recurso" data-categoria="manual">
            <h3>manual usuario</h3>
            <p>Descarga nuestro manual de usuario para saber mas sobre neustro sitio web.</p>
            <a href="../Documentación/manual_user.pdf" download="manual usuario shoop .pdf"
                class="btn  btn-descargar">Descargar</a>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Shoop. Todos los derechos reservados.</p>
    </footer>


    <script>
    function changeAyuda() {
            document.getElementById('categoria').addEventListener('change', function () {
                const categoriaSeleccionada = this.value;
                const recursos = document.querySelectorAll('.recurso');

                recursos.forEach(recurso => {
                    if (categoriaSeleccionada === 'todos' || recurso.getAttribute('data-categoria') === categoriaSeleccionada) {
                        recurso.style.display = 'block';
                    } else {
                        recurso.style.display = 'none';
                    }
                });
            });
        }
        changeAyuda();
    </script>
</body>

</html>