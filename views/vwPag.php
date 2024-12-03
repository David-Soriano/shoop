<div class="page-list">
    <h2>Listado de Páginas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Ruta</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Ejemplo de una fila de página -->
            <tr>
                <td>1</td>
                <td>Página de Inicio</td>
                <td>/inicio</td>
                <td>
                    <button onclick="habilitarPagina(1)">Habilitar</button>
                    <button onclick="deshabilitarPagina(1)">Deshabilitar</button>
                    <button onclick="editarPagina(1)">Editar</button>
                </td>
            </tr>
            <!-- Añade más filas según sea necesario -->
        </tbody>
    </table>
</div>

<script>
    function habilitarPagina(id) {
        // Lógica para habilitar la página
        console.log("Habilitar página con ID:", id);
    }

    function deshabilitarPagina(id) {
        // Lógica para deshabilitar la página
        console.log("Deshabilitar página con ID:", id);
    }

    function editarPagina(id) {
        // Lógica para editar la página
        console.log("Editar página con ID:", id);
    }
</script>
