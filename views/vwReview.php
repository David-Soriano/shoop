<div class="row">
    <div class="col">
        <h2>Reseñas del producto</h2>
        <?php if (!empty($reviews)): ?>
            <ul>
                <?php foreach ($reviews as $review): ?>
                    <li><strong><?php echo htmlspecialchars($review['nomusu']); ?></strong>:
                        <?php echo htmlspecialchars($review['comentario']); ?> -
                        <strong><?php echo $review['rating']; ?>/5</strong>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay reseñas para este producto.</p>
        <?php endif; ?>
    </div>
</div>