<div class="pqr-section">
    <h2 class="section-title">PQR Recibidas</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pqrs as $pqr): ?>
                    <tr>
                        <td><?= htmlspecialchars($pqr['nombre']); ?></td>
                        <td><?= htmlspecialchars($pqr['fecha']); ?></td>
                        <td><?= htmlspecialchars($pqr['descripcion']); ?></td>
                        <td>
                            <form action="responder.php" method="post">
                                <input type="hidden" name="id" value="<?= $pqr['id']; ?>">
                                <button type="submit" class="respond-button">Responder</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <form action="crear_pqr.php" method="post">
        <button type="submit" class="new-pqr-button">Realizar PQR</button>
    </form>
</div>
